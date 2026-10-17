<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f7f0e8">
    <title>Dejavu Milkshake — Teman Manis Harimu</title>
    <style>
        :root {
            --ink: #30231f;
            --muted: #786c64;
            --cream: #f7f0e8;
            --paper: #fffdf9;
            --berry: #a94352;
            --berry-dark: #81323e;
            --line: #e9ddd2;
            --green: #52664c;
            --radius: 22px;
            --shadow: 0 18px 45px rgba(54, 35, 25, .09);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            background: var(--paper);
            color: var(--ink);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        img { display: block; max-width: 100%; }
        a { color: inherit; text-decoration: none; }
        .container { width: min(1160px, calc(100% - 44px)); margin: 0 auto; }
        .announcement {
            background: var(--ink); color: #fff8ef; text-align: center;
            padding: 8px 16px; font-size: 11px; letter-spacing: 1.3px;
        }
        header {
            position: sticky; top: 0; z-index: 20;
            background: rgba(255,253,249,.94); backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(233,221,210,.8);
        }
        .navbar { min-height: 82px; display: flex; align-items: center; justify-content: space-between; gap: 28px; }
        .brand { display: inline-flex; flex-direction: column; line-height: 1; flex-shrink: 0; }
        .brand-name { font-family: Georgia, "Times New Roman", serif; font-size: 29px; font-weight: 700; letter-spacing: -.9px; }
        .brand-sub { margin-top: 6px; font-size: 9px; font-weight: 700; letter-spacing: 3.2px; color: var(--berry); }
        nav { display: flex; align-items: center; gap: 29px; color: #5e5149; font-size: 13px; }
        nav a:hover { color: var(--berry); }
        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .button {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            min-height: 45px; padding: 0 20px; border: 1px solid transparent;
            border-radius: 999px; font-size: 12px; font-weight: 700; cursor: pointer;
            transition: transform .2s, background .2s, border-color .2s;
        }
        .button:hover { transform: translateY(-2px); }
        .button-dark { background: var(--ink); color: white; }
        .button-dark:hover { background: var(--berry-dark); }
        .button-outline { border-color: var(--line); background: transparent; }
        .button-outline:hover { border-color: var(--berry); }
        .hero { background: var(--cream); overflow: hidden; }
        .hero-inner {
            min-height: 590px; padding-top: 62px; padding-bottom: 62px;
            display: grid; grid-template-columns: .9fr 1.1fr; align-items: center; gap: 62px;
        }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 10px;
            color: var(--berry); font-size: 10px; font-weight: 800;
            letter-spacing: 2.1px; text-transform: uppercase;
        }
        .eyebrow::before { content: ""; width: 25px; height: 1px; background: currentColor; }
        h1 {
            margin: 20px 0 20px; max-width: 560px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(43px, 5.4vw, 70px); font-weight: 500;
            line-height: 1.03; letter-spacing: -2.5px;
        }
        h1 em { color: var(--berry); font-weight: 500; }
        .hero-copy { max-width: 430px; color: var(--muted); font-size: 14px; line-height: 1.9; }
        .hero-buttons { display: flex; flex-wrap: wrap; gap: 11px; margin-top: 28px; }
        .hero-note { margin-top: 23px; color: var(--muted); font-size: 11px; }
        .hero-note strong { color: var(--ink); }
        .hero-visual { position: relative; min-width: 0; }
        .hero-photo-wrap {
            position: relative; overflow: hidden; border-radius: 46% 46% 22px 22px;
            height: 440px; background: #e8d8c8;
            box-shadow: var(--shadow);
        }
        .hero-photo { width: 100%; height: 100%; object-fit: cover; object-position: center; }
        .photo-tag {
            position: absolute; right: -15px; bottom: 28px; width: 132px; height: 132px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            border-radius: 50%; background: var(--berry); color: white; text-align: center;
            border: 7px solid var(--cream); transform: rotate(8deg);
        }
        .photo-tag span { font-family: Georgia, serif; font-size: 26px; line-height: 1.1; }
        .photo-tag small { margin-top: 5px; font-size: 8px; letter-spacing: 1.5px; text-transform: uppercase; }
        .trust-strip { border-bottom: 1px solid var(--line); background: var(--paper); }
        .trust-grid { display: grid; grid-template-columns: repeat(4, 1fr); }
        .trust-item { padding: 25px 20px; display: flex; align-items: center; justify-content: center; gap: 11px; border-right: 1px solid var(--line); }
        .trust-item:first-child { border-left: 1px solid var(--line); }
        .trust-icon { font-size: 20px; }
        .trust-item strong { display: block; font-size: 11px; }
        .trust-item small { display: block; color: var(--muted); font-size: 10px; margin-top: 2px; }
        section.menu-section { padding: 92px 0; }
        .section-top { display: flex; justify-content: space-between; align-items: end; gap: 24px; margin-bottom: 32px; }
        h2 { font-family: Georgia, "Times New Roman", serif; font-size: clamp(32px, 4vw, 46px); font-weight: 500; line-height: 1.12; letter-spacing: -1.2px; }
        .section-intro { color: var(--muted); font-size: 13px; max-width: 410px; margin-top: 12px; }
        .small-link { color: var(--berry); font-size: 12px; font-weight: 800; white-space: nowrap; }
        .products { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
        .product { min-width: 0; }
        .product-image-wrap { position: relative; overflow: hidden; border-radius: 18px; background: var(--cream); aspect-ratio: 4 / 4.5; }
        .product-image { width: 100%; height: 100%; object-fit: cover; transition: transform .45s ease; }
        .product:hover .product-image { transform: scale(1.045); }
        .product-label {
            position: absolute; top: 12px; left: 12px; padding: 6px 10px; border-radius: 99px;
            background: rgba(255,253,249,.93); color: var(--ink); font-size: 9px; font-weight: 800;
        }
        .product-info { padding: 16px 3px 0; }
        .product-title-row { display: flex; justify-content: space-between; align-items: start; gap: 10px; }
        .product h3 { font-family: Georgia, serif; font-size: 20px; font-weight: 600; }
        .price { color: var(--berry); font-size: 12px; font-weight: 800; white-space: nowrap; padding-top: 4px; }
        .description { margin: 7px 0 13px; color: var(--muted); font-size: 11px; line-height: 1.7; }
        .product .button { width: 100%; min-height: 40px; font-size: 11px; }
        .story { padding: 25px 0 90px; }
        .story-card { display: grid; grid-template-columns: 1fr 1fr; overflow: hidden; border-radius: 24px; background: #efe4d7; }
        .story-image { min-height: 360px; height: 100%; width: 100%; object-fit: cover; }
        .story-copy { padding: clamp(28px, 5vw, 66px); align-self: center; }
        .story-copy h2 { margin: 17px 0; }
        .story-copy p { color: #6f6157; font-size: 13px; line-height: 1.9; }
        .story-copy .button { margin-top: 23px; }
        .closing { padding: 0 0 90px; }
        .closing-inner { padding: 48px 28px; text-align: center; border: 1px solid var(--line); border-radius: 22px; }
        .closing h2 { margin: 12px 0; }
        .closing p { color: var(--muted); font-size: 13px; margin: 0 auto 22px; max-width: 480px; }
        footer { background: var(--ink); color: #fff8ef; padding: 40px 0 22px; }
        .footer-main { display: flex; align-items: start; justify-content: space-between; gap: 28px; padding-bottom: 32px; }
        .footer-brand .brand-sub { color: #e5a6ad; }
        .footer-copy { color: #d0c0b4; max-width: 300px; font-size: 11px; margin-top: 15px; }
        .footer-links { display: flex; flex-wrap: wrap; gap: 22px; color: #eaded4; font-size: 11px; }
        .footer-bottom { border-top: 1px solid #51413a; padding-top: 18px; color: #bca99d; font-size: 10px; display: flex; justify-content: space-between; gap: 15px; }
        @media (max-width: 900px) {
            .navbar { gap: 16px; }
            nav { gap: 16px; }
            .hero-inner { gap: 32px; min-height: auto; }
            .hero-photo-wrap { height: 370px; }
            .trust-item { padding: 20px 10px; }
            .products { grid-template-columns: repeat(2, 1fr); row-gap: 30px; }
        }
        @media (max-width: 650px) {
            .container { width: min(100% - 30px, 520px); }
            .announcement { font-size: 9px; }
            .navbar { min-height: 72px; flex-wrap: wrap; padding: 13px 0; }
            .brand-name { font-size: 26px; }
            nav { order: 3; width: 100%; justify-content: space-between; gap: 10px; font-size: 11px; padding: 3px 0 5px; }
            .nav-actions .button { min-height: 38px; padding: 0 13px; font-size: 10px; }
            .hero-inner { grid-template-columns: 1fr; gap: 30px; padding-top: 46px; padding-bottom: 55px; }
            h1 { font-size: clamp(43px, 12vw, 60px); letter-spacing: -1.7px; }
            .hero-copy { font-size: 13px; }
            .hero-visual { margin: 0 12px 0 0; }
            .hero-photo-wrap { height: 340px; border-radius: 42% 42% 18px 18px; }
            .photo-tag { width: 105px; height: 105px; right: -10px; bottom: 18px; border-width: 5px; }
            .photo-tag span { font-size: 21px; }
            .trust-grid { grid-template-columns: repeat(2, 1fr); }
            .trust-item { justify-content: flex-start; border-bottom: 1px solid var(--line); padding: 17px 9px; }
            .trust-item:first-child { border-left: 0; }
            .trust-item:nth-child(odd) { border-right: 1px solid var(--line); }
            .trust-item:nth-child(even) { border-right: 0; }
            .trust-icon { font-size: 18px; }
            .trust-item strong { font-size: 10px; }
            .trust-item small { font-size: 9px; }
            section.menu-section { padding: 65px 0; }
            .section-top { align-items: start; flex-direction: column; margin-bottom: 24px; }
            .products { gap: 23px 12px; }
            .product-image-wrap { border-radius: 13px; }
            .product-info { padding-top: 11px; }
            .product h3 { font-size: 17px; }
            .price { font-size: 10px; }
            .description { font-size: 10px; }
            .product .button { padding: 0 10px; min-height: 37px; }
            .story { padding: 0 0 65px; }
            .story-card { grid-template-columns: 1fr; }
            .story-image { min-height: 240px; max-height: 300px; }
            .story-copy { padding: 30px 24px; }
            .closing { padding-bottom: 65px; }
            .closing-inner { padding: 36px 20px; }
            .footer-main { flex-direction: column; }
            .footer-bottom { flex-direction: column; gap: 7px; }
        }
    </style>
</head>
<body>
    <div class="announcement">MILKSHAKE FAVORITMU, DIBUAT FRESH UNTUK MENEMANI HARI</div>
    <header>
        <div class="container navbar">
            <a class="brand" href="#beranda" aria-label="Dejavu Milkshake beranda">
                <span class="brand-name">Dejavu</span>
                <span class="brand-sub">MILKSHAKE</span>
            </a>
            <nav aria-label="Navigasi utama">
                <a href="#beranda">Beranda</a>
                <a href="#menu">Menu</a>
                <a href="#tentang">Tentang Kami</a>
                <a href="#kontak">Kontak</a>
            </nav>
            <div class="nav-actions">
                <a class="button button-outline" href="#menu">Jelajahi Menu</a>
                <a class="button button-dark" href="#menu">Pesan Sekarang <span aria-hidden="true"></span></a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero" id="beranda">
            <div class="container hero-inner">
                <div class="hero-content">
                    <div class="eyebrow">Sedikit manis, banyak cerita</div>
                    <h1>Satu tegukan,<br><em>mood jadi baik.</em></h1>
                    <p class="hero-copy">Temukan milkshake creamy dengan rasa favoritmu. Diracik untuk menemani waktu santai, obrolan panjang, dan momen kecil yang ingin kamu ingat.</p>
                    <div class="hero-buttons">
                        <a class="button button-dark" href="#menu">Lihat Menu Kami <span aria-hidden="true"></span></a>
                        <a class="button button-outline" href="#tentang">Kenali Dejavu</a>
                    </div>
                    <p class="hero-note"><strong>Dejavu Milkshake</strong> · Segarnya bikin kangen.</p>
                </div>
                <div class="hero-visual">
                    <div class="hero-photo-wrap">
                        <img class="hero-photo" src="{{ asset('images/products/hero-milkshake.jpg') }}" alt="Milkshake Dejavu dengan kemasan khas" fetchpriority="high">
                    </div>
                    <div class="photo-tag"><span>Made<br>with love</span><small>Dejavu Milkshake</small></div>
                </div>
            </div>
        </section>

        <section class="trust-strip" aria-label="Keunggulan Dejavu">
            <div class="container trust-grid">
                <div class="trust-item"><span class="trust-icon" aria-hidden="true">✳</span><div><strong>Rasa yang memorable</strong><small>Favorit untuk setiap suasana</small></div></div>
                <div class="trust-item"><span class="trust-icon" aria-hidden="true">♡</span><div><strong>Dibuat sepenuh hati</strong><small>Detail kecil, rasa istimewa</small></div></div>
                <div class="trust-item"><span class="trust-icon" aria-hidden="true">☼</span><div><strong>Teman waktu santai</strong><small>Manisnya pas untuk harimu</small></div></div>
                <div class="trust-item"><span class="trust-icon" aria-hidden="true">✦</span><div><strong>Pilihan rasa beragam</strong><small>Cari rasa andalanmu</small></div></div>
            </div>
        </section>

        <section class="menu-section" id="menu">
            <div class="container">
                <div class="section-top">
                    <div>
                        <div class="eyebrow">Dari menu kami</div>
                        <h2>Temukan rasa<br>favoritmu.</h2>
                        <p class="section-intro">Setiap rasa punya ceritanya sendiri. Pilih yang paling cocok dengan suasana hatimu hari ini.</p>
                    </div>
                    <a class="small-link" href="#kontak">Tanya menu lengkap <span aria-hidden="true"></span></a>
                </div> 
            <div class="products">
                @forelse ($products as $product)
                    <article class="product">
                        <div class="product-image-wrap">
                            <img
                                class="product-image"
                                src="{{ asset($product->image) }}"
                                alt="Milkshake {{ $product->name }}"
                                loading="lazy"
                            >

                            @if ($loop->first)
                                <span class="product-label">BEST LOVED</span>
                            @endif
                        </div>

                        <div class="product-info">
                            <div class="product-title-row">
                               <h3>{{ $product->name === 'Strawberry Milkshake' ? 'Strawberry' : $product->name }}</h3>

                                <span class="price">
                                    Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <p class="description">
                                {{ $product->description }}
                            </p>

                            <a class="button button-outline"
                               href="{{ route('orders.create', $product->id) }}">
                                Pilih varian
                            </a>
                        </div>
                    </article>
                @empty
                    <p>Belum ada produk milkshake yang tersedia.</p>
                @endforelse
            </div>
            </div>
        </section>

        <section class="story" id="tentang">
            <div class="container">
                <div class="story-card">
                    <img class="story-image" src="{{ asset('images/products/tentang-kami.jpg') }}" alt="Cerita dan suasana Dejavu Milkshake" loading="lazy">
                    <div class="story-copy">
                        <div class="eyebrow">Cerita di balik gelas</div>
                        <h2>Hal sederhana<br>yang jadi kenangan.</h2>
                        <p>Dejavu Milkshake hadir dengan satu harapan sederhana: menghadirkan minuman yang bisa menemani hari dan menciptakan momen menyenangkan. Dari pilihan rasa sampai kemasannya, kami ingin setiap pesanan terasa spesial.</p>
                        <a class="button button-dark" href="#menu">Temukan pilihanmu <span aria-hidden="true"></span></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="closing" id="kontak">
            <div class="container">
                <div class="closing-inner">
                    <div class="eyebrow">Ada rasa untuk semua cerita</div>
                    <h2>Hari ini, pilih yang manis.</h2>
                    <p>Lihat varian milkshake Dejavu dan temukan teman yang pas untuk momenmu berikutnya.</p>
                    <a class="button button-dark" href="#menu">Lihat menu milkshake <span aria-hidden="true"></span></a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-main">
                <div class="footer-brand">
                    <a class="brand" href="#beranda">
                        <span class="brand-name">Dejavu</span>
                        <span class="brand-sub">MILKSHAKE</span>
                    </a>
                    <p class="footer-copy">Segarnya bikin kangen. Terima kasih sudah memberi ruang untuk Dejavu dalam harimu.</p>
                </div>
                <div class="footer-links">
                    <a href="#beranda">Beranda</a>
                    <a href="#menu">Menu</a>
                    <a href="#tentang">Tentang Kami</a>
                    <a href="#kontak">Kontak</a>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© {{ date('Y') }} Dejavu Milkshake. Semua hak dilindungi.</span>
                <span>Dibuat dengan sepenuh hati.</span>
            </div>
        </div>
    </footer>
</body>
</html>
