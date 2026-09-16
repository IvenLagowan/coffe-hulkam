<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Panel') — Hulkam Caffe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kosmos: {
                            bg: '#0E0B09',       /* page background (espresso black) */
                            sec: '#17110B',      /* secondary bg */
                            panel: '#100C08',    /* sidebar panel */
                            surface: '#1B140E',  /* cards */
                            primary: '#E0A263',  /* gold accent */
                            dark: '#C8894A',     /* gold darker */
                            sage: '#93A56B',
                            brown: '#F1E7D9',    /* used as heading/light text on dark */
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
                radial-gradient(900px 500px at 100% -5%, rgba(224,162,99,0.10), transparent 60%),
                radial-gradient(700px 400px at -10% 110%, rgba(147,165,107,0.07), transparent 60%);
            background-attachment: fixed;
        }
        .sidebar-link { transition: all 0.2s ease; border-left: 3px solid transparent; }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(224, 162, 99, 0.12);
            border-left-color: #E0A263;
            color: #F1E7D9;
        }
        .sidebar-link.active { background: rgba(224, 162, 99, 0.18); }
        .nav-badge { background: #E0A263; color: #1B140E; }
        .card-kosmos {
            background: #1B140E;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.35);
            border: 1px solid rgba(224,178,122,0.14);
        }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #6b4f38; border-radius: 9999px; }
        ::selection { background: #E0A263; color: #1B140E; }

        /* ===== Dark-mode utility overrides (KedaiSeduh) ===== */
        .bg-white{background-color:#1B140E !important;}
        .bg-gray-50,.bg-gray-100,.bg-slate-50,.bg-slate-100{background-color:#17110B !important;}
        .bg-gray-200,.bg-slate-200{background-color:#241C15 !important;}
        .bg-gray-800,.bg-gray-900,.bg-slate-800,.bg-slate-900{background-color:#0E0B09 !important;}
        .text-gray-900,.text-gray-800,.text-gray-700,.text-slate-900,.text-slate-800,.text-slate-700,.text-black{color:#E9DECF !important;}
        .text-gray-600,.text-gray-500,.text-gray-400,.text-slate-600,.text-slate-500,.text-slate-400{color:#A08E7B !important;}
        .border-gray-50,.border-gray-100,.border-gray-200,.border-gray-300,.border-slate-100,.border-slate-200{border-color:rgba(224,178,122,0.14) !important;}
        .divide-gray-100>:not([hidden])~:not([hidden]),.divide-gray-200>:not([hidden])~:not([hidden]){border-color:rgba(224,178,122,0.12) !important;}
        .hover\:bg-gray-50:hover,.hover\:bg-gray-100:hover{background-color:#241C15 !important;}
        input,select,textarea{background-color:#17110B;color:#E9DECF;border-color:rgba(224,178,122,0.18);}
        input::placeholder,textarea::placeholder{color:#8a7a68;}
        table thead{background-color:#17110B !important;}

        #vendor-sidebar { transition: transform 0.3s ease; }
        #sidebar-overlay { transition: opacity 0.3s ease; }
    </style>
</head>
<body class="flex min-h-screen antialiased bg-kosmos-bg">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 hidden opacity-0 lg:hidden" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="vendor-sidebar" class="bg-kosmos-panel fixed left-0 top-0 h-full w-64 z-50 flex flex-col min-h-screen -translate-x-full lg:translate-x-0 transition-transform duration-300 border-r border-kosmos-border">
        <!-- Logo -->
        <div class="px-6 py-6 border-b border-kosmos-border">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-gradient-to-br from-kosmos-primary to-kosmos-dark shadow-lg shadow-kosmos-primary/20">
                    <i class="fas fa-mug-hot text-[#1B140E] text-sm"></i>
                </div>
                <div>
                    <p class="text-kosmos-brown font-serif font-bold text-lg leading-tight">Hulkam Caffe</p>
                    <p class="text-kosmos-muted text-xs">Vendor Panel</p>
                </div>
                <button onclick="closeSidebar()" class="ml-auto text-kosmos-muted hover:text-white lg:hidden">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- User Info -->
        <div class="px-4 py-4 border-b border-kosmos-border">
            <div class="flex items-center gap-3 px-2 py-2 rounded-xl bg-white/5">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-kosmos-primary to-kosmos-dark flex items-center justify-center text-[#1B140E] font-semibold text-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-white text-xs font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-kosmos-muted text-xs truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <p class="text-kosmos-muted text-xs font-semibold uppercase tracking-widest px-3 mb-3">Menu Utama</p>

            <a href="{{ route('vendor.dashboard') }}" onclick="closeSidebar()" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-kosmos-text/70 text-sm {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-bar w-4 text-center"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('vendor.menu.index') }}" onclick="closeSidebar()" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-kosmos-text/70 text-sm {{ request()->routeIs('vendor.menu.*') ? 'active' : '' }}">
                <i class="fas fa-utensils w-4 text-center"></i>
                <span>Manajemen Menu</span>
            </a>
            <a href="{{ route('vendor.pesanan.index') }}" onclick="closeSidebar()" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-kosmos-text/70 text-sm {{ request()->routeIs('vendor.pesanan.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag w-4 text-center"></i>
                <span>Pesanan Masuk</span>
                @php $jumlahPesananBaru = \Illuminate\Support\Facades\DB::table('transaksi')->where('status','Masuk')->count(); @endphp
                @if($jumlahPesananBaru > 0)
                    <span class="nav-badge ml-auto text-xs font-bold px-2 py-0.5 rounded-full">{{ $jumlahPesananBaru }}</span>
                @endif
            </a>
            <a href="{{ route('vendor.booking.index') }}" onclick="closeSidebar()" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-kosmos-text/70 text-sm {{ request()->routeIs('vendor.booking.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt w-4 text-center"></i>
                <span>Kelola Booking</span>
            </a>
            <a href="{{ route('vendor.meja.index') }}" onclick="closeSidebar()" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-kosmos-text/70 text-sm {{ request()->routeIs('vendor.meja.*') ? 'active' : '' }}">
                <i class="fas fa-chair w-4 text-center"></i>
                <span>Manajemen Meja</span>
            </a>

            <p class="text-kosmos-muted text-xs font-semibold uppercase tracking-widest px-3 mt-5 mb-3">Pengaturan</p>

            <a href="{{ route('vendor.profil.index') }}" onclick="closeSidebar()" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-kosmos-text/70 text-sm {{ request()->routeIs('vendor.profil.*') ? 'active' : '' }}">
                <i class="fas fa-store w-4 text-center"></i>
                <span>Profil Cafe</span>
            </a>
            <a href="{{ route('vendor.galeri.index') }}" onclick="closeSidebar()" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-kosmos-text/70 text-sm {{ request()->routeIs('vendor.galeri.*') ? 'active' : '' }}">
                <i class="fas fa-images w-4 text-center"></i>
                <span>Galeri & Info Cafe</span>
            </a>
        </nav>

        <!-- Bottom: Back + Logout -->
        <div class="px-3 py-4 border-t border-kosmos-border space-y-1">
            <a href="{{ url('/') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-kosmos-muted text-sm hover:text-white">
                <i class="fas fa-arrow-left w-4 text-center"></i>
                <span>Kembali ke Website</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-400 text-sm hover:bg-red-500/20 hover:text-red-300 hover:border-red-500">
                    <i class="fas fa-sign-out-alt w-4 text-center"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen overflow-y-auto">
        <!-- Top Bar -->
        <header class="sticky top-0 z-30 bg-kosmos-bg/70 backdrop-blur-md border-b border-kosmos-border px-4 sm:px-8 py-4 flex items-center justify-between">
            <!-- Hamburger + Title -->
            <div class="flex items-center gap-3">
                <button onclick="openSidebar()" class="lg:hidden w-10 h-10 rounded-xl bg-kosmos-surface border border-kosmos-border text-kosmos-primary flex items-center justify-center shadow-sm flex-shrink-0">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h2 class="text-kosmos-brown font-serif font-bold text-base sm:text-lg">@yield('page_title', 'Dashboard')</h2>
                    <p class="text-kosmos-muted text-xs mt-0.5 hidden sm:block">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-kosmos-brown text-xs font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-kosmos-muted text-xs capitalize">Role: Vendor</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-kosmos-primary to-kosmos-dark flex items-center justify-center text-[#1B140E] font-semibold text-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4 sm:p-6 lg:p-8 flex-grow">
            @yield('content')
        </main>

        <footer class="text-center py-4 text-xs text-kosmos-muted border-t border-kosmos-border mx-4 sm:mx-8 mt-auto">
            &copy; 2026 Hulkam Caffe. All rights reserved.
        </footer>
    </div>

    <script>
        function openSidebar() {
            const sidebar = document.getElementById('vendor-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden', 'opacity-0');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
        }
        function closeSidebar() {
            const sidebar = document.getElementById('vendor-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            setTimeout(() => overlay.classList.add('hidden', 'opacity-0'), 300);
        }
    </script>

</body>
</html>
