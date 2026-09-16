<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request, $cafe_id)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'no_telp' => 'required|string',
            'tgl' => 'required|date|after:now',
            'num_person' => 'required|integer|min:1',
            'table_id' => 'required|string',
            'catatan' => 'nullable|string'
        ]);

        $cafe = DB::table('cafe')->where('id', $cafe_id)->first();
        if (!$cafe) {
            return back()->with('error', 'Cafe tidak ditemukan.');
        }

        // Validate table exists for this cafe
        $table = DB::table('cafe_table')->where('id', $request->table_id)->where('cafe_id', $cafe_id)->first();
        if (!$table) {
            return back()->with('error', 'Meja tidak valid.');
        }

        if ($request->num_person > $table->max_person) {
            return back()->with('error', 'Jumlah orang melebihi kapasitas meja (' . $table->max_person . ' orang).');
        }

        // Check for double booking
        // Assuming a booking takes around 2 hours, so check if there's any active booking for this table within +/- 2 hours
        $bookingTime = Carbon::parse($request->tgl);
        
        $conflict = DB::table('booking')
            ->where('cafe_id', $cafe_id)
            ->where('table_id', $request->table_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereBetween('tgl', [
                $bookingTime->copy()->subHours(2)->toDateTimeString(),
                $bookingTime->copy()->addHours(2)->toDateTimeString()
            ])
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Mohon maaf, meja ini sudah dipesan pada waktu tersebut (atau berdekatan). Silakan pilih meja atau waktu lain.');
        }

        // Insert
        DB::table('booking')->insert([
            'id' => Str::uuid()->toString(),
            'cafe_id' => $cafe_id,
            'table_id' => $request->table_id,
            'cust_id' => Auth::id(),
            'num_person' => $request->num_person,
            'tgl' => $request->tgl,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Reservasi meja berhasil diajukan! Silakan menunggu konfirmasi dari pihak cafe.');
    }
}
