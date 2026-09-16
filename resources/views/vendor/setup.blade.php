<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Cafe — Hulkam Caffe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kosmos: {
                            bg: '#0E0B09',
                            sec: '#17110B',
                            panel: '#100C08',
                            surface: '#1B140E',
                            primary: '#E0A263',
                            dark: '#C8894A',
                            sage: '#93A56B',
                            brown: '#F1E7D9',
                            text: '#E9DECF',
                            muted: '#A08E7B',
                            border: 'rgba(224,178,122,0.14)'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0E0B09; color: #E9DECF;
            background-image: radial-gradient(800px 500px at 10% -10%, rgba(224,162,99,0.10), transparent 60%);
        }
        .card-kosmos {
            background: #1B140E;
            border-radius: 24px;
            box-shadow: 0 20px 55px rgba(0,0,0,0.5);
            border: 1px solid rgba(224,178,122,0.14);
        }
        .bg-white{background-color:#1B140E !important;}
        .text-gray-900,.text-gray-800,.text-gray-700{color:#E9DECF !important;}
        .text-gray-600,.text-gray-500,.text-gray-400{color:#A08E7B !important;}
        input,select,textarea{background-color:#17110B;color:#E9DECF;border-color:rgba(224,178,122,0.18);}
        input::placeholder,textarea::placeholder{color:#8a7a68;}
        ::selection{background:#E0A263;color:#1B140E;}
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-kosmos-bg px-4 py-8">
    <div class="w-full max-w-lg card-kosmos p-8 md:p-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-kosmos-primary text-white rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-kosmos-primary/30">
                <i class="fas fa-store text-3xl"></i>
            </div>
            <h1 class="text-2xl font-serif font-bold text-kosmos-brown">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-kosmos-muted mt-2 text-sm leading-relaxed">Mari siapkan halaman Cafe Anda untuk mulai menerima pesanan.</p>
        </div>

        <form action="{{ route('vendor.setup.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Nama Cafe <span class="text-red-500">*</span></label>
                <input type="text" name="nama" required class="w-full px-4 py-3 rounded-xl border border-kosmos-border bg-kosmos-bg/30 focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary transition-shadow outline-none text-sm text-kosmos-brown" placeholder="Contoh: Kopi Kenangan Barat">
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-xl border border-kosmos-border bg-kosmos-bg/30 focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary transition-shadow outline-none text-sm text-kosmos-brown resize-none" placeholder="Ceritakan sedikit tentang cafe Anda..."></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Alamat (Lokasi)</label>
                <textarea name="alamat" rows="2" class="w-full px-4 py-3 rounded-xl border border-kosmos-border bg-kosmos-bg/30 focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary transition-shadow outline-none text-sm text-kosmos-brown resize-none" placeholder="Jl. Contoh No. 123..."></textarea>
            </div>
            
            <hr class="border-kosmos-border/50 my-6">

            <p class="text-xs text-kosmos-muted mb-4 font-semibold"><i class="fas fa-info-circle mr-1"></i>Opsional (bisa diisi nanti)</p>
            
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Fasilitas</label>
                <input type="text" name="fasilitas" class="w-full px-4 py-3 rounded-xl border border-kosmos-border bg-kosmos-bg/30 focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary transition-shadow outline-none text-sm text-kosmos-brown" placeholder="WiFi, Area Smoking, dll">
            </div>
            
            <div>
                <label class="block text-xs font-semibold tracking-wide text-kosmos-muted uppercase mb-1.5">Galeri (Link Gambar)</label>
                <input type="text" name="galeri" class="w-full px-4 py-3 rounded-xl border border-kosmos-border bg-kosmos-bg/30 focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary transition-shadow outline-none text-sm font-mono text-kosmos-brown" placeholder="https://contoh.com/gambar1.jpg...">
            </div>

            <button type="submit" class="w-full py-3.5 mt-8 bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold rounded-full shadow-md shadow-kosmos-primary/20 transition-all transform hover:-translate-y-1 text-sm">
                Selesai & Buka Dashboard <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </form>

        <form action="{{ route('logout') }}" method="POST" class="mt-8 text-center border-t border-kosmos-border pt-6">
            @csrf
            <button type="submit" class="text-sm font-semibold text-red-500 hover:text-red-700 underline transition-colors">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </form>
    </div>
</body>
</html>
