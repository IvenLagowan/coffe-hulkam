@extends('vendor.layouts.app')
@section('title', 'Manajemen Menu')
@section('page_title', 'Manajemen Menu')

@section('content')

@if(session('success'))
    <div class="mb-4 flex items-center gap-3 bg-kosmos-sage/10 border border-kosmos-sage/20 text-kosmos-sage px-4 py-3 rounded-xl text-sm">
        <i class="fas fa-check-circle"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <i class="fas fa-exclamation-circle text-red-500"></i>{{ session('error') }}
    </div>
@endif

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-kosmos-brown">Daftar Menu</h1>
        <p class="text-kosmos-muted text-sm mt-1">Kelola hidangan dan minuman yang tersedia di kafe Anda.</p>
    </div>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')"
        class="flex items-center gap-2 bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold text-sm py-2.5 px-5 rounded-full shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:shadow-kosmos-primary/30">
        <i class="fas fa-plus text-xs"></i> Tambah Menu
    </button>
</div>

<!-- Menu Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse ($menus as $item)
        <div class="card-kosmos overflow-hidden flex flex-col group hover:-translate-y-1 transition-transform">
            @if($item->gambar)
                <img src="{{ $item->gambar }}" alt="{{ $item->nama_menu }}" class="w-full h-40 object-cover" onerror="this.style.display='none'">
            @else
                <div class="w-full h-40 bg-kosmos-sec/30 flex items-center justify-center">
                    <i class="fas fa-image text-4xl text-kosmos-border"></i>
                </div>
            @endif
            <div class="p-5 flex flex-col gap-3 flex-1">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-serif font-bold text-kosmos-brown text-base truncate group-hover:text-kosmos-primary transition-colors">{{ $item->nama_menu }}</h3>
                        @if($item->deskripsi)
                            <p class="text-kosmos-muted text-xs mt-1.5 line-clamp-2 leading-relaxed">{{ $item->deskripsi }}</p>
                        @endif
                    </div>
                    @php $status = $item->status ?? 'tersedia'; @endphp
                    <span class="ml-3 flex-shrink-0 text-xs font-semibold px-3 py-1 rounded-full {{ $status === 'habis' ? 'bg-red-50 text-red-600' : 'bg-kosmos-sage/10 text-kosmos-sage' }}">
                        {{ $status === 'habis' ? 'Habis' : 'Tersedia' }}
                    </span>
                </div>
                <p class="text-kosmos-primary font-bold text-lg mt-1">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                <div class="flex gap-3 pt-4 border-t border-kosmos-border mt-auto">
                    <button onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->nama_menu) }}', {{ $item->harga }}, '{{ addslashes($item->deskripsi ?? '') }}', '{{ $status }}', '{{ addslashes($item->gambar ?? '') }}')"
                        class="flex-1 flex items-center justify-center gap-1.5 bg-kosmos-sec/30 hover:bg-kosmos-sec text-kosmos-brown text-xs font-semibold py-2.5 rounded-xl transition-colors border border-kosmos-border/50">
                        <i class="fas fa-pen text-xs"></i> Edit
                    </button>
                    <form action="{{ route('vendor.menu.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus menu ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold py-2.5 rounded-xl transition-colors">
                            <i class="fas fa-trash text-xs"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-3 card-kosmos p-16 text-center">
            <i class="fas fa-utensils text-5xl text-kosmos-border mb-4"></i>
            <p class="text-kosmos-brown font-serif font-bold text-lg">Belum ada menu</p>
            <p class="text-kosmos-muted text-sm mt-1">Tambahkan menu baru menggunakan tombol di atas.</p>
        </div>
    @endforelse
</div>

<!-- Modal Tambah Menu -->
<div id="addModal" class="fixed inset-0 z-[100] hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
        <div class="px-6 py-5 bg-kosmos-bg border-b border-kosmos-border flex items-center justify-between">
            <h3 class="font-serif font-bold text-kosmos-brown text-lg">Tambah Menu Baru</h3>
            <button onclick="document.getElementById('addModal').classList.add('hidden')" class="text-kosmos-muted hover:text-kosmos-brown transition"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('vendor.menu.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Nama Menu</label>
                <input type="text" name="nama_menu" required class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-text">
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Harga (Rp)</label>
                <input type="number" name="harga" required min="0" class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-text">
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition resize-none text-kosmos-text"></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Gambar Menu (URL)</label>
                <input type="url" name="gambar" class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm font-mono focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-text" placeholder="https://images.unsplash.com/...">
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Status</label>
                <select name="status" required class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-text">
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="flex-1 py-2.5 border border-kosmos-border bg-white rounded-full text-sm font-semibold text-kosmos-muted hover:text-kosmos-brown hover:bg-kosmos-bg transition">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-kosmos-primary hover:bg-kosmos-dark text-white rounded-full text-sm font-semibold transition shadow-sm">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Menu -->
<div id="editModal" class="fixed inset-0 z-[100] hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
        <div class="px-6 py-5 bg-kosmos-bg border-b border-kosmos-border flex items-center justify-between">
            <h3 class="font-serif font-bold text-kosmos-brown text-lg">Edit Menu</h3>
            <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-kosmos-muted hover:text-kosmos-brown transition"><i class="fas fa-times"></i></button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Nama Menu</label>
                <input type="text" id="edit_nama_menu" name="nama_menu" required class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-text">
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Harga (Rp)</label>
                <input type="number" id="edit_harga" name="harga" required min="0" class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-text">
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Deskripsi (Opsional)</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition resize-none text-kosmos-text"></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Gambar Menu (URL)</label>
                <input type="url" id="edit_gambar" name="gambar" class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm font-mono focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-text" placeholder="https://images.unsplash.com/...">
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Status</label>
                <select id="edit_status" name="status" required class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-text">
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="flex-1 py-2.5 border border-kosmos-border bg-white rounded-full text-sm font-semibold text-kosmos-muted hover:text-kosmos-brown hover:bg-kosmos-bg transition">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-kosmos-primary hover:bg-kosmos-dark text-white rounded-full text-sm font-semibold transition shadow-sm">Update Menu</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, nama, harga, deskripsi, status, gambar) {
    const form = document.getElementById('editForm');
    form.action = `/vendor/menu/${id}`;
    document.getElementById('edit_nama_menu').value = nama;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_deskripsi').value = deskripsi;
    document.getElementById('edit_gambar').value = gambar || '';
    document.getElementById('edit_status').value = status;
    document.getElementById('editModal').classList.remove('hidden');
}
</script>
@endsection