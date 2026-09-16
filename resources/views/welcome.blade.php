<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hulkam Caffe — Temukan Cafe Terbaik di Papua Pegunungan</title>
    <meta name="description" content="Pesan meja dan nikmati pengalaman kuliner tak terlupakan di cafe-cafe pilihan Jakarta Barat. Booking mudah, menu variatif, pembayaran fleksibel.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* =============================================
           DESIGN TOKENS — Kosmos-inspired System
        ============================================= */
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

        /* =============================================
           RESET & BASE
        ============================================= */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        ::selection { background: var(--primary); color: #fff; }
        ::-moz-selection { background: var(--primary); color: #fff; }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            line-height: 1.2;
        }
        a { text-decoration: none; color: inherit; }
        img { display: block; max-width: 100%; }

        /* =============================================
           UTILITY
        ============================================= */
        .container {
            max-width: 1180px;
            margin-inline: auto;
            padding-inline: 24px;
        }
        .label-tag {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
        }
        .btn-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            border-radius: var(--radius-pill);
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 15px;
            transition: var(--transition);
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: var(--primary);
            color: #fff;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(232,147,90,0.35);
            color: #fff;
        }
        .btn-outline {
            background: transparent;
            color: var(--text);
            border: 2px solid var(--border);
        }
        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        /* =============================================
           NAVBAR
        ============================================= */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 0 24px;
            transition: var(--transition);
        }
        .navbar.scrolled {
            background: rgba(247,234,217,0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 1px 24px rgba(42,33,25,0.08);
        }
        .navbar-inner {
            max-width: 1180px;
            margin-inline: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 20px;
            color: var(--brown);
        }
        .navbar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
            flex-shrink: 0;
        }
        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
        }
        .navbar-nav a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            padding: 8px 14px;
            border-radius: 8px;
            position: relative;
            transition: var(--transition);
        }
        .navbar-nav a::after {
            content: '';
            position: absolute;
            bottom: 4px; left: 14px; right: 14px;
            height: 2px;
            background: var(--primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s ease;
        }
        .navbar-nav a:hover { color: var(--primary); }
        .navbar-nav a:hover::after { transform: scaleX(1); }
        .navbar-nav a.active { color: var(--primary); }
        .navbar-nav a.active::after { transform: scaleX(1); }
        .navbar-nav .btn-nav {
            background: var(--primary);
            color: #fff !important;
            padding: 9px 20px;
            border-radius: var(--radius-pill);
            font-weight: 600;
        }
        .navbar-nav .btn-nav::after { display: none; }
        .navbar-nav .btn-nav:hover {
            background: var(--primary-dark) !important;
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(232,147,90,0.3);
        }

        /* Dropdown */
        .dropdown { position: relative; }
        .dropdown-menu-custom {
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%);
            min-width: 200px;
            background: var(--surface);
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(42,33,25,0.14);
            border: 1px solid var(--border);
            padding: 6px;
            opacity: 0;
            visibility: hidden;
            transform: translateX(-50%) translateY(-8px);
            transition: all 0.2s ease;
            z-index: 200;
        }
        .dropdown:hover .dropdown-menu-custom,
        .dropdown-menu-custom:hover {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        .dropdown-menu-custom a {
            display: block;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            color: var(--text);
            transition: var(--transition);
        }
        .dropdown-menu-custom a::after { display: none; }
        .dropdown-menu-custom a:hover {
            background: var(--bg);
            color: var(--primary);
        }
        .dropdown-toggle-icon {
            font-size: 10px;
            margin-left: 2px;
            transition: transform 0.2s;
        }
        .dropdown:hover .dropdown-toggle-icon { transform: rotate(180deg); }

        /* Hamburger */
        .navbar-toggler {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--text);
            font-size: 20px;
        }
        .mobile-menu {
            display: none;
            flex-direction: column;
            background: var(--surface);
            padding: 16px 24px 24px;
            gap: 4px;
            border-top: 1px solid var(--border);
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            color: var(--text);
            transition: var(--transition);
        }
        .mobile-menu a:hover { background: var(--bg); color: var(--primary); }
        .mobile-menu .btn-nav {
            background: var(--primary);
            color: #fff !important;
            text-align: center;
            border-radius: var(--radius-pill);
            margin-top: 8px;
        }

        /* =============================================
           HERO SECTION
        ============================================= */
        .hero {
            min-height: 100vh;
            background: var(--bg);
            display: flex;
            align-items: center;
            padding-top: 80px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -120px; right: -80px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(232,147,90,0.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -100px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(124,138,92,0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .hero-inner {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 60px;
            width: 100%;
            padding-block: 80px;
        }
        .hero-content { }
        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(232,147,90,0.12);
            color: var(--primary-dark);
            border-radius: var(--radius-pill);
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 24px;
        }
        .hero-label i { font-size: 10px; }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(42px, 5.5vw, 68px);
            font-weight: 700;
            color: var(--brown);
            margin-bottom: 20px;
            line-height: 1.1;
        }
        .hero-title em {
            font-style: italic;
            color: var(--primary);
        }
        .hero-subtitle {
            font-size: 17px;
            color: var(--text-muted);
            margin-bottom: 40px;
            max-width: 440px;
            line-height: 1.7;
        }
        .hero-ctas {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .hero-stats {
            display: flex;
            gap: 32px;
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid var(--border);
        }
        .hero-stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--brown);
        }
        .hero-stat-label {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Hero Image Side */
        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: flex-end;
        }
        .hero-img-wrap {
            position: relative;
            width: 100%;
            max-width: 460px;
        }
        .hero-img-main {
            width: 100%;
            aspect-ratio: 4/5;
            object-fit: cover;
            border-radius: 40% 40% 50% 50% / 20% 20% 50% 50%;
            box-shadow: 0 24px 64px rgba(42,33,25,0.18);
        }
        .hero-img-badge {
            position: absolute;
            bottom: 32px;
            left: -20px;
            background: var(--surface);
            border-radius: 16px;
            padding: 14px 20px;
            box-shadow: 0 8px 32px rgba(42,33,25,0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 220px;
        }
        .hero-img-badge .badge-icon {
            width: 42px;
            height: 42px;
            background: var(--bg-secondary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 18px;
            flex-shrink: 0;
        }
        .hero-img-badge .badge-text { font-size: 13px; font-weight: 600; color: var(--text); }
        .hero-img-badge .badge-sub { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
        .hero-img-float {
            position: absolute;
            top: 20px;
            right: -16px;
            background: var(--primary);
            color: #fff;
            border-radius: 14px;
            padding: 10px 16px;
            box-shadow: 0 8px 24px rgba(232,147,90,0.35);
        }
        .hero-img-float .float-num {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
        }
        .hero-img-float .float-label { font-size: 10px; font-weight: 500; opacity: 0.85; margin-top: 2px; }

        /* =============================================
           FEATURES SECTION
        ============================================= */
        .features {
            background: var(--bg-secondary);
            padding: 80px 24px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .feature-card {
            background: var(--surface);
            border-radius: var(--radius-card);
            padding: 32px 28px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(42,33,25,0.12);
        }
        .feature-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 20px;
        }
        .feature-icon-wrap.terracotta {
            background: rgba(232,147,90,0.15);
            color: var(--primary);
        }
        .feature-icon-wrap.sage {
            background: rgba(124,138,92,0.15);
            color: var(--sage);
        }
        .feature-icon-wrap.brown {
            background: rgba(58,42,29,0.10);
            color: var(--brown);
        }
        .feature-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--brown);
            margin-bottom: 10px;
        }
        .feature-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.65;
        }

        /* =============================================
           CAFE CARDS SECTION
        ============================================= */
        .cafes-section {
            padding: 100px 24px;
            background: var(--bg);
        }
        .section-header {
            text-align: center;
            margin-bottom: 56px;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 700;
            color: var(--brown);
            margin-top: 12px;
        }
        .section-title em { font-style: italic; color: var(--primary); }
        .section-subtitle {
            font-size: 15px;
            color: var(--text-muted);
            margin-top: 12px;
        }
        .cafes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 28px;
        }
        .cafe-card {
            background: var(--surface);
            border-radius: var(--radius-card);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }
        .cafe-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(42,33,25,0.15);
        }
        .cafe-card-img-wrap {
            position: relative;
            overflow: hidden;
            height: 220px;
        }
        .cafe-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .cafe-card:hover .cafe-card-img { transform: scale(1.06); }
        .cafe-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(42,33,25,0.5) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .cafe-card:hover .cafe-card-overlay { opacity: 1; }
        .cafe-card-body {
            padding: 22px 22px 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .cafe-card-name {
            font-size: 19px;
            font-weight: 700;
            color: var(--brown);
            margin-bottom: 8px;
        }
        .cafe-card-address {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 12px;
        }
        .cafe-card-address i { color: var(--primary); font-size: 11px; }
        .cafe-card-desc {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.6;
            flex: 1;
            margin-bottom: 20px;
        }
        .cafe-card-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 0;
            background: var(--primary);
            color: #fff;
            border-radius: var(--radius-pill);
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
        }
        .cafe-card-btn:hover {
            background: var(--primary-dark);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(232,147,90,0.35);
        }
        .cafe-empty {
            grid-column: 1/-1;
            text-align: center;
            padding: 60px;
            color: var(--text-muted);
            font-size: 16px;
        }
        .cafe-empty i { font-size: 40px; margin-bottom: 16px; opacity: 0.4; display: block; }

        /* =============================================
           CTA BANNER
        ============================================= */
        .cta-banner {
            background: var(--brown);
            padding: 80px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-banner::before {
            content: '';
            position: absolute;
            top: -60px; left: 50%;
            transform: translateX(-50%);
            width: 800px; height: 400px;
            background: radial-gradient(ellipse, rgba(232,147,90,0.18) 0%, transparent 70%);
        }
        .cta-banner h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 4vw, 42px);
            color: #F7EAD9;
            margin-bottom: 16px;
        }
        .cta-banner h2 em { font-style: italic; color: var(--primary); }
        .cta-banner p {
            font-size: 16px;
            color: rgba(247,234,217,0.65);
            margin-bottom: 36px;
            max-width: 500px;
            margin-inline: auto;
        }
        .cta-banner .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--primary);
            color: #fff;
            padding: 16px 40px;
            border-radius: var(--radius-pill);
            font-weight: 600;
            font-size: 16px;
            transition: var(--transition);
        }
        .cta-banner .btn-cta:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(232,147,90,0.4);
        }

        /* =============================================
           FOOTER
        ============================================= */
        .footer {
            background: var(--brown);
            color: rgba(247,234,217,0.7);
            padding: 48px 24px 32px;
            border-top: 1px solid rgba(247,234,217,0.08);
        }
        .footer-inner {
            max-width: 1180px;
            margin-inline: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: #F7EAD9;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .footer-brand i { color: var(--primary); }
        .footer-copy {
            font-size: 13px;
            color: rgba(247,234,217,0.5);
        }
        .footer-socials {
            display: flex;
            gap: 12px;
        }
        .footer-socials a {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(247,234,217,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(247,234,217,0.7);
            font-size: 15px;
            transition: var(--transition);
        }
        .footer-socials a:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px);
        }

        /* =============================================
           SCROLL TO TOP
        ============================================= */
        .btn-scroll-top {
            position: fixed; bottom: 30px; right: 30px; z-index: 90;
            width: 48px; height: 48px; border-radius: 14px;
            background: var(--primary); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 18px;
            box-shadow: 0 10px 24px rgba(232,147,90,0.4);
            opacity: 0; visibility: hidden; transform: translateY(20px);
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1); cursor: pointer; border: none;
        }
        .btn-scroll-top.show { opacity: 1; visibility: visible; transform: translateY(0); }
        .btn-scroll-top:hover { background: var(--primary-dark); transform: translateY(-4px); box-shadow: 0 14px 32px rgba(232,147,90,0.5); }

        /* =============================================
           SCROLL REVEAL ANIMATION
        ============================================= */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }

        /* =============================================
           RESPONSIVE
        ============================================= */
        @media (max-width: 900px) {
            .hero-inner { grid-template-columns: 1fr; gap: 40px; padding-block: 60px; }
            .hero-visual { order: -1; }
            .hero-img-main { border-radius: 28px; aspect-ratio: 16/9; }
            .hero-img-badge { left: 12px; bottom: 12px; }
            .hero-img-float { right: 12px; top: 12px; }
            .features-grid { grid-template-columns: 1fr; }
            .navbar-nav { display: none; }
            .navbar-toggler { display: block; }
        }
        @media (max-width: 600px) {
            .hero-title { font-size: 36px; }
            .hero-stats { flex-wrap: wrap; gap: 20px; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
            .cafes-grid { grid-template-columns: 1fr; }
        }
    </style>
    <style>
        /* ===== KedaiSeduh Premium Dark override ===== */
        :root{
            --bg:#0E0B09; --bg-secondary:#17110B; --bg-sec:#17110B; --surface:#1B140E;
            --primary:#E0A263; --primary-dark:#C8894A; --sage:#93A56B;
            --brown:#F1E7D9; --text:#E9DECF; --text-muted:#A08E7B; --muted:#A08E7B;
            --border:rgba(224,178,122,0.14); --shadow-card:0 18px 45px rgba(0,0,0,0.45);
        }
        body{background-color:#0E0B09; color:#E9DECF;}
        .navbar.scrolled{background:rgba(14,11,9,0.9) !important; box-shadow:0 1px 24px rgba(0,0,0,0.5) !important;}
        .cta-banner, .footer{background:#100C08 !important;}
        ::selection{background:#E0A263; color:#1B140E;}
    </style>
</head>
<body>

    <!-- ============================================================
         NAVBAR
    ============================================================ -->
    <nav class="navbar" id="mainNavbar">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="navbar-brand">
                <div class="brand-icon"><i class="fas fa-coffee"></i></div>
                Hulkam Caffe
            </a>

            <ul class="navbar-nav" id="navLinks">
                <li><a href="{{ url('/') }}" class="active">Home</a></li>

                <!-- Cafe List Dropdown -->
                <li class="dropdown">
                    <a href="#cafes" style="display:flex;align-items:center;gap:4px;">
                        <i class="fas fa-store" style="font-size:12px;"></i> Cafe List
                        <i class="fas fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <div class="dropdown-menu-custom">
                        @if(isset($cafes) && count($cafes) > 0)
                            @foreach($cafes as $c)
                                <a href="{{ route('cafe.detail', $c->id) }}">{{ $c->nama }}</a>
                            @endforeach
                        @else
                            <a style="color:var(--text-muted);cursor:default;">Belum ada cafe</a>
                        @endif
                    </div>
                </li>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <li>
                            <a href="{{ route('admin.admin-dashboard') }}">
                                <i class="fas fa-user-shield" style="font-size:12px;"></i> Admin
                            </a>
                        </li>
                    @elseif(Auth::user()->role === 'vendor')
                        <li>
                            <a href="{{ route('vendor.dashboard') }}">
                                <i class="fas fa-store-alt" style="font-size:12px;"></i> Vendor
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('order.index') }}">
                                <i class="fas fa-box" style="font-size:12px;"></i> Pesanan Saya
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ Auth::user()->role === 'vendor' ? route('vendor.profil.index') : route('profil.index') }}" class="btn-nav">
                            <i class="fas fa-user-circle" style="font-size:12px;"></i> Profil
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="btn-nav">
                            <i class="fas fa-sign-in-alt" style="font-size:12px;"></i> Login
                        </a>
                    </li>
                @endauth
            </ul>

            <button class="navbar-toggler" id="navToggler" aria-label="Toggle menu">
                <i class="fas fa-bars" id="toggleIcon"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ url('/') }}">Home</a>
            <a href="#cafes"><i class="fas fa-store" style="font-size:12px;margin-right:6px;"></i> Cafe List</a>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.admin-dashboard') }}">Admin Dashboard</a>
                @elseif(Auth::user()->role === 'vendor')
                    <a href="{{ route('vendor.dashboard') }}">Vendor Dashboard</a>
                @else
                    <a href="{{ route('order.index') }}">Pesanan Saya</a>
                @endif
                <a href="{{ Auth::user()->role === 'vendor' ? route('vendor.profil.index') : route('profil.index') }}" class="btn-nav">Profil Saya</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav">Login</a>
            @endauth
        </div>
    </nav>

    <!-- ============================================================
         HERO SECTION
    ============================================================ -->
    <section class="hero">
        <div class="container">
            <div class="hero-inner">
                <!-- Text Content -->
                <div class="hero-content">
                    <div class="hero-label reveal">
                        <i class="fas fa-map-marker-alt"></i>
                        Papua Pegunungan · West Papua
                    </div>
                    <h1 class="hero-title reveal reveal-delay-1">
                        Temukan Cafe<br><em>Terbaik di</em><br>Papua Pegunungan
                    </h1>
                    <p class="hero-subtitle reveal reveal-delay-2">
                        Pesan meja dan nikmati pengalaman kuliner yang tak terlupakan — dari kopi specialty hingga brunch favorit, semua ada di sini.
                    </p>
                    <div class="hero-ctas reveal reveal-delay-2">
                        <a href="#cafes" class="btn-pill btn-primary">
                            <i class="fas fa-search"></i> Jelajahi Cafe
                        </a>
                        @guest
                        <a href="{{ route('login') }}" class="btn-pill btn-outline">
                            Masuk <i class="fas fa-arrow-right" style="font-size:12px;"></i>
                        </a>
                        @endguest
                    </div>
                    <div class="hero-stats reveal reveal-delay-3">
                        <div>
                            <div class="hero-stat-num">{{ isset($cafes) ? count($cafes) : '10' }}+</div>
                            <div class="hero-stat-label">Cafe Pilihan</div>
                        </div>
                        <div>
                            <div class="hero-stat-num">100%</div>
                            <div class="hero-stat-label">Booking Online</div>
                        </div>
                        <div>
                            <div class="hero-stat-num">QRIS</div>
                            <div class="hero-stat-label">Pembayaran</div>
                        </div>
                    </div>
                </div>

                <!-- Visual Side -->
                <div class="hero-visual reveal reveal-delay-1">
                    <div class="hero-img-wrap">
                        <img
                            src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800&q=80"
                            alt="Suasana cafe di Jakarta Barat"
                            class="hero-img-main"
                            onerror="this.src='https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800'"
                        >
                        <div class="hero-img-badge">
                            <div class="badge-icon"><i class="fas fa-calendar-check"></i></div>
                            <div>
                                <div class="badge-text">Booking Mudah</div>
                                <div class="badge-sub">Reservasi dalam hitungan detik</div>
                            </div>
                        </div>
                        <div class="hero-img-float">
                            <div class="float-num">⭐ 4.9</div>
                            <div class="float-label">Rating Terbaik</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         FEATURES SECTION
    ============================================================ -->
    <section class="features">
        <div class="container">
            <div class="section-header reveal">
                <span class="label-tag">Kenapa Hulkam Caffe?</span>
                <h2 class="section-title">Satu platform, semua <em>kemudahan</em></h2>
            </div>
            <div class="features-grid">
                <div class="feature-card reveal">
                    <div class="feature-icon-wrap terracotta">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="feature-title">Booking Mudah</div>
                    <p class="feature-desc">Reservasi meja dengan cepat dan praktis langsung dari halaman cafe pilihan Anda.</p>
                </div>
                <div class="feature-card reveal reveal-delay-1">
                    <div class="feature-icon-wrap sage">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="feature-title">Menu Variatif</div>
                    <p class="feature-desc">Berbagai pilihan makanan dan minuman berkualitas dari cafe-cafe pilihan terbaik Jakarta Barat.</p>
                </div>
                <div class="feature-card reveal reveal-delay-2">
                    <div class="feature-icon-wrap brown">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="feature-title">Pembayaran Fleksibel</div>
                    <p class="feature-desc">Cash atau QRIS, sesuai kebutuhan Anda. Scan, bayar, dan nikmati — semudah itu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         CAFE CARDS SECTION
    ============================================================ -->
    <section id="cafes" class="cafes-section">
        <div class="container">
            <div class="section-header reveal">
                <span class="label-tag">Temukan Tempat Favoritmu</span>
                <h2 class="section-title">Cafe <em>Pilihan</em> Kami</h2>
                <p class="section-subtitle">Dari kopi specialty hingga tempat nongkrong asyik, semuanya ada di sini.</p>
            </div>

            <div class="cafes-grid">
                @forelse($cafes as $cafe)
                <div class="cafe-card reveal">
                    <div class="cafe-card-img-wrap">
                        <img
                            src="{{ $cafe->foto_profil ?: 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=600' }}"
                            class="cafe-card-img"
                            alt="{{ $cafe->nama }}"
                            onerror="this.src='https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=600'"
                        >
                        <div class="cafe-card-overlay"></div>
                    </div>
                    <div class="cafe-card-body">
                        <div class="cafe-card-name">{{ $cafe->nama }}</div>
                        <div class="cafe-card-address">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ Str::limit($cafe->alamat ?? 'Jakarta Barat', 36) }}
                        </div>
                        <p class="cafe-card-desc">{{ Str::limit($cafe->deskripsi ?? 'Cafe nyaman di Jakarta Barat', 70) }}</p>
                        <a href="{{ route('cafe.detail', $cafe->id) }}" class="cafe-card-btn">
                            <i class="fas fa-eye" style="font-size:13px;"></i> Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                <div class="cafe-empty reveal">
                    <i class="fas fa-store-slash"></i>
                    Belum ada data cafe tersedia.
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ============================================================
         CTA BANNER
    ============================================================ -->
    <section class="cta-banner">
        <div class="container" style="position:relative;z-index:2;">
            <div class="reveal">
                <h2>Siap untuk pengalaman<br>cafe yang <em>berbeda?</em></h2>
                <p>Daftar sekarang dan nikmati kemudahan memesan meja di cafe favorit Anda kapan saja, di mana saja.</p>
                @guest
                    <a href="{{ route('login') }}" class="btn-cta">
                        Mulai Sekarang <i class="fas fa-arrow-right"></i>
                    </a>
                @else
                    <a href="#cafes" class="btn-cta">
                        Jelajahi Cafe <i class="fas fa-arrow-right"></i>
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- ============================================================
         FOOTER
    ============================================================ -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <i class="fas fa-coffee"></i> Hulkam Caffe
            </div>
            <div class="footer-copy">
                &copy; 2026 Papua Pegunungan Cafe Hub. All rights reserved.
            </div>
            <div class="footer-socials">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <button class="btn-scroll-top" id="btnScrollTop" aria-label="Scroll to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- ============================================================
         JS — UI only, no business logic changes
    ============================================================ -->
    <script>
        // Navbar scroll effect & Scroll to top
        const navbar = document.getElementById('mainNavbar');
        const btnScrollTop = document.getElementById('btnScrollTop');
        
        const onScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 30);
            if (window.scrollY > 400) {
                btnScrollTop.classList.add('show');
            } else {
                btnScrollTop.classList.remove('show');
            }
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        btnScrollTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Mobile menu toggle
        const toggler = document.getElementById('navToggler');
        const mobileMenu = document.getElementById('mobileMenu');
        const toggleIcon = document.getElementById('toggleIcon');
        toggler.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            toggleIcon.className = mobileMenu.classList.contains('open')
                ? 'fas fa-times'
                : 'fas fa-bars';
        });

        // Reveal on scroll (Intersection Observer)
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        revealEls.forEach(el => observer.observe(el));

        // Hero elements visible immediately (above fold)
        document.querySelectorAll('.hero .reveal').forEach(el => {
            setTimeout(() => el.classList.add('visible'), 100);
        });
    </script>

</body>
</html>