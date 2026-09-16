<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cafe->nama ?? 'Cafe' }} — Hulkam Caffe</title>
    <meta name="description" content="{{ Str::limit($cafe->deskripsi ?? 'Cafe pilihan di Jakarta Barat', 160) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg:           #F7EAD9;
            --bg-secondary: #F0DCC8;
            --surface:      #FFFFFF;
            --primary:      #E8935A;
            --primary-dark: #D07A42;
            --sage:         #7C8A5C;
            --brown:        #3A2A1D;
            --text:         #2A2119;
            --text-muted:   #7A6355;
            --border:       rgba(42,33,25,0.10);
            --shadow-card:  0 2px 16px rgba(42,33,25,0.09);
            --radius-card:  20px;
            --radius-pill:  9999px;
            --transition:   all 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        ::selection { background: var(--primary); color: #fff; }
        ::-moz-selection { background: var(--primary); color: #fff; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; }
        h1,h2,h3,h4 { font-family: 'Playfair Display', serif; line-height: 1.2; }
        a { text-decoration: none; color: inherit; }
        img { display: block; max-width: 100%; }

        /* NAVBAR */
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 0 24px; transition: var(--transition); }
        .navbar.scrolled { background: rgba(247,234,217,0.94); backdrop-filter: blur(16px); box-shadow: 0 1px 24px rgba(42,33,25,0.08); }
        .navbar-inner { max-width: 1180px; margin-inline: auto; display: flex; align-items: center; justify-content: space-between; height: 72px; }
        .navbar-brand { display: flex; align-items: center; gap: 10px; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 20px; color: var(--surface); transition: var(--transition); }
        .navbar.scrolled .navbar-brand { color: var(--brown); }
        .brand-icon { width: 36px; height: 36px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; flex-shrink: 0; }
        .navbar-nav { display: flex; align-items: center; gap: 6px; list-style: none; }
        .navbar-nav a { font-size: 14px; font-weight: 500; color: rgba(255,255,255,0.9); padding: 8px 14px; border-radius: 8px; transition: var(--transition); position: relative; }
        .navbar.scrolled .navbar-nav a { color: var(--text); }
        .navbar-nav a:hover { color: var(--primary) !important; }
        .navbar-nav .btn-nav { background: var(--primary); color: #fff !important; border-radius: var(--radius-pill); font-weight: 600; padding: 9px 20px; }
        .navbar-nav .btn-nav:hover { background: var(--primary-dark) !important; color: #fff !important; }

        /* HAMBURGER & MOBILE MENU */
        .navbar-toggler { display: none; background: none; border: none; cursor: pointer; padding: 4px; color: var(--surface); font-size: 20px; transition: var(--transition); }
        .navbar.scrolled .navbar-toggler { color: var(--text); }
        .mobile-menu { display: none; flex-direction: column; background: var(--surface); padding: 16px 24px 24px; gap: 4px; border-top: 1px solid var(--border); position: absolute; top: 100%; left: 0; right: 0; box-shadow: 0 16px 32px rgba(42,33,25,0.08); }
        .mobile-menu.open { display: flex; }
        .mobile-menu a { padding: 12px 16px; border-radius: 10px; font-size: 15px; font-weight: 500; color: var(--text); transition: var(--transition); }
        .mobile-menu a:hover { background: var(--bg); color: var(--primary); }
        .mobile-menu .btn-nav { background: var(--primary); color: #fff !important; text-align: center; border-radius: var(--radius-pill); margin-top: 8px; }

        /* HERO BANNER */
        .hero-banner {
            height: 520px;
            background: linear-gradient(to bottom, rgba(42,33,25,0.45) 0%, rgba(42,33,25,0.65) 100%),
                        url('{{ $cafe->foto_profil ?? "https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1400" }}') center/cover no-repeat;
            display: flex; align-items: flex-end; padding-bottom: 60px;
        }
        .hero-banner .container { max-width: 1180px; margin-inline: auto; padding-inline: 24px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 18px; border-radius: var(--radius-pill);
            font-size: 13px; font-weight: 700; letter-spacing: 0.05em;
            margin-bottom: 16px;
        }
        .hero-badge.open { background: rgba(124,138,92,0.9); color: #fff; }
        .hero-badge.closed { background: rgba(200,80,60,0.85); color: #fff; }
        .hero-title { font-size: clamp(36px,5vw,60px); color: #fff; margin-bottom: 12px; }
        .hero-address { font-size: 15px; color: rgba(255,255,255,0.8); display: flex; align-items: center; gap: 8px; }
        .hero-address i { color: var(--primary); }

        /* CONTAINER */
        .container { max-width: 1180px; margin-inline: auto; padding-inline: 24px; }

        /* SECTIONS */
        .section { padding: 72px 0; }
        .section-alt { background: var(--bg-secondary); }
        .section-label { font-size: 11px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 10px; }
        .section-title { font-size: clamp(26px,3.5vw,38px); color: var(--brown); margin-bottom: 8px; }
        .section-title em { font-style: italic; color: var(--primary); }

        /* INFO CARDS */
        .info-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 32px; align-items: start; }
        .info-card { background: var(--surface); border-radius: var(--radius-card); padding: 28px; box-shadow: var(--shadow-card); border: 1px solid var(--border); }
        .info-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 24px; }
        .info-block h4 { font-size: 15px; font-weight: 600; color: var(--brown); margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .info-block h4 i { color: var(--primary); font-size: 14px; }
        .info-block p { font-size: 14px; color: var(--text-muted); line-height: 1.65; }
        .fasilitas-list { list-style: none; display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px; }
        .fasilitas-pill { display: inline-flex; align-items: center; gap: 6px; background: var(--bg); border-radius: var(--radius-pill); padding: 6px 14px; font-size: 12.5px; font-weight: 500; color: var(--text); border: 1px solid var(--border); }
        .fasilitas-pill i { color: var(--sage); font-size: 11px; }

        /* GALLERY */
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .gallery-item { position: relative; border-radius: 16px; overflow: hidden; aspect-ratio: 1; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .gallery-item:hover img { transform: scale(1.06); }
        .gallery-label { position: absolute; bottom: 0; left: 0; right: 0; padding: 12px 14px; background: linear-gradient(to top, rgba(42,33,25,0.75), transparent); color: #fff; font-size: 12px; font-weight: 600; }

        /* MENU SECTION */
        .alert-closed { background: rgba(200,80,60,0.08); border: 1px solid rgba(200,80,60,0.25); border-radius: 14px; padding: 14px 20px; color: #b84030; font-size: 14px; margin-bottom: 28px; }
        .alert-success-styled { background: rgba(124,138,92,0.08); border: 1px solid rgba(124,138,92,0.25); border-radius: 14px; padding: 14px 20px; color: var(--sage); font-size: 14px; margin-bottom: 28px; display: flex; align-items: center; gap: 10px; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px; }
        .menu-card { background: var(--surface); border-radius: var(--radius-card); overflow: hidden; box-shadow: var(--shadow-card); border: 1px solid var(--border); transition: var(--transition); }
        .menu-card:hover { transform: translateY(-6px); box-shadow: 0 16px 48px rgba(42,33,25,0.13); }
        .menu-card-img { width: 100%; height: 200px; object-fit: cover; }
        .menu-card-body { padding: 18px 18px 20px; }
        .menu-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; gap: 8px; }
        .menu-card-name { font-size: 17px; font-weight: 700; color: var(--brown); }
        .badge-pill { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 600; flex-shrink: 0; }
        .badge-available { background: rgba(124,138,92,0.12); color: var(--sage); }
        .badge-habis { background: rgba(200,80,60,0.10); color: #b84030; }
        .menu-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 16px; line-height: 1.55; }
        .menu-card-footer { display: flex; justify-content: space-between; align-items: center; }
        .menu-price { font-size: 18px; font-weight: 700; color: var(--primary); font-family: 'Playfair Display', serif; }
        .btn-add { display: inline-flex; align-items: center; gap: 6px; background: var(--primary); color: #fff; padding: 9px 18px; border-radius: var(--radius-pill); font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: var(--transition); }
        .btn-add:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(232,147,90,0.35); }
        .btn-add:disabled, .btn-disabled { background: rgba(42,33,25,0.08); color: var(--text-muted); cursor: not-allowed; }
        .btn-view-cart { display: inline-flex; align-items: center; gap: 10px; background: var(--primary); color: #fff; padding: 16px 40px; border-radius: var(--radius-pill); font-size: 16px; font-weight: 600; transition: var(--transition); }
        .btn-view-cart:hover { background: var(--primary-dark); color: #fff; transform: translateY(-2px); box-shadow: 0 8px 28px rgba(232,147,90,0.35); }

        /* BOOKING FORM */
        .booking-wrap { background: var(--bg-secondary); padding: 72px 0; }
        .booking-card { background: var(--surface); border-radius: var(--radius-card); padding: 40px; box-shadow: var(--shadow-card); border: 1px solid var(--border); max-width: 640px; margin-inline: auto; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; }
        .form-control-styled {
            width: 100%; padding: 12px 16px; border-radius: 12px;
            border: 1.5px solid var(--border); background: var(--bg);
            font-family: 'Inter', sans-serif; font-size: 14px; color: var(--text);
            transition: var(--transition); outline: none;
        }
        .form-control-styled:focus { border-color: var(--primary); background: var(--surface); box-shadow: 0 0 0 3px rgba(232,147,90,0.12); }
        .form-control-styled[readonly] { opacity: 0.65; cursor: not-allowed; }
        .form-control-styled.select-styled { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%237A6355' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }
        .form-help { font-size: 12px; color: var(--text-muted); margin-top: 6px; }
        .alert-form { border-radius: 12px; padding: 12px 16px; font-size: 13.5px; margin-bottom: 20px; }
        .alert-form.error { background: rgba(200,80,60,0.08); border: 1px solid rgba(200,80,60,0.2); color: #b84030; }
        .btn-booking { width: 100%; padding: 16px; background: var(--primary); color: #fff; border: none; border-radius: var(--radius-pill); font-size: 16px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; transition: var(--transition); display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-booking:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 8px 28px rgba(232,147,90,0.35); }
        .btn-booking-login { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 16px; background: var(--bg-secondary); color: var(--brown); border: 2px solid var(--border); border-radius: var(--radius-pill); font-size: 15px; font-weight: 600; transition: var(--transition); }
        .btn-booking-login:hover { border-color: var(--primary); color: var(--primary); }

        /* FOOTER */
        .footer { background: var(--brown); color: rgba(247,234,217,0.7); padding: 48px 24px 32px; }
        .footer-inner { max-width: 1180px; margin-inline: auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: #F7EAD9; display: flex; align-items: center; gap: 8px; }
        .footer-brand i { color: var(--primary); }
        .footer-copy { font-size: 13px; color: rgba(247,234,217,0.5); }

        /* REVEAL */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }

        @media (max-width: 860px) {
            .info-grid { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: repeat(2,1fr); }
            .menu-grid { grid-template-columns: 1fr 1fr; }
            .navbar-nav { display: none; }
            .navbar-toggler { display: block; }
        }
        @media (max-width: 580px) {
            .gallery-grid { grid-template-columns: 1fr; }
            .menu-grid { grid-template-columns: 1fr; }
            .hero-banner { height: 420px; padding-bottom: 40px; }
            .info-row { grid-template-columns: 1fr; }
        }
    </style>
    <style>
        /* ===== KedaiSeduh Premium Dark override ===== */
        :root{--bg:#0E0B09;--bg-secondary:#17110B;--bg-sec:#17110B;--surface:#1B140E;--primary:#E0A263;--primary-dark:#C8894A;--sage:#93A56B;--brown:#F1E7D9;--text:#E9DECF;--text-muted:#A08E7B;--muted:#A08E7B;--border:rgba(224,178,122,0.14);--shadow-card:0 18px 45px rgba(0,0,0,0.45);}
        body{background-color:#0E0B09;color:#E9DECF;}
        .navbar.scrolled{background:rgba(14,11,9,0.92) !important;box-shadow:0 1px 24px rgba(0,0,0,0.5) !important;}
        .navbar-brand{color:#F1E7D9 !important;}
        .navbar-toggler{color:#F1E7D9 !important;}
        .footer{background:#100C08 !important;}
        ::selection{background:#E0A263;color:#1B140E;}
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar" id="mainNavbar">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="navbar-brand">
                <div class="brand-icon"><i class="fas fa-coffee"></i></div>
                Hulkam Caffe
            </a>
            <ul class="navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="#booking">Booking</a></li>
                <li><a href="#menu">Menu</a></li>
                @auth
                    <li><a href="{{ route('order.index') }}" class="btn-nav"><i class="fas fa-box" style="font-size:12px;"></i> Pesanan</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="btn-nav"><i class="fas fa-sign-in-alt" style="font-size:12px;"></i> Login</a></li>
                @endauth
            </ul>
            
            <button class="navbar-toggler" id="navToggler" aria-label="Toggle menu">
                <i class="fas fa-bars" id="toggleIcon"></i>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ url('/') }}">Home</a>
            <a href="#booking">Booking</a>
            <a href="#menu">Menu</a>
            @auth
                <a href="{{ route('order.index') }}" class="btn-nav">Pesanan</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav">Login</a>
            @endauth
        </div>
    </nav>

    <!-- HERO BANNER -->
    <div class="hero-banner">
        <div class="container">
            @if($cafe->is_open)
                <div class="hero-badge open"><i class="fas fa-door-open"></i> BUKA</div>
            @else
                <div class="hero-badge closed"><i class="fas fa-door-closed"></i> TUTUP</div>
            @endif
            <h1 class="hero-title">{{ $cafe->nama }}</h1>
            <p class="hero-address"><i class="fas fa-map-marker-alt"></i> {{ $cafe->alamat ?? 'Jakarta Barat' }}</p>
        </div>
    </div>

    <!-- TENTANG KAMI -->
    <section class="section">
        <div class="container">
            <div class="info-grid">
                <div>
                    <span class="section-label">Tentang Kami</span>
                    <h2 class="section-title">{{ $cafe->nama }}</h2>
                    @if($cafe->deskripsi)
                        <p style="color:var(--text-muted);line-height:1.75;margin-top:12px;">{!! nl2br(e($cafe->deskripsi)) !!}</p>
                    @else
                        <p style="color:var(--text-muted);line-height:1.75;margin-top:12px;">Selamat datang di {{ $cafe->nama }}! Kunjungi kami untuk pengalaman yang menyenangkan.</p>
                    @endif

                    <div class="info-row">
                        <div class="info-block">
                            <h4><i class="fas fa-clock"></i> Jam Operasional</h4>
                            @if($cafe->jam_operasional)
                                <p>{!! nl2br(e($cafe->jam_operasional)) !!}</p>
                            @else
                                <p>Hubungi kami untuk info jam buka.</p>
                            @endif
                        </div>
                        <div class="info-block">
                            <h4><i class="fas fa-phone"></i> Kontak</h4>
                            <p>
                                @if($cafe->no_telp)Telepon: {{ $cafe->no_telp }}<br>@endif
                                <i class="fas fa-map-marker-alt" style="color:var(--primary);font-size:11px;"></i> {{ $cafe->alamat ?? 'Jakarta Barat' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FASILITAS CARD -->
                <div class="info-card reveal">
                    <span class="section-label">Fasilitas</span>
                    @php
                        $fasilitasIcons = [
                            'wifi' => 'fa-wifi', 'ac' => 'fa-snowflake', 'toilet' => 'fa-restroom',
                            'parkir' => 'fa-parking', 'smoking area' => 'fa-smoking',
                            'non-smoking' => 'fa-smoking-ban', 'wheelchair' => 'fa-wheelchair',
                            'power' => 'fa-plug', 'outlet' => 'fa-plug',
                            'mushola' => 'fa-mosque', 'live music' => 'fa-music',
                        ];
                        $fasilitasList = $cafe->fasilitas
                            ? array_filter(array_map('trim', explode(',', $cafe->fasilitas)))
                            : [];
                    @endphp
                    @if(count($fasilitasList) > 0)
                        <ul class="fasilitas-list">
                            @foreach($fasilitasList as $fasilitas)
                                @php
                                    $icon = 'fa-check'; $lower = strtolower($fasilitas);
                                    foreach($fasilitasIcons as $key => $ic) {
                                        if (str_contains($lower, $key)) { $icon = $ic; break; }
                                    }
                                @endphp
                                <li class="fasilitas-pill"><i class="fas {{ $icon }}"></i> {{ $fasilitas }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p style="color:var(--text-muted);font-size:14px;margin-top:8px;">Belum ada informasi fasilitas.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- GALLERY -->
    @if(isset($galeri) && count($galeri) > 0)
    <section class="section section-alt">
        <div class="container">
            <div style="text-align:center;margin-bottom:40px;" class="reveal">
                <span class="section-label">Galeri</span>
                <h2 class="section-title">Lihat <em>Suasana</em> Kami</h2>
            </div>
            <div class="gallery-grid">
                @foreach($galeri as $g)
                <div class="gallery-item reveal">
                    <img src="{{ $g->gambar }}" alt="Galeri {{ $cafe->nama }}" onerror="this.parentElement.style.display='none'">
                    @if($g->nama_ruangan)
                        <div class="gallery-label">{{ $g->nama_ruangan }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- MENU SECTION -->
    <section id="menu" class="section">
        <div class="container">
            <div style="text-align:center;margin-bottom:40px;" class="reveal">
                <span class="section-label">Menu Kami</span>
                <h2 class="section-title"><em>Pilihan</em> Spesial</h2>
            </div>

            @if(!$cafe->is_open)
                <div class="alert-closed">
                    <i class="fas fa-exclamation-triangle" style="margin-right:8px;"></i>
                    Mohon maaf, cafe sedang tutup. Anda tidak dapat memesan menu saat ini.
                </div>
            @endif

            @if(session('success'))
                <div class="alert-success-styled">
                    <i class="fas fa-check-circle"></i>{{ session('success') }}
                </div>
            @endif

            <div class="menu-grid">
                @forelse($menus as $menu)
                <div class="menu-card reveal">
                    <img src="{{ $menu->gambar ?? 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=500' }}"
                         class="menu-card-img" alt="{{ $menu->nama_menu }}"
                         onerror="this.src='https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=500'">
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <div class="menu-card-name">{{ $menu->nama_menu }}</div>
                            @if(isset($menu->status) && $menu->status == 'habis')
                                <span class="badge-pill badge-habis"><i class="fas fa-times-circle" style="font-size:9px;"></i> Habis</span>
                            @else
                                <span class="badge-pill badge-available"><i class="fas fa-check-circle" style="font-size:9px;"></i> Tersedia</span>
                            @endif
                        </div>
                        <p class="menu-desc">{{ $menu->deskripsi ?? 'Nikmati kesegaran dan kelezatan menu spesial kami.' }}</p>
                        <div class="menu-card-footer">
                            <div class="menu-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                            @if(!isset($menu->status) || $menu->status != 'habis')
                                @if($cafe->is_open)
                                    <form action="{{ route('cart.add', ['cafe_id' => $cafe->id]) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <input type="hidden" name="jumlah" value="1">
                                        <button type="submit" class="btn-add">
                                            <i class="fas fa-cart-plus" style="font-size:12px;"></i> Tambah
                                        </button>
                                    </form>
                                @else
                                    <button class="btn-add btn-disabled" disabled>
                                        <i class="fas fa-ban" style="font-size:12px;"></i> Tutup
                                    </button>
                                @endif
                            @else
                                <button class="btn-add btn-disabled" disabled>Habis</button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--text-muted);">
                    <i class="fas fa-utensils" style="font-size:40px;opacity:0.3;display:block;margin-bottom:16px;"></i>
                    Belum ada menu yang tersedia untuk cafe ini.
                </div>
                @endforelse
            </div>

            <div style="text-align:center;margin-top:48px;" class="reveal">
                @if($cafe->is_open)
                    <a href="{{ route('cart.index', ['cafe_id' => $cafe->id]) }}" class="btn-view-cart">
                        <i class="fas fa-shopping-cart"></i> Lihat Keranjang
                    </a>
                @else
                    <button class="btn-view-cart" style="background:var(--bg-secondary);color:var(--text-muted);cursor:not-allowed;" disabled>
                        <i class="fas fa-shopping-cart"></i> Lihat Keranjang
                    </button>
                @endif
            </div>
        </div>
    </section>

    <!-- BOOKING SECTION -->
    <div class="booking-wrap" id="booking">
        <div class="container">
            <div style="text-align:center;margin-bottom:40px;" class="reveal">
                <span class="section-label">Reservasi</span>
                <h2 class="section-title">Pesan <em>Meja</em> Sekarang</h2>
            </div>
            <div class="booking-card reveal">
                <form action="{{ route('booking.store', $cafe->id) }}" method="POST">
                    @csrf

                    @if(session('error'))
                        <div class="alert-form error"><i class="fas fa-exclamation-circle" style="margin-right:8px;"></i>{{ session('error') }}</div>
                    @endif

                    @auth
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control-styled" value="{{ Auth::user()->name }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control-styled" value="{{ Auth::user()->email }}" required readonly>
                        </div>
                    @else
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control-styled" value="{{ old('nama') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control-styled" value="{{ old('email') }}" required>
                        </div>
                    @endauth

                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" name="no_telp" class="form-control-styled" value="{{ old('no_telp') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal & Waktu</label>
                        <input type="datetime-local" name="tgl" class="form-control-styled" value="{{ old('tgl') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Orang</label>
                        <select name="num_person" class="form-control-styled select-styled" required>
                            <option value="">Pilih...</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('num_person') == $i ? 'selected' : '' }}>{{ $i }} Orang</option>
                            @endfor
                            <option value="11" {{ old('num_person') == '11' ? 'selected' : '' }}>Lebih dari 10 Orang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pilih Meja</label>
                        <select name="table_id" class="form-control-styled select-styled" required>
                            <option value="">Pilih Meja...</option>
                            @foreach($tables as $t)
                                <option value="{{ $t->id }}" {{ old('table_id') == $t->id ? 'selected' : '' }}>
                                    Meja {{ $t->no_table }} (Max {{ $t->max_person }} orang)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keperluan / Tujuan Booking</label>
                        <textarea name="catatan" class="form-control-styled" rows="3" placeholder="Contoh: Meeting, Nongkrong, Rayain Ulang Tahun, Reuni, dll" required>{{ old('catatan') }}</textarea>
                        <p class="form-help">Jelaskan secara singkat tujuan reservasi meja Anda.</p>
                    </div>

                    @auth
                        <button type="submit" onclick="if(this.form.checkValidity()){ this.classList.add('opacity-80', 'cursor-not-allowed'); this.innerHTML='<i class=\'fas fa-spinner fa-spin mr-2\'></i> Memproses...'; }" class="btn-booking">
                            <i class="fas fa-calendar-check"></i> Reservasi Sekarang
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="btn-booking-login">
                            <i class="fas fa-sign-in-alt"></i> Login untuk Reservasi
                        </a>
                    @endauth
                </form>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand"><i class="fas fa-coffee"></i> Hulkam Caffe</div>
            <div class="footer-copy">&copy; 2026 JPapua Pegunungan Cafe Hub. All rights reserved.</div>
        </div>
    </footer>

    <script>
        // Navbar scroll
        const nav = document.getElementById('mainNavbar');
        window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 40), { passive: true });

        // Reveal on scroll
        const observer = new IntersectionObserver(entries => {
            entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); observer.unobserve(e.target); } });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Mobile menu toggle
        const toggler = document.getElementById('navToggler');
        const mobileMenu = document.getElementById('mobileMenu');
        const toggleIcon = document.getElementById('toggleIcon');
        toggler.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            toggleIcon.className = mobileMenu.classList.contains('open') ? 'fas fa-times' : 'fas fa-bars';
        });
    </script>
</body>
</html>