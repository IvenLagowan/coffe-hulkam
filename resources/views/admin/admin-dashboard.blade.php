<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — Hulkam Caffe</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0E0B09; color: #E9DECF; }
        .sidebar-link {
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-link.active, .sidebar-link:hover {
            background-color: rgba(232, 147, 90, 0.1);
            border-left-color: #E8935A;
            color: #E8935A;
        }
        .section-content { display: none; }
        .section-content.active { display: block; }
        .card-kosmos {
            background: #1B140E;
            border-radius: 20px;
            box-shadow: 0 12px 34px rgba(0,0,0,0.4);
            border: 1px solid rgba(224,178,122,0.14);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-kosmos-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(42,33,25,0.1);
        }
        
        /* Custom scrollbar for sidebar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(58, 42, 29, 0.2); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(58, 42, 29, 0.4); }
        /* Sidebar transition */
        #admin-sidebar { transition: transform 0.3s ease; }
        #sidebar-overlay { transition: opacity 0.3s ease; }
        /* ===== Dark-mode utility overrides (KedaiSeduh) ===== */
        .bg-white{background-color:#1B140E !important;}
        .bg-white\/70,.bg-white\/80,.bg-white\/90,.bg-white\/95{background-color:rgba(16,12,8,0.88) !important;}
        .bg-gray-50,.bg-gray-100,.bg-slate-50,.bg-slate-100{background-color:#17110B !important;}
        .bg-gray-200,.bg-slate-200{background-color:#241C15 !important;}
        .text-gray-900,.text-gray-800,.text-gray-700,.text-slate-900,.text-slate-800,.text-slate-700,.text-black{color:#E9DECF !important;}
        .text-gray-600,.text-gray-500,.text-gray-400,.text-slate-600,.text-slate-500,.text-slate-400{color:#A08E7B !important;}
        .border-gray-100,.border-gray-200,.border-gray-300,.border-slate-100,.border-slate-200{border-color:rgba(224,178,122,0.14) !important;}
        .divide-gray-100>:not([hidden])~:not([hidden]),.divide-gray-200>:not([hidden])~:not([hidden]){border-color:rgba(224,178,122,0.12) !important;}
        table thead{background-color:#17110B !important;}
        input,select,textarea{background-color:#17110B;color:#E9DECF;border-color:rgba(224,178,122,0.18);}
        input::placeholder,textarea::placeholder{color:#8a7a68;}
        ::selection{background:#E0A263;color:#1B140E;}
    </style>
</head>
<body class="bg-kosmos-bg text-kosmos-text flex min-h-screen">
    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden opacity-0 lg:hidden" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="w-64 bg-kosmos-panel text-white fixed lg:sticky top-0 h-screen flex flex-col shadow-2xl z-50 flex-shrink-0 overflow-y-auto -translate-x-full lg:translate-x-0">
        <div class="p-6 text-center border-b border-white/10">
            <div class="w-12 h-12 bg-kosmos-primary text-white rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                <i class="fas fa-user-shield text-xl"></i>
            </div>
            <h5 class="font-serif font-bold text-lg tracking-wide text-kosmos-brown">Admin Panel</h5>
            <p class="text-xs text-kosmos-brown/60 mt-1">Hulkam Caffe</p>
        </div>
        
        <nav class="flex-1 py-4 flex flex-col gap-1 px-3">
            <a href="#" data-section="dashboard" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-kosmos-brown/80">
                <i class="fas fa-chart-line w-5 text-center"></i> Dashboard
            </a>
            <a href="#" data-section="cafes" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-kosmos-brown/80">
                <i class="fas fa-store w-5 text-center"></i> Kelola Cafe
            </a>
            <a href="#" data-section="menus" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-kosmos-brown/80">
                <i class="fas fa-utensils w-5 text-center"></i> Kelola Menu
            </a>
            <a href="#" data-section="bookings" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-kosmos-brown/80">
                <i class="fas fa-calendar-alt w-5 text-center"></i> Kelola Booking
            </a>
            <a href="#" data-section="transactions" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-kosmos-brown/80">
                <i class="fas fa-receipt w-5 text-center"></i> Transaksi
            </a>
            <a href="#" data-section="users" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-kosmos-brown/80">
                <i class="fas fa-users w-5 text-center"></i> Kelola User
            </a>
            <a href="#" data-section="reports" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-kosmos-brown/80">
                <i class="fas fa-flag w-5 text-center"></i> Laporan & Komplain
            </a>
            <a href="#" data-section="gallery" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-kosmos-brown/80">
                <i class="fas fa-images w-5 text-center"></i> Galeri
            </a>
            
            <div class="mt-auto pt-4 border-t border-white/10 flex flex-col gap-1">
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-kosmos-brown/60 hover:text-white hover:bg-white/5 transition-colors">
                    <i class="fas fa-home w-5 text-center"></i> Ke Website
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-400/10 transition-colors text-left">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 lg:ml-0 flex flex-col min-h-screen relative">
        <!-- Topbar -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md shadow-sm border-b border-kosmos-border px-4 sm:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <!-- Hamburger (mobile only) -->
                <button onclick="openSidebar()" class="lg:hidden w-10 h-10 rounded-xl bg-kosmos-panel text-white flex items-center justify-center shadow-sm flex-shrink-0">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="font-serif font-bold text-base sm:text-xl text-kosmos-brown flex items-center gap-3">
                    <i class="fas fa-cube text-kosmos-primary text-sm hidden sm:inline"></i>
                    <span id="current-section-title">Dashboard Overview</span>
                </h2>
            </div>
            <div class="text-sm font-semibold text-kosmos-muted flex items-center gap-2 hidden sm:flex">
                <i class="fas fa-calendar-alt text-kosmos-primary"></i> {{ date('d F Y') }}
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 relative">
            
            @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-kosmos-sage/10 border border-kosmos-sage/20 text-kosmos-sage px-4 py-3 rounded-xl text-sm shadow-sm">
                <i class="fas fa-check-circle"></i>{{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm shadow-sm">
                <i class="fas fa-exclamation-circle text-red-500"></i>{{ session('error') }}
            </div>
            @endif

            <!-- ===== DASHBOARD SECTION ===== -->
            <div id="dashboard-section" class="section-content active">
                <!-- Global Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="card-kosmos card-kosmos-hover p-6 flex justify-between items-center border-l-4 border-l-kosmos-primary">
                        <div>
                            <p class="text-xs font-bold tracking-wider text-kosmos-muted uppercase mb-1">Vendor Aktif</p>
                            <h3 class="text-3xl font-serif font-bold text-kosmos-brown">{{ $total_vendor_aktif }}</h3>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-kosmos-primary/10 flex items-center justify-center">
                            <i class="fas fa-store text-2xl text-kosmos-primary"></i>
                        </div>
                    </div>
                    <div class="card-kosmos card-kosmos-hover p-6 flex justify-between items-center border-l-4 border-l-yellow-400">
                        <div>
                            <p class="text-xs font-bold tracking-wider text-kosmos-muted uppercase mb-1">Vendor Pending</p>
                            <h3 class="text-3xl font-serif font-bold text-kosmos-brown">{{ $total_vendor_pending }}</h3>
                            @if($total_vendor_pending > 0)
                                <p class="text-[10px] text-yellow-600 font-bold mt-1 uppercase tracking-wide"><i class="fas fa-circle text-[8px] mr-1 animate-pulse"></i>Perlu ditinjau</p>
                            @endif
                        </div>
                        <div class="w-14 h-14 rounded-full bg-yellow-400/10 flex items-center justify-center">
                            <i class="fas fa-clock text-2xl text-yellow-500"></i>
                        </div>
                    </div>
                    <div class="card-kosmos card-kosmos-hover p-6 flex justify-between items-center border-l-4 border-l-kosmos-sage">
                        <div>
                            <p class="text-xs font-bold tracking-wider text-kosmos-muted uppercase mb-1">Total Customer</p>
                            <h3 class="text-3xl font-serif font-bold text-kosmos-brown">{{ $total_customer }}</h3>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-kosmos-sage/10 flex items-center justify-center">
                            <i class="fas fa-users text-2xl text-kosmos-sage"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                    <!-- Per-Cafe Stats Table -->
                    <div class="card-kosmos overflow-hidden flex flex-col">
                        <div class="px-6 py-4 bg-kosmos-bg/30 border-b border-kosmos-border flex items-center gap-2">
                            <i class="fas fa-chart-bar text-kosmos-primary"></i>
                            <h5 class="font-bold text-kosmos-brown text-sm uppercase tracking-wide">Performa per Cafe (Approved)</h5>
                        </div>
                        <div class="overflow-x-auto p-4 flex-1">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="text-xs text-kosmos-muted border-b border-kosmos-border">
                                        <th class="pb-3 px-2">#</th>
                                        <th class="pb-3 px-2">Nama Cafe</th>
                                        <th class="pb-3 px-2">Trx</th>
                                        <th class="pb-3 px-2 text-right">Revenue</th>
                                        <th class="pb-3 px-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-kosmos-border/50">
                                    @forelse($cafe_stats as $i => $cs)
                                    <tr class="hover:bg-kosmos-bg/30 transition-colors group">
                                        <td class="py-3 px-2 text-kosmos-muted">{{ $i + 1 }}</td>
                                        <td class="py-3 px-2 font-bold text-kosmos-brown">{{ $cs->nama }}</td>
                                        <td class="py-3 px-2"><span class="bg-kosmos-primary/10 text-kosmos-primary px-2 py-1 rounded text-xs font-bold">{{ $cs->total_transaksi }}</span></td>
                                        <td class="py-3 px-2 font-bold text-kosmos-sage text-right">Rp {{ number_format($cs->total_revenue ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-3 px-2 text-center">
                                            <a href="{{ route('admin.cafe.detail', $cs->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-kosmos-bg text-kosmos-primary hover:bg-kosmos-primary hover:text-white transition-colors border border-kosmos-border">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center text-kosmos-muted py-6">Belum ada cafe yang disetujui.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="card-kosmos overflow-hidden flex flex-col">
                        <div class="px-6 py-4 bg-kosmos-bg/30 border-b border-kosmos-border flex items-center gap-2">
                            <i class="fas fa-history text-kosmos-sage"></i>
                            <h5 class="font-bold text-kosmos-brown text-sm uppercase tracking-wide">Transaksi Terbaru</h5>
                        </div>
                        <div class="overflow-x-auto p-4 flex-1">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="text-xs text-kosmos-muted border-b border-kosmos-border">
                                        <th class="pb-3 px-2">Kode</th>
                                        <th class="pb-3 px-2">Cafe</th>
                                        <th class="pb-3 px-2">Status</th>
                                        <th class="pb-3 px-2 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-kosmos-border/50">
                                    @forelse($recent_transactions as $trx)
                                    <tr class="hover:bg-kosmos-bg/30 transition-colors">
                                        <td class="py-3 px-2">
                                            <p class="font-bold text-kosmos-primary text-xs">{{ $trx->order_code }}</p>
                                            <p class="text-[10px] text-kosmos-muted mt-0.5">{{ \Carbon\Carbon::parse($trx->tgl)->format('d M, H:i') }}</p>
                                        </td>
                                        <td class="py-3 px-2">
                                            <p class="font-bold text-kosmos-brown text-xs">{{ $trx->nama_cafe }}</p>
                                            <p class="text-[10px] text-kosmos-muted mt-0.5 truncate max-w-[100px]">{{ $trx->nama_pelanggan }}</p>
                                        </td>
                                        <td class="py-3 px-2">
                                            @php
                                                $sc = match($trx->status) {
                                                    'Masuk' => 'bg-blue-50 text-blue-700', 'Dibayar' => 'bg-kosmos-sage/15 text-kosmos-sage',
                                                    'Diproses' => 'bg-kosmos-primary/15 text-kosmos-primary', 'Siap Diambil' => 'bg-kosmos-dark/15 text-kosmos-dark',
                                                    'Selesai' => 'bg-kosmos-bg text-kosmos-muted border border-kosmos-border', default => 'bg-red-50 text-red-700',
                                                };
                                            @endphp
                                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $sc }}">{{ $trx->status }}</span>
                                        </td>
                                        <td class="py-3 px-2 font-bold text-kosmos-brown text-right whitespace-nowrap">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center text-kosmos-muted py-6">Belum ada transaksi.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== CAFES SECTION ===== -->
            <div id="cafes-section" class="section-content">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-serif font-bold text-kosmos-brown">Kelola Cafe</h2>
                        <p class="text-sm text-kosmos-muted mt-1">Review dan kelola pendaftaran cafe vendor.</p>
                    </div>
                </div>
                <div class="card-kosmos overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-kosmos-bg/50 border-b border-kosmos-border">
                                <tr class="text-xs font-bold text-kosmos-muted uppercase tracking-wider">
                                    <th class="py-4 px-6">Nama Cafe</th>
                                    <th class="py-4 px-6">Vendor</th>
                                    <th class="py-4 px-6">Lokasi</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                    <th class="py-4 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-kosmos-border/50">
                                @forelse($cafes as $cafe)
                                <tr class="hover:bg-kosmos-bg/30 transition-colors">
                                    <td class="py-4 px-6 font-bold text-kosmos-brown">{{ $cafe->nama }}</td>
                                    <td class="py-4 px-6 font-medium text-kosmos-brown">{{ $cafe->vendor->name ?? '-' }}</td>
                                    <td class="py-4 px-6 text-xs text-kosmos-muted truncate max-w-[200px]">{{ $cafe->alamat ?? '-' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if($cafe->status == 'approved')
                                            <span class="inline-flex px-3 py-1 rounded-full bg-kosmos-sage/15 text-kosmos-sage text-xs font-bold">Approved</span>
                                        @elseif($cafe->status == 'rejected')
                                            <span class="inline-flex px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-bold" title="{{ $cafe->alasan_ditolak }}">Rejected</span>
                                        @else
                                            <span class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-bold">Pending</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                                        <a href="{{ route('admin.cafe.detail', $cafe->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded bg-kosmos-bg text-kosmos-primary hover:bg-kosmos-primary hover:text-white transition-colors border border-kosmos-border" title="Detail & Chart"><i class="fas fa-chart-line text-xs"></i></a>
                                        <button onclick='showCafeInfo(@json($cafe), @json($cafe->vendor))' class="inline-flex items-center justify-center w-8 h-8 rounded bg-kosmos-bg text-kosmos-brown hover:bg-kosmos-panel hover:text-white transition-colors border border-kosmos-border" title="Info Cafe"><i class="fas fa-eye text-xs"></i></button>
                                        @if($cafe->status != 'approved')
                                        <form action="{{ route('admin.cafe.approve', $cafe->id) }}" method="POST" class="inline-block">
                                            @csrf @method('PUT')
                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded bg-kosmos-sage/10 text-kosmos-sage hover:bg-kosmos-sage hover:text-white transition-colors border border-kosmos-sage/20" title="Setujui"><i class="fas fa-check text-xs"></i></button>
                                        </form>
                                        @endif
                                        @if($cafe->status != 'rejected')
                                        <button onclick="showRejectModal('{{ $cafe->id }}', '{{ addslashes($cafe->nama) }}')" class="inline-flex items-center justify-center w-8 h-8 rounded bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-colors border border-red-100" title="Tolak"><i class="fas fa-times text-xs"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-kosmos-muted py-8 font-medium">Belum ada pendaftaran cafe.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===== MENUS SECTION ===== -->
            <div id="menus-section" class="section-content">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-serif font-bold text-kosmos-brown">Kelola Menu <span class="text-sm font-sans font-normal text-kosmos-muted ml-2">(Read-Only)</span></h2>
                        <p class="text-sm text-kosmos-muted mt-1">Pantau seluruh menu yang ada di platform.</p>
                    </div>
                </div>
                
                <div class="card-kosmos mb-6 p-4 bg-white/50">
                    <form method="GET" action="{{ route('admin.admin-dashboard') }}" class="flex flex-wrap items-center gap-3">
                        <input type="hidden" name="tab" value="menus">
                        <div class="relative min-w-[250px]">
                            <select name="cafe_id" class="w-full px-4 py-2.5 bg-white border border-kosmos-border rounded-xl text-sm outline-none focus:border-kosmos-primary focus:ring-1 focus:ring-kosmos-primary text-kosmos-brown appearance-none">
                                <option value="">Semua Cafe</option>
                                @foreach($cafes as $c)
                                    <option value="{{ $c->id }}" {{ request('cafe_id') == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-kosmos-muted pointer-events-none"></i>
                        </div>
                        <button type="submit" class="bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold py-2.5 px-5 rounded-xl transition shadow-sm text-sm"><i class="fas fa-filter mr-1"></i> Filter</button>
                        @if(request('cafe_id'))
                            <a href="{{ route('admin.admin-dashboard', ['tab' => 'menus']) }}" class="text-sm font-semibold text-kosmos-muted hover:text-kosmos-brown px-3">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="card-kosmos overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-kosmos-bg/50 border-b border-kosmos-border">
                                <tr class="text-xs font-bold text-kosmos-muted uppercase tracking-wider">
                                    <th class="py-4 px-6">Menu</th>
                                    <th class="py-4 px-6">Cafe</th>
                                    <th class="py-4 px-6">Kategori</th>
                                    <th class="py-4 px-6">Harga</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-kosmos-border/50">
                                @forelse($menus as $menu)
                                <tr class="hover:bg-kosmos-bg/30 transition-colors">
                                    <td class="py-4 px-6 flex items-center gap-3">
                                        @if($menu->gambar)
                                            <img src="{{ $menu->gambar }}" class="w-10 h-10 rounded-lg object-cover border border-kosmos-border" alt="Menu">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-kosmos-bg border border-kosmos-border flex items-center justify-center text-kosmos-muted"><i class="fas fa-image text-xs"></i></div>
                                        @endif
                                        <span class="font-bold text-kosmos-brown">{{ $menu->nama_menu }}</span>
                                    </td>
                                    <td class="py-4 px-6 font-medium text-kosmos-brown">{{ $menu->nama_cafe }}</td>
                                    <td class="py-4 px-6">
                                        @if($menu->kategori)
                                            <span class="bg-kosmos-bg border border-kosmos-border text-kosmos-muted px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">{{ $menu->kategori }}</span>
                                        @else
                                            <span class="text-kosmos-muted text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 font-bold text-kosmos-primary">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $menu->status == 'tersedia' ? 'bg-kosmos-sage/15 text-kosmos-sage' : 'bg-red-50 text-red-600' }}">
                                            {{ $menu->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-kosmos-muted py-8 font-medium">Belum ada menu.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 bg-kosmos-bg/30 border-t border-kosmos-border">
                        {{ $menus->appends(request()->except('menu_page'))->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>

            <!-- ===== BOOKINGS SECTION ===== -->
            <div id="bookings-section" class="section-content">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-serif font-bold text-kosmos-brown">Kelola Booking Global</h2>
                </div>
                
                <div class="card-kosmos mb-6 p-4 bg-white/50">
                    <form method="GET" action="{{ route('admin.admin-dashboard') }}" class="flex flex-wrap items-end gap-3">
                        <input type="hidden" name="tab" value="bookings">
                        <div>
                            <label class="block text-xs font-bold text-kosmos-muted uppercase tracking-wider mb-1.5">Filter Cafe</label>
                            <div class="relative min-w-[250px]">
                                <select name="cafe_id" class="w-full px-4 py-2.5 bg-white border border-kosmos-border rounded-xl text-sm outline-none focus:border-kosmos-primary focus:ring-1 focus:ring-kosmos-primary text-kosmos-brown appearance-none">
                                    <option value="">-- Semua Cafe --</option>
                                    @foreach($cafes as $c)
                                        <option value="{{ $c->id }}" {{ request('cafe_id') == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-kosmos-muted pointer-events-none"></i>
                            </div>
                        </div>
                        <button type="submit" class="bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold py-2.5 px-5 rounded-xl transition shadow-sm text-sm"><i class="fas fa-filter mr-1"></i> Filter</button>
                        @if(request('cafe_id'))
                            <a href="{{ route('admin.admin-dashboard', ['tab' => 'bookings']) }}" class="text-sm font-semibold text-kosmos-muted hover:text-kosmos-brown px-3 mb-2.5">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="card-kosmos overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-kosmos-bg/50 border-b border-kosmos-border">
                                <tr class="text-xs font-bold text-kosmos-muted uppercase tracking-wider">
                                    <th class="py-4 px-6">Waktu</th>
                                    <th class="py-4 px-6">Customer</th>
                                    <th class="py-4 px-6">Cafe</th>
                                    <th class="py-4 px-6">Meja</th>
                                    <th class="py-4 px-6 text-center">Pax</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-kosmos-border/50">
                                @forelse($all_bookings as $b)
                                <tr class="hover:bg-kosmos-bg/30 transition-colors">
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-kosmos-brown">{{ \Carbon\Carbon::parse($b->tgl)->format('d M Y') }}</p>
                                        <p class="text-[10px] text-kosmos-muted mt-0.5">{{ \Carbon\Carbon::parse($b->tgl)->format('H:i') }}</p>
                                    </td>
                                    <td class="py-4 px-6 font-bold text-kosmos-brown">{{ $b->nama_pelanggan }}</td>
                                    <td class="py-4 px-6 text-kosmos-muted font-medium">{{ $b->nama_cafe }}</td>
                                    <td class="py-4 px-6 text-kosmos-muted">Meja <span class="font-bold text-kosmos-brown">{{ $b->no_table }}</span></td>
                                    <td class="py-4 px-6 text-center font-bold text-kosmos-primary">{{ $b->num_person }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if($b->status == 'pending')
                                            <span class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-[10px] font-bold uppercase tracking-wider">Pending</span>
                                        @elseif($b->status == 'confirmed')
                                            <span class="inline-flex px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider">Confirmed</span>
                                        @elseif($b->status == 'completed')
                                            <span class="inline-flex px-3 py-1 rounded-full bg-kosmos-sage/15 text-kosmos-sage text-[10px] font-bold uppercase tracking-wider">Completed</span>
                                        @else
                                            <span class="inline-flex px-3 py-1 rounded-full bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wider">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-kosmos-muted py-8 font-medium">Belum ada booking.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($all_bookings->hasPages())
                    <div class="p-4 bg-kosmos-bg/30 border-t border-kosmos-border">
                        {{ $all_bookings->links('pagination::tailwind') }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- ===== TRANSACTIONS SECTION ===== -->
            <div id="transactions-section" class="section-content">
                <h2 class="text-2xl font-serif font-bold text-kosmos-brown mb-6">Daftar Transaksi</h2>
                
                <div class="card-kosmos mb-6 p-4">
                    <form method="GET" action="{{ route('admin.admin-dashboard') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                        <input type="hidden" name="tab" value="transactions">
                        <div>
                            <label class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Cari Kode</label>
                            <input type="text" name="q" class="w-full px-3 py-2 bg-kosmos-bg/30 border border-kosmos-border rounded-lg text-sm outline-none focus:border-kosmos-primary text-kosmos-brown" placeholder="INV-..." value="{{ request('q') }}">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Mulai Tanggal</label>
                            <input type="date" name="start_date" class="w-full px-3 py-2 bg-kosmos-bg/30 border border-kosmos-border rounded-lg text-sm outline-none focus:border-kosmos-primary text-kosmos-brown" value="{{ request('start_date') }}">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="w-full px-3 py-2 bg-kosmos-bg/30 border border-kosmos-border rounded-lg text-sm outline-none focus:border-kosmos-primary text-kosmos-brown" value="{{ request('end_date') }}">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Status</label>
                            <select name="status" class="w-full px-3 py-2 bg-kosmos-bg/30 border border-kosmos-border rounded-lg text-sm outline-none focus:border-kosmos-primary text-kosmos-brown appearance-none">
                                <option value="">Semua Status</option>
                                @foreach(['Masuk','Dibayar','Diproses','Siap Diambil','Selesai','Batal','Komplain'] as $s)
                                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold py-2 px-4 rounded-lg transition shadow-sm text-sm flex-1"><i class="fas fa-search"></i> Cari</button>
                            @if(request()->hasAny(['q','start_date','end_date','status']))
                                <a href="{{ route('admin.admin-dashboard', ['tab' => 'transactions']) }}" class="flex items-center justify-center bg-kosmos-bg border border-kosmos-border hover:bg-white text-kosmos-muted py-2 px-4 rounded-lg text-sm transition">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="card-kosmos overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-kosmos-bg/50 border-b border-kosmos-border">
                                <tr class="text-xs font-bold text-kosmos-muted uppercase tracking-wider">
                                    <th class="py-4 px-6">Kode</th>
                                    <th class="py-4 px-6">Waktu</th>
                                    <th class="py-4 px-6">Cafe / Cust</th>
                                    <th class="py-4 px-6 text-center">Metode</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                    <th class="py-4 px-6 text-right">Total</th>
                                    <th class="py-4 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-kosmos-border/50">
                                @forelse($transactions as $trx)
                                <tr class="hover:bg-kosmos-bg/30 transition-colors">
                                    <td class="py-4 px-6 font-bold text-kosmos-primary font-mono text-xs">{{ $trx->order_code }}</td>
                                    <td class="py-4 px-6 text-xs text-kosmos-muted">{{ \Carbon\Carbon::parse($trx->tgl)->format('d M y, H:i') }}</td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-kosmos-brown truncate max-w-[150px]">{{ $trx->nama_cafe }}</p>
                                        <p class="text-[10px] text-kosmos-muted truncate max-w-[150px]">{{ $trx->nama_pelanggan }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-center text-xs font-bold uppercase text-kosmos-muted">{{ $trx->channel_pembayaran }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @php
                                            $sc = match($trx->status) {
                                                'Masuk' => 'bg-blue-50 text-blue-700', 'Dibayar' => 'bg-kosmos-sage/15 text-kosmos-sage',
                                                'Diproses' => 'bg-kosmos-primary/15 text-kosmos-primary', 'Siap Diambil' => 'bg-kosmos-dark/15 text-kosmos-dark',
                                                'Selesai' => 'bg-kosmos-bg text-kosmos-muted border border-kosmos-border', default => 'bg-red-50 text-red-700',
                                            };
                                        @endphp
                                        <span class="inline-flex px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $sc }}">{{ $trx->status }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold text-kosmos-brown whitespace-nowrap">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <button type="button" class="inline-flex items-center justify-center w-8 h-8 rounded bg-kosmos-bg text-kosmos-primary hover:bg-kosmos-primary hover:text-white transition-colors border border-kosmos-border" onclick='showTrxDetail(@json($trx))' title="Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center text-kosmos-muted py-8 font-medium">Belum ada transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 bg-kosmos-bg/30 border-t border-kosmos-border flex justify-center">
                        {{ $transactions->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>

            <!-- ===== USERS SECTION ===== -->
            <div id="users-section" class="section-content">
                <h2 class="text-2xl font-serif font-bold text-kosmos-brown mb-6">Kelola User (Customer)</h2>
                <div class="card-kosmos overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-kosmos-bg/50 border-b border-kosmos-border">
                                <tr class="text-xs font-bold text-kosmos-muted uppercase tracking-wider">
                                    <th class="py-4 px-6">Nama Customer</th>
                                    <th class="py-4 px-6">Email</th>
                                    <th class="py-4 px-6">Bergabung Pada</th>
                                    <th class="py-4 px-6 text-center">Pesanan</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                    <th class="py-4 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-kosmos-border/50">
                                @forelse($users as $user)
                                <tr class="hover:bg-kosmos-bg/30 transition-colors">
                                    <td class="py-4 px-6 font-bold text-kosmos-brown">{{ $user->name }}</td>
                                    <td class="py-4 px-6 text-kosmos-muted">{{ $user->email }}</td>
                                    <td class="py-4 px-6 text-xs text-kosmos-muted">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                                    <td class="py-4 px-6 text-center font-bold text-kosmos-primary">{{ $user->total_pesanan }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $user->status == 'active' ? 'bg-kosmos-sage/15 text-kosmos-sage' : 'bg-red-50 text-red-700' }}">
                                            {{ $user->status == 'active' ? 'Active' : 'Suspended' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <form action="{{ route('admin.user.toggle-status', $user->id) }}" method="POST" class="inline-block">
                                            @csrf @method('PUT')
                                            @if($user->status == 'active')
                                                <button type="submit" class="bg-red-50 hover:bg-red-500 text-red-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border border-red-100" onclick="return confirm('Suspend user ini?')"><i class="fas fa-ban mr-1"></i> Suspend</button>
                                            @else
                                                <button type="submit" class="bg-kosmos-sage/10 hover:bg-kosmos-sage text-kosmos-sage hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border border-kosmos-sage/20"><i class="fas fa-check mr-1"></i> Aktifkan</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-kosmos-muted py-8 font-medium">Belum ada customer.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===== REPORTS SECTION ===== -->
            <div id="reports-section" class="section-content">
                <h2 class="text-2xl font-serif font-bold text-kosmos-brown mb-6">Laporan & Komplain</h2>
                <div class="card-kosmos overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-kosmos-bg/50 border-b border-kosmos-border">
                                <tr class="text-xs font-bold text-kosmos-muted uppercase tracking-wider">
                                    <th class="py-4 px-6">Tanggal</th>
                                    <th class="py-4 px-6">Pelapor</th>
                                    <th class="py-4 px-6">Terlapor (Vendor)</th>
                                    <th class="py-4 px-6">Tipe & Kategori</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                    <th class="py-4 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-kosmos-border/50">
                                @forelse($reports as $report)
                                <tr class="hover:bg-kosmos-bg/30 transition-colors">
                                    <td class="py-4 px-6 text-xs text-kosmos-muted">{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</td>
                                    <td class="py-4 px-6 font-bold text-kosmos-brown">{{ $report->pelapor ? $report->pelapor->name : '-' }}</td>
                                    <td class="py-4 px-6 text-kosmos-primary font-bold">{{ $report->terlapor ? $report->terlapor->name : '-' }}</td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-kosmos-brown text-xs uppercase">{{ $report->tipe }}</p>
                                        <p class="text-[10px] text-kosmos-muted mt-0.5">{{ $report->kategori_laporan }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($report->status == 'pending')
                                            <span class="inline-flex px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($report->status == 'investigating')
                                            <span class="inline-flex px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700">Investigating</span>
                                        @elseif($report->status == 'resolved')
                                            <span class="inline-flex px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-kosmos-sage/15 text-kosmos-sage">Resolved</span>
                                        @else
                                            <span class="inline-flex px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-red-50 text-red-700">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <button class="bg-kosmos-bg border border-kosmos-border hover:bg-kosmos-panel text-kosmos-brown hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors" onclick="showReportDetail({{ htmlspecialchars(json_encode($report)) }})">
                                            <i class="fas fa-search mr-1"></i> Review
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-kosmos-muted py-8 font-medium">Belum ada laporan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 bg-kosmos-bg/30 border-t border-kosmos-border flex justify-center">
                        {{ $reports->appends(request()->except('report_page'))->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>

            <!-- ===== GALLERY SECTION ===== -->
            <div id="gallery-section" class="section-content">
                <h2 class="text-2xl font-serif font-bold text-kosmos-brown mb-6">Galeri Cafe</h2>

                <div class="card-kosmos mb-6 p-4 bg-white/50">
                    <form method="GET" action="{{ route('admin.admin-dashboard') }}" class="flex flex-wrap items-end gap-3">
                        <input type="hidden" name="tab" value="gallery">
                        <div>
                            <label class="block text-xs font-bold text-kosmos-muted uppercase tracking-wider mb-1.5">Filter Cafe</label>
                            <div class="relative min-w-[250px]">
                                <select name="gallery_cafe_id" class="w-full px-4 py-2.5 bg-white border border-kosmos-border rounded-xl text-sm outline-none focus:border-kosmos-primary focus:ring-1 focus:ring-kosmos-primary text-kosmos-brown appearance-none">
                                    <option value="">-- Semua Cafe --</option>
                                    @foreach($cafes as $c)
                                        <option value="{{ $c->id }}" {{ request('gallery_cafe_id') == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-kosmos-muted pointer-events-none"></i>
                            </div>
                        </div>
                        <button type="submit" class="bg-kosmos-primary hover:bg-kosmos-dark text-white font-semibold py-2.5 px-5 rounded-xl transition shadow-sm text-sm"><i class="fas fa-filter mr-1"></i> Filter</button>
                        @if(request('gallery_cafe_id'))
                            <a href="{{ route('admin.admin-dashboard', ['tab' => 'gallery']) }}" class="text-sm font-semibold text-kosmos-muted hover:text-kosmos-brown px-3 mb-2.5">Reset</a>
                        @endif
                    </form>
                </div>

                @if($galleries->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($galleries as $g)
                    <div class="relative aspect-square rounded-2xl overflow-hidden group border border-kosmos-border shadow-sm">
                        <img src="{{ $g->gambar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Galeri">
                        <div class="absolute inset-0 bg-kosmos-panel/70 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                            <span class="text-white text-xs font-bold truncate">{{ $g->cafe->nama ?? 'Unknown' }}</span>
                            @if($g->nama_ruangan)
                                <span class="text-white/70 text-[10px] mt-0.5 truncate">{{ $g->nama_ruangan }}</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 flex justify-center">
                    {{ $galleries->appends(request()->except('gallery_page'))->links('pagination::tailwind') }}
                </div>
                @else
                <div class="card-kosmos p-12 text-center border-dashed">
                    <i class="fas fa-images text-5xl text-kosmos-border mb-4 block"></i>
                    <p class="text-lg font-serif font-bold text-kosmos-brown">Galeri Kosong</p>
                    <p class="text-sm text-kosmos-muted mt-1">Belum ada foto yang diunggah oleh vendor.</p>
                </div>
                @endif
            </div>

            <footer class="mt-12 text-center text-xs text-kosmos-muted/60 pb-4">
                &copy; {{ date('Y') }} KedaiSeduh - Admin Panel.
            </footer>
        </div>
    </main>

    <!-- Modals -->

    <!-- Reject Cafe Modal -->
    <div id="rejectCafeModal" class="fixed inset-0 z-[100] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
            <div class="px-6 py-5 bg-kosmos-bg border-b border-kosmos-border flex items-center justify-between">
                <h3 class="font-serif font-bold text-kosmos-brown text-lg">Tolak Pendaftaran Cafe</h3>
                <button onclick="closeModal('rejectCafeModal')" class="text-kosmos-muted hover:text-kosmos-brown"><i class="fas fa-times"></i></button>
            </div>
            <form id="formRejectCafe" method="POST" class="p-6">
                @csrf @method('PUT')
                <div class="mb-5">
                    <p class="text-sm text-kosmos-muted mb-3">Anda akan menolak pendaftaran untuk: <strong class="text-kosmos-brown" id="rejectCafeName"></strong></p>
                    <label class="block text-xs font-bold text-kosmos-muted uppercase tracking-wider mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="alasan_ditolak" class="w-full px-4 py-3 bg-kosmos-bg/30 border border-kosmos-border rounded-xl text-sm outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-kosmos-brown resize-none" rows="3" required placeholder="Contoh: Dokumen tidak valid..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('rejectCafeModal')" class="flex-1 bg-white border border-kosmos-border text-kosmos-muted font-bold py-2.5 rounded-full hover:bg-kosmos-bg transition">Batal</button>
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-full transition shadow-sm">Tolak Cafe</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Cafe Modal -->
    <div id="infoCafeModal" class="fixed inset-0 z-[100] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border flex flex-col max-h-[90vh]">
            <div class="px-6 py-5 bg-kosmos-bg border-b border-kosmos-border flex items-center justify-between sticky top-0 z-10">
                <h3 class="font-serif font-bold text-kosmos-brown text-lg">Detail Informasi Cafe</h3>
                <button onclick="closeModal('infoCafeModal')" class="text-kosmos-muted hover:text-kosmos-brown"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto">
                <div class="text-center mb-6">
                    <img id="infoCafeFoto" src="" alt="Cafe" class="w-24 h-24 rounded-2xl object-cover mx-auto mb-3 shadow-md border border-kosmos-border">
                    <h4 id="infoCafaNama" class="text-xl font-serif font-bold text-kosmos-brown"></h4>
                    <p class="text-xs text-kosmos-muted mt-1 uppercase tracking-widest font-bold">Vendor: <span id="infoCafeVendor" class="text-kosmos-primary"></span></p>
                </div>
                <div class="space-y-4">
                    <div class="bg-kosmos-bg/30 p-4 rounded-xl border border-kosmos-border/50">
                        <small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Telepon</small>
                        <p id="infoCafeTelp" class="text-sm font-medium text-kosmos-brown"></p>
                    </div>
                    <div class="bg-kosmos-bg/30 p-4 rounded-xl border border-kosmos-border/50">
                        <small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Alamat</small>
                        <p id="infoCafeAlamat" class="text-sm font-medium text-kosmos-brown"></p>
                    </div>
                    <div class="bg-kosmos-bg/30 p-4 rounded-xl border border-kosmos-border/50">
                        <small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Jam Operasional</small>
                        <p id="infoCafeJam" class="text-sm font-medium text-kosmos-brown whitespace-pre-wrap"></p>
                    </div>
                    <div class="bg-kosmos-bg/30 p-4 rounded-xl border border-kosmos-border/50">
                        <small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Fasilitas</small>
                        <p id="infoCafeFasilitas" class="text-sm font-medium text-kosmos-brown"></p>
                    </div>
                    <div class="bg-kosmos-bg/30 p-4 rounded-xl border border-kosmos-border/50">
                        <small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Deskripsi</small>
                        <p id="infoCafeDeskripsi" class="text-sm text-kosmos-muted"></p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-kosmos-bg/50 border-t border-kosmos-border sticky bottom-0">
                <a href="#" id="infoCafeDetailLink" class="w-full flex items-center justify-center gap-2 bg-kosmos-primary hover:bg-kosmos-dark text-white font-bold py-3 rounded-full transition shadow-sm">
                    <i class="fas fa-chart-line"></i> Lihat Analitik & Detail Lengkap
                </a>
            </div>
        </div>
    </div>

    <!-- Transaction Detail Modal -->
    <div id="trxDetailModal" class="fixed inset-0 z-[100] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
            <div class="px-6 py-5 bg-kosmos-bg border-b border-kosmos-border flex items-center justify-between">
                <h3 class="font-serif font-bold text-kosmos-brown text-lg">Detail Transaksi</h3>
                <button onclick="closeModal('trxDetailModal')" class="text-kosmos-muted hover:text-kosmos-brown"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6" id="trxDetailBody">
                <!-- Injected via JS -->
            </div>
            <div class="px-6 pb-6 pt-2">
                <button onclick="closeModal('trxDetailModal')" class="w-full bg-kosmos-bg border border-kosmos-border text-kosmos-muted font-bold py-2.5 rounded-full hover:bg-white transition">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Report Detail Modal -->
    <div id="reportDetailModal" class="fixed inset-0 z-[100] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-kosmos-border">
            <div class="px-6 py-5 bg-kosmos-bg border-b border-kosmos-border flex items-center justify-between">
                <h3 class="font-serif font-bold text-kosmos-brown text-lg">Tindak Lanjut Laporan</h3>
                <button onclick="closeModal('reportDetailModal')" class="text-kosmos-muted hover:text-kosmos-brown"><i class="fas fa-times"></i></button>
            </div>
            <form id="formReportStatus" method="POST">
                @csrf @method('PUT')
                <div class="p-6 space-y-4">
                    <div class="bg-kosmos-bg/30 p-4 rounded-xl border border-kosmos-border/50">
                        <label class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Tipe</label>
                        <div class="font-bold text-kosmos-brown" id="detailReportTipe"></div>
                    </div>
                    <div class="bg-kosmos-bg/30 p-4 rounded-xl border border-kosmos-border/50">
                        <label class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Kategori</label>
                        <div class="font-bold text-kosmos-brown" id="detailReportKategori"></div>
                    </div>
                    <div class="bg-kosmos-bg/30 p-4 rounded-xl border border-kosmos-border/50">
                        <label class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Deskripsi</label>
                        <p id="detailReportDeskripsi" class="text-sm text-kosmos-muted whitespace-pre-wrap"></p>
                    </div>
                    <hr class="border-kosmos-border/50">
                    <div>
                        <label class="block text-xs font-bold text-kosmos-muted uppercase tracking-wider mb-2">Ubah Status Laporan</label>
                        <select name="status" id="reportStatusSelect" class="w-full px-4 py-3 bg-white border border-kosmos-border rounded-xl text-sm outline-none focus:border-kosmos-primary focus:ring-2 focus:ring-kosmos-primary/20 text-kosmos-brown" required>
                            <option value="pending">Pending</option>
                            <option value="investigating">Investigating</option>
                            <option value="resolved">Resolved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="px-6 py-4 bg-kosmos-bg/30 border-t border-kosmos-border flex gap-3">
                    <button type="button" onclick="closeModal('reportDetailModal')" class="flex-1 bg-white border border-kosmos-border text-kosmos-muted font-bold py-2.5 rounded-full hover:bg-kosmos-bg transition">Batal</button>
                    <button type="submit" class="flex-1 bg-kosmos-primary hover:bg-kosmos-dark text-white font-bold py-2.5 rounded-full transition shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal helpers
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        // Section Navigation
        const sections = document.querySelectorAll('.section-content');
        const navLinks = document.querySelectorAll('.sidebar-link[data-section]');
        const titleEl = document.getElementById('current-section-title');

        const sectionTitles = {
            'dashboard': 'Dashboard Overview',
            'cafes': 'Kelola Cafe',
            'menus': 'Kelola Menu',
            'bookings': 'Kelola Booking',
            'transactions': 'Daftar Transaksi',
            'users': 'Kelola User',
            'reports': 'Laporan & Komplain',
            'gallery': 'Galeri Cafe',
        };

        function showSection(sectionName) {
            sections.forEach(s => s.classList.remove('active'));
            navLinks.forEach(l => l.classList.remove('active'));

            const sec = document.getElementById(sectionName + '-section');
            const link = document.querySelector(`.sidebar-link[data-section="${sectionName}"]`);
            if (sec) sec.classList.add('active');
            if (link) link.classList.add('active');
            if (titleEl) titleEl.textContent = sectionTitles[sectionName] || sectionName;

            // Update URL without reload
            const url = new URL(window.location);
            url.searchParams.set('tab', sectionName);
            window.history.pushState({}, '', url);
        }

        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const section = this.getAttribute('data-section');
                if (section) showSection(section);
            });
        });

        // Activate tab from URL on load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');
            if (activeTab && document.getElementById(activeTab + '-section')) {
                showSection(activeTab);
            }
        });

        // Reject Cafe Modal
        function showRejectModal(id, nama) {
            document.getElementById('rejectCafeName').innerText = nama;
            document.getElementById('formRejectCafe').action = '/admin/cafe/' + id + '/reject';
            openModal('rejectCafeModal');
        }

        // Info Cafe Modal
        function showCafeInfo(cafe, vendor) {
            document.getElementById('infoCafaNama').innerText = cafe.nama || '-';
            document.getElementById('infoCafeVendor').innerText = (vendor && vendor.name) ? vendor.name : '-';
            document.getElementById('infoCafeTelp').innerText = cafe.no_telp || '-';
            document.getElementById('infoCafeAlamat').innerText = cafe.alamat || '-';
            document.getElementById('infoCafeJam').innerText = cafe.jam_operasional || '-';
            document.getElementById('infoCafeFasilitas').innerText = cafe.fasilitas || '-';
            document.getElementById('infoCafeDeskripsi').innerText = cafe.deskripsi || '-';
            document.getElementById('infoCafeDetailLink').href = '/admin/cafe/' + cafe.id;

            let photo = cafe.foto_profil ? cafe.foto_profil : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(cafe.nama) + '&size=200&background=F7EAD9&color=E8935A';
            document.getElementById('infoCafeFoto').src = photo;

            openModal('infoCafeModal');
        }

        // Transaction Detail Modal
        function showTrxDetail(trx) {
            const body = document.getElementById('trxDetailBody');
            body.innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-kosmos-bg/30 p-3 rounded-xl border border-kosmos-border/50"><small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Kode Order</small><p class="font-bold text-kosmos-primary font-mono text-sm">${trx.order_code || '-'}</p></div>
                    <div class="bg-kosmos-bg/30 p-3 rounded-xl border border-kosmos-border/50"><small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Tanggal</small><p class="text-sm font-medium text-kosmos-brown">${trx.tgl ? trx.tgl.replace('T',' ').substring(0,16) : '-'}</p></div>
                    <div class="bg-kosmos-bg/30 p-3 rounded-xl border border-kosmos-border/50"><small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Cafe</small><p class="text-sm font-bold text-kosmos-brown">${trx.nama_cafe || '-'}</p></div>
                    <div class="bg-kosmos-bg/30 p-3 rounded-xl border border-kosmos-border/50"><small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Customer</small><p class="text-sm font-medium text-kosmos-brown">${trx.nama_pelanggan || '-'}</p></div>
                    <div class="bg-kosmos-bg/30 p-3 rounded-xl border border-kosmos-border/50"><small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Metode</small><p class="text-sm font-bold uppercase text-kosmos-muted">${trx.channel_pembayaran || '-'}</p></div>
                    <div class="bg-kosmos-bg/30 p-3 rounded-xl border border-kosmos-border/50"><small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Status</small><p><span class="inline-flex px-2 py-1 rounded bg-kosmos-sage/15 text-kosmos-sage text-[10px] font-bold uppercase tracking-wider">${trx.status || '-'}</span></p></div>
                    <div class="col-span-2 bg-kosmos-bg/50 p-4 rounded-xl border border-kosmos-border text-center mt-2"><small class="block text-[10px] font-bold text-kosmos-muted uppercase tracking-wider mb-1">Total Pembayaran</small><h4 class="text-2xl text-kosmos-primary font-bold">Rp ${parseInt(trx.total_harga || 0).toLocaleString('id-ID')}</h4></div>
                </div>`;
            openModal('trxDetailModal');
        }

        // Report Detail Modal
        function showReportDetail(report) {
            document.getElementById('detailReportTipe').innerText = report.tipe || '-';
            document.getElementById('detailReportKategori').innerText = report.kategori_laporan || '-';
            document.getElementById('detailReportDeskripsi').innerText = report.deskripsi || '-';
            document.getElementById('reportStatusSelect').value = report.status;
            document.getElementById('formReportStatus').action = '/admin/report/' + report.id + '/update-status';
            openModal('reportDetailModal');
        }

        // Mobile Sidebar Toggle
        function openSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden', 'opacity-0');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
        }
        function closeSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            setTimeout(() => { overlay.classList.add('hidden'); overlay.classList.add('opacity-0'); }, 300);
        }

        // Auto-close sidebar on mobile when nav link is clicked
        document.querySelectorAll('.sidebar-link[data-section]').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) closeSidebar();
            });
        });
    </script>
</body>
</html>