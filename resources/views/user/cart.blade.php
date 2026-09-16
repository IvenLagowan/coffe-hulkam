<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja — Hulkam Caffe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--bg:#F7EAD9;--bg-sec:#F0DCC8;--surface:#fff;--primary:#E8935A;--primary-dark:#D07A42;--sage:#7C8A5C;--brown:#3A2A1D;--text:#2A2119;--muted:#7A6355;--border:rgba(42,33,25,0.10);--shadow:0 2px 16px rgba(42,33,25,0.09);--pill:9999px;--card:18px;--trans:all 0.3s cubic-bezier(0.4,0,0.2,1);}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);}
        a{text-decoration:none;color:inherit;}
        img{display:block;max-width:100%;}
        .top-nav{background:var(--brown);padding:0 24px;position:sticky;top:0;z-index:50;}
        .top-nav-inner{max-width:1180px;margin-inline:auto;height:62px;display:flex;align-items:center;justify-content:space-between;}
        .nav-brand{font-family:'Playfair Display',serif;font-weight:700;font-size:18px;color:#F7EAD9;display:flex;align-items:center;gap:10px;}
        .nav-brand .bi{width:30px;height:30px;background:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;}
        .nav-links{display:flex;gap:6px;}
        .nav-links a{font-size:13px;font-weight:500;color:rgba(247,234,217,0.7);padding:7px 14px;border-radius:8px;transition:var(--trans);}
        .nav-links a:hover{color:#F7EAD9;background:rgba(255,255,255,0.08);}
        .page{max-width:1180px;margin-inline:auto;padding:48px 24px;}
        .alert-ok{background:rgba(124,138,92,0.1);border:1px solid rgba(124,138,92,0.25);border-radius:12px;padding:12px 16px;color:var(--sage);font-size:14px;display:flex;align-items:center;gap:10px;margin-bottom:20px;}
        .alert-err{background:rgba(200,80,60,0.08);border:1px solid rgba(200,80,60,0.2);border-radius:12px;padding:12px 16px;color:#b84030;font-size:14px;display:flex;align-items:center;gap:10px;margin-bottom:20px;}
        .grid-layout{display:grid;grid-template-columns:1fr 360px;gap:32px;align-items:start;}
        .section-head{margin-bottom:24px;}
        .section-title{font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--brown);margin-bottom:4px;}
        .section-sub{font-size:13px;color:var(--muted);}
        /* MENU GRID */
        .menu-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;}
        .menu-tile{background:var(--surface);border-radius:var(--card);padding:18px;border:1px solid var(--border);box-shadow:var(--shadow);transition:var(--trans);}
        .menu-tile:hover{border-color:var(--primary);transform:translateY(-3px);box-shadow:0 8px 28px rgba(42,33,25,0.12);}
        .menu-tile-head{display:flex;justify-content:space-between;align-items:flex-start;gap:8px;margin-bottom:6px;}
        .menu-tile-name{font-size:14px;font-weight:600;color:var(--brown);}
        .badge-pill{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:var(--pill);font-size:10.5px;font-weight:600;}
        .badge-ok{background:rgba(124,138,92,0.1);color:var(--sage);}
        .badge-habis{background:rgba(200,80,60,0.08);color:#b84030;}
        .menu-tile-desc{font-size:12px;color:var(--muted);margin-bottom:12px;line-height:1.5;}
        .menu-tile-foot{display:flex;justify-content:space-between;align-items:center;}
        .menu-price{font-size:14px;font-weight:700;color:var(--primary);}
        .btn-add{display:inline-flex;align-items:center;gap:5px;background:rgba(232,147,90,0.1);color:var(--primary);padding:7px 14px;border-radius:var(--pill);font-size:12px;font-weight:600;border:1px solid rgba(232,147,90,0.25);cursor:pointer;transition:var(--trans);font-family:'Inter',sans-serif;}
        .btn-add:hover{background:var(--primary);color:#fff;border-color:var(--primary);}
        .btn-add:disabled{background:var(--bg-sec);color:var(--muted);border-color:var(--border);cursor:not-allowed;}
        /* CART ITEMS */
        .cart-section{margin-top:36px;}
        .cart-item{background:var(--surface);border-radius:var(--card);padding:16px 20px;border:1px solid var(--border);box-shadow:var(--shadow);display:flex;align-items:center;gap:14px;margin-bottom:12px;transition:var(--trans);}
        .cart-item:hover{box-shadow:0 6px 24px rgba(42,33,25,0.11);}
        .cart-item-info{flex:1;}
        .cart-item-name{font-size:14px;font-weight:600;color:var(--brown);}
        .cart-item-unit{font-size:12px;color:var(--muted);margin-top:2px;}
        .qty-controls{display:flex;align-items:center;gap:8px;}
        .qty-btn{width:30px;height:30px;border:1.5px solid var(--border);background:var(--bg);border-radius:8px;font-size:16px;font-weight:700;color:var(--brown);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:var(--trans);font-family:'Inter',sans-serif;}
        .qty-btn:hover{background:var(--primary);color:#fff;border-color:var(--primary);}
        .qty-num{font-size:15px;font-weight:700;color:var(--brown);min-width:24px;text-align:center;}
        .cart-item-total{font-size:15px;font-weight:700;color:var(--primary);min-width:100px;text-align:right;}
        .btn-remove{background:none;border:none;cursor:pointer;color:var(--muted);font-size:14px;transition:var(--trans);padding:4px;}
        .btn-remove:hover{color:#b84030;}
        .cart-empty-small{text-align:center;padding:40px 20px;color:var(--muted);}
        .cart-empty-small i{font-size:32px;display:block;margin-bottom:10px;opacity:0.3;}
        /* SUMMARY CARD */
        .summary-card{background:var(--surface);border-radius:var(--card);padding:28px;border:1px solid var(--border);box-shadow:var(--shadow);position:sticky;top:80px;}
        .summary-title{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--brown);margin-bottom:20px;}
        .summary-row{display:flex;justify-content:space-between;align-items:center;font-size:13px;color:var(--muted);margin-bottom:10px;}
        .summary-row span:last-child{font-weight:500;color:var(--text);}
        .summary-divider{border:none;border-top:1px solid var(--border);margin:14px 0;}
        .summary-total{display:flex;justify-content:space-between;align-items:center;font-weight:700;font-size:16px;color:var(--brown);margin-bottom:20px;}
        .summary-total span:last-child{color:var(--primary);font-size:18px;}
        .btn-checkout{display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:14px;background:var(--primary);color:#fff;border:none;border-radius:var(--pill);font-size:15px;font-weight:600;cursor:pointer;transition:var(--trans);font-family:'Inter',sans-serif;text-decoration:none;}
        .btn-checkout:hover{background:var(--primary-dark);transform:translateY(-1px);box-shadow:0 6px 20px rgba(232,147,90,0.3);color:#fff;}
        .btn-clear{display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:10px;background:none;color:#b84030;border:none;font-size:13px;font-weight:600;cursor:pointer;margin-top:10px;font-family:'Inter',sans-serif;border-radius:var(--pill);transition:var(--trans);}
        .btn-clear:hover{background:rgba(200,80,60,0.06);}
        .summary-empty{text-align:center;padding:20px 0;color:var(--muted);font-size:13px;}
        @media(max-width:900px){.grid-layout{grid-template-columns:1fr;}.summary-card{position:static;}}
        @media(max-width:580px){.menu-grid{grid-template-columns:1fr 1fr;}}
    </style>
    <style>
        /* ===== KedaiSeduh Premium Dark override ===== */
        :root{
            --bg:#0E0B09; --bg-sec:#17110B; --bg-secondary:#17110B; --surface:#1B140E;
            --primary:#E0A263; --primary-dark:#C8894A; --sage:#93A56B;
            --brown:#F1E7D9; --text:#E9DECF; --muted:#A08E7B; --text-muted:#A08E7B;
            --border:rgba(224,178,122,0.14); --shadow:0 18px 45px rgba(0,0,0,0.45);
        }
        body{background-color:#0E0B09 !important; color:#E9DECF;}
        .top-nav,.footer{background:#100C08 !important;}
        ::selection{background:#E0A263; color:#1B140E;}
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-inner">
            <a href="{{ url('/') }}" class="nav-brand">
                <div class="bi"><i class="fas fa-coffee"></i></div>
                Hulkam Caffe
            </a>
            <div class="nav-links">
                <a href="{{ route('order.index') }}"><i class="fas fa-box" style="font-size:11px;margin-right:4px;"></i>Pesanan</a>
                <a href="{{ route('profil.index') }}"><i class="fas fa-user-circle" style="font-size:11px;margin-right:4px;"></i>Profil</a>
            </div>
        </div>
    </nav>

    <div class="page">
        @if(session('success'))
            <div class="alert-ok"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-err"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>
        @endif

        <div class="grid-layout">
            <!-- LEFT -->
            <div>
                <!-- MENU LIST -->
                <div class="section-head">
                    <h1 class="section-title">Pilih Menu</h1>
                    <p class="section-sub">Klik menu untuk menambahkannya ke keranjang</p>
                </div>
                <div class="menu-grid">
                    @foreach($menus as $menu)
                    <div class="menu-tile">
                        <div class="menu-tile-head">
                            <div class="menu-tile-name">{{ $menu->nama_menu }}</div>
                            @php $status = $menu->status ?? 'tersedia'; @endphp
                            @if($status !== 'habis')
                                <span class="badge-pill badge-ok">Tersedia</span>
                            @else
                                <span class="badge-pill badge-habis">Habis</span>
                            @endif
                        </div>
                        @if($menu->deskripsi)
                            <p class="menu-tile-desc">{{ Str::limit($menu->deskripsi, 55) }}</p>
                        @endif
                        <div class="menu-tile-foot">
                            <span class="menu-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                            @if($status !== 'habis')
                                <form action="{{ route('cart.add', ['cafe_id' => $cafe->id]) }}" method="POST" style="margin:0;">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn-add"><i class="fas fa-plus" style="font-size:10px;"></i> Tambah</button>
                                </form>
                            @else
                                <button disabled class="btn-add">Habis</button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- CART ITEMS -->
                <div class="cart-section">
                    <h2 class="section-title" style="margin-bottom:16px;">
                        <i class="fas fa-shopping-cart" style="color:var(--muted);font-size:18px;margin-right:8px;"></i>
                        Keranjang ({{ count($cart) }} item)
                    </h2>
                    @if(empty($cart))
                        <div class="cart-empty-small">
                            <i class="fas fa-shopping-cart"></i>
                            <p style="font-size:14px;">Keranjang masih kosong — pilih menu di atas</p>
                        </div>
                    @else
                        @foreach($cart as $id => $item)
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <div class="cart-item-name">{{ $item['nama_menu'] }}</div>
                                <div class="cart-item-unit">Rp {{ number_format($item['harga'], 0, ',', '.') }} / item</div>
                            </div>
                            <form action="{{ route('cart.update', ['cafe_id' => $cafe->id, 'menuId' => $id]) }}" method="POST" style="margin:0;">
                                @csrf @method('PUT')
                                <div class="qty-controls">
                                    <button type="submit" name="jumlah" value="{{ max(0, $item['jumlah'] - 1) }}" class="qty-btn">−</button>
                                    <span class="qty-num">{{ $item['jumlah'] }}</span>
                                    <button type="submit" name="jumlah" value="{{ $item['jumlah'] + 1 }}" class="qty-btn">+</button>
                                </div>
                            </form>
                            <div class="cart-item-total">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</div>
                            <form action="{{ route('cart.remove', ['cafe_id' => $cafe->id, 'menuId' => $id]) }}" method="POST" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-remove" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- RIGHT: SUMMARY -->
            <div>
                <div class="summary-card">
                    <div class="summary-title">Ringkasan Pesanan</div>
                    @if(!empty($cart))
                        @php $total = collect($cart)->sum(fn($i) => $i['harga'] * $i['jumlah']); @endphp
                        @foreach($cart as $item)
                            <div class="summary-row">
                                <span>{{ $item['nama_menu'] }} ×{{ $item['jumlah'] }}</span>
                                <span>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <hr class="summary-divider">
                        <div class="summary-total">
                            <span>Total</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('cart.checkout', ['cafe_id' => $cafe->id]) }}" class="btn-checkout">
                            <i class="fas fa-arrow-right" style="font-size:13px;"></i> Lanjut ke Checkout
                        </a>
                        <form action="{{ route('cart.clear', ['cafe_id' => $cafe->id]) }}" method="POST" style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-clear" onclick="return confirm('Kosongkan keranjang?')">
                                <i class="fas fa-trash" style="font-size:11px;"></i> Kosongkan Keranjang
                            </button>
                        </form>
                    @else
                        <div class="summary-empty">Pilih menu untuk melihat ringkasan</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
