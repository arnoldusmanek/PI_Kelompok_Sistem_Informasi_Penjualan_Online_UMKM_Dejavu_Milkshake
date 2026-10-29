<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function create(Product $product)
    {
        if (!$product->is_available) {
            abort(404);
        }

        return view('orders.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        if (!$product->is_available) {
            abort(404);
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:2000',
            'quantity' => 'required|integer|min:1|max:100',
            'payment_method' => 'required|in:bank_transfer,qris,ewallet,cod',
            'notes' => 'nullable|string|max:2000',
        ]);

        // Hitung harga berdasarkan data produk di database.
        $quantity = (int) $validated['quantity'];
        $subtotal = (float) $product->price * $quantity;

        // Simpan pesanan beserta detail produknya.
        $order = DB::transaction(function () use (
            $validated,
            $product,
            $quantity,
            $subtotal
        ) {
            $order = Order::create([
                'order_number' => 'DJV-'
                    . now()->format('YmdHis')
                    . '-'
                    . Str::upper(Str::random(10)),
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'total_amount' => $subtotal,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'subtotal' => $subtotal,
            ]);

            return $order;
        });

        // COD tidak memerlukan checkout Midtrans.
        if ($validated['payment_method'] === 'cod') {
            return redirect()->route('orders.show', $order->id);
        }

        // Pastikan kunci Sandbox sudah diisi.
        $serverKey = config('midtrans.server_key');

        if (empty($serverKey)) {
            Log::error('Midtrans Server Key belum dikonfigurasi.');

            return redirect()
                ->route('orders.show', $order->id)
                ->with(
                    'payment_error',
                    'Pesanan tersimpan, tetapi pembayaran belum dapat dibuat. Silakan hubungi admin.'
                );
        }

        Config::$serverKey = $serverKey;
        Config::$isProduction = (bool) config(
            'midtrans.is_production',
            false
        );
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Batasi metode pembayaran sesuai pilihan pelanggan.
        $enabledPayments = match ($validated['payment_method']) {
            'bank_transfer' => ['bank_transfer'],
            'qris' => ['other_qris'],
            'ewallet' => ['gopay', 'shopeepay', 'ovo', 'dana'],
        };

        try {
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) round($subtotal),
                ],

                'item_details' => [
                    [
                        'id' => (string) $product->id,
                        'price' => (int) round((float) $product->price),
                        'quantity' => $quantity,
                        'name' => Str::limit($product->name, 50, ''),
                    ],
                ],

                'customer_details' => [
                    'first_name' => $validated['customer_name'],
                    'phone' => $validated['phone'],
                ],

                'enabled_payments' => $enabledPayments,

                'callbacks' => [
                    'finish' => route('orders.show', $order->id, true),
                ],
            ];

            $snapResponse = Snap::createTransaction($params);

            $order->update([
                'snap_token' => $snapResponse->token,
                'snap_redirect_url' => $snapResponse->redirect_url,
                'payment_status' => 'pending',
            ]);

            return redirect()->away($snapResponse->redirect_url);
       } catch (\Throwable $e) {
            Log::error('Gagal membuat checkout Midtrans.', [
                'order_id' => $order->id,
                'exception_class' => get_class($e),
                'message' => $e->getMessage(),
            ]);

            $order->update([
                'payment_status' => 'failed',
            ]);

            return redirect()
                ->route('orders.show', $order->id)
                ->with(
                    'payment_error',
                    'Pesanan tersimpan, tetapi halaman pembayaran gagal dibuat. Silakan hubungi admin.'
                );
        }
    }
    
    public function notification(Request $request)
    {
        $payload = $request->all();

        $serverKey = config('midtrans.server_key');

        if (empty($serverKey)) {
            return response()->json([
                'message' => 'Payment configuration unavailable',
            ], 500);
        }

        foreach ([
            'order_id',
            'status_code',
            'gross_amount',
            'signature_key',
            'transaction_status',
        ] as $field) {
            if (!isset($payload[$field])) {
                return response()->json([
                    'message' => 'Invalid notification',
                ], 400);
            }
        }

        $expectedSignature = hash(
            'sha512',
            $payload['order_id']
                . $payload['status_code']
                . $payload['gross_amount']
                . $serverKey
        );

        if (!hash_equals(
            $expectedSignature,
            (string) $payload['signature_key']
        )) {
            return response()->json([
                'message' => 'Invalid signature',
            ], 403);
        }

        $order = Order::where(
            'order_number',
            $payload['order_id']
        )->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }

        if (abs(
            (float) $payload['gross_amount']
            - (float) $order->total_amount
        ) > 0.009) {
            return response()->json([
                'message' => 'Amount mismatch',
            ], 400);
        }

        $transactionStatus = $payload['transaction_status'];
        $fraudStatus = $payload['fraud_status'] ?? null;

        $paymentStatus = match ($transactionStatus) {
            'settlement' => 'paid',
            'capture' => $fraudStatus === 'accept'
                ? 'paid'
                : 'pending',
            'pending' => 'pending',
            'expire' => 'expired',
            'cancel' => 'cancelled',
            'deny' => 'failed',
            default => null,
        };

        if ($paymentStatus === null) {
            return response()->json([
                'message' => 'Notification status ignored',
            ]);
        }

        // Jangan menurunkan status pesanan yang sudah dibayar.
        if ($order->payment_status === 'paid'
            && $paymentStatus !== 'paid') {
            return response()->json(['message' => 'OK']);
        }

        $order->payment_status = $paymentStatus;

        if (!empty($payload['transaction_id'])) {
            $order->midtrans_transaction_id =
                $payload['transaction_id'];
        }

        if ($paymentStatus === 'paid') {
            $order->paid_at ??= now();
            $order->status = 'processing';
        }

        $order->save();

        return response()->json(['message' => 'OK']);
    }


    public function show(Order $order)
    {
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
