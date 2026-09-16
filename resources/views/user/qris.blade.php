<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bayar dengan QRIS — Hulkam Caffe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg:#F7EAD9; --bg-sec:#F0DCC8; --surface:#fff;
            --primary:#E8935A; --primary-dark:#D07A42;
            --sage:#7C8A5C; --brown:#3A2A1D; --text:#2A2119; --muted:#7A6355;
            --border:rgba(42,33,25,0.10);
            --shadow:0 30px 80px rgba(42,33,25,0.15);
            --trans:all 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;background:var(--brown);color:var(--text);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;}
        a{text-decoration:none;}
        /* CARD */
        .qris-card{background:var(--surface);border-radius:28px;overflow:hidden;width:100%;max-width:420px;box-shadow:var(--shadow);}
        .qris-head{background:var(--bg-sec);padding:28px 24px 24px;text-align:center;border-bottom:1px solid var(--border);}
        .qris-head-title{font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--brown);margin-bottom:6px;}
        .qris-head-sub{font-size:13px;color:var(--muted);}
        .qris-body{padding:24px;}
        /* AMOUNT BOX */
        .amount-box{text-align:center;background:rgba(232,147,90,0.08);border-radius:20px;padding:20px;margin-bottom:24px;border:1px solid rgba(232,147,90,0.2);}
        .amount-label{font-size:12px;color:var(--primary-dark);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;}
        .amount-val{font-size:28px;font-weight:700;color:var(--brown);font-family:'Playfair Display',serif;margin-bottom:4px;}
        .amount-id{font-size:12px;color:var(--muted);font-family:monospace;}
        /* SCAN FRAME */
        .scan-wrap{display:flex;justify-content:center;margin-bottom:24px;}
        .scan-frame{position:relative;background:var(--surface);border:2px solid var(--border);border-radius:20px;padding:12px;display:inline-block;}
        .corner-tl,.corner-tr,.corner-bl,.corner-br{position:absolute;width:24px;height:24px;border-color:var(--primary);border-style:solid;}
        .corner-tl{top:8px;left:8px;border-width:4px 0 0 4px;border-radius:8px 0 0 0;}
        .corner-tr{top:8px;right:8px;border-width:4px 4px 0 0;border-radius:0 8px 0 0;}
        .corner-bl{bottom:8px;left:8px;border-width:0 0 4px 4px;border-radius:0 0 0 8px;}
        .corner-br{bottom:8px;right:8px;border-width:0 4px 4px 0;border-radius:0 0 8px 0;}
        .scan-line{position:absolute;top:12px;left:12px;right:12px;height:2px;background:linear-gradient(to right,transparent,var(--primary),transparent);animation:scanDown 2s ease-in-out infinite;}
        @keyframes scanDown{0%{top:12px;} 50%{top:calc(100% - 14px);} 100%{top:12px;}}
        /* SVG QRIS COLORS REDEFINED */
        svg rect[fill="#1a1f3c"]{fill:var(--brown);}
        svg rect[fill="#6c63ff"]{fill:var(--primary);}
        /* STATUS BOX */
        .status-box{border-radius:16px;padding:14px 20px;font-size:13.5px;text-align:center;margin-bottom:24px;font-weight:600;border:1px solid transparent;}
        .status-wait{background:rgba(232,147,90,0.1);border-color:rgba(232,147,90,0.25);color:var(--primary-dark);}
        /* BTN SCAN */
        .btn-scan{background:var(--primary);color:#fff;border:none;font-weight:700;padding:16px;border-radius:9999px;font-size:15px;width:100%;transition:var(--trans);font-family:'Inter',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;}
        .btn-scan:hover:not(:disabled){background:var(--primary-dark);transform:translateY(-2px);box-shadow:0 8px 24px rgba(232,147,90,0.3);}
        .btn-scan:disabled{background:rgba(42,33,25,0.08);color:var(--muted);cursor:not-allowed;}
        /* CANCEL LINK */
        .btn-cancel{display:block;text-align:center;color:var(--muted);font-size:13px;font-weight:500;margin-top:20px;transition:var(--trans);}
        .btn-cancel:hover{color:var(--brown);}
        /* INVOICE OVERLAY */
        .invoice-overlay{display:none;position:fixed;inset:0;background:rgba(42,33,25,0.6);backdrop-filter:blur(6px);z-index:9999;align-items:center;justify-content:center;padding:24px;}
        .invoice-overlay.show{display:flex;}
        .invoice-popup{background:var(--surface);border-radius:24px;width:100%;max-width:380px;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,0.3);animation:popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);}
        @keyframes popIn{from{opacity:0;transform:scale(0.85) translateY(20px);}to{opacity:1;transform:scale(1) translateY(0);}}
        .invoice-head{background:var(--bg-sec);padding:32px 24px 24px;text-align:center;border-bottom:1px solid var(--border);}
        .invoice-body{padding:24px;color:var(--text);}
        .invoice-actions{padding:0 24px 24px;display:flex;flex-direction:column;gap:10px;}
        .btn-act{display:flex;align-items:center;justify-content:center;padding:14px;border-radius:9999px;font-weight:600;font-size:14px;transition:var(--trans);text-decoration:none;border:none;}
        .btn-act.primary{background:var(--primary);color:#fff;}
        .btn-act.primary:hover{background:var(--primary-dark);}
        .btn-act.secondary{background:var(--bg);color:var(--brown);border:1.5px solid var(--border);}
        .btn-act.secondary:hover{border-color:var(--primary);color:var(--primary);}
        /* PRINT */
        @media print{body{background:#fff;}.qris-card{box-shadow:none;}.btn-scan,.btn-cancel{display:none;}.invoice-overlay{display:none !important;}}
    </style>
    <style>
        /* ===== KedaiSeduh Premium Dark override ===== */
        :root{--bg:#0E0B09;--bg-sec:#17110B;--bg-secondary:#17110B;--surface:#1B140E;--primary:#E0A263;--primary-dark:#C8894A;--sage:#93A56B;--brown:#F1E7D9;--text:#E9DECF;--muted:#A08E7B;--text-muted:#A08E7B;--border:rgba(224,178,122,0.14);--shadow:0 18px 45px rgba(0,0,0,0.45);}
        body{background:#0E0B09 !important;color:#E9DECF;}
        .top-nav,.footer{background:#100C08 !important;}
        ::selection{background:#E0A263;color:#1B140E;}
    </style>
</head>
<body>
    <div class="qris-card">
        <div class="qris-head">
            <div style="font-size:32px;margin-bottom:8px;">📱</div>
            <h1 class="qris-head-title">Bayar dengan QRIS</h1>
            <p class="qris-head-sub">Scan QR code menggunakan aplikasi e-wallet Anda</p>
        </div>

        <div class="qris-body">
            <div class="amount-box">
                <div class="amount-label">Total Pembayaran</div>
                <div class="amount-val">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                <div class="amount-id">Order #{{ substr($transaksi->id, 0, 8) }}...</div>
            </div>

            <div class="scan-wrap">
                <div class="scan-frame">
                    <div class="corner-tl"></div>
                    <div class="corner-tr"></div>
                    <div class="corner-bl"></div>
                    <div class="corner-br"></div>
                    <div class="scan-line"></div>
                    <svg width="190" height="190" viewBox="0 0 200 200">
                        <rect width="200" height="200" fill="white"/>
                        <rect x="10" y="10" width="50" height="50" rx="3" fill="#1a1f3c"/>
                        <rect x="18" y="18" width="34" height="34" rx="1" fill="white"/>
                        <rect x="24" y="24" width="22" height="22" rx="1" fill="#1a1f3c"/>
                        <rect x="140" y="10" width="50" height="50" rx="3" fill="#1a1f3c"/>
                        <rect x="148" y="18" width="34" height="34" rx="1" fill="white"/>
                        <rect x="154" y="24" width="22" height="22" rx="1" fill="#1a1f3c"/>
                        <rect x="10" y="140" width="50" height="50" rx="3" fill="#1a1f3c"/>
                        <rect x="18" y="148" width="34" height="34" rx="1" fill="white"/>
                        <rect x="24" y="154" width="22" height="22" rx="1" fill="#1a1f3c"/>
                        <rect x="75" y="10" width="7" height="7" fill="#6c63ff"/>
                        <rect x="85" y="10" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="100" y="10" width="7" height="7" fill="#6c63ff"/>
                        <rect x="115" y="10" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="75" y="20" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="90" y="20" width="7" height="7" fill="#6c63ff"/>
                        <rect x="105" y="20" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="120" y="20" width="7" height="7" fill="#6c63ff"/>
                        <rect x="75" y="30" width="7" height="7" fill="#6c63ff"/>
                        <rect x="88" y="30" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="100" y="30" width="7" height="7" fill="#6c63ff"/>
                        <rect x="115" y="30" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="10" y="75" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="22" y="75" width="7" height="7" fill="#6c63ff"/>
                        <rect x="35" y="75" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="50" y="75" width="7" height="7" fill="#6c63ff"/>
                        <rect x="65" y="75" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="80" y="75" width="7" height="7" fill="#6c63ff"/>
                        <rect x="95" y="75" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="110" y="75" width="7" height="7" fill="#6c63ff"/>
                        <rect x="125" y="75" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="140" y="75" width="7" height="7" fill="#6c63ff"/>
                        <rect x="155" y="75" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="170" y="75" width="7" height="7" fill="#6c63ff"/>
                        <rect x="75" y="88" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="90" y="88" width="7" height="7" fill="#6c63ff"/>
                        <rect x="105" y="88" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="80" y="100" width="7" height="7" fill="#6c63ff"/>
                        <rect x="95" y="100" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="110" y="100" width="7" height="7" fill="#6c63ff"/>
                        <rect x="75" y="112" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="92" y="112" width="7" height="7" fill="#6c63ff"/>
                        <rect x="107" y="112" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="75" y="140" width="7" height="7" fill="#6c63ff"/>
                        <rect x="90" y="140" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="105" y="140" width="7" height="7" fill="#6c63ff"/>
                        <rect x="120" y="140" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="140" y="140" width="7" height="7" fill="#6c63ff"/>
                        <rect x="155" y="140" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="75" y="155" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="92" y="155" width="7" height="7" fill="#6c63ff"/>
                        <rect x="107" y="155" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="135" y="155" width="7" height="7" fill="#6c63ff"/>
                        <rect x="150" y="155" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="165" y="155" width="7" height="7" fill="#6c63ff"/>
                        <rect x="75" y="170" width="7" height="7" fill="#6c63ff"/>
                        <rect x="87" y="170" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="102" y="170" width="7" height="7" fill="#6c63ff"/>
                        <rect x="140" y="170" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="155" y="170" width="7" height="7" fill="#6c63ff"/>
                        <rect x="170" y="170" width="7" height="7" fill="#1a1f3c"/>
                        <rect x="87" y="88" width="26" height="26" rx="5" fill="white"/>
                        <rect x="90" y="91" width="20" height="20" rx="3" fill="#E8935A"/>
                        <text x="100" y="104" font-size="9" fill="white" text-anchor="middle" font-weight="bold">QRIS</text>
                    </svg>
                </div>
            </div>

            <div id="statusBox" class="status-box status-wait">
                <span id="statusText"><i class="fas fa-hourglass-half"></i> Menunggu pembayaran...</span>
            </div>

            <button id="btnScan" class="btn-scan" onclick="doScan()">
                <i class="fas fa-qrcode"></i> Scan QR (Simulasi)
            </button>

            <a href="{{ route('order.index') }}" class="btn-cancel">
                <i class="fas fa-times" style="margin-right:4px;"></i> Batalkan & Bayar Nanti
            </a>
        </div>
    </div>

    <!-- INVOICE OVERLAY -->
    <div class="invoice-overlay" id="invoiceOverlay">
        <div class="invoice-popup">
            <div class="invoice-head">
                <div style="font-size:40px;margin-bottom:12px;">🎉</div>
                <div style="font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--brown);">Pembayaran Berhasil!</div>
                <div style="font-size:13px;color:var(--muted);margin-top:4px;">Silakan menunggu pesanan diproses</div>
            </div>
            <div id="invoiceContent" class="invoice-body"></div>
            <div class="invoice-actions">
                <a href="{{ route('order.show', $transaksi->id) }}" class="btn-act primary">
                    Cek Detail Pesanan
                </a>
                <a href="{{ route('order.index') }}" class="btn-act secondary">
                    Daftar Pesanan
                </a>
            </div>
        </div>
    </div>

    <script>
    const transaksiId = '{{ $transaksi->id }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    async function doScan() {
        const btn = document.getElementById('btnScan');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

        const statusBox = document.getElementById('statusBox');
        const statusText = document.getElementById('statusText');
        
        statusBox.style.background = 'rgba(245,158,11,0.08)';
        statusBox.style.borderColor = 'rgba(245,158,11,0.25)';
        statusBox.style.color = '#b45309';
        statusText.innerHTML = '<i class="fas fa-sync fa-spin"></i> Memverifikasi pembayaran...';

        try {
            const res = await fetch(`/pesanan/${transaksiId}/scan-qr`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            });
            const data = await res.json();

            if (data.success) {
                statusBox.style.background = 'rgba(124,138,92,0.1)';
                statusBox.style.borderColor = 'rgba(124,138,92,0.25)';
                statusBox.style.color = '#7C8A5C';
                statusText.innerHTML = '<i class="fas fa-check-circle"></i> Pembayaran berhasil dikonfirmasi!';
                tampilkanInvoice(data);
            } else {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-qrcode"></i> Scan QR (Simulasi)';
                statusBox.style.background = 'rgba(200,80,60,0.08)';
                statusBox.style.borderColor = 'rgba(200,80,60,0.2)';
                statusBox.style.color = '#b84030';
                statusText.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + data.message;
            }
        } catch(e) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-qrcode"></i> Scan QR (Simulasi)';
            statusBox.style.background = 'rgba(200,80,60,0.08)';
            statusBox.style.borderColor = 'rgba(200,80,60,0.2)';
            statusBox.style.color = '#b84030';
            statusText.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan. Coba lagi.';
        }
    }

    function tampilkanInvoice(data) {
        const t = data.transaksi || {};
        const detail = data.detail || [];
        const cafe = data.cafe || {};
        const now = new Date().toLocaleString('id-ID', {dateStyle:'long', timeStyle:'short'});

        let rows = detail.map(d => `
            <div style="display:flex;justify-content:space-between;padding:4px 0;font-size:13px;">
                <span>${d.nama_menu} <span style="color:var(--muted);">×${d.jumlah}</span></span>
                <span style="font-weight:600;color:var(--brown);">Rp ${Number(d.harga_saat_transaksi * d.jumlah).toLocaleString('id')}</span>
            </div>
        `).join('');

        document.getElementById('invoiceContent').innerHTML = `
            <div style="text-align:center;margin-bottom:20px;">
                <div style="font-weight:700;font-family:'Playfair Display',serif;font-size:16px;color:var(--brown);">${cafe.nama || 'KedaiSeduh'}</div>
                <div style="font-size:12px;color:var(--muted);">${cafe.alamat || 'Jakarta Barat'}</div>
                <div style="font-size:11px;color:var(--muted);margin-top:4px;">${now}</div>
                <div style="font-size:11px;color:var(--border);font-family:monospace;margin-top:2px;">ID: #${transaksiId.substring(0,12)}...</div>
            </div>
            ${rows}
            <div style="display:flex;justify-content:space-between;font-weight:700;margin-top:16px;padding-top:12px;border-top:1px dashed var(--border);font-size:15px;color:var(--brown);">
                <span>TOTAL BAYAR</span>
                <span style="color:var(--primary);">Rp ${Number(t.total_harga).toLocaleString('id')}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--muted);margin-top:8px;">
                <span>Metode</span>
                <span style="text-transform:uppercase;font-weight:600;">QRIS</span>
            </div>
        `;
        document.getElementById('invoiceOverlay').classList.add('show');
    }

    function cetakInvoice() {
        window.print();
    }
    </script>
</body>
</html>
