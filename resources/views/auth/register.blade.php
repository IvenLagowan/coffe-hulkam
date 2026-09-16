<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Hulkam Caffe</title>
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
            background-color: #0E0B09;
            color: #E9DECF;
            background-image:
                radial-gradient(800px 500px at 10% -10%, rgba(147,165,107,0.08), transparent 60%),
                radial-gradient(700px 400px at 100% 110%, rgba(224,162,99,0.10), transparent 60%);
        }
        .card-kosmos {
            background: #1B140E;
            border-radius: 24px;
            box-shadow: 0 20px 55px rgba(0,0,0,0.5);
            border: 1px solid rgba(224,178,122,0.14);
        }
        ::selection{background:#E0A263;color:#1B140E;}
        .bg-white{background-color:#1B140E !important;}
        .bg-gray-100,.bg-gray-200{background-color:#241C15 !important;}
        .text-gray-900,.text-gray-800,.text-gray-700{color:#E9DECF !important;}
        .text-gray-600,.text-gray-500,.text-gray-400{color:#A08E7B !important;}
        input::placeholder,textarea::placeholder{color:#8a7a68;}
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-kosmos-bg px-4 py-10 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-kosmos-sage/10 blur-3xl"></div>
        <div class="absolute -bottom-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-kosmos-primary/10 blur-3xl"></div>
    </div>

    <div class="card-kosmos p-8 md:p-10 w-full max-w-md relative z-10 my-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-kosmos-primary to-kosmos-dark text-[#1B140E] rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-kosmos-primary/30">
                <i class="fas fa-mug-hot text-3xl"></i>
            </div>
            <h1 class="text-3xl font-serif font-bold text-kosmos-brown">Daftar Akun</h1>
            <p class="text-kosmos-muted mt-2 text-sm">Buat akun baru untuk mengakses Hulkam Caffe</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 mb-6 rounded-xl text-sm font-medium flex items-start gap-3">
                <i class="fas fa-exclamation-circle mt-0.5 text-red-500"></i>
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold tracking-wide text-kosmos-muted uppercase mb-1.5">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-kosmos-muted"><i class="fas fa-user"></i></span>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full pl-11 pr-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold tracking-wide text-kosmos-muted uppercase mb-1.5">Email</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-kosmos-muted"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full pl-11 pr-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold tracking-wide text-kosmos-muted uppercase mb-1.5">Pilih Peran (Role)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-kosmos-muted"><i class="fas fa-id-badge"></i></span>
                    <select name="role" required class="w-full pl-11 pr-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown appearance-none">
                        <option value="user">Pelanggan (Customer)</option>
                        <option value="vendor">Pemilik Cafe (Vendor)</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <p class="text-[11px] font-medium text-kosmos-muted/70 mt-1.5">*Pemilihan role terbuka untuk keperluan demo tugas.</p>
            </div>
            <div>
                <label class="block text-xs font-bold tracking-wide text-kosmos-muted uppercase mb-1.5">Password</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-kosmos-muted"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" required class="w-full pl-11 pr-11 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown">
                    <button type="button" onclick="togglePassword('password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-kosmos-muted hover:text-kosmos-brown transition-colors outline-none">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold tracking-wide text-kosmos-muted uppercase mb-1.5">Konfirmasi Password</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-kosmos-muted"><i class="fas fa-check"></i></span>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full pl-11 pr-11 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm focus:ring-2 focus:ring-kosmos-primary/20 focus:border-kosmos-primary outline-none transition text-kosmos-brown">
                    <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-kosmos-muted hover:text-kosmos-brown transition-colors outline-none">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="pt-4">
                <button type="submit" onclick="if(this.form.checkValidity()){ this.classList.add('opacity-80', 'cursor-not-allowed'); this.innerHTML='<i class=\'fas fa-spinner fa-spin mr-2\'></i> Memproses...'; }" class="w-full bg-kosmos-primary hover:bg-kosmos-dark text-white font-bold py-3.5 px-4 rounded-full shadow-md shadow-kosmos-primary/20 transition-all transform hover:-translate-y-1">
                    Daftar Sekarang <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </form>

        <p class="text-center text-kosmos-muted text-sm mt-8 border-t border-kosmos-border pt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-kosmos-primary font-bold hover:text-kosmos-dark transition-colors">Masuk di sini</a>
        </p>
        
        <div class="text-center mt-4">
             <a href="{{ url('/') }}" class="text-xs text-kosmos-muted hover:text-kosmos-brown transition-colors"><i class="fas fa-home mr-1"></i> Kembali ke Beranda</a>
        </div>
    </div>
    
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
