@extends('vendor.layouts.app')
@section('title', 'Detail Pesanan')
@section('page_title', 'Detail Pesanan')

@section('content')

<div class="max-w-3xl mx-auto print:max-w-full">
    <div class="flex items-center justify-between mb-6 print:hidden">
        <a href="{{ route('vendor.pesanan.index') }}" class="inline-flex items-center gap-2 text-sm text-kosmos-muted hover:text-kosmos-brown transition font-medium">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Pesanan
        </a>
        @if(in_array($transaksi->status, ['Dibayar', 'Diproses', 'Siap Diambil', 'Selesai']))
        <button onclick="document.getElementById('receiptPopup').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-kosmos-sec/40 hover:bg-kosmos-sec text-kosmos-brown border border-kosmos-border/50 font-semibold text-sm py-2 px-5 rounded-full transition-all">
            <i class="fas fa-print text-xs"></i> Cetak Struk
        </button>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-kosmos-sage/10 border border-kosmos-sage/20 text-kosmos-sage px-4 py-3 rounded-xl text-sm print:hidden">
            <i class="fas fa-check-circle"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card-kosmos p-8 mb-6 print:shadow-none print:border-none print:p-0 bg-white">
        <div class="flex items-start justify-between mb-6 border-b border-kosmos-border pb-5">
            <div>
                <h1 class="text-2xl font-serif font-bold text-kosmos-brown">Detail Pesanan</h1>
                <p class="text-xs text-kosmos-muted mt-1 font-mono">ID: {{ $transaksi->id }}</p>
                <p class="text-xl font-bold text-kosmos-primary mt-2 bg-kosmos-bg/40 inline-block px-3 py-1 rounded-lg border border-kosmos-border">Kode: {{ $transaksi->order_code }}</p>
            </div>
            @php
                $sc = match($transaksi->status) {
                    'Masuk' => 'bg-blue-50 text-blue-700 border-blue-100',
                    'Dibayar' => 'bg-kosmos-sage/15 text-kosmos-sage border-kosmos-sage/20',
                    'Diproses' => 'bg-kosmos-primary/15 text-kosmos-primary border-kosmos-primary/20',
                    'Siap Diambil' => 'bg-kosmos-dark/15 text-kosmos-dark border-kosmos-dark/20',
                    'Selesai' => 'bg-kosmos-bg text-kosmos-muted border-kosmos-border',
                    'Komplain' => 'bg-red-50 text-red-700 border-red-100',
                    default => 'bg-kosmos-bg text-kosmos-muted border-kosmos-border',
                };
            @endphp
            <span class="px-4 py-1.5 rounded-full text-xs font-bold border print:border-black print:bg-transparent print:text-black {{ $sc }}">{{ $transaksi->status }}</span>
        </div>

        <!-- Info Pelanggan -->
        <div class="grid grid-cols-2 gap-y-6 gap-x-4 py-2 mb-6">
            <div>
                <p class="text-xs text-kosmos-muted uppercase font-bold tracking-wider mb-1">Pelanggan</p>
                <p class="font-bold text-kosmos-brown text-base">{{ $transaksi->nama_pelanggan }}</p>
                <p class="text-kosmos-muted text-sm mt-0.5">{{ $transaksi->email_pelanggan }}</p>
            </div>
            <div>
                <p class="text-xs text-kosmos-muted uppercase font-bold tracking-wider mb-1">Metode Bayar</p>
                <p class="font-bold text-kosmos-primary text-base uppercase">{{ $transaksi->channel_pembayaran }}</p>
            </div>
            <div>
                <p class="text-xs text-kosmos-muted uppercase font-bold tracking-wider mb-1">Waktu Pesan</p>
                <p class="font-bold text-kosmos-brown text-sm">{{ \Carbon\Carbon::parse($transaksi->tgl)->format('d M Y, H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-xs text-kosmos-muted uppercase font-bold tracking-wider mb-1">Waktu Bayar</p>
                @if($transaksi->waktu_pembayaran)
                    <p class="font-bold text-kosmos-sage text-sm">{{ \Carbon\Carbon::parse($transaksi->waktu_pembayaran)->format('d M Y, H:i') }} WIB</p>
                @else
                    <p class="text-kosmos-muted font-medium text-sm">Belum dibayar</p>
                @endif
            </div>
        </div>

        <!-- Detail Item -->
        <div class="py-5 border-t border-dashed border-kosmos-border">
            <p class="text-xs font-bold text-kosmos-muted uppercase tracking-wider mb-4">Item Pesanan</p>
            <div class="space-y-3">
                @foreach($detail as $item)
                <div class="flex items-center justify-between p-3 bg-kosmos-bg/30 rounded-xl border border-kosmos-border/50">
                    <div class="flex items-center gap-4">
                        <span class="w-8 h-8 rounded-full bg-kosmos-primary text-white text-xs font-bold flex items-center justify-center print:border print:bg-transparent print:text-black">{{ $item->jumlah }}</span>
                        <span class="text-kosmos-brown text-sm font-bold">{{ $item->nama_menu }}</span>
                    </div>
                    <span class="text-kosmos-brown text-sm font-bold">Rp {{ number_format($item->harga_saat_transaksi * $item->jumlah, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Total -->
        <div class="border-t border-kosmos-border mt-2 pt-5 flex justify-between items-center">
            <span class="font-serif font-bold text-lg text-kosmos-brown">Total Pembayaran</span>
            <span class="font-bold text-kosmos-primary text-2xl">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="print:hidden space-y-4">
        @if(in_array($transaksi->status, ['Masuk']) && $transaksi->channel_pembayaran === 'qris')
        <div class="card-kosmos p-6 bg-kosmos-sage/5 border-kosmos-sage/20">
            <p class="font-serif font-bold text-kosmos-brown text-lg mb-4 flex items-center gap-2"><i class="fas fa-qrcode text-kosmos-sage"></i> Tampilkan QRIS ke Pelanggan</p>
            <a href="{{ route('vendor.pesanan.qris', $transaksi->id) }}"
                class="flex items-center justify-center gap-2 bg-kosmos-sage hover:bg-kosmos-sage/90 text-white font-semibold text-sm py-3.5 rounded-full transition shadow-sm">
                Tampilkan Layar QRIS
            </a>
        </div>
        @endif

        @if($transaksi->status === 'Masuk' && $transaksi->channel_pembayaran === 'cash')
        <div class="card-kosmos p-6 bg-kosmos-sage/10 border border-kosmos-sage/20">
            <p class="font-serif font-bold text-kosmos-brown text-lg mb-4 flex items-center gap-2"><i class="fas fa-money-bill-wave text-kosmos-sage"></i> Pembayaran Tunai (Cash)</p>
            <form action="{{ route('vendor.pesanan.update-status', $transaksi->id) }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="Dibayar">
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-kosmos-sage hover:bg-kosmos-sage/90 text-white font-semibold text-sm py-3.5 rounded-full transition shadow-sm">
                    Terima & Konfirmasi Pembayaran
                </button>
            </form>
        </div>
        @endif

        @if($transaksi->status === 'Dibayar')
        <div class="card-kosmos p-6 bg-kosmos-primary/5 border-kosmos-primary/20">
            <p class="font-serif font-bold text-kosmos-brown text-lg mb-4 flex items-center gap-2"><i class="fas fa-fire text-kosmos-primary"></i> Lanjut Diproses</p>
            <form action="{{ route('vendor.pesanan.update-status', $transaksi->id) }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="Diproses">
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold text-sm py-3.5 rounded-full transition shadow-sm">
                    Tandai Sedang Diproses
                </button>
            </form>
        </div>
        @endif

        @if($transaksi->status === 'Diproses')
        <div class="card-kosmos p-6 bg-kosmos-dark/5 border-kosmos-dark/20">
            <p class="font-serif font-bold text-kosmos-brown text-lg mb-4 flex items-center gap-2"><i class="fas fa-bell text-kosmos-dark"></i> Pesanan Siap</p>
            <form action="{{ route('vendor.pesanan.update-status', $transaksi->id) }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="Siap Diambil">
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-kosmos-dark hover:bg-kosmos-brown text-white font-semibold text-sm py-3.5 rounded-full transition shadow-sm">
                    Tandai Siap Diambil
                </button>
            </form>
        </div>
        @endif
    </div>

    <!-- Invoice Popup Vendor -->
    <div id="receiptPopup" class="hidden fixed inset-0 z-[100] bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 print:hidden">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
            <div class="bg-kosmos-brown px-6 py-6 text-kosmos-bg text-center">
                <i class="fas fa-receipt text-3xl mb-3 text-kosmos-primary"></i>
                <p class="font-serif font-bold text-xl">Struk Pesanan</p>
                <p class="text-xs opacity-70 mt-1">Hulkam Caffe</p>
            </div>
            <div class="px-6 py-6 text-sm bg-kosmos-bg/10 text-kosmos-brown">
                <div class="text-center border-b border-dashed border-kosmos-border pb-5 mb-5">
                    <p class="font-bold text-lg">{{ env('APP_NAME', 'HulkamCaffe') }}</p>
                    <p class="text-xs text-kosmos-muted mt-1 font-mono">ID: #{{ substr($transaksi->id, 0, 8) }}</p>
                    <p class="font-bold text-kosmos-primary text-lg mt-2">Kode: {{ $transaksi->order_code }}</p>
                    <p class="text-xs text-kosmos-muted mt-2">{{ \Carbon\Carbon::parse($transaksi->tgl)->format('d M Y, H:i') }}</p>
                </div>
                <div class="space-y-2 mb-5">
                    @foreach($detail as $d)
                    <div class="flex justify-between py-1.5 border-b border-dashed border-kosmos-border/50">
                        <span class="font-medium">{{ $d->nama_menu }} <span class="text-kosmos-muted text-xs ml-1">x{{ $d->jumlah }}</span></span>
                        <span class="font-bold">Rp {{ number_format($d->harga_saat_transaksi * $d->jumlah, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-between font-bold text-base pt-3 border-t-2 border-kosmos-brown">
                    <span>TOTAL</span>
                    <span class="text-kosmos-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xs text-kosmos-muted mt-3">
                    <span>Metode</span>
                    <span class="uppercase font-bold">{{ $transaksi->channel_pembayaran }}</span>
                </div>
            </div>
            <div class="px-6 pb-6 bg-kosmos-bg/10 flex gap-3">
                <button onclick="document.getElementById('receiptPopup').classList.add('hidden')" class="flex-1 bg-white border border-kosmos-border hover:bg-kosmos-bg text-kosmos-muted font-bold py-3.5 rounded-full transition">
                    Tutup
                </button>
                <button onclick="window.print()" class="flex-1 bg-kosmos-primary hover:bg-kosmos-dark text-white font-bold py-3.5 rounded-full transition flex items-center justify-center gap-2 shadow-sm">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>

@if(session('success') && str_contains(session('success'), 'Dibayar'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('receiptPopup').classList.remove('hidden');
    });
</script>
@endif

@endsection
