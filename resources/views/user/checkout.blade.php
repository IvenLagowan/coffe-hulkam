<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — Hulkam Caffe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--bg:#F7EAD9;--bg-sec:#F0DCC8;--surface:#fff;--primary:#E8935A;--primary-dark:#D07A42;--sage:#7C8A5C;--brown:#3A2A1D;--text:#2A2119;--muted:#7A6355;--border:rgba(42,33,25,0.10);--shadow:0 2px 16px rgba(42,33,25,0.09);--pill:9999px;--card:20px;--trans:all 0.3s cubic-bezier(0.4,0,0.2,1);}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);}
        a{text-decoration:none;color:inherit;}
        .top-nav{background:var(--brown);padding:0 24px;position:sticky;top:0;z-index:50;}
        .top-nav-inner{max-width:1060px;margin-inline:auto;height:62px;display:flex;align-items:center;justify-content:space-between;}
        .nav-brand{font-family:'Playfair Display',serif;font-weight:700;font-size:18px;color:#F7EAD9;display:flex;align-items:center;gap:10px;}
        .nav-brand .bi{width:30px;height:30px;background:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;}
        .nav-back{font-size:13px;font-weight:500;color:rgba(247,234,217,0.7);display:flex;align-items:center;gap:6px;transition:var(--trans);}
        .nav-back:hover{color:#F7EAD9;}
        .page{max-width:1060px;margin-inline:auto;padding:48px 24px;}
        /* STEPS */
        .steps{display:flex;align-items:center;gap:0;margin-bottom:48px;}
        .step{display:flex;align-items:center;gap:10px;}
        .step-num{width:30px;height:30px;border-radius:50%;background:var(--primary);color:#fff;font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
        .step-label{font-size:12px;font-weight:600;color:var(--primary);}
        .step-line{flex:1;height:2px;background:var(--border);margin:0 12px;}
        /* GRID */
        .grid-co{display:grid;grid-template-columns:1fr 380px;gap:28px;align-items:start;}
        /* CARDS */
        .co-card{background:var(--surface);border-radius:var(--card);padding:28px;border:1px solid var(--border);box-shadow:var(--shadow);margin-bottom:20px;}
        .co-card-title{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--brown);margin-bottom:20px;display:flex;align-items:center;gap:10px;}
        /* ORDER ITEMS */
        .order-item-row{display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--border);}
        .order-item-row:last-child{border-bottom:none;}
        .oi-name{font-size:14px;font-weight:600;color:var(--brown);}
        .oi-qty{font-size:12px;color:var(--muted);}
        .oi-price{font-size:14px;font-weight:600;color:var(--primary);}
        .order-total-row{display:flex;justify-content:space-between;align-items:center;margin-top:16px;padding-top:14px;border-top:2px solid var(--border);}
        .order-total-row span{font-size:17px;font-weight:700;color:var(--brown);}
        .order-total-row span:last-child{color:var(--primary);font-size:20px;}
        /* PAYMENT METHODS */
        .method-card{border:2px solid var(--border);border-radius:16px;padding:16px 18px;cursor:pointer;transition:var(--trans);display:flex;align-items:center;gap:14px;margin-bottom:12px;}
        .method-card:hover{border-color:var(--primary);background:rgba(232,147,90,0.04);}
        .method-card.selected{border-color:var(--primary);background:rgba(232,147,90,0.07);}
        .method-card input[type="radio"]{accent-color:var(--primary);width:16px;height:16px;flex-shrink:0;}
        .method-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
        .method-icon.qris{background:rgba(232,147,90,0.12);color:var(--primary);}
        .method-icon.cash{background:rgba(124,138,92,0.12);color:var(--sage);}
        .method-info-name{font-size:14px;font-weight:600;color:var(--brown);}
        .method-info-desc{font-size:12px;color:var(--muted);margin-top:2px;}
        .method-badge{margin-left:auto;background:rgba(232,147,90,0.12);color:var(--primary);padding:3px 10px;border-radius:var(--pill);font-size:11px;font-weight:600;flex-shrink:0;}
        /* QRIS NOTE */
        .qris-note{background:rgba(232,147,90,0.08);border:1px solid rgba(232,147,90,0.2);border-radius:12px;padding:12px 16px;font-size:13px;color:var(--primary-dark);margin-bottom:20px;display:flex;align-items:flex-start;gap:8px;}
        .qris-note i{margin-top:2px;flex-shrink:0;}
        /* PAY BTN */
        .btn-pay{width:100%;padding:16px;background:var(--primary);color:#fff;border:none;border-radius:var(--pill);font-size:16px;font-weight:700;cursor:pointer;transition:var(--trans);font-family:'Inter',sans-serif;display:flex;align-items:center;justify-content:center;gap:10px;}
        .btn-pay:hover{background:var(--primary-dark);transform:translateY(-2px);box-shadow:0 8px 28px rgba(232,147,90,0.35);}
        /* USER INFO CARD */
        .user-avatar{width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-dark));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:18px;flex-shrink:0;}
        .info-chip{display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--muted);margin-top:12px;}
        .info-chip i{color:var(--primary);margin-top:2px;font-size:12px;flex-shrink:0;}
        @media(max-width:800px){.grid-co{grid-template-columns:1fr;}}
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
        input,select,textarea{background:#17110B; color:#E9DECF; border-color:rgba(224,178,122,0.18);}
        input::placeholder,textarea::placeholder{color:#8a7a68;}
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-inner">
            <a href="{{ url('/') }}" class="nav-brand">
                <div class="bi"><i class="fas fa-coffee"></i></div>
                KedaiSeduh
            </a>
            <a href="{{ route('cart.index', ['cafe_id' => $cafe->id]) }}" class="nav-back">
                <i class="fas fa-arrow-left" style="font-size:12px;"></i> Kembali ke Keranjang
            </a>
        </div>
    </nav>

    <div class="page">
        <!-- STEPS -->
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <span class="step-label">Keranjang</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-num">2</div>
                <span class="step-label">Checkout</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-num" style="background:var(--bg-sec);color:var(--muted);">3</div>
                <span class="step-label" style="color:var(--muted);">Selesai</span>
            </div>
        </div>

        <div class="grid-co">
            <!-- LEFT -->
            <div>
                <!-- RINGKASAN -->
                <div class="co-card">
                    <div class="co-card-title"><i class="fas fa-receipt" style="color:var(--primary);font-size:16px;"></i> Ringkasan Pesanan</div>
                    @foreach($cart as $item)
                    <div class="order-item-row">
                        <div>
                            <div class="oi-name">{{ $item['nama_menu'] }}</div>
                            <div class="oi-qty">{{ $item['jumlah'] }} × Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                        </div>
                        <div class="oi-price">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                    <div class="order-total-row">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- METODE BAYAR -->
                <div class="co-card">
                    <div class="co-card-title"><i class="fas fa-credit-card" style="color:var(--primary);font-size:16px;"></i> Metode Pembayaran</div>
                    <form action="{{ route('order.store') }}" method="POST" id="checkoutForm">
                        @csrf
                        <input type="hidden" name="cafe_id" value="{{ $cafe->id }}">

                        <label class="method-card selected" id="label_qris">
                            <input type="radio" name="channel_pembayaran" value="qris" checked onchange="selectMethod(this)">
                            <div class="method-icon qris"><i class="fas fa-qrcode"></i></div>
                            <div>
                                <div class="method-info-name">QRIS</div>
                                <div class="method-info-desc">Scan QR code untuk bayar instan</div>
                            </div>
                            <span class="method-badge">Rekomen</span>
                        </label>

                        <label class="method-card" id="label_cash">
                            <input type="radio" name="channel_pembayaran" value="cash" onchange="selectMethod(this)">
                            <div class="method-icon cash"><i class="fas fa-money-bill-wave"></i></div>
                            <div>
                                <div class="method-info-name">Tunai (Cash)</div>
                                <div class="method-info-desc">Bayar langsung di kasir</div>
                            </div>
                        </label>

                        <div id="qrisNote" class="qris-note">
                            <i class="fas fa-info-circle"></i>
                            Anda akan diarahkan ke halaman scan QRIS setelah menekan tombol Bayar.
                        </div>

                        <button type="submit" class="btn-pay">
                            <i class="fas fa-shield-alt"></i>
                            Bayar Sekarang — Rp {{ number_format($total, 0, ',', '.') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIGHT: INFO PEMESAN -->
            <div>
                <div class="co-card">
                    <div class="co-card-title"><i class="fas fa-user" style="color:var(--primary);font-size:16px;"></i> Informasi Pemesan</div>
                    <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px;">
                        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <div>
                            <div style="font-weight:600;font-size:15px;color:var(--brown);">{{ Auth::user()->name }}</div>
                            <div style="font-size:13px;color:var(--muted);margin-top:2px;">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <hr style="border:none;border-top:1px solid var(--border);margin-bottom:14px;">
                    <div class="info-chip"><i class="fas fa-lock"></i> Transaksi ini aman dan terenkripsi</div>
                    <div class="info-chip"><i class="fas fa-envelope"></i> Detail pesanan tersimpan di akun Anda</div>
                    <div class="info-chip"><i class="fas fa-clock"></i> Estimasi pesanan siap: 15–30 menit</div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function selectMethod(el) {
        document.querySelectorAll('.method-card').forEach(c => c.classList.remove('selected'));
        el.closest('.method-card').classList.add('selected');
        document.getElementById('qrisNote').style.display = el.value === 'qris' ? 'flex' : 'none';
    }
    </script>
</body>
</html>
