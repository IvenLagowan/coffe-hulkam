@extends('vendor.layouts.app')
@section('title', 'Galeri & Info Cafe')
@section('page_title', 'Galeri & Info Cafe')

@section('content')

@if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-kosmos-sage/10 border border-kosmos-sage/20 text-kosmos-sage px-4 py-3 rounded-xl text-sm">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-serif font-bold text-kosmos-brown">Galeri & Info Cafe</h1>
        <p class="text-kosmos-muted text-sm mt-1">Tambahkan foto galeri (URL) dan fasilitas yang tersedia di kafe Anda.</p>
    </div>

    <form action="{{ route('vendor.galeri.fasilitas') }}" method="POST">
        @csrf @method('PUT')
        <div class="card-kosmos p-6 space-y-5 mb-8">
            <!-- Fasilitas -->
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-2">Fasilitas Cafe</label>
                <p class="text-kosmos-muted text-xs mb-3">Pisahkan setiap fasilitas dengan koma. Contoh: WiFi, AC, Toilet, Parkir</p>
                <input type="text" name="fasilitas" value="{{ old('fasilitas', $cafe->fasilitas ?? '') }}"
                    class="w-full px-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown"
                    placeholder="WiFi, AC, Toilet, Parkir, Smoking Area">
            </div>

            <!-- Submit Fasilitas -->
            <div class="flex justify-end pt-4 border-t border-kosmos-border">
                <button type="submit"
                    class="flex items-center gap-2 bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold text-sm py-3 px-8 rounded-full shadow-sm transition-all">
                    <i class="fas fa-save"></i> Simpan Fasilitas
                </button>
            </div>
        </div>
    </form>

    <div class="card-kosmos p-6">
        <h2 class="text-lg font-serif font-bold text-kosmos-brown mb-5 border-b border-kosmos-border pb-4">Galeri Foto</h2>
        
        <form action="{{ route('vendor.galeri.store') }}" method="POST" class="mb-8 bg-kosmos-bg/50 p-5 rounded-2xl border border-kosmos-border">
            @csrf
            <h3 class="text-sm font-semibold text-kosmos-brown mb-4 uppercase tracking-wide">Tambah Foto Baru</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs text-kosmos-muted font-semibold mb-1.5">URL Gambar <span class="text-red-500">*</span></label>
                    <input type="url" name="gambar" class="w-full px-3.5 py-2.5 bg-white border border-kosmos-border rounded-xl text-sm outline-none focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary transition" required placeholder="https://...">
                </div>
                <div>
                    <label class="block text-xs text-kosmos-muted font-semibold mb-1.5">Nama Ruangan (Opsional)</label>
                    <input type="text" name="nama_ruangan" class="w-full px-3.5 py-2.5 bg-white border border-kosmos-border rounded-xl text-sm outline-none focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary transition" placeholder="Area Indoor">
                </div>
                <div>
                    <label class="block text-xs text-kosmos-muted font-semibold mb-1.5">Lantai (Opsional)</label>
                    <div class="flex gap-2">
                        <input type="number" name="lantai" class="w-full px-3.5 py-2.5 bg-white border border-kosmos-border rounded-xl text-sm outline-none focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary transition" placeholder="1">
                        <button type="submit" class="bg-kosmos-primary hover:bg-kosmos-dark text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition whitespace-nowrap shadow-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Preview Galeri -->
        <div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($galeri as $g)
                    <div class="relative aspect-square rounded-2xl overflow-hidden bg-kosmos-sec group border border-kosmos-border/50 shadow-sm">
                        <img src="{{ $g->gambar }}" alt="{{ $g->nama_ruangan }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-kosmos-brown/70 backdrop-blur-[2px] transition-all flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 p-4 text-center">
                            @if($g->nama_ruangan)
                                <p class="text-white text-xs font-bold mb-3 tracking-wide">{{ $g->nama_ruangan }}</p>
                            @endif
                            <form action="{{ route('vendor.galeri.destroy', $g->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-xs font-semibold shadow-md transition" onclick="return confirm('Hapus foto ini dari galeri?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 border-2 border-dashed border-kosmos-border rounded-2xl bg-kosmos-bg/30">
                        <i class="fas fa-images text-5xl mb-4 text-kosmos-border block"></i>
                        <p class="font-serif font-bold text-lg text-kosmos-brown">Belum ada foto</p>
                        <p class="text-sm text-kosmos-muted mt-1">Tambahkan foto galeri menggunakan form di atas.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
