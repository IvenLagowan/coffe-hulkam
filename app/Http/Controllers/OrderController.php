<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // ==========================================
    // Buat Pesanan Baru dari Checkout
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'channel_pembayaran' => 'required|in:cash,qris',
            'cafe_id' => 'required|string',
        ]);

        $cafe_id = $request->cafe_id;
        $cart = session()->get("cart.{$cafe_id}", []);
        if (empty($cart)) {
            return redirect()->route('cart.index', ['cafe_id' => $cafe_id])->with('error', 'Keranjang kosong!');
        }

        $cafe = DB::table('cafe')->where('id', $cafe_id)->first();
        if (!$cafe) {
            return back()->with('error', 'Konfigurasi cafe belum ada. Hubungi vendor.');
        }

        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['jumlah']);

        // Buat order_code unik
        $count = DB::table('transaksi')->where('cafe_id', $cafe_id)->count() + 1;
        $orderCode = strtoupper(Str::random(3)) . str_pad($count, 2, '0', STR_PAD_LEFT);

        // Buat transaksi
        $transaksiId = Str::uuid()->toString();
        DB::table('transaksi')->insert([
            'id'                  => $transaksiId,
            'order_code'          => $orderCode,
            'cafe_id'             => $cafe->id,
            'cust_id'             => Auth::id(),
            'channel_pembayaran'  => $request->channel_pembayaran,
            'tgl'                 => now(),
            'status'              => 'Masuk',
            'total_harga'         => $total,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        // Buat detail transaksi
        foreach ($cart as $item) {
            DB::table('transaksi_detail')->insert([
                'transaksi_id'        => $transaksiId,
                'menu_id'             => $item['menu_id'],
                'jumlah'              => $item['jumlah'],
                'harga_saat_transaksi'=> $item['harga'],
            ]);
        }

        // Kosongkan keranjang
        session()->forget("cart.{$cafe_id}");

        if ($request->channel_pembayaran === 'qris') {
            return redirect()->route('order.qris', $transaksiId);
        }

        return redirect()->route('order.show', $transaksiId)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran di kasir.');
    }

    // ==========================================
    // Halaman Fake QRIS Scan
    // ==========================================
    public function qris($id)
    {
        $transaksi = DB::table('transaksi')->where('id', $id)->where('cust_id', Auth::id())->first();
        if (!$transaksi) abort(403, 'Akses tidak diizinkan.');

        $detail = DB::table('transaksi_detail')
            ->join('menu', 'transaksi_detail.menu_id', '=', 'menu.id')
            ->select('transaksi_detail.*', 'menu.nama_menu')
            ->where('transaksi_detail.transaksi_id', $id)
            ->get();

        return view('user.qris', compact('transaksi', 'detail'));
    }

    // ==========================================
    // Proses "Scan QR" → Update status Dibayar
    // ==========================================
    public function scanQr(Request $request, $id)
    {
        $transaksi = DB::table('transaksi')->where('id', $id)->where('cust_id', Auth::id())->first();

        if (!$transaksi || $transaksi->status === 'Dibayar') {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak valid atau sudah dibayar.']);
        }

        DB::table('transaksi')->where('id', $id)->update([
            'status'           => 'Dibayar',
            'waktu_pembayaran' => now(),
            'updated_at'       => now(),
        ]);

        $detail = DB::table('transaksi_detail')
            ->join('menu', 'transaksi_detail.menu_id', '=', 'menu.id')
            ->select('transaksi_detail.*', 'menu.nama_menu')
            ->where('transaksi_detail.transaksi_id', $id)
            ->get();

        $transaksiUpdated = DB::table('transaksi')
            ->join('users', 'transaksi.cust_id', '=', 'users.id')
            ->select('transaksi.*', 'users.name as nama_pelanggan')
            ->where('transaksi.id', $id)
            ->first();

        $cafe = DB::table('cafe')->first();

        return response()->json([
            'success'   => true,
            'message'   => 'Pembayaran berhasil!',
            'transaksi' => $transaksiUpdated,
            'detail'    => $detail,
            'cafe'      => $cafe,
        ]);
    }

    // ==========================================
    // Halaman Detail Pesanan User
    // ==========================================
    public function show($id)
    {
        $transaksi = DB::table('transaksi')->where('id', $id)->where('cust_id', Auth::id())->first();
        if (!$transaksi) abort(403);

        $detail = DB::table('transaksi_detail')
            ->join('menu', 'transaksi_detail.menu_id', '=', 'menu.id')
            ->select('transaksi_detail.*', 'menu.nama_menu')
            ->where('transaksi_detail.transaksi_id', $id)
            ->get();

        return view('user.order-detail', compact('transaksi', 'detail'));
    }

    // ==========================================
    // Halaman Daftar Pesanan User
    // ==========================================
    public function index()
    {
        $pesanan = DB::table('transaksi')
            ->where('cust_id', Auth::id())
            ->orderBy('tgl', 'desc')
            ->get();

        return view('user.orders', compact('pesanan'));
    }

    // ==========================================
    // Konfirmasi Selesai oleh User
    // ==========================================
    public function konfirmasiSelesai(Request $request, $id)
    {
        $transaksi = DB::table('transaksi')->where('id', $id)->where('cust_id', Auth::id())->first();

        if (!$transaksi || $transaksi->status !== 'Siap Diambil') {
            return back()->with('error', 'Pesanan belum siap atau tidak valid untuk dikonfirmasi.');
        }

        DB::table('transaksi')->where('id', $id)->update([
            'status'     => 'Selesai',
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Terima kasih! Pesanan telah dikonfirmasi selesai.');
    }

    // ==========================================
    // Komplain Pesanan
    // ==========================================
    public function komplain(Request $request, $id)
    {
        $request->validate(['komplain' => 'required|string|max:500']);

        $transaksi = DB::table('transaksi')->where('id', $id)->where('cust_id', Auth::id())->first();
        if (!$transaksi) return back()->with('error', 'Pesanan tidak ditemukan.');

        // In a real system you'd store the complaint. Here we just update a note.
        DB::table('transaksi')->where('id', $id)->update([
            'status'     => 'Komplain',
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Komplain berhasil dikirim. Tim kami akan segera menghubungi Anda.');
    }
}
