@extends('vendor.layouts.app')
@section('title', 'Pesanan Masuk')
@section('page_title', 'Pesanan Masuk')

@section('content')

@if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-kosmos-sage/10 border border-kosmos-sage/20 text-kosmos-sage px-4 py-3 rounded-xl text-sm">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-serif font-bold text-kosmos-brown">Pesanan Masuk</h1>
        <p class="text-kosmos-muted text-sm mt-1">Pantau, perbarui status, dan konfirmasi pembayaran pelanggan.</p>
    </div>
    <!-- Legend -->
    <div class="hidden md:flex items-center gap-3 text-xs text-kosmos-muted">
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span> Masuk</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-kosmos-sage"></span> Dibayar</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-kosmos-primary"></span> Diproses</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-kosmos-dark"></span> Siap Diambil</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-kosmos-border"></span> Selesai</span>
    </div>
</div>

<div class="card-kosmos overflow-hidden border border-kosmos-border">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-kosmos-bg/50 border-b border-kosmos-border">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Waktu Pesan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Pembayaran</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-kosmos-border/50">
                @forelse ($pesanan as $row)
                @php
                    $statusColors = [
                        'Masuk'       => 'bg-blue-50 text-blue-700',
                        'Dibayar'     => 'bg-kosmos-sage/15 text-kosmos-sage',
                        'Diproses'    => 'bg-kosmos-primary/15 text-kosmos-primary',
                        'Siap Diambil'=> 'bg-kosmos-dark/15 text-kosmos-dark',
                        'Selesai'     => 'bg-kosmos-bg text-kosmos-muted',
                        'Komplain'    => 'bg-red-50 text-red-700',
                        'Dibatalkan'  => 'bg-red-50 text-red-700',
                    ];
                    $sc = $statusColors[$row->status] ?? 'bg-kosmos-bg text-kosmos-muted';
                @endphp
                <tr class="hover:bg-kosmos-bg/30 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-bold text-kosmos-brown text-sm">{{ $row->nama_pelanggan }}</p>
                        <p class="text-kosmos-muted text-xs">{{ $row->email_pelanggan }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-kosmos-brown font-medium text-sm">{{ \Carbon\Carbon::parse($row->tgl)->format('d M Y') }}</p>
                        <p class="text-kosmos-muted text-xs">{{ \Carbon\Carbon::parse($row->tgl)->format('H:i') }} WIB</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-kosmos-brown">Rp {{ number_format($row->total_harga, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-kosmos-primary">{{ $row->channel_pembayaran }}</span>
                        @if($row->waktu_pembayaran)
                            <p class="text-xs text-kosmos-sage font-medium mt-0.5"><i class="fas fa-check"></i> {{ \Carbon\Carbon::parse($row->waktu_pembayaran)->format('H:i') }}</p>
                        @else
                            <p class="text-xs text-kosmos-muted mt-0.5">Belum dibayar</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold tracking-wide {{ $sc }}">
                            {{ $row->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('vendor.pesanan.detail', $row->id) }}"
                                class="w-full text-center text-xs font-semibold bg-kosmos-sec/30 hover:bg-kosmos-sec text-kosmos-brown border border-kosmos-border/50 px-3 py-2 rounded-lg transition-colors">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if($row->channel_pembayaran === 'qris' && $row->status === 'Masuk')
                                <a href="{{ route('vendor.pesanan.qris', $row->id) }}"
                                    class="w-full text-center text-xs font-semibold bg-kosmos-sage/10 hover:bg-kosmos-sage/20 text-kosmos-sage border border-kosmos-sage/20 px-3 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-qrcode"></i> Tampilkan QRIS
                                </a>
                            @endif
                            @if(in_array($row->status, ['Dibayar']))
                                <form action="{{ route('vendor.pesanan.update-status', $row->id) }}" method="POST" class="w-full">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Diproses">
                                    <button type="submit" class="w-full text-xs font-semibold bg-kosmos-primary/10 hover:bg-kosmos-primary/20 text-kosmos-primary border border-kosmos-primary/20 px-3 py-2 rounded-lg transition-colors">
                                        <i class="fas fa-fire"></i> Set Diproses
                                    </button>
                                </form>
                            @endif
                            @if($row->status === 'Diproses')
                                <form action="{{ route('vendor.pesanan.update-status', $row->id) }}" method="POST" class="w-full">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Siap Diambil">
                                    <button type="submit" class="w-full text-xs font-semibold bg-kosmos-dark/10 hover:bg-kosmos-dark/20 text-kosmos-dark border border-kosmos-dark/20 px-3 py-2 rounded-lg transition-colors">
                                        <i class="fas fa-bell"></i> Siap Diambil
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-kosmos-bg rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-2xl text-kosmos-border"></i>
                            </div>
                            <p class="font-serif font-bold text-lg text-kosmos-brown">Belum ada pesanan masuk</p>
                            <p class="text-kosmos-muted text-sm mt-1">Pesanan dari pelanggan akan muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Invoice Popup (muncul via JS setelah vendor melihat QRIS yang sudah dibayar) -->
<div id="invoiceModal" class="fixed inset-0 z-[100] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
        <div class="bg-kosmos-brown px-6 py-5 text-kosmos-bg text-center">
            <i class="fas fa-receipt text-3xl mb-2 text-kosmos-primary"></i>
            <p class="font-serif font-bold text-lg">Invoice Digital</p>
            <p class="text-xs text-white/50">KedaiSeduh</p>
        </div>
        <div id="invoiceContent" class="px-6 py-5 text-sm text-kosmos-brown bg-kosmos-bg/10"></div>
        <div class="px-6 pb-6 bg-kosmos-bg/10">
            <button onclick="cetakInvoice()" class="w-full bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold py-3 rounded-full transition flex items-center justify-center gap-2 shadow-sm">
                <i class="fas fa-print"></i> Cetak Invoice
            </button>
        </div>
    </div>
</div>

<script>
// Cek apakah ada pesanan yang baru dibayar via query string dari redirect QRIS vendor
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('invoice') === '1') {
    // Ambil data invoice dari session jika ada
    const nama = urlParams.get('nama') || '';
    const total = urlParams.get('total') || '';
    const id = urlParams.get('trx') || '';
    if (id) {
        document.getElementById('invoiceContent').innerHTML = `
            <div class="text-center border-b border-dashed border-kosmos-border pb-4 mb-4">
                <p class="font-bold text-base text-kosmos-brown">${nama}</p>
                <p class="text-xs text-kosmos-muted mt-1 font-mono">ID: ${id}</p>
            </div>
            <div class="flex justify-between items-center font-bold text-kosmos-brown mt-2">
                <span class="text-xs uppercase tracking-wider text-kosmos-muted">Total Bayar</span>
                <span class="text-lg text-kosmos-primary">Rp ${total}</span>
            </div>
            <p class="text-center text-xs text-kosmos-muted mt-6 italic">Terima kasih telah berbelanja!</p>
        `;
        document.getElementById('invoiceModal').classList.remove('hidden');
    }
}
function cetakInvoice() {
    window.print();
    document.getElementById('invoiceModal').classList.add('hidden');
}
</script>

@endsection