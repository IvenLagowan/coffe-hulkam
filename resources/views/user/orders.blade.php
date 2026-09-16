<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya — Hulkam Caffe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg:#F7EAD9; --bg-sec:#F0DCC8; --surface:#fff;
            --primary:#E8935A; --primary-dark:#D07A42;
            --sage:#7C8A5C; --brown:#3A2A1D;
            --text:#2A2119; --muted:#7A6355;
            --border:rgba(42,33,25,0.10);
            --shadow:0 2px 16px rgba(42,33,25,0.09);
            --pill:9999px; --card:18px;
            --trans:all 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;}
        a{text-decoration:none;color:inherit;}
        /* NAV */
        .top-nav{background:var(--brown);padding:0 24px;position:sticky;top:0;z-index:50;}
        .top-nav-inner{max-width:900px;margin-inline:auto;height:62px;display:flex;align-items:center;justify-content:space-between;}
        .nav-brand{font-family:'Playfair Display',serif;font-weight:700;font-size:18px;color:#F7EAD9;display:flex;align-items:center;gap:10px;}
        .nav-brand .bi{width:30px;height:30px;background:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;}
        .nav-links{display:flex;gap:6px;}
        .nav-links a{font-size:13px;font-weight:500;color:rgba(247,234,217,0.7);padding:7px 14px;border-radius:8px;transition:var(--trans);}
        .nav-links a:hover{color:#F7EAD9;background:rgba(255,255,255,0.08);}
        /* CONTENT */
        .page{max-width:900px;margin-inline:auto;padding:48px 24px;}
        .page-header{margin-bottom:32px;}
        .page-title{font-family:'Playfair Display',serif;font-size:clamp(26px,4vw,34px);font-weight:700;color:var(--brown);margin-bottom:6px;}
        .page-subtitle{font-size:14px;color:var(--muted);}
        .btn-pesan{display:inline-flex;align-items:center;gap:8px;background:var(--primary);color:#fff;padding:11px 22px;border-radius:var(--pill);font-size:14px;font-weight:600;transition:var(--trans);}
        .btn-pesan:hover{background:var(--primary-dark);transform:translateY(-1px);}
        /* ALERTS */
        .alert-ok{background:rgba(124,138,92,0.1);border:1px solid rgba(124,138,92,0.25);border-radius:12px;padding:12px 16px;color:var(--sage);font-size:14px;display:flex;align-items:center;gap:10px;margin-bottom:20px;}
        .alert-err{background:rgba(200,80,60,0.08);border:1px solid rgba(200,80,60,0.2);border-radius:12px;padding:12px 16px;color:#b84030;font-size:14px;display:flex;align-items:center;gap:10px;margin-bottom:20px;}
        /* ORDER CARDS */
        .order-card{background:var(--surface);border-radius:var(--card);border:1px solid var(--border);box-shadow:var(--shadow);padding:22px 24px;margin-bottom:20px;transition:var(--trans);}
        .order-card:hover{transform:translateY(-3px);box-shadow:0 10px 36px rgba(42,33,25,0.12);}
        .order-head{display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:14px;}
        .order-code{font-size:13px;font-weight:700;color:var(--primary);}
        .order-time{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:5px;margin-top:4px;}
        .order-amount{font-size:17px;font-weight:700;color:var(--brown);text-align:right;}
        .order-channel{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.05em;margin-top:2px;}
        /* STATUS PILLS */
        .status-pill{display:inline-flex;align-items:center;gap:5px;padding:5px 13px;border-radius:var(--pill);font-size:12px;font-weight:600;}
        .s-masuk{background:rgba(59,130,246,0.1);color:#2563eb;}
        .s-dibayar{background:rgba(124,138,92,0.12);color:var(--sage);}
        .s-diproses{background:rgba(245,158,11,0.12);color:#b45309;}
        .s-siap{background:rgba(232,147,90,0.15);color:var(--primary-dark);}
        .s-selesai{background:rgba(42,33,25,0.07);color:var(--muted);}
        .s-komplain{background:rgba(200,80,60,0.08);color:#b84030;}
        /* PROGRESS BAR */
        .progress-track{display:flex;align-items:center;gap:6px;margin:14px 0 16px;overflow-x:auto;padding-bottom:2px;}
        .prog-step{display:flex;align-items:center;gap:6px;}
        .prog-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0;}
        .prog-dot.done{background:var(--primary);}
        .prog-dot.active{background:var(--primary);box-shadow:0 0 0 4px rgba(232,147,90,0.2);}
        .prog-dot.pending{background:var(--border);border:1.5px solid rgba(42,33,25,0.15);}
        .prog-label{font-size:10.5px;color:var(--muted);white-space:nowrap;font-weight:500;}
        .prog-label.done,.prog-label.active{color:var(--primary);font-weight:600;}
        .prog-line{flex:1;height:1px;background:var(--border);min-width:20px;}
        .prog-line.done{background:var(--primary);}
        /* ACTION BUTTONS */
        .order-actions{display:flex;flex-wrap:wrap;gap:8px;margin-top:6px;}
        .btn-action{display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border-radius:var(--pill);font-size:13px;font-weight:600;border:none;cursor:pointer;transition:var(--trans);}
        .btn-detail{background:rgba(232,147,90,0.1);color:var(--primary);}
        .btn-detail:hover{background:rgba(232,147,90,0.2);}
        .btn-qris{background:var(--primary);color:#fff;}
        .btn-qris:hover{background:var(--primary-dark);}
        .btn-confirm{background:var(--sage);color:#fff;}
        .btn-confirm:hover{background:#68784c;}
        /* WARNING BOX */
        .warning-box{background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.25);border-radius:12px;padding:12px 16px;margin-top:12px;font-size:13px;color:#b45309;}
        .warning-box strong{font-weight:600;}
        /* KOMPLAIN */
        .komplain-toggle{background:none;border:none;cursor:pointer;font-size:12.5px;color:#b84030;font-weight:600;display:flex;align-items:center;gap:5px;padding:4px 0;margin-top:8px;font-family:'Inter',sans-serif;}
        .komplain-form{margin-top:10px;display:none;}
        .komplain-form.open{display:block;}
        .komplain-form textarea{width:100%;padding:10px 14px;border-radius:12px;border:1.5px solid var(--border);background:var(--bg);font-family:'Inter',sans-serif;font-size:13px;color:var(--text);resize:vertical;outline:none;}
        .komplain-form textarea:focus{border-color:var(--primary);}
        .btn-kirim{display:inline-flex;align-items:center;gap:6px;margin-top:8px;padding:9px 18px;background:#b84030;color:#fff;border:none;border-radius:var(--pill);font-size:13px;font-weight:600;cursor:pointer;}
        /* EMPTY */
        .empty-state{text-align:center;padding:80px 24px;}
        .empty-icon{font-size:48px;display:block;margin-bottom:16px;opacity:0.3;}
        .empty-title{font-family:'Playfair Display',serif;font-size:22px;color:var(--brown);margin-bottom:8px;}
        .empty-text{font-size:14px;color:var(--muted);margin-bottom:24px;}
    </style>
    <style>
        /* ===== KedaiSeduh Premium Dark override ===== */
        :root{--bg:#0E0B09;--bg-sec:#17110B;--bg-secondary:#17110B;--surface:#1B140E;--primary:#E0A263;--primary-dark:#C8894A;--sage:#93A56B;--brown:#F1E7D9;--text:#E9DECF;--muted:#A08E7B;--text-muted:#A08E7B;--border:rgba(224,178,122,0.14);--shadow:0 18px 45px rgba(0,0,0,0.45);}
        body{background-color:#0E0B09 !important;color:#E9DECF;}
        .top-nav,.footer{background:#100C08 !important;}
        ::selection{background:#E0A263;color:#1B140E;}
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
                <a href="{{ url('/') }}"><i class="fas fa-store" style="font-size:11px;margin-right:4px;"></i>Pilih Cafe</a>
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

        <div class="page-header" style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px;">
            <div>
                <h1 class="page-title">Pesanan Saya</h1>
                <p class="page-subtitle">{{ count($pesanan) }} pesanan ditemukan</p>
            </div>
            <a href="{{ url('/') }}" class="btn-pesan"><i class="fas fa-plus" style="font-size:12px;"></i> Pesan Lagi</a>
        </div>

        @forelse($pesanan as $order)
        @php
            $sc = match($order->status) {
                'Masuk'        => 's-masuk',
                'Dibayar'      => 's-dibayar',
                'Diproses'     => 's-diproses',
                'Siap Diambil' => 's-siap',
                'Selesai'      => 's-selesai',
                'Komplain'     => 's-komplain',
                default        => 's-selesai',
            };
            $steps = ['Masuk', 'Dibayar', 'Diproses', 'Siap Diambil', 'Selesai'];
            $currentIdx = array_search($order->status, $steps);
            $currentIdx = $currentIdx === false ? 0 : $currentIdx;
            $orderTime   = \Carbon\Carbon::parse($order->tgl);
            $deadlineTime = $orderTime->addHours(2);
        @endphp
        <div class="order-card">
            <div class="order-head">
                <div>
                    <span class="status-pill {{ $sc }}">{{ $order->status }}</span>
                    <div class="order-code" style="margin-top:6px;">Kode: {{ $order->order_code }}</div>
                    <div class="order-time"><i class="fas fa-clock" style="font-size:10px;"></i>{{ \Carbon\Carbon::parse($order->tgl)->format('d M Y, H:i') }} WIB</div>
                </div>
                <div>
                    <div class="order-amount">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                    <div class="order-channel">{{ $order->channel_pembayaran }}</div>
                </div>
            </div>

            @if(!in_array($order->status, ['Komplain', 'Dibatalkan']))
            <div class="progress-track">
                @foreach($steps as $i => $step)
                    <div class="prog-step">
                        <div class="prog-dot {{ $i < $currentIdx ? 'done' : ($i == $currentIdx ? 'active' : 'pending') }}"></div>
                        <span class="prog-label {{ $i <= $currentIdx ? ($i == $currentIdx ? 'active' : 'done') : '' }}">{{ $step }}</span>
                    </div>
                    @if($i < count($steps)-1)
                        <div class="prog-line {{ $i < $currentIdx ? 'done' : '' }}"></div>
                    @endif
                @endforeach
            </div>
            @endif

            <div class="order-actions">
                <a href="{{ route('order.show', $order->id) }}" class="btn-action btn-detail">
                    <i class="fas fa-eye" style="font-size:11px;"></i> Lihat Detail
                </a>
                @if($order->status === 'Masuk' && $order->channel_pembayaran === 'qris')
                    <a href="{{ route('order.qris', $order->id) }}" class="btn-action btn-qris">
                        <i class="fas fa-qrcode" style="font-size:11px;"></i> Bayar via QRIS
                    </a>
                @endif
                @if($order->status === 'Siap Diambil')
                    <form action="{{ route('order.konfirmasi-selesai', $order->id) }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-action btn-confirm" onclick="return confirm('Konfirmasi pesanan telah diterima?')">
                            <i class="fas fa-check" style="font-size:11px;"></i> Konfirmasi Selesai
                        </button>
                    </form>
                @endif
            </div>

            @if($order->status === 'Siap Diambil')
            <div class="warning-box">
                <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>
                Jika tidak dikonfirmasi, pesanan otomatis selesai pada <strong>{{ $deadlineTime->format('H:i, d M Y') }} WIB</strong>.
            </div>
            @endif

            @if(in_array($order->status, ['Siap Diambil', 'Diproses']))
            <div>
                <button class="komplain-toggle" onclick="document.getElementById('komplain{{ $loop->index }}').classList.toggle('open')">
                    <i class="fas fa-flag" style="font-size:11px;"></i> Laporkan Masalah
                </button>
                <div class="komplain-form" id="komplain{{ $loop->index }}">
                    <form action="{{ route('order.komplain', $order->id) }}" method="POST">
                        @csrf
                        <textarea name="komplain" rows="2" placeholder="Ceritakan masalah Anda..." required></textarea>
                        <button type="submit" class="btn-kirim"><i class="fas fa-paper-plane" style="font-size:11px;"></i> Kirim Laporan</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-box-open empty-icon"></i>
            <h3 class="empty-title">Belum ada pesanan</h3>
            <p class="empty-text">Yuk pesan sekarang dan nikmati kopi terbaiknya!</p>
            <a href="{{ url('/') }}" class="btn-pesan" style="display:inline-flex;">
                <i class="fas fa-utensils" style="font-size:12px;"></i> Pesan Sekarang
            </a>
        </div>
        @endforelse
    </div>
</body>
</html>
