@extends('vendor.layouts.app')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-serif font-bold text-kosmos-brown">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-kosmos-muted text-sm mt-1">Berikut adalah ringkasan aktivitas kafe Anda hari ini.</p>
    </div>
    
    <!-- Status Toggle -->
    <div class="card-kosmos px-5 py-3 flex items-center gap-4">
        <div>
            <p class="text-xs font-semibold text-kosmos-muted uppercase">Status Cafe</p>
            <p class="font-bold text-lg {{ $cafe->is_open ? 'text-kosmos-sage' : 'text-red-600' }}">
                {{ $cafe->is_open ? 'BUKA' : 'TUTUP' }}
            </p>
        </div>
        <form action="{{ route('vendor.cafe.toggle-status') }}" method="POST">
            @csrf
            <button type="submit" class="relative inline-flex h-7 w-14 items-center rounded-full transition-colors {{ $cafe->is_open ? 'bg-kosmos-sage' : 'bg-gray-300' }}">
                <span class="inline-block h-5 w-5 transform rounded-full bg-white transition-transform {{ $cafe->is_open ? 'translate-x-8' : 'translate-x-1' }}"></span>
            </button>
        </form>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="card-kosmos p-5 hover:-translate-y-1 transition-transform">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-kosmos-primary/10">
                <i class="fas fa-shopping-bag text-kosmos-primary"></i>
            </div>
            <span class="text-xs font-semibold text-kosmos-muted uppercase tracking-wide">Total</span>
        </div>
        <p class="text-3xl font-serif font-bold text-kosmos-brown mb-0.5">{{ $totalPesanan }}</p>
        <p class="text-xs text-kosmos-muted">Total Pesanan</p>
    </div>

    <div class="card-kosmos p-5 hover:-translate-y-1 transition-transform">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-kosmos-dark/10">
                <i class="fas fa-bell text-kosmos-dark"></i>
            </div>
            <span class="text-xs font-semibold text-kosmos-muted uppercase tracking-wide">Baru</span>
        </div>
        <p class="text-3xl font-serif font-bold text-kosmos-brown mb-0.5">{{ $pesananBaru }}</p>
        <p class="text-xs text-kosmos-muted">Pesanan Baru</p>
    </div>

    <div class="card-kosmos p-5 hover:-translate-y-1 transition-transform">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-kosmos-sage/10">
                <i class="fas fa-check-circle text-kosmos-sage"></i>
            </div>
            <span class="text-xs font-semibold text-kosmos-muted uppercase tracking-wide">Dibayar</span>
        </div>
        <p class="text-3xl font-serif font-bold text-kosmos-brown mb-0.5">{{ $pesananDibayar }}</p>
        <p class="text-xs text-kosmos-muted">Sudah Dibayar</p>
    </div>

    <div class="card-kosmos p-5 hover:-translate-y-1 transition-transform">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-kosmos-brown/10">
                <i class="fas fa-utensils text-kosmos-brown"></i>
            </div>
            <span class="text-xs font-semibold text-kosmos-muted uppercase tracking-wide">Menu</span>
        </div>
        <p class="text-3xl font-serif font-bold text-kosmos-brown mb-0.5">{{ $totalMenu }}</p>
        <p class="text-xs text-kosmos-muted">Total Menu</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="card-kosmos p-6">
        <h3 class="font-serif font-semibold text-lg text-kosmos-brown mb-4 flex items-center gap-2">
            <i class="fas fa-bolt text-kosmos-primary"></i> Aksi Cepat
        </h3>
        <div class="space-y-2">
            <a href="{{ route('vendor.pesanan.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-kosmos-bg transition group">
                <span class="text-sm font-medium text-kosmos-brown group-hover:text-kosmos-primary">Lihat Semua Pesanan</span>
                <i class="fas fa-arrow-right text-kosmos-border group-hover:text-kosmos-primary text-xs transition"></i>
            </a>
            <a href="{{ route('vendor.menu.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-kosmos-bg transition group">
                <span class="text-sm font-medium text-kosmos-brown group-hover:text-kosmos-primary">Tambah Menu Baru</span>
                <i class="fas fa-arrow-right text-kosmos-border group-hover:text-kosmos-primary text-xs transition"></i>
            </a>
            <a href="{{ route('vendor.profil.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-kosmos-bg transition group">
                <span class="text-sm font-medium text-kosmos-brown group-hover:text-kosmos-primary">Update Profil Cafe</span>
                <i class="fas fa-arrow-right text-kosmos-border group-hover:text-kosmos-primary text-xs transition"></i>
            </a>
            <a href="{{ route('vendor.galeri.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-kosmos-bg transition group">
                <span class="text-sm font-medium text-kosmos-brown group-hover:text-kosmos-primary">Kelola Galeri & Fasilitas</span>
                <i class="fas fa-arrow-right text-kosmos-border group-hover:text-kosmos-primary text-xs transition"></i>
            </a>
        </div>
    </div>

    <div class="card-kosmos p-6">
        <h3 class="font-serif font-semibold text-lg text-kosmos-brown mb-4 flex items-center gap-2">
            <i class="fas fa-info-circle text-kosmos-sage"></i> Tips & Info
        </h3>
        <div class="space-y-3">
            <div class="flex items-start gap-3 p-3 rounded-xl bg-kosmos-primary/10 border border-kosmos-primary/20">
                <i class="fas fa-qrcode text-kosmos-primary mt-0.5"></i>
                <p class="text-xs text-kosmos-brown">Pesanan QRIS yang belum dibayar bisa <strong>ditampilkan QR-nya</strong> dari halaman Pesanan Masuk.</p>
            </div>
            <div class="flex items-start gap-3 p-3 rounded-xl bg-kosmos-sage/10 border border-kosmos-sage/20">
                <i class="fas fa-bell text-kosmos-sage mt-0.5"></i>
                <p class="text-xs text-kosmos-brown">Badge warna <strong class="text-kosmos-primary">terracotta</strong> pada menu <strong>Pesanan Masuk</strong> menunjukkan jumlah pesanan baru yang belum diproses.</p>
            </div>
            <div class="flex items-start gap-3 p-3 rounded-xl bg-kosmos-dark/10 border border-kosmos-dark/20">
                <i class="fas fa-star text-kosmos-dark mt-0.5"></i>
                <p class="text-xs text-kosmos-brown">Lengkapi <strong>profil dan galeri</strong> cafe untuk menarik lebih banyak pelanggan!</p>
            </div>
        </div>
    </div>
</div>

@endsection