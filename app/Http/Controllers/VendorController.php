<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    private function getCafe()
    {
        return DB::table('cafe')->where('vendor_id', Auth::id())->first();
    }

    // ==========================================
    // 0. SETUP CAFE
    // ==========================================
    public function setup()
    {
        $cafe = $this->getCafe();
        if ($cafe) {
            return redirect()->route('vendor.dashboard');
        }
        return view('vendor.setup');
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'alamat'     => 'nullable|string',
            'galeri'     => 'nullable|string',
            'fasilitas'  => 'nullable|string',
        ]);

        $cafe = $this->getCafe();
        if ($cafe) {
            return redirect()->route('vendor.dashboard');
        }

        DB::table('cafe')->insert([
            'id'         => Str::uuid()->toString(),
            'vendor_id'  => Auth::id(),
            'nama'       => $request->nama,
            'deskripsi'  => $request->deskripsi,
            'alamat'     => $request->alamat,
            'galeri'     => $request->galeri,
            'fasilitas'  => $request->fasilitas,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('vendor.dashboard')->with('success', 'Cafe berhasil dibuat! Selamat datang.');
    }


    // ==========================================
    // 1. DASHBOARD
    // ==========================================
    public function index()
    {
        $cafe = $this->getCafe();
        if (!$cafe) {
            return redirect()->route('vendor.setup');
        }

        $totalPesanan    = DB::table('transaksi')->where('cafe_id', $cafe->id)->count();
        $pesananBaru     = DB::table('transaksi')->where('cafe_id', $cafe->id)->where('status', 'Masuk')->count();
        $pesananDibayar  = DB::table('transaksi')->where('cafe_id', $cafe->id)->where('status', 'Dibayar')->count();
        $totalMenu       = DB::table('menu')->where('cafe_id', $cafe->id)->count();

        return view('vendor.dashboard', compact('cafe', 'totalPesanan', 'pesananBaru', 'pesananDibayar', 'totalMenu'));
    }

    // ==========================================
    // 2. MANAJEMEN MENU (CRUD)
    // ==========================================
    public function menuIndex()
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $menus = DB::table('menu')->where('cafe_id', $cafe->id)->orderBy('created_at', 'desc')->get();
        return view('vendor.menu.index', compact('menus'));
    }

    public function storeMenu(Request $request)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $request->validate([
            'nama_menu'  => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'deskripsi'  => 'nullable|string',
            'gambar'     => 'nullable|url|max:500',
            'status'     => 'required|in:tersedia,habis',
        ]);

        DB::table('menu')->insert([
            'id'         => Str::uuid()->toString(),
            'cafe_id'    => $cafe->id,
            'nama_menu'  => $request->nama_menu,
            'harga'      => $request->harga,
            'deskripsi'  => $request->deskripsi,
            'gambar'     => $request->gambar,
            'status'     => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('vendor.menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function updateMenu(Request $request, $id)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $request->validate([
            'nama_menu'  => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'deskripsi'  => 'nullable|string',
            'gambar'     => 'nullable|url|max:500',
            'status'     => 'required|in:tersedia,habis',
        ]);

        DB::table('menu')->where('id', $id)->where('cafe_id', $cafe->id)->update([
            'nama_menu'  => $request->nama_menu,
            'harga'      => $request->harga,
            'deskripsi'  => $request->deskripsi,
            'gambar'     => $request->gambar,
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->route('vendor.menu.index')->with('success', 'Data menu berhasil diperbarui!');
    }

    public function destroyMenu($id)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        try {
            DB::table('menu')->where('id', $id)->where('cafe_id', $cafe->id)->delete();
            return redirect()->route('vendor.menu.index')->with('success', 'Menu berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('vendor.menu.index')->with('error', 'Gagal! Menu ini tidak bisa dihapus karena sudah ada di riwayat pesanan.');
            }
            return redirect()->route('vendor.menu.index')->with('error', 'Terjadi kesalahan saat menghapus menu.');
        }
    }

    // ==========================================
    // 3. MANAJEMEN PESANAN
    // ==========================================
    public function pesananIndex()
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $pesanan = DB::table('transaksi')
            ->join('users', 'transaksi.cust_id', '=', 'users.id')
            ->select('transaksi.*', 'users.name as nama_pelanggan', 'users.email as email_pelanggan')
            ->where('transaksi.cafe_id', $cafe->id)
            ->orderBy('transaksi.tgl', 'desc')
            ->get();

        return view('vendor.pesanan.index', compact('pesanan'));
    }

    public function pesananDetail($id)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $transaksi = DB::table('transaksi')
            ->join('users', 'transaksi.cust_id', '=', 'users.id')
            ->select('transaksi.*', 'users.name as nama_pelanggan', 'users.email as email_pelanggan')
            ->where('transaksi.id', $id)
            ->where('transaksi.cafe_id', $cafe->id)
            ->first();

        if (!$transaksi) {
            return redirect()->route('vendor.pesanan.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        $detail = DB::table('transaksi_detail')
            ->join('menu', 'transaksi_detail.menu_id', '=', 'menu.id')
            ->select('transaksi_detail.*', 'menu.nama_menu')
            ->where('transaksi_detail.transaksi_id', $id)
            ->get();

        return view('vendor.pesanan.detail', compact('transaksi', 'detail'));
    }

    public function updatePesananStatus(Request $request, $id)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $request->validate([
            'status' => 'required|string',
        ]);

        DB::table('transaksi')->where('id', $id)->where('cafe_id', $cafe->id)->update([
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diubah menjadi "' . $request->status . '"!');
    }

    // Vendor tampilkan QRIS => user akan melakukan "scan" dan mengupdate status
    public function tampilkanQris($id)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $transaksi = DB::table('transaksi')->where('id', $id)->where('cafe_id', $cafe->id)->first();
        if (!$transaksi) abort(404);

        return view('vendor.pesanan.qris', compact('transaksi'));
    }

    // ==========================================
    // 3A. MANAJEMEN BOOKING
    // ==========================================
    public function bookingIndex()
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $bookings = DB::table('booking')
            ->join('users', 'booking.cust_id', '=', 'users.id')
            ->join('cafe_table', 'booking.table_id', '=', 'cafe_table.id')
            ->select('booking.*', 'users.name as nama_pelanggan', 'users.email as email_pelanggan', 'cafe_table.no_table', 'cafe_table.max_person')
            ->where('booking.cafe_id', $cafe->id)
            ->orderBy('booking.tgl', 'desc')
            ->get();

        return view('vendor.booking.index', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        DB::table('booking')->where('id', $id)->where('cafe_id', $cafe->id)->update([
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status booking berhasil diubah menjadi "' . $request->status . '"!');
    }

    // ==========================================
    // 4. MANAJEMEN PROFIL CAFE
    // ==========================================
    public function profilIndex()
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        return view('vendor.profil.index', compact('cafe'));
    }

    public function updateProfil(Request $request)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $request->validate([
            'nama'            => 'required|string|max:255',
            'no_telp'         => 'nullable|string|max:20',
            'alamat'          => 'nullable|string',
            'deskripsi'       => 'nullable|string',
            'foto_profil'     => 'nullable|url|max:500',
            'jam_operasional' => 'nullable|string',
        ]);

        $data = [
            'nama'            => $request->nama,
            'no_telp'         => $request->no_telp,
            'alamat'          => $request->alamat,
            'deskripsi'       => $request->deskripsi,
            'foto_profil'     => $request->foto_profil,
            'jam_operasional' => $request->jam_operasional,
            'updated_at'      => now(),
        ];

        DB::table('cafe')->where('id', $cafe->id)->update($data);

        return redirect()->route('vendor.profil.index')->with('success', 'Profil Cafe berhasil diperbarui!');
    }

    // ==========================================
    // 5. GALERI & INFO CAFE
    // ==========================================
    public function galeriIndex()
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $galeri = DB::table('gallery')->where('cafe_id', $cafe->id)->orderBy('created_at', 'desc')->get();

        return view('vendor.galeri.index', compact('cafe', 'galeri'));
    }

    public function updateFasilitas(Request $request)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $request->validate([
            'fasilitas'  => 'nullable|string',
        ]);

        DB::table('cafe')->where('id', $cafe->id)->update([
            'fasilitas'  => $request->fasilitas,
            'updated_at' => now(),
        ]);

        return redirect()->route('vendor.galeri.index')->with('success', 'Fasilitas Cafe berhasil disimpan!');
    }

    public function storeGaleri(Request $request)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $request->validate([
            'gambar' => 'required|url|max:500',
            'nama_ruangan' => 'nullable|string|max:100',
            'lantai' => 'nullable|integer',
        ]);

        DB::table('gallery')->insert([
            'id' => Str::uuid()->toString(),
            'cafe_id' => $cafe->id,
            'gambar' => $request->gambar,
            'nama_ruangan' => $request->nama_ruangan,
            'lantai' => $request->lantai,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('vendor.galeri.index')->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    public function destroyGaleri($id)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        DB::table('gallery')->where('id', $id)->where('cafe_id', $cafe->id)->delete();

        return redirect()->route('vendor.galeri.index')->with('success', 'Foto galeri berhasil dihapus!');
    }

    // ==========================================
    // 6. TOGGLE STATUS & KELOLA MEJA
    // ==========================================
    public function toggleStatus()
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        DB::table('cafe')->where('id', $cafe->id)->update([
            'is_open' => !$cafe->is_open,
            'updated_at' => now(),
        ]);

        $status = !$cafe->is_open ? 'BUKA' : 'TUTUP';
        return redirect()->back()->with('success', "Status cafe sekarang: $status.");
    }

    public function mejaIndex()
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $meja = DB::table('cafe_table')->where('cafe_id', $cafe->id)->orderBy('no_table', 'asc')->get();
        return view('vendor.meja.index', compact('meja', 'cafe'));
    }

    public function mejaStore(Request $request)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $request->validate([
            'no_table' => 'required|string|max:50',
            'max_person' => 'required|integer|min:1',
        ]);

        // Check if table number exists
        $exists = DB::table('cafe_table')->where('cafe_id', $cafe->id)->where('no_table', $request->no_table)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Nomor meja sudah ada!');
        }

        DB::table('cafe_table')->insert([
            'id' => Str::uuid()->toString(),
            'cafe_id' => $cafe->id,
            'no_table' => $request->no_table,
            'max_person' => $request->max_person,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('vendor.meja.index')->with('success', 'Meja baru berhasil ditambahkan!');
    }

    public function mejaUpdate(Request $request, $id)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        $request->validate([
            'no_table' => 'required|string|max:50',
            'max_person' => 'required|integer|min:1',
        ]);

        // Check uniqueness excluding current ID
        $exists = DB::table('cafe_table')
            ->where('cafe_id', $cafe->id)
            ->where('no_table', $request->no_table)
            ->where('id', '!=', $id)
            ->exists();
            
        if ($exists) {
            return redirect()->back()->with('error', 'Nomor meja sudah digunakan!');
        }

        DB::table('cafe_table')->where('id', $id)->where('cafe_id', $cafe->id)->update([
            'no_table' => $request->no_table,
            'max_person' => $request->max_person,
            'updated_at' => now(),
        ]);

        return redirect()->route('vendor.meja.index')->with('success', 'Data meja berhasil diperbarui!');
    }

    public function mejaDestroy($id)
    {
        $cafe = $this->getCafe();
        if (!$cafe) return redirect()->route('vendor.setup');

        try {
            DB::table('cafe_table')->where('id', $id)->where('cafe_id', $cafe->id)->delete();
            return redirect()->route('vendor.meja.index')->with('success', 'Meja berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('vendor.meja.index')->with('error', 'Meja tidak dapat dihapus (mungkin sudah ada riwayat pesanan/booking pada meja ini).');
        }
    }
}