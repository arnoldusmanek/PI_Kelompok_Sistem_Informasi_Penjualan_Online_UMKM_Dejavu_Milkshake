
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Pesanan | Dejavu Milkshake</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 16px;
            background: #fff8f0;
            color: #38251f;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 720px;
            margin: auto;
        }

        .card {
            padding: 28px;
            background: white;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(70, 40, 20, 0.08);
        }

        h1 {
            margin-top: 0;
        }

        h2 {
            overflow-wrap: anywhere;
        }

        .notice {
            padding: 14px;
            margin: 18px 0;
            border-radius: 10px;
            background: #fff3d8;
            color: #6b4b13;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .success {
            padding: 14px;
            margin: 18px 0;
            border-radius: 10px;
            background: #e8f7e9;
            color: #246b32;
            line-height: 1.6;
        }

        .error {
            padding: 14px;
            margin: 18px 0;
            border-radius: 10px;
            background: #fdebea;
            color: #a12722;
            line-height: 1.6;
        }

        .muted {
            color: #806f66;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .item {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid #eee3da;
        }

        .item > * {
            min-width: 0;
        }

        .total {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .details {
            margin: 20px 0;
            line-height: 1.8;
            overflow-wrap: anywhere;
        }

        .button {
            display: block;
            padding: 14px;
            margin-top: 14px;
            border-radius: 10px;
            background: #75432e;
            color: white;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
        }

        .button:hover {
            background: #5e3424;
        }

        @media (max-width: 480px) {
            .card {
                padding: 20px;
            }

            .total {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <main class="container">
        <section class="card">
            <h1>Ringkasan Pesanan</h1>

            @if (session('payment_error'))
                <div class="error">
                    {{ session('payment_error') }}
                </div>
            @endif

            @if ($order->payment_method === 'cod')
                <div class="notice">
                    Pesanan berhasil dicatat. Pembayaran dilakukan saat
                    pesanan diterima.

                    <br>
                    <strong>Status pembayaran: Belum dibayar.</strong>
                </div>

            @elseif ($order->payment_status === 'paid')
                <div class="success">
                    Pembayaran telah dikonfirmasi oleh sistem.

                    <br>
                    <strong>Status pembayaran: Lunas.</strong>
                </div>

            @elseif (
                $order->payment_status === 'pending'
                && $order->snap_redirect_url
            )
                <div class="notice">
                    Pesanan berhasil dibuat, tetapi pembayaran belum
                    dikonfirmasi.

                    <br>
                    Silakan selesaikan pembayaran melalui Midtrans.
                </div>

                <a
                    class="button"
                    href="{{ $order->snap_redirect_url }}"
                    style="margin-bottom: 20px;"
                >
                    Lanjutkan Pembayaran
                </a>

            @elseif ($order->payment_status === 'failed')
                <div class="error">
                    Pembayaran gagal diproses atau transaksi ditolak.

                    <br>
                    Silakan hubungi admin untuk mendapatkan bantuan.
                </div>

            @elseif ($order->payment_status === 'expired')
                <div class="error">
                    Waktu pembayaran telah berakhir.

                    <br>
                    Silakan hubungi admin untuk langkah berikutnya.
                </div>

            @elseif ($order->payment_status === 'cancelled')
                <div class="notice">
                    Transaksi pembayaran dibatalkan.
                    Silakan hubungi admin apabila ingin melanjutkan pesanan.
                </div>

            @else
                <div class="notice">
                    Pesanan berhasil dicatat. Status pembayaran masih
                    menunggu konfirmasi.

                    <br>
                    <strong>
                        Status:
                        {{ ucfirst($order->payment_status ?? 'unpaid') }}
                    </strong>
                </div>
            @endif

            <p class="muted">Nomor pesanan:</p>
            <h2>{{ $order->order_number }}</h2>

            <div class="details">
                <strong>Nama pelanggan:</strong>
                {{ $order->customer_name }}
                <br>

                <strong>Nomor telepon:</strong>
                {{ $order->phone }}
                <br>

                <strong>Alamat pengantaran:</strong>
                <br>
                {{ $order->address }}
            </div>

            <h2>Detail pesanan</h2>

            @foreach ($order->items as $item)
                <div class="item">
                    <div>
                        <strong>{{ $item->product->name }}</strong>

                        <div class="muted">
                            {{ $item->quantity }} gelas ×
                            Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                        </div>
                    </div>

                    <strong>
                        Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                    </strong>
                </div>
            @endforeach

            <div class="total">
                <span>Total pesanan</span>

                <span>
                    Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}
                </span>
            </div>

            <p class="muted">
                Catatan: {{ $order->notes ?: '-' }}
            </p>

            <a class="button" href="{{ url('/') }}">
                Kembali ke halaman utama
            </a>
        </section>
    </main>
</body>
</html>
