<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed data awal KedaiSeduh.
     * Jalankan: php artisan migrate:fresh --seed
     *
     * Semua akun demo memakai password: "password"
     */
    public function run(): void
    {
        $now = now();

        // =====================================================
        // 1. USERS (admin, vendor, customer)
        // =====================================================
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin KedaiSeduh',
            'email' => 'admin@kedaiseduh.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $vendor1 = DB::table('users')->insertGetId([
            'name' => 'Rangga Aditya',
            'email' => 'vendor1@kedaiseduh.test',
            'password' => Hash::make('password'),
            'role' => 'vendor', 'status' => 'active',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $vendor2 = DB::table('users')->insertGetId([
            'name' => 'Sari Wulandari',
            'email' => 'vendor2@kedaiseduh.test',
            'password' => Hash::make('password'),
            'role' => 'vendor', 'status' => 'active',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        // Vendor tanpa cafe (untuk demo alur "setup cafe")
        DB::table('users')->insert([
            'name' => 'Vendor Baru',
            'email' => 'vendor3@kedaiseduh.test',
            'password' => Hash::make('password'),
            'role' => 'vendor', 'status' => 'active',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $cust1 = DB::table('users')->insertGetId([
            'name' => 'Budi Santoso',
            'email' => 'budi@kedaiseduh.test',
            'password' => Hash::make('password'),
            'role' => 'user', 'status' => 'active',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $cust2 = DB::table('users')->insertGetId([
            'name' => 'Ayu Lestari',
            'email' => 'ayu@kedaiseduh.test',
            'password' => Hash::make('password'),
            'role' => 'user', 'status' => 'active',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        // =====================================================
        // 2. CAFE
        // =====================================================
        $img = fn($id) => "https://images.unsplash.com/photo-{$id}?w=1000&q=80&auto=format&fit=crop";

        $cafe1 = (string) Str::uuid();
        DB::table('cafe')->insert([
            'id' => $cafe1,
            'vendor_id' => $vendor1,
            'nama' => 'Seduh Senja',
            'status' => 'approved',
            'no_telp' => '081234567890',
            'alamat' => 'Jl. Kemang Raya No. 45, Jakarta Selatan',
            'deskripsi' => 'Kedai kopi bernuansa hangat dengan racikan single origin pilihan. Tempat sempurna untuk menikmati senja sambil bekerja atau berbincang.',
            'fasilitas' => "WiFi Cepat\nStop Kontak\nIndoor & Outdoor\nMushola\nParkir Luas",
            'foto_profil' => $img('1445116572660-236099ec97a0'),
            'jam_operasional' => '08.00 - 23.00 WIB',
            'titik_geo' => '-6.260, 106.813',
            'is_open' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $cafe2 = (string) Str::uuid();
        DB::table('cafe')->insert([
            'id' => $cafe2,
            'vendor_id' => $vendor2,
            'nama' => 'Nocturnal Brew',
            'status' => 'approved',
            'no_telp' => '087811223344',
            'alamat' => 'Jl. Braga No. 12, Bandung',
            'deskripsi' => 'Specialty coffee house bertema gelap-elegan yang buka hingga larut malam. Cocok untuk night owl dan pecinta kopi manual brew.',
            'fasilitas' => "WiFi Cepat\nStop Kontak\nSmoking Area\nLive Music (Weekend)\nParkir",
            'foto_profil' => $img('1554118811-1e0d58224f24'),
            'jam_operasional' => '10.00 - 02.00 WIB',
            'titik_geo' => '-6.917, 107.609',
            'is_open' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        // Cafe menunggu persetujuan admin (untuk demo approve/reject)
        $cafe3 = (string) Str::uuid();
        DB::table('cafe')->insert([
            'id' => $cafe3,
            'vendor_id' => $vendor2,
            'nama' => 'Ruang Tenang Coffee',
            'status' => 'pending',
            'no_telp' => '081999888777',
            'alamat' => 'Jl. Malioboro No. 88, Yogyakarta',
            'deskripsi' => 'Coffee space minimalis untuk fokus dan produktivitas.',
            'fasilitas' => "WiFi\nStop Kontak\nQuiet Zone",
            'foto_profil' => $img('1501339847302-ac426a4a7cbb'),
            'jam_operasional' => '09.00 - 22.00 WIB',
            'is_open' => false,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        // =====================================================
        // 3. MENU
        // =====================================================
        $menu = function ($cafeId, $nama, $harga, $kategori, $imgId, $status = 'tersedia', $desk = null) use ($now, $img) {
            $id = (string) Str::uuid();
            DB::table('menu')->insert([
                'id' => $id,
                'cafe_id' => $cafeId,
                'nama_menu' => $nama,
                'harga' => $harga,
                'deskripsi' => $desk ?? 'Disajikan dengan bahan pilihan.',
                'gambar' => $img($imgId),
                'kategori' => $kategori,
                'status' => $status,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            return $id;
        };

        // Menu Seduh Senja
        $m1 = $menu($cafe1, 'Kopi Susu Gula Aren', 22000, 'Kopi', '1461023058943-07fcbe16d735');
        $m2 = $menu($cafe1, 'Espresso',            18000, 'Kopi', '1510591509098-f4fdc6d0ff04');
        $m3 = $menu($cafe1, 'Cappuccino',          25000, 'Kopi', '1572442388796-11668a67e53d');
        $menu($cafe1, 'Matcha Latte',       28000, 'Non-Kopi', '1515823662972-da6a2e4d3002');
        $menu($cafe1, 'Cokelat Panas',      24000, 'Non-Kopi', '1542990253-a781e04c0082');
        $menu($cafe1, 'Croissant Butter',   20000, 'Makanan',  '1555507036-ab1f4038808a');
        $menu($cafe1, 'Roti Bakar Cokelat', 18000, 'Makanan',  '1481391319762-47dff72954d9', 'habis');
        $menu($cafe1, 'Kentang Goreng',     20000, 'Snack',    '1573080496219-bb080dd4f877');

        // Menu Nocturnal Brew
        $n1 = $menu($cafe2, 'V60 Single Origin',   30000, 'Kopi', '1495474472287-4d71bcdd2085');
        $n2 = $menu($cafe2, 'Kopi Susu Nocturnal', 24000, 'Kopi', '1447933601403-0c6688de566e');
        $menu($cafe2, 'Americano',          20000, 'Kopi',     '1521302080334-4bebac2763a6');
        $menu($cafe2, 'Red Velvet Latte',   29000, 'Non-Kopi', '1541167760496-1628856ab772');
        $menu($cafe2, 'Nasi Goreng Kampung',32000, 'Makanan',  '1512058564366-18510be2db19');
        $menu($cafe2, 'Pisang Goreng Keju', 22000, 'Snack',    '1592151675528-1a0c09dde9b2');

        // =====================================================
        // 4. MEJA (cafe_table)
        // =====================================================
        $table = function ($cafeId, $no, $max) use ($now) {
            $id = (string) Str::uuid();
            DB::table('cafe_table')->insert([
                'id' => $id, 'cafe_id' => $cafeId,
                'no_table' => $no, 'max_person' => $max,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            return $id;
        };
        $t1 = $table($cafe1, 'T1', 2);
        $table($cafe1, 'T2', 2);
        $t3 = $table($cafe1, 'T3', 4);
        $table($cafe1, 'T4', 4);
        $table($cafe1, 'T5', 6);

        $a1 = $table($cafe2, 'A1', 2);
        $a2 = $table($cafe2, 'A2', 4);
        $table($cafe2, 'A3', 6);

        // =====================================================
        // 5. GALLERY
        // =====================================================
        $gallery = function ($cafeId, $imgId, $ruangan, $lantai) use ($now, $img) {
            DB::table('gallery')->insert([
                'id' => (string) Str::uuid(), 'cafe_id' => $cafeId,
                'gambar' => $img($imgId), 'nama_ruangan' => $ruangan, 'lantai' => $lantai,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        };
        $gallery($cafe1, '1554118811-1e0d58224f24', 'Indoor Lantai 1', 1);
        $gallery($cafe1, '1521017432531-fbd92d768814', 'Outdoor Garden', 1);
        $gallery($cafe1, '1600093463592-8e36ae95ef56', 'Rooftop', 2);
        $gallery($cafe2, '1445116572660-236099ec97a0', 'Main Hall', 1);
        $gallery($cafe2, '1559925393-8be0ec4767c8', 'Bar Area', 1);
        $gallery($cafe2, '1453614512568-c4024d13c247', 'Loft', 2);

        // =====================================================
        // 6. TRANSAKSI + DETAIL (contoh riwayat)
        // =====================================================
        $buatTransaksi = function ($cafeId, $custId, $orderCode, $channel, $status, $tgl, $items, $bayar = null) use ($now) {
            $total = collect($items)->sum(fn($it) => $it['harga'] * $it['qty']);
            $trxId = (string) Str::uuid();
            DB::table('transaksi')->insert([
                'id' => $trxId, 'order_code' => $orderCode,
                'cafe_id' => $cafeId, 'cust_id' => $custId,
                'channel_pembayaran' => $channel, 'tgl' => $tgl,
                'status' => $status, 'total_harga' => $total,
                'waktu_pembayaran' => $bayar,
                'created_at' => $tgl, 'updated_at' => $now,
            ]);
            foreach ($items as $it) {
                DB::table('transaksi_detail')->insert([
                    'transaksi_id' => $trxId, 'menu_id' => $it['id'],
                    'jumlah' => $it['qty'], 'harga_saat_transaksi' => $it['harga'],
                ]);
            }
            return $trxId;
        };

        $buatTransaksi($cafe1, $cust1, 'AXK01', 'qris', 'Selesai',
            Carbon::now()->subDays(3),
            [['id' => $m1, 'harga' => 22000, 'qty' => 2], ['id' => $m3, 'harga' => 25000, 'qty' => 1]],
            Carbon::now()->subDays(3)->addMinutes(4));

        $buatTransaksi($cafe1, $cust2, 'BQL02', 'cash', 'Masuk',
            Carbon::now()->subHours(2),
            [['id' => $m2, 'harga' => 18000, 'qty' => 1]]);

        $buatTransaksi($cafe2, $cust1, 'CMN01', 'qris', 'Dibayar',
            Carbon::now()->subDay(),
            [['id' => $n1, 'harga' => 30000, 'qty' => 1], ['id' => $n2, 'harga' => 24000, 'qty' => 2]],
            Carbon::now()->subDay()->addMinutes(2));

        // =====================================================
        // 7. BOOKING
        // =====================================================
        DB::table('booking')->insert([
            'id' => (string) Str::uuid(), 'cafe_id' => $cafe1, 'table_id' => $t3,
            'cust_id' => $cust2, 'num_person' => 4, 'tgl' => Carbon::now()->addDay()->setTime(19, 0),
            'catatan' => 'Rayakan ulang tahun, tolong siapkan tempat dekat jendela.',
            'status' => 'pending', 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('booking')->insert([
            'id' => (string) Str::uuid(), 'cafe_id' => $cafe2, 'table_id' => $a2,
            'cust_id' => $cust1, 'num_person' => 3, 'tgl' => Carbon::now()->addDays(2)->setTime(20, 30),
            'catatan' => null, 'status' => 'confirmed', 'created_at' => $now, 'updated_at' => $now,
        ]);

        // =====================================================
        // 8. REPORT (komplain untuk admin)
        // =====================================================
        DB::table('reports')->insert([
            'pelapor_id' => $cust1, 'terlapor_id' => $vendor2, 'terlapor_cafe_id' => $cafe2,
            'tipe' => 'terhadap_vendor', 'kategori_laporan' => 'Pelayanan',
            'deskripsi' => 'Pesanan datang cukup lama saat jam ramai. Mohon ditingkatkan.',
            'status' => 'baru', 'bukti' => null,
            'created_at' => $now, 'updated_at' => $now,
        ]);
    }
}
