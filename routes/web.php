<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController;

// Homepage
Route::get('/', function () {
    $cafes = DB::table('cafe')->where('status', 'approved')->get();
    return view('welcome', compact('cafes'));
})->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// API route for QRIS polling (public, no auth)
Route::get('/api/transaksi/{id}/status', function ($id) {
    $transaksi = DB::table('transaksi')
        ->join('users', 'transaksi.cust_id', '=', 'users.id')
        ->select('transaksi.*', 'users.name as nama_pelanggan')
        ->where('transaksi.id', $id)
        ->first();

    if (!$transaksi) {
        return response()->json(['status' => 'not_found'], 404);
    }

    $detail = DB::table('transaksi_detail')
        ->join('menu', 'transaksi_detail.menu_id', '=', 'menu.id')
        ->select('transaksi_detail.*', 'menu.nama_menu')
        ->where('transaksi_detail.transaksi_id', $id)
        ->get();

    $cafe = DB::table('cafe')->first();

    return response()->json([
        'status'    => $transaksi->status,
        'transaksi' => $transaksi,
        'detail'    => $detail,
        'cafe'      => $cafe,
    ]);
});

// Profil & Cart & Order Routes (Auth required)
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', function () {
        return view('profil.index');
    })->name('profil.index');

    // Cart (Per Cafe)
    Route::prefix('cafe/{cafe_id}/keranjang')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/tambah', [CartController::class, 'add'])->name('cart.add');
        Route::put('/{menuId}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/{menuId}', [CartController::class, 'remove'])->name('cart.remove');
        Route::delete('/', [CartController::class, 'clear'])->name('cart.clear');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    });

    // Orders
    Route::post('/pesanan', [OrderController::class, 'store'])->name('order.store');
    Route::get('/pesanan', [OrderController::class, 'index'])->name('order.index');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/pesanan/{id}/qris', [OrderController::class, 'qris'])->name('order.qris');
    Route::post('/pesanan/{id}/scan-qr', [OrderController::class, 'scanQr'])->name('order.scan-qr');
    Route::post('/pesanan/{id}/konfirmasi-selesai', [OrderController::class, 'konfirmasiSelesai'])->name('order.konfirmasi-selesai');
    Route::post('/pesanan/{id}/komplain', [OrderController::class, 'komplain'])->name('order.komplain');

    // Booking / Reservasi
    Route::post('/cafe/{cafe_id}/booking', [BookingController::class, 'store'])->name('booking.store');
});

// Cafe Detail Routes (Public)
Route::get('/cafe/{identifier}', function ($identifier) {
    // Try by ID first
    $cafe = DB::table('cafe')->where('id', $identifier)->where('status', 'approved')->first();
    
    // Fallback to name search for legacy links like 'kopi-kenangan'
    if (!$cafe) {
        $name = str_replace('-', ' ', $identifier);
        $cafe = DB::table('cafe')->where('nama', 'like', "%{$name}%")->where('status', 'approved')->first();
    }
    
    if (!$cafe) {
        abort(404, 'Cafe tidak ditemukan');
    }
    
    $menus = DB::table('menu')->where('cafe_id', $cafe->id)->where('status', 'tersedia')->get();
    $tables = DB::table('cafe_table')->where('cafe_id', $cafe->id)->orderBy('no_table')->get();
    $galeri = DB::table('gallery')->where('cafe_id', $cafe->id)->orderBy('created_at', 'desc')->get();
    
    return view('cafe.detail', compact('cafe', 'menus', 'tables', 'galeri'));
})->name('cafe.detail');

use App\Http\Controllers\AdminController;

// Admin Routes (Protected)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.admin-dashboard');
    Route::get('/cafe/{id}', [AdminController::class, 'cafeDetail'])->name('admin.cafe.detail');
    Route::put('/cafe/{id}/approve', [AdminController::class, 'approveCafe'])->name('admin.cafe.approve');
    Route::put('/cafe/{id}/reject', [AdminController::class, 'rejectCafe'])->name('admin.cafe.reject');
    Route::put('/user/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.user.toggle-status');
    Route::put('/report/{id}/update-status', [AdminController::class, 'updateReportStatus'])->name('admin.report.update-status');
});

// Vendor Routes (Protected)
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->group(function () {
    Route::get('/setup', [VendorController::class, 'setup'])->name('vendor.setup');
    Route::post('/setup', [VendorController::class, 'storeSetup'])->name('vendor.setup.store');
    Route::get('/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');

    // Menu
    Route::get('/menu', [VendorController::class, 'menuIndex'])->name('vendor.menu.index');
    Route::post('/menu', [VendorController::class, 'storeMenu'])->name('vendor.menu.store');
    Route::put('/menu/{id}', [VendorController::class, 'updateMenu'])->name('vendor.menu.update');
    Route::delete('/menu/{id}', [VendorController::class, 'destroyMenu'])->name('vendor.menu.destroy');

    // Pesanan
    Route::get('/pesanan', [VendorController::class, 'pesananIndex'])->name('vendor.pesanan.index');
    Route::get('/pesanan/{id}', [VendorController::class, 'pesananDetail'])->name('vendor.pesanan.detail');
    Route::put('/pesanan/{id}/status', [VendorController::class, 'updatePesananStatus'])->name('vendor.pesanan.update-status');
    Route::get('/pesanan/{id}/qris', [VendorController::class, 'tampilkanQris'])->name('vendor.pesanan.qris');

    // Booking
    Route::get('/booking', [VendorController::class, 'bookingIndex'])->name('vendor.booking.index');
    Route::put('/booking/{id}/status', [VendorController::class, 'updateBookingStatus'])->name('vendor.booking.update-status');

    // Profil
    Route::get('/profil', [VendorController::class, 'profilIndex'])->name('vendor.profil.index');
    Route::put('/profil', [VendorController::class, 'updateProfil'])->name('vendor.profil.update');

    // Galeri
    Route::get('/galeri', [VendorController::class, 'galeriIndex'])->name('vendor.galeri.index');
    Route::put('/galeri/fasilitas', [VendorController::class, 'updateFasilitas'])->name('vendor.galeri.fasilitas');
    Route::post('/galeri', [VendorController::class, 'storeGaleri'])->name('vendor.galeri.store');
    Route::delete('/galeri/{id}', [VendorController::class, 'destroyGaleri'])->name('vendor.galeri.destroy');

    // Toggle Status Buka/Tutup
    Route::post('/cafe/toggle-status', [VendorController::class, 'toggleStatus'])->name('vendor.cafe.toggle-status');

    // Manajemen Meja
    Route::get('/meja', [VendorController::class, 'mejaIndex'])->name('vendor.meja.index');
    Route::post('/meja', [VendorController::class, 'mejaStore'])->name('vendor.meja.store');
    Route::put('/meja/{id}', [VendorController::class, 'mejaUpdate'])->name('vendor.meja.update');
    Route::delete('/meja/{id}', [VendorController::class, 'mejaDestroy'])->name('vendor.meja.destroy');
});