@extends('vendor.layouts.app')
@section('title', 'Manajemen Booking')
@section('page_title', 'Daftar Booking / Reservasi')

@section('content')

@if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-kosmos-sage/10 border border-kosmos-sage/20 text-kosmos-sage px-4 py-3 rounded-xl text-sm">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="card-kosmos p-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-kosmos-bg/50 border-b border-kosmos-border">
                    <th class="py-4 px-4 text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Tanggal & Waktu</th>
                    <th class="py-4 px-4 text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Customer</th>
                    <th class="py-4 px-4 text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Meja</th>
                    <th class="py-4 px-4 text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Jumlah Orang</th>
                    <th class="py-4 px-4 text-xs font-semibold text-kosmos-muted uppercase tracking-wider">Status</th>
                    <th class="py-4 px-4 text-xs font-semibold text-kosmos-muted uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-kosmos-border/50">
                @forelse($bookings as $b)
                <tr class="hover:bg-kosmos-bg/30 transition-colors">
                    <td class="py-4 px-4">
                        <p class="text-sm font-bold text-kosmos-brown">{{ \Carbon\Carbon::parse($b->tgl)->format('d M Y') }}</p>
                        <p class="text-xs text-kosmos-muted">{{ \Carbon\Carbon::parse($b->tgl)->format('H:i') }}</p>
                    </td>
                    <td class="py-4 px-4">
                        <p class="text-sm font-bold text-kosmos-brown">{{ $b->nama_pelanggan }}</p>
                        <p class="text-xs text-kosmos-muted">{{ $b->email_pelanggan }}</p>
                    </td>
                    <td class="py-4 px-4">
                        <p class="text-sm font-bold text-kosmos-brown">Meja {{ $b->no_table }}</p>
                        <p class="text-xs text-kosmos-muted">Max {{ $b->max_person }} orang</p>
                    </td>
                    <td class="py-4 px-4 text-sm font-medium text-kosmos-brown">
                        {{ $b->num_person }} Orang
                    </td>
                    <td class="py-4 px-4">
                        @if($b->status == 'pending')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-kosmos-primary/15 text-kosmos-primary">Pending</span>
                        @elseif($b->status == 'confirmed')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Confirmed</span>
                        @elseif($b->status == 'completed')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-kosmos-sage/15 text-kosmos-sage">Completed</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700">Cancelled</span>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-right">
                        <form action="{{ route('vendor.booking.update-status', $b->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" class="text-sm border-kosmos-border bg-kosmos-bg/30 text-kosmos-brown rounded-lg focus:ring-kosmos-primary focus:border-kosmos-primary py-2 px-3 outline-none">
                                <option value="pending" {{ $b->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $b->status == 'confirmed' ? 'selected' : '' }}>Konfirmasi</option>
                                <option value="completed" {{ $b->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $b->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @if($b->catatan)
                <tr class="bg-kosmos-bg/10">
                    <td colspan="6" class="py-3 px-4 text-xs text-kosmos-muted border-b border-kosmos-border">
                        <strong class="text-kosmos-brown">Catatan:</strong> {{ $b->catatan }}
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-kosmos-muted text-sm">
                        <i class="fas fa-calendar-times text-5xl mb-4 text-kosmos-border block"></i>
                        <p class="font-serif font-bold text-lg text-kosmos-brown">Belum ada data booking.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
