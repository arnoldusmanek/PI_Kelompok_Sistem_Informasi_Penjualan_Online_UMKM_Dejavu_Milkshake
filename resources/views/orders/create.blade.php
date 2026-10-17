
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Milkshake | Dejavu Milkshake</title>

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
            max-width: 760px;
            margin: auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 22px;
            color: #75432e;
            text-decoration: none;
        }

        .card {
            padding: 28px;
            background: white;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(70, 40, 20, 0.08);
        }

        h1 {
            margin: 0 0 8px;
        }

        .muted {
            color: #806f66;
            line-height: 1.6;
        }

        .product {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 18px 0;
            margin: 16px 0 24px;
            border-top: 1px solid #eee3da;
            border-bottom: 1px solid #eee3da;
        }

        .product img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 14px;
        }

        .product h2 {
            margin: 0 0 8px;
            font-size: 20px;
        }

        .price {
            color: #8b4b30;
            font-weight: bold;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddcfc5;
            border-radius: 9px;
            font: inherit;
        }

        textarea {
            min-height: 95px;
            resize: vertical;
        }

        .error {
            margin-top: 6px;
            color: #b42318;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            width: 100%;
            padding: 14px;
            border: 0;
            border-radius: 10px;
            background: #75432e;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover {
            background: #5e3424;
        }

        @media (max-width: 480px) {
            .card {
                padding: 20px;
            }

            .product img {
                width: 85px;
                height: 85px;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <a class="back-link" href="{{ url('/') }}">
            &larr; Kembali ke halaman utama
        </a>

        <section class="card">
            <h1>Formulir Pemesanan</h1>
            <p class="muted">
                Isi data di bawah ini untuk memesan milkshake favoritmu.
            </p>

            <div class="product">
                <img
                    src="{{ asset($product->image) }}"
                    alt="{{ $product->name }}"
                >

                <div>
                    <h2>{{ $product->name }}</h2>
                    <div class="price">
                        Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                        / gelas
                    </div>
                </div>
            </div>

            <form
                action="{{ route('orders.store', $product->id) }}"
                method="POST"
            >
                @csrf

                <div class="field">
                    <label for="customer_name">Nama lengkap</label>
                    <input
                        type="text"
                        id="customer_name"
                        name="customer_name"
                        value="{{ old('customer_name') }}"
                        required
                        maxlength="255"
                        autocomplete="name"
                    >
                    @error('customer_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="phone">Nomor telepon / WhatsApp</label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        required
                        maxlength="20"
                        autocomplete="tel"
                    >
                    @error('phone')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="address">Alamat pengantaran</label>
                    <textarea
                        id="address"
                        name="address"
                        required
                        maxlength="2000"
                        autocomplete="street-address"
                    >{{ old('address') }}</textarea>
                    @error('address')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="quantity">Jumlah gelas</label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        value="{{ old('quantity', 1) }}"
                        min="1"
                        max="100"
                        required
                    >
                    @error('quantity')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="notes">Catatan tambahan (opsional)</label>
                    <textarea
                        id="notes"
                        name="notes"
                        maxlength="2000"
                        placeholder="Contoh: gula sedikit atau catatan pengantaran"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="button">
                    Buat Pesanan
                </button>
            </form>
        </section>
    </main>
</body>
</html>
