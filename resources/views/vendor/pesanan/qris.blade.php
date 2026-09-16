@extends('vendor.layouts.app')
@section('title', 'QRIS Pesanan')
@section('page_title', 'Tampilkan QRIS')

@section('content')

<div class="max-w-md mx-auto">
    <a href="{{ route('vendor.pesanan.detail', $transaksi->id) }}" class="inline-flex items-center gap-2 text-sm text-kosmos-muted hover:text-kosmos-brown mb-6 transition font-medium">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Detail
    </a>

    <div class="card-kosmos p-8 text-center bg-white">
        <p class="text-xs font-bold text-kosmos-muted uppercase tracking-widest mb-2">QRIS Pembayaran</p>
        <h2 class="text-3xl font-serif font-bold text-kosmos-brown mb-2">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h2>
        <p class="text-sm text-kosmos-muted mb-8">Tunjukkan QR ini kepada pelanggan untuk scan</p>

        <!-- Fake QRIS Image -->
        <div class="flex justify-center mb-8">
            <div class="relative p-5 bg-kosmos-bg border border-kosmos-border rounded-[2rem] shadow-inner">
                <!-- Fake QR code generated via SVG pattern using Kosmos colors -->
                <svg width="200" height="200" viewBox="0 0 200 200" class="rounded-xl">
                    <!-- Background -->
                    <rect width="200" height="200" fill="transparent"/>
                    <!-- Top-left finder pattern -->
                    <rect x="10" y="10" width="50" height="50" rx="3" fill="#3A2A1D"/>
                    <rect x="18" y="18" width="34" height="34" rx="1" fill="#F7EAD9"/>
                    <rect x="24" y="24" width="22" height="22" rx="1" fill="#3A2A1D"/>
                    <!-- Top-right finder pattern -->
                    <rect x="140" y="10" width="50" height="50" rx="3" fill="#3A2A1D"/>
                    <rect x="148" y="18" width="34" height="34" rx="1" fill="#F7EAD9"/>
                    <rect x="154" y="24" width="22" height="22" rx="1" fill="#3A2A1D"/>
                    <!-- Bottom-left finder pattern -->
                    <rect x="10" y="140" width="50" height="50" rx="3" fill="#3A2A1D"/>
                    <rect x="18" y="148" width="34" height="34" rx="1" fill="#F7EAD9"/>
                    <rect x="24" y="154" width="22" height="22" rx="1" fill="#3A2A1D"/>
                    <!-- Fake data pixels -->
                    <rect x="75" y="10" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="85" y="10" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="100" y="10" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="115" y="10" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="75" y="20" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="95" y="20" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="110" y="20" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="75" y="30" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="85" y="30" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="100" y="30" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="115" y="30" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="75" y="40" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="90" y="40" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="105" y="40" width="7" height="7" fill="#3A2A1D"/>
                    <!-- Middle row -->
                    <rect x="10" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="25" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="40" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="55" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="70" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="85" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="100" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="120" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="135" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="150" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="165" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="180" y="75" width="7" height="7" fill="#3A2A1D"/>
                    <!-- Center area -->
                    <rect x="75" y="85" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="95" y="85" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="115" y="85" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="80" y="95" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="100" y="95" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="120" y="95" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="75" y="105" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="90" y="105" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="110" y="105" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="125" y="105" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="80" y="115" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="100" y="115" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="115" y="115" width="7" height="7" fill="#3A2A1D"/>
                    <!-- Bottom rows -->
                    <rect x="75" y="140" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="90" y="140" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="105" y="140" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="120" y="140" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="140" y="140" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="155" y="140" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="170" y="140" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="75" y="150" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="95" y="150" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="110" y="150" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="135" y="150" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="150" y="150" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="165" y="150" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="180" y="150" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="75" y="160" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="85" y="160" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="105" y="160" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="125" y="160" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="145" y="160" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="160" y="160" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="175" y="160" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="75" y="170" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="90" y="170" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="100" y="170" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="115" y="170" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="130" y="170" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="150" y="170" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="165" y="170" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="180" y="170" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="75" y="180" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="95" y="180" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="110" y="180" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="130" y="180" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="145" y="180" width="7" height="7" fill="#3A2A1D"/>
                    <rect x="165" y="180" width="7" height="7" fill="#3A2A1D"/>
                    <!-- QRIS Logo area in center -->
                    <rect x="88" y="88" width="24" height="24" rx="4" fill="#F7EAD9"/>
                    <rect x="91" y="91" width="18" height="18" rx="2" fill="#E8935A"/>
                    <text x="100" y="103" font-size="9" fill="white" text-anchor="middle" font-weight="bold">Q</text>
                </svg>
                <!-- Pulse animation overlay when waiting -->
                <div id="scanPulse" class="absolute inset-0 flex items-center justify-center rounded-[2rem] pointer-events-none">
                    <div class="w-full h-0.5 bg-kosmos-sage opacity-50 animate-ping absolute top-1/2"></div>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div id="statusBox" class="mb-4 p-3.5 bg-kosmos-bg border border-kosmos-border rounded-xl shadow-sm transition-colors duration-300">
            <p class="text-kosmos-brown text-sm font-bold" id="statusText"><i class="fas fa-circle-notch fa-spin mr-1"></i> Menunggu pembayaran pelanggan...</p>
        </div>

        <p class="text-xs text-kosmos-muted font-mono mt-4">ID Transaksi: #{{ substr($transaksi->id, 0, 8) }}...</p>
    </div>

    <!-- Invoice Popup Vendor -->
    <div id="invoicePopup" class="hidden fixed inset-0 z-[100] bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
            <div class="bg-kosmos-brown px-6 py-6 text-kosmos-bg text-center">
                <div class="w-16 h-16 bg-kosmos-sage rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg">
                    <i class="fas fa-check text-2xl text-white"></i>
                </div>
                <p class="font-serif font-bold text-xl">Pembayaran Berhasil!</p>
                <p class="text-xs text-kosmos-bg/60 mt-1">Invoice Digital - KedaiSeduh</p>
            </div>
            <div id="invoiceBody" class="px-6 py-5 text-sm bg-kosmos-bg/10 text-kosmos-brown"></div>
            <div class="px-6 pb-6 bg-kosmos-bg/10">
                <button onclick="cetakDanTutup()" class="w-full bg-kosmos-primary hover:bg-kosmos-dark text-white font-bold py-3.5 rounded-full transition flex items-center justify-center gap-2 shadow-sm">
                    <i class="fas fa-print"></i> Cetak Invoice & Lanjut
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const transaksiId = '{{ $transaksi->id }}';
let polling = null;

// Poll setiap 3 detik untuk cek status pembayaran
polling = setInterval(async () => {
    try {
        const res = await fetch(`/api/transaksi/${transaksiId}/status`);
        const data = await res.json();
        if (data.status === 'Dibayar') {
            clearInterval(polling);
            document.getElementById('scanPulse').innerHTML = '';
            document.getElementById('statusBox').className = 'mb-4 p-3.5 bg-kosmos-sage/10 border border-kosmos-sage/30 rounded-xl shadow-sm transition-colors duration-300';
            document.getElementById('statusText').className = 'text-kosmos-sage text-sm font-bold';
            document.getElementById('statusText').innerHTML = '<i class="fas fa-check-circle mr-1"></i> Pembayaran berhasil dikonfirmasi!';
            // Tampilkan invoice popup
            tampilkanInvoice(data);
        }
    } catch(e) {}
}, 3000);

function tampilkanInvoice(data) {
    const t = data.transaksi || {};
    const detail = data.detail || [];
    let rows = detail.map(d => `
        <div class="flex justify-between py-1.5 border-b border-dashed border-kosmos-border/50">
            <span class="font-medium">${d.nama_menu} <span class="text-kosmos-muted text-xs ml-1">x${d.jumlah}</span></span>
            <span class="font-bold">Rp ${Number(d.harga_saat_transaksi * d.jumlah).toLocaleString('id')}</span>
        </div>
    `).join('');

    document.getElementById('invoiceBody').innerHTML = `
        <div class="text-center border-b border-dashed border-kosmos-border pb-5 mb-5">
            <p class="font-bold text-lg text-kosmos-brown">${data.cafe?.nama || 'KedaiSeduh'}</p>
            <p class="text-xs text-kosmos-muted mt-0.5">${data.cafe?.alamat || 'Jakarta Barat'}</p>
            <p class="text-xs text-kosmos-muted mt-2 font-mono">ID: #${transaksiId.substring(0,8)}</p>
            <p class="font-bold text-kosmos-primary text-lg mt-2 inline-block bg-kosmos-bg border border-kosmos-border px-3 py-1 rounded-lg">Kode: ${t.order_code || '-'}</p>
            <p class="text-xs text-kosmos-muted mt-2">${new Date().toLocaleString('id')}</p>
        </div>
        <div class="space-y-2 mb-5">${rows}</div>
        <div class="flex justify-between font-bold text-base pt-3 border-t-2 border-kosmos-brown text-kosmos-brown">
            <span>TOTAL BAYAR</span>
            <span class="text-kosmos-primary">Rp ${Number(t.total_harga).toLocaleString('id')}</span>
        </div>
        <p class="text-center text-xs text-kosmos-muted mt-6 italic">Terima kasih atas kunjungan Anda!</p>
    `;
    document.getElementById('invoicePopup').classList.remove('hidden');
}

function cetakDanTutup() {
    window.print();
    setTimeout(() => {
        document.getElementById('invoicePopup').classList.add('hidden');
        window.location.href = '{{ route("vendor.pesanan.index") }}';
    }, 500);
}
</script>

@endsection
