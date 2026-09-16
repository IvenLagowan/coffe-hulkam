@extends('vendor.layouts.app')
@section('title', 'Manajemen Meja')
@section('page_title', 'Manajemen Meja')

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
        <h1 class="text-2xl font-serif font-bold text-kosmos-brown">Daftar Meja</h1>
        <p class="text-kosmos-muted text-sm mt-1">Kelola ketersediaan meja untuk reservasi/booking di kafe Anda.</p>
    </div>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')"
        class="flex items-center gap-2 bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold text-sm py-2.5 px-5 rounded-full shadow-sm transition-all hover:-translate-y-0.5">
        <i class="fas fa-plus text-xs"></i> Tambah Meja
    </button>
</div>

<!-- Meja Grid -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
    @forelse ($meja as $item)
        <div class="card-kosmos p-5 flex flex-col items-center text-center relative overflow-hidden group hover:-translate-y-1 transition-transform">
            <!-- Decorative corner -->
            <div class="absolute -right-4 -top-4 w-12 h-12 bg-kosmos-bg rounded-full group-hover:bg-kosmos-sec/50 transition-colors"></div>
            
            <div class="w-16 h-16 bg-kosmos-bg border border-kosmos-border rounded-full flex items-center justify-center mb-4 relative z-10 group-hover:scale-110 transition-transform">
                <i class="fas fa-chair text-2xl text-kosmos-primary"></i>
            </div>
            <h3 class="font-serif font-bold text-kosmos-brown text-lg">Meja {{ $item->no_table }}</h3>
            <span class="text-xs font-semibold text-kosmos-muted bg-kosmos-bg px-3 py-1.5 rounded-full mt-2 mb-5 border border-kosmos-border">
                Kapasitas: {{ $item->max_person }} Orang
            </span>
            
            <div class="flex w-full gap-3 mt-auto">
                <button onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->no_table) }}', {{ $item->max_person }})"
                    class="flex-1 flex items-center justify-center bg-kosmos-sec/30 hover:bg-kosmos-sec text-kosmos-brown text-xs font-semibold py-2.5 rounded-xl transition border border-kosmos-border/50">
                    <i class="fas fa-pen"></i>
                </button>
                <form action="{{ route('vendor.meja.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus meja ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold py-2.5 rounded-xl transition border border-red-100">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full card-kosmos p-16 text-center border border-dashed border-kosmos-border bg-white shadow-none">
            <i class="fas fa-border-all text-5xl text-kosmos-border mb-4"></i>
            <p class="font-serif font-bold text-lg text-kosmos-brown">Belum ada meja</p>
            <p class="text-kosmos-muted text-sm mt-1">Tambahkan meja baru untuk memungkinkan pelanggan melakukan reservasi.</p>
        </div>
    @endforelse
</div>

<!-- Modal Tambah Meja -->
<div id="addModal" class="fixed inset-0 z-[100] hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
        <div class="px-6 py-5 bg-kosmos-bg border-b border-kosmos-border flex items-center justify-between">
            <h3 class="font-serif font-bold text-kosmos-brown text-lg">Tambah Meja Baru</h3>
            <button onclick="document.getElementById('addModal').classList.add('hidden')" class="text-kosmos-muted hover:text-kosmos-brown"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('vendor.meja.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-kosmos-muted uppercase tracking-wide mb-1.5">Nomor/Nama Meja</label>
                <input type="text" name="no_table" required placeholder="Contoh: 1, 2, A1, VIP" class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown">
            </div>
            <div>
                <label class="block text-xs font-semibold text-kosmos-muted uppercase tracking-wide mb-1.5">Kapasitas (Orang)</label>
                <input type="number" name="max_person" required min="1" placeholder="Contoh: 4" class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown">
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold py-3 rounded-full transition shadow-sm">Simpan Meja</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Meja -->
<div id="editModal" class="fixed inset-0 z-[100] hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
        <div class="px-6 py-5 bg-kosmos-bg border-b border-kosmos-border flex items-center justify-between">
            <h3 class="font-serif font-bold text-kosmos-brown text-lg">Edit Meja</h3>
            <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-kosmos-muted hover:text-kosmos-brown"><i class="fas fa-times"></i></button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-kosmos-muted uppercase tracking-wide mb-1.5">Nomor/Nama Meja</label>
                <input type="text" id="edit_no_table" name="no_table" required class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown">
            </div>
            <div>
                <label class="block text-xs font-semibold text-kosmos-muted uppercase tracking-wide mb-1.5">Kapasitas (Orang)</label>
                <input type="number" id="edit_max_person" name="max_person" required min="1" class="w-full px-3.5 py-2.5 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown">
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold py-3 rounded-full transition shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, no_table, max_person) {
        document.getElementById('edit_no_table').value = no_table;
        document.getElementById('edit_max_person').value = max_person;
        document.getElementById('editForm').action = '/vendor/meja/' + id;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>
@endsection
