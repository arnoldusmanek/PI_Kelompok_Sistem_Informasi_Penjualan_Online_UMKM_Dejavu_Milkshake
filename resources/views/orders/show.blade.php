
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

        .success {
            padding: 14px;
            margin-bottom: 22px;
            border-radius: 10px;
            background: #e8f7e9;
            color: #246b32;
            line-height: 1.5;
        }

        .muted {
            color: #806f66;
            line-height: 1.6;
        }

        .item {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid #eee3da;
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
            border-radius: 10px;
            background: #75432e;
            color: white;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 480px) {
            .card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <section class="card">
            <h1>Pesanan Berhasil Dibuat!</h1>

            <div class="success">
                Pesanan kamu sudah tersimpan. Status awal pesanan adalah
                <strong>Menunggu diproses</strong>.
            </div>

            <p class="muted">Nomor pesanan:</p>
            <h2>{{ $order->order_number }}</h2>

            <div class="details">
                <strong>Nama pelanggan:</strong>
                {{ $order->customer_name }}<br>

                <strong>Nomor telepon:</strong>
                {{ $order->phone }}<br>

                <strong>Alamat pengantaran:</strong><br>
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
