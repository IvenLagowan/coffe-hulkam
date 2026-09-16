<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Cafe: {{ $cafe->nama }} — Admin Panel</title>
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
        .card-kosmos {
            background: #1B140E;
            border-radius: 20px;
            box-shadow: 0 12px 34px rgba(0,0,0,0.4);
            border: 1px solid rgba(224,178,122,0.14);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-kosmos-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 44px rgba(0,0,0,0.5);
        }
        .bg-white{background-color:#1B140E !important;}
        .bg-gray-50,.bg-gray-100,.bg-slate-50,.bg-slate-100{background-color:#17110B !important;}
        .bg-gray-200,.bg-slate-200{background-color:#241C15 !important;}
        .text-gray-900,.text-gray-800,.text-gray-700,.text-slate-900,.text-slate-800,.text-slate-700,.text-black{color:#E9DECF !important;}
        .text-gray-600,.text-gray-500,.text-gray-400,.text-slate-600,.text-slate-500,.text-slate-400{color:#A08E7B !important;}
        .border-gray-100,.border-gray-200,.border-gray-300,.border-slate-100,.border-slate-200{border-color:rgba(224,178,122,0.14) !important;}
        table thead{background-color:#17110B !important;}
        input,select,textarea{background-color:#17110B;color:#E9DECF;border-color:rgba(224,178,122,0.18);}
        ::selection{background:#E0A263;color:#1B140E;}
    </style>
</head>
<body class="bg-kosmos-bg text-kosmos-text min-h-screen flex flex-col">
    <!-- Topbar -->
    <nav class="bg-kosmos-panel/90 backdrop-blur-md shadow-sm border-b border-kosmos-border px-4 sm:px-8 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('admin.admin-dashboard') }}?tab=cafes" class="w-10 h-10 rounded-full bg-kosmos-bg text-kosmos-brown hover:bg-kosmos-brown hover:text-white flex items-center justify-center transition-colors border border-kosmos-border shadow-sm flex-shrink-0">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="min-w-0">
                <h5 class="font-serif font-bold text-base sm:text-xl text-kosmos-brown mb-0.5 truncate">{{ $cafe->nama }}</h5>
                <p class="text-xs text-kosmos-muted flex items-center gap-1.5 truncate"><i class="fas fa-map-marker-alt text-kosmos-primary flex-shrink-0"></i> <span class="truncate">{{ $cafe->alamat ?? 'Lokasi tidak diketahui' }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
            @if($cafe->vendor)
            <span class="text-sm font-semibold text-kosmos-brown hidden sm:flex items-center gap-2 px-4 py-2 bg-kosmos-bg/50 rounded-full border border-kosmos-border">
                <i class="fas fa-user text-kosmos-primary"></i> {{ $cafe->vendor->name }}
            </span>
            @endif
            @php
                $statusColor = match($cafe->status) {
                    'approved' => 'bg-kosmos-sage/15 text-kosmos-sage border-kosmos-sage/20',
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    default => 'bg-red-50 text-red-700 border-red-200'
                };
            @endphp
            <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusColor }}">
                {{ $cafe->status }}
            </span>
        </div>
    </nav>

    <div class="p-8 flex-1 w-full max-w-7xl mx-auto space-y-8">

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card-kosmos card-kosmos-hover p-6 flex justify-between items-center border-l-4 border-l-kosmos-primary">
                <div>
                    <p class="text-[10px] font-bold tracking-wider text-kosmos-muted uppercase mb-1">Total Transaksi</p>
                    <h2 class="text-4xl font-serif font-bold text-kosmos-brown">{{ $total_transaksi }}</h2>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-kosmos-primary/10 flex items-center justify-center text-kosmos-primary shadow-inner">
                    <i class="fas fa-receipt text-3xl"></i>
                </div>
            </div>
            <div class="card-kosmos card-kosmos-hover p-6 flex justify-between items-center border-l-4 border-l-kosmos-sage">
                <div>
                    <p class="text-[10px] font-bold tracking-wider text-kosmos-muted uppercase mb-1">Total Revenue</p>
                    <h2 class="text-2xl lg:text-3xl font-bold text-kosmos-sage">Rp {{ number_format($total_revenue, 0, ',', '.') }}</h2>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-kosmos-sage/10 flex items-center justify-center text-kosmos-sage shadow-inner">
                    <i class="fas fa-money-bill-wave text-3xl"></i>
                </div>
            </div>
            <div class="card-kosmos card-kosmos-hover p-6 flex justify-between items-center border-l-4 border-l-yellow-400">
                <div>
                    <p class="text-[10px] font-bold tracking-wider text-kosmos-muted uppercase mb-1">Booking Aktif</p>
                    <h2 class="text-4xl font-serif font-bold text-kosmos-brown">{{ $booking_aktif }}</h2>
                    <p class="text-[10px] text-kosmos-muted mt-1">Pending + Confirmed</p>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-yellow-400/10 flex items-center justify-center text-yellow-500 shadow-inner">
                    <i class="fas fa-calendar-check text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Chart + Bookings -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="card-kosmos h-full flex flex-col">
                    <div class="px-6 py-5 border-b border-kosmos-border flex justify-between items-center bg-kosmos-bg/30">
                        <h5 class="font-bold text-kosmos-brown flex items-center gap-2"><i class="fas fa-chart-line text-kosmos-primary"></i> Tren Revenue — 30 Hari Terakhir</h5>
                    </div>
                    <div class="p-6 flex-1">
                        @if(count($chart_labels) > 0)
                        <div class="h-[300px] w-full">
                            <canvas id="revenueChart"></canvas>
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center h-full py-12 text-kosmos-muted">
                            <div class="w-20 h-20 bg-kosmos-bg rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-chart-line text-3xl text-kosmos-border"></i>
                            </div>
                            <p class="font-medium text-sm">Belum ada data transaksi untuk 30 hari terakhir.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <div class="card-kosmos h-full flex flex-col">
                    <div class="px-6 py-5 border-b border-kosmos-border flex justify-between items-center bg-kosmos-bg/30">
                        <h5 class="font-bold text-kosmos-brown flex items-center gap-2"><i class="fas fa-calendar-alt text-kosmos-primary"></i> Booking Terbaru</h5>
                    </div>
                    <div class="flex-1 overflow-y-auto p-0">
                        <ul class="divide-y divide-kosmos-border/50">
                            @forelse($bookings as $b)
                            <li class="p-5 hover:bg-kosmos-bg/30 transition-colors">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-sm text-kosmos-brown truncate">{{ $b->nama_pelanggan }}</p>
                                        <p class="text-xs text-kosmos-muted mt-1">Meja {{ $b->no_table }} &mdash; {{ $b->num_person }} orang</p>
                                    </div>
                                    <div class="text-right whitespace-nowrap">
                                        <span class="block text-xs font-semibold text-kosmos-muted mb-1">{{ \Carbon\Carbon::parse($b->tgl)->format('d M') }}</span>
                                        @if($b->status == 'pending')
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($b->status == 'confirmed')
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700">Confirmed</span>
                                        @elseif($b->status == 'completed')
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-kosmos-sage/15 text-kosmos-sage">Selesai</span>
                                        @else
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-red-50 text-red-700">Batal</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="p-8 text-center text-kosmos-muted">
                                <i class="fas fa-calendar-times text-4xl text-kosmos-border mb-3 block"></i>
                                <span class="text-sm font-medium">Belum ada booking.</span>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Galeri Section -->
        <div class="card-kosmos overflow-hidden">
            <div class="px-6 py-5 border-b border-kosmos-border flex justify-between items-center bg-kosmos-bg/30">
                <div class="flex items-center gap-3">
                    <h5 class="font-bold text-kosmos-brown flex items-center gap-2"><i class="fas fa-images text-kosmos-sage"></i> Galeri Cafe</h5>
                    <span class="bg-kosmos-brown text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ count($galeri) }}</span>
                </div>
                <span class="text-xs text-kosmos-muted font-medium px-3 py-1 bg-white rounded-full border border-kosmos-border">Dikelola oleh vendor</span>
            </div>
            <div class="p-6">
                @if(count($galeri) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($galeri as $g)
                    <div class="relative aspect-square rounded-xl overflow-hidden group border border-kosmos-border shadow-sm">
                        <img src="{{ $g->gambar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="{{ $g->nama_ruangan ?? 'Galeri' }}" onerror="this.src='https://placehold.co/400x400/F7EAD9/3A2A1D?text=Error'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3">
                            <span class="text-white text-xs font-bold truncate">{{ $g->nama_ruangan ?? 'Foto Galeri' }}</span>
                            @if($g->lantai)
                                <span class="text-white/80 text-[10px] mt-0.5">Lantai {{ $g->lantai }}</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-kosmos-muted">
                    <div class="w-20 h-20 bg-kosmos-bg rounded-full flex items-center justify-center mx-auto mb-4 border border-kosmos-border">
                        <i class="fas fa-image text-3xl text-kosmos-border"></i>
                    </div>
                    <p class="font-serif font-bold text-lg text-kosmos-brown mb-1">Galeri Kosong</p>
                    <p class="text-sm">Cafe ini belum memiliki foto galeri. Vendor perlu menambahkan melalui panel mereka.</p>
                </div>
                @endif
            </div>
        </div>

    </div><!-- end container -->

    <script>
        @if(count($chart_labels) > 0)
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            
            // Create gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(124, 138, 92, 0.4)'); // kosmos-sage
            gradient.addColorStop(1, 'rgba(124, 138, 92, 0.0)');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chart_labels) !!},
                    datasets: [{
                        label: 'Revenue',
                        data: {!! json_encode($chart_data) !!},
                        borderColor: '#7C8A5C', // kosmos-sage
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4, // smooth curves
                        pointRadius: 4,
                        pointBackgroundColor: '#7C8A5C',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#3A2A1D', // kosmos-brown
                        pointHoverBorderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#3A2A1D',
                            titleFont: { family: 'Inter', size: 13 },
                            bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: Rp ' + Number(context.parsed.y).toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(42,33,25,0.05)', drawBorder: false },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: '#7A6355',
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'jt';
                                    if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'k';
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: { 
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: 'Inter', size: 11 }, color: '#7A6355' }
                        }
                    }
                }
            });
        });
        @endif
    </script>
</body>
</html>
