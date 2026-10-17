<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            'notes' => 'nullable|string|max:2000',
        ]);

        $order = DB::transaction(function () use ($validated, $product) {
            $subtotal = (float) $product->price
                * (int) $validated['quantity'];

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
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'unit_price' => $product->price,
                'subtotal' => $subtotal,
            ]);

            return $order;
        });

        return redirect()->route('orders.show', $order->id);
    }

    public function show(Order $order)
    {
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
