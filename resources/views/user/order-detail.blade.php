<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan — Caffe Hulkam</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--bg:#F7EAD9;--bg-sec:#F0DCC8;--surface:#fff;--primary:#E8935A;--primary-dark:#D07A42;--sage:#7C8A5C;--brown:#3A2A1D;--text:#2A2119;--muted:#7A6355;--border:rgba(42,33,25,0.10);--shadow:0 2px 16px rgba(42,33,25,0.09);--pill:9999px;--card:20px;--trans:all 0.3s cubic-bezier(0.4,0,0.2,1);}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);}
        a{text-decoration:none;color:inherit;}
        .top-nav{background:var(--brown);padding:0 24px;position:sticky;top:0;z-index:50;}
        .top-nav-inner{max-width:720px;margin-inline:auto;height:62px;display:flex;align-items:center;justify-content:space-between;}
        .nav-brand{font-family:'Playfair Display',serif;font-weight:700;font-size:18px;color:#F7EAD9;display:flex;align-items:center;gap:10px;}
        .nav-brand .bi{width:30px;height:30px;background:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;}
        .nav-back{font-size:13px;font-weight:500;color:rgba(247,234,217,0.7);display:flex;align-items:center;gap:6px;transition:var(--trans);}
        .nav-back:hover{color:#F7EAD9;}
        .page{max-width:720px;margin-inline:auto;padding:48px 24px;}
        .alert-ok{background:rgba(124,138,92,0.1);border:1px solid rgba(124,138,92,0.25);border-radius:12px;padding:12px 16px;color:var(--sage);font-size:14px;display:flex;align-items:center;gap:10px;margin-bottom:20px;}
        .alert-err{background:rgba(200,80,60,0.08);border:1px solid rgba(200,80,60,0.2);border-radius:12px;padding:12px 16px;color:#b84030;font-size:14px;display:flex;align-items:center;gap:10px;margin-bottom:20px;}
        .co-card{background:var(--surface);border-radius:var(--card);padding:28px;border:1px solid var(--border);box-shadow:var(--shadow);margin-bottom:20px;}
        .status-pill{display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:var(--pill);font-size:13px;font-weight:700;}
        .s-masuk{background:rgba(59,130,246,0.1);color:#2563eb;}
        .s-dibayar{background:rgba(124,138,92,0.12);color:var(--sage);}
        .s-diproses{background:rgba(245,158,11,0.12);color:#b45309;}
        .s-siap{background:rgba(232,147,90,0.15);color:var(--primary-dark);}
        .s-selesai{background:rgba(42,33,25,0.07);color:var(--muted);}
        .s-komplain{background:rgba(200,80,60,0.08);color:#b84030;}
        .detail-head{display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:24px;}
        .detail-title{font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--brown);margin-bottom:4px;}
        .detail-id{font-size:12px;color:var(--muted);font-family:monospace;}
        .detail-code{font-size:14px;font-weight:700;color:var(--primary);margin-top:4px;}
        .meta-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:20px;}
        .meta-item label{font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--muted);display:block;margin-bottom:4px;}
        .meta-item span{font-size:13.5px;font-weight:600;color:var(--text);}
        .divider{border:none;border-top:1px dashed var(--border);margin:18px 0;}
        .items-label{font-size:11px;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:var(--muted);margin-bottom:12px;}
        .item-row{display:flex;justify-content:space-between;align-items:center;padding:12px 14px;border-radius:12px;background:var(--bg);margin-bottom:8px;}
        .item-qty-badge{background:var(--primary);color:#fff;border-radius:var(--pill);padding:3px 10px;font-size:12px;font-weight:700;margin-right:10px;}
        .item-name{font-size:14px;font-weight:600;color:var(--brown);}
        .item-price{font-size:14px;font-weight:700;color:var(--primary);}
        .total-row{display:flex;justify-content:space-between;align-items:center;background:rgba(232,147,90,0.08);border-radius:14px;padding:16px 18px;}
        .total-row span{font-size:15px;font-weight:700;color:var(--brown);}
        .total-row span:last-child{font-size:20px;color:var(--primary);}
        .actions-title{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--brown);margin-bottom:18px;}
        .btn-act{display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:14px;border-radius:var(--pill);font-size:15px;font-weight:600;cursor:pointer;border:none;font-family:'Inter',sans-serif;transition:var(--trans);text-decoration:none;margin-bottom:12px;}
        .btn-act.qris{background:var(--primary);color:#fff;}
        .btn-act.qris:hover{background:var(--primary-dark);color:#fff;}
        .btn-act.confirm{background:var(--sage);color:#fff;}
        .btn-act.confirm:hover{background:#68784c;}
        .btn-act.back{background:var(--bg-sec);color:var(--brown);border:2px solid var(--border);}
        .btn-act.back:hover{border-color:var(--primary);color:var(--primary);}
        .warning-box{background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.25);border-radius:12px;padding:14px 16px;font-size:13px;color:#b45309;margin-bottom:12px;}
        .komplain-wrap{border:1px solid rgba(200,80,60,0.2);border-radius:14px;padding:16px 18px;}
        .komplain-label{font-size:13px;font-weight:600;color:#b84030;margin-bottom:10px;display:flex;align-items:center;gap:6px;}
        .komplain-textarea{width:100%;padding:10px 14px;border-radius:12px;border:1.5px solid var(--border);background:var(--bg);font-family:'Inter',sans-serif;font-size:13px;color:var(--text);resize:vertical;outline:none;margin-bottom:10px;}
        .komplain-textarea:focus{border-color:#b84030;}
        .btn-kirim{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#b84030;color:#fff;border:none;border-radius:var(--pill);font-size:13px;font-weight:600;cursor:pointer;}
        @media(max-width:580px){.meta-grid{grid-template-columns:1fr 1fr;}}
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
    @php
        $sc = match($transaksi->status) {
            'Masuk'        => 's-masuk',
            'Dibayar'      => 's-dibayar',
            'Diproses'     => 's-diproses',
            'Siap Diambil' => 's-siap',
            'Selesai'      => 's-selesai',
            'Komplain'     => 's-komplain',
            default        => 's-selesai',
        };
        $scLabel = match($transaksi->status) {
            'Diproses' => 'Sedang Diproses',
            default    => $transaksi->status,
        };
    @endphp

    <nav class="top-nav">
        <div class="top-nav-inner">
            <a href="{{ url('/') }}" class="nav-brand">
                <div class="bi"><i class="fas fa-coffee"></i></div>
                Hulkam Caffe
            </a>
            <a href="{{ route('order.index') }}" class="nav-back">
                <i class="fas fa-arrow-left" style="font-size:12px;"></i> Pesanan Saya
            </a>
        </div>
    </nav>

    <div class="page">
        @if(session('success'))
            <div class="alert-ok"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-err"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>
        @endif

        <!-- DETAIL CARD -->
        <div class="co-card">
            <div class="detail-head">
                <div>
                    <h1 class="detail-title">Detail Pesanan</h1>
                    <div class="detail-id">ID: #{{ substr($transaksi->id, 0, 12) }}...</div>
                    <div class="detail-code">Kode: {{ $transaksi->order_code }}</div>
                </div>
                <span class="status-pill {{ $sc }}">{{ $scLabel }}</span>
            </div>

            <div class="meta-grid">
                <div class="meta-item">
                    <label>Metode Bayar</label>
                    <span>{{ strtoupper($transaksi->channel_pembayaran) }}</span>
                </div>
                <div class="meta-item">
                    <label>Waktu Pesan</label>
                    <span>{{ \Carbon\Carbon::parse($transaksi->tgl)->format('d M Y, H:i') }} WIB</span>
                </div>
                <div class="meta-item">
                    <label>Waktu Bayar</label>
                    @if($transaksi->waktu_pembayaran)
                        <span style="color:var(--sage);">{{ \Carbon\Carbon::parse($transaksi->waktu_pembayaran)->format('d M Y, H:i') }} WIB</span>
                    @else
                        <span style="color:var(--muted);">Belum dibayar</span>
                    @endif
                </div>
            </div>

            <hr class="divider">

            <div class="items-label">Item yang Dipesan</div>
            @foreach($detail as $item)
            <div class="item-row">
                <div style="display:flex;align-items:center;">
                    <span class="item-qty-badge">{{ $item->jumlah }}</span>
                    <span class="item-name">{{ $item->nama_menu }}</span>
                </div>
                <span class="item-price">Rp {{ number_format($item->harga_saat_transaksi * $item->jumlah, 0, ',', '.') }}</span>
            </div>
            @endforeach

            <div style="margin-top:14px;">
                <div class="total-row">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- ACTIONS CARD -->
        <div class="co-card">
            <div class="actions-title">Tindakan</div>

            @if($transaksi->status === 'Masuk' && $transaksi->channel_pembayaran === 'qris')
                <a href="{{ route('order.qris', $transaksi->id) }}" class="btn-act qris">
                    <i class="fas fa-qrcode"></i> Bayar dengan QRIS
                </a>
            @endif

            @if($transaksi->status === 'Siap Diambil')
                <div class="warning-box">
                    <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>
                    Jika tidak dikonfirmasi dalam 2 jam sejak pesanan siap, sistem akan otomatis menyelesaikan pesanan Anda.
                </div>
                <form action="{{ route('order.konfirmasi-selesai', $transaksi->id) }}" method="POST" style="margin-bottom:12px;">
                    @csrf
                    <button type="submit" class="btn-act confirm" onclick="return confirm('Konfirmasi pesanan sudah diterima?')" style="width:100%;">
                        <i class="fas fa-check"></i> Konfirmasi Pesanan Selesai
                    </button>
                </form>
            @endif

            @if(in_array($transaksi->status, ['Diproses', 'Siap Diambil']))
                <div class="komplain-wrap" style="margin-bottom:12px;">
                    <div class="komplain-label"><i class="fas fa-flag"></i> Laporkan Masalah</div>
                    <form action="{{ route('order.komplain', $transaksi->id) }}" method="POST">
                        @csrf
                        <textarea name="komplain" class="komplain-textarea" rows="2" placeholder="Ceritakan masalah Anda..." required></textarea>
                        <button type="submit" class="btn-kirim"><i class="fas fa-paper-plane" style="font-size:11px;"></i> Kirim Laporan</button>
                    </form>
                </div>
            @endif

            <a href="{{ route('order.index') }}" class="btn-act back">
                <i class="fas fa-arrow-left" style="font-size:13px;"></i> Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</body>
</html>
