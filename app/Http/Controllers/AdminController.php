<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cafe;
use App\Models\User;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $total_vendor_aktif = Cafe::where('status', 'approved')->count();
        $total_vendor_pending = Cafe::where('status', 'pending')->count();
        $total_customer = User::where('role', 'user')->count();

        $query = DB::table('transaksi')
            ->join('users', 'transaksi.cust_id', '=', 'users.id')
            ->join('cafe', 'transaksi.cafe_id', '=', 'cafe.id')
            ->select('transaksi.*', 'users.name as nama_pelanggan', 'cafe.nama as nama_cafe');

        if ($request->has('q') && $request->q != '') {
            $query->where('transaksi.order_code', 'like', '%' . $request->q . '%');
        }
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('transaksi.tgl', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('transaksi.tgl', '<=', $request->end_date);
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('transaksi.status', $request->status);
        }

        $transactions = $query->orderBy('transaksi.created_at', 'desc')->paginate(15, ['*'], 'trx_page')->withQueryString();

        $recent_transactions = DB::table('transaksi')
            ->join('users', 'transaksi.cust_id', '=', 'users.id')
            ->join('cafe', 'transaksi.cafe_id', '=', 'cafe.id')
            ->select('transaksi.*', 'users.name as nama_pelanggan', 'cafe.nama as nama_cafe')
            ->orderBy('transaksi.created_at', 'desc')
            ->limit(10)
            ->get();

        $cafes = Cafe::with('vendor')->orderBy('created_at', 'desc')->get();

        $menu_query = DB::table('menu')
            ->join('cafe', 'menu.cafe_id', '=', 'cafe.id')
            ->select('menu.*', 'cafe.nama as nama_cafe');
            
        if ($request->has('cafe_id') && $request->cafe_id != '') {
            $menu_query->where('menu.cafe_id', $request->cafe_id);
        }
        
        $menus = $menu_query->orderBy('menu.created_at', 'desc')->paginate(15, ['*'], 'menu_page')->withQueryString();

        $users = DB::table('users')
            ->where('role', 'user')
            ->leftJoin('transaksi', 'users.id', '=', 'transaksi.cust_id')
            ->select('users.id', 'users.name', 'users.email', 'users.status', 'users.created_at', DB::raw('COUNT(transaksi.id) as total_pesanan'))
            ->groupBy('users.id', 'users.name', 'users.email', 'users.status', 'users.created_at')
            ->orderBy('users.created_at', 'desc')
            ->get();

        $reports = \App\Models\Report::with(['pelapor', 'terlapor', 'cafe'])
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], 'report_page')
            ->withQueryString();

        $bookings_query = DB::table('booking')
            ->join('users', 'booking.cust_id', '=', 'users.id')
            ->join('cafe', 'booking.cafe_id', '=', 'cafe.id')
            ->join('cafe_table', 'booking.table_id', '=', 'cafe_table.id')
            ->select('booking.*', 'users.name as nama_pelanggan', 'cafe.nama as nama_cafe', 'cafe_table.no_table');

        if ($request->has('cafe_id') && $request->cafe_id != '') {
            $bookings_query->where('booking.cafe_id', $request->cafe_id);
        }

        $all_bookings = $bookings_query->orderBy('booking.tgl', 'desc')
            ->paginate(15, ['*'], 'booking_page')
            ->withQueryString();

        // Gallery per-cafe for Admin gallery section
        $gallery_query = DB::table('gallery')
            ->join('cafe', 'gallery.cafe_id', '=', 'cafe.id')
            ->select('gallery.*', 'cafe.nama as nama_cafe');

        if ($request->has('gallery_cafe_id') && $request->gallery_cafe_id != '') {
            $gallery_query->where('gallery.cafe_id', $request->gallery_cafe_id);
        }

        $galleries = $gallery_query->orderBy('gallery.created_at', 'desc')
            ->paginate(20, ['*'], 'gallery_page')
            ->withQueryString();

        // Per-cafe stats for dashboard overview
        $cafe_stats = DB::table('cafe')
            ->leftJoin('transaksi', 'cafe.id', '=', 'transaksi.cafe_id')
            ->select(
                'cafe.id',
                'cafe.nama',
                'cafe.status',
                DB::raw('COUNT(transaksi.id) as total_transaksi'),
                DB::raw("SUM(CASE WHEN transaksi.status IN ('Dibayar','Diproses','Siap Diambil','Selesai') THEN transaksi.total_harga ELSE 0 END) as total_revenue")
            )
            ->where('cafe.status', 'approved')
            ->groupBy('cafe.id', 'cafe.nama', 'cafe.status')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Transaksi detail for modal (preload all detail by trx ID)
        return view('admin.admin-dashboard', compact(
            'total_vendor_aktif',
            'total_vendor_pending',
            'total_customer',
            'recent_transactions',
            'transactions',
            'cafes',
            'menus',
            'users',
            'reports',
            'all_bookings',
            'galleries',
            'cafe_stats'
        ));
    }

    public function approveCafe(Request $request, $id)
    {
        $cafe = Cafe::findOrFail($id);
        $cafe->update([
            'status' => 'approved',
            'alasan_ditolak' => null
        ]);
        return back()->with('success', 'Cafe berhasil disetujui.');
    }

    public function rejectCafe(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string'
        ]);

        $cafe = Cafe::findOrFail($id);
        $cafe->update([
            'status' => 'rejected',
            'alasan_ditolak' => $request->alasan_ditolak
        ]);
        return back()->with('success', 'Cafe berhasil ditolak.');
    }

    public function toggleUserStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent modifying non-user roles through this endpoint just in case
        if ($user->role !== 'user') {
            return back()->with('error', 'Hanya bisa mengubah status customer.');
        }

        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();

        $msg = $user->status === 'active' ? 'diaktifkan' : 'disuspend';
        return back()->with('success', "User berhasil $msg.");
    }

    public function updateReportStatus(Request $request, $id)
    {
        $report = \App\Models\Report::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,investigating,resolved,rejected',
        ]);

        $report->status = $request->status;
        $report->save();

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function cafeDetail($id)
    {
        $cafe = Cafe::with('vendor')->findOrFail($id);

        $total_transaksi = DB::table('transaksi')->where('cafe_id', $id)->count();
        $total_revenue = DB::table('transaksi')
            ->where('cafe_id', $id)
            ->whereIn('status', ['Dibayar', 'Diproses', 'Siap Diambil', 'Selesai'])
            ->sum('total_harga');
        
        $booking_aktif = DB::table('booking')
            ->where('cafe_id', $id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        // Chart Data (30 Days Revenue)
        $revenue_chart = DB::table('transaksi')
            ->where('cafe_id', $id)
            ->whereIn('status', ['Dibayar', 'Diproses', 'Siap Diambil', 'Selesai'])
            ->where('tgl', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(tgl) as date'), DB::raw('SUM(total_harga) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chart_labels = $revenue_chart->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        });
        $chart_data = $revenue_chart->pluck('revenue');

        $bookings = DB::table('booking')
            ->join('users', 'booking.cust_id', '=', 'users.id')
            ->join('cafe_table', 'booking.table_id', '=', 'cafe_table.id')
            ->select('booking.*', 'users.name as nama_pelanggan', 'cafe_table.no_table')
            ->where('booking.cafe_id', $id)
            ->orderBy('booking.tgl', 'desc')
            ->limit(10)
            ->get();

        $galeri = DB::table('gallery')->where('cafe_id', $id)->get();

        return view('admin.cafe-detail', compact(
            'cafe', 'total_transaksi', 'total_revenue', 'booking_aktif', 
            'chart_labels', 'chart_data', 'bookings', 'galeri'
        ));
    }
}
