@extends('vendor.layouts.app')
@section('title', 'Profil Cafe')
@section('page_title', 'Profil Cafe')

@section('content')

@if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-kosmos-sage/10 border border-kosmos-sage/20 text-kosmos-sage px-4 py-3 rounded-xl text-sm">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <ul class="list-disc pl-5 space-y-1 font-semibold text-xs">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-serif font-bold text-kosmos-brown">Profil Cafe</h1>
        <p class="text-kosmos-muted text-sm mt-1">Atur informasi dasar yang akan tampil kepada pelanggan.</p>
    </div>

    <form action="{{ route('vendor.profil.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="card-kosmos p-6 space-y-6">

            <!-- Nama Cafe -->
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-2">Nama Cafe <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $cafe->nama ?? '') }}" required
                    class="w-full px-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown"
                    placeholder="Contoh: Kopi Nusantara">
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-2">Nomor Telepon / WhatsApp</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-kosmos-muted text-sm"><i class="fas fa-phone"></i></span>
                    <input type="text" name="no_telp" value="{{ old('no_telp', $cafe->no_telp ?? '') }}"
                        class="w-full pl-10 pr-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown"
                        placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-2">Alamat Lengkap</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-kosmos-muted text-sm"><i class="fas fa-map-marker-alt"></i></span>
                    <textarea name="alamat" rows="3"
                        class="w-full pl-10 pr-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition resize-none text-kosmos-brown"
                        placeholder="Jl. Contoh No. 1, Kel. X, Kec. Y, Jakarta Barat">{{ old('alamat', $cafe->alamat ?? '') }}</textarea>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-2">Deskripsi Singkat Cafe</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full px-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition resize-none text-kosmos-brown"
                    placeholder="Ceritakan tentang suasana, keunikan, dan keistimewaan kafe Anda...">{{ old('deskripsi', $cafe->deskripsi ?? '') }}</textarea>
            </div>

            <!-- Foto Profil / Cover (URL) -->
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-2">Foto Profil / Cover (URL)</label>
                <p class="text-kosmos-muted text-xs mb-2">Masukkan URL gambar yang akan dijadikan banner/cover halaman cafe Anda.</p>
                <input type="url" name="foto_profil" id="foto_profil_input" value="{{ old('foto_profil', $cafe->foto_profil ?? '') }}"
                    class="w-full px-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm font-mono focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown"
                    placeholder="https://images.unsplash.com/photo-..."
                    oninput="document.getElementById('foto_profil_preview').src=this.value; document.getElementById('foto_profil_preview_box').style.display=this.value?'block':'none';">
                <div id="foto_profil_preview_box" class="mt-3 {{ !empty($cafe->foto_profil) ? '' : 'hidden' }}">
                    <img id="foto_profil_preview" src="{{ $cafe->foto_profil ?? '' }}" alt="Preview" class="w-full h-48 object-cover rounded-xl bg-kosmos-sec"
                        onerror="this.parentElement.style.display='none'">
                </div>
            </div>

            <!-- Jam Operasional -->
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-2">Jam Operasional</label>
                <p class="text-kosmos-muted text-xs mb-2">Contoh: Senin - Jumat: 08:00 - 22:00, Sabtu - Minggu: 09:00 - 23:00</p>
                <textarea name="jam_operasional" rows="3"
                    class="w-full px-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition resize-none text-kosmos-brown"
                    placeholder="Senin - Jumat: 08:00 - 22:00&#10;Sabtu - Minggu: 09:00 - 23:00">{{ old('jam_operasional', $cafe->jam_operasional ?? '') }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-4 border-t border-kosmos-border">
                <button type="submit"
                    class="flex items-center gap-2 bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold text-sm py-3 px-8 rounded-full shadow-sm transition-all hover:shadow-md">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    <!-- Logout -->
    <div class="mt-8 card-kosmos p-6 border-red-200/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <p class="font-serif font-bold text-kosmos-brown text-lg">Keluar dari Akun</p>
            <p class="text-kosmos-muted text-sm mt-0.5">Sesi Anda akan diakhiri dan Anda akan diarahkan ke halaman login.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full md:w-auto flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-sm py-2.5 px-6 rounded-full border border-red-200 transition-colors">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>

@endsection