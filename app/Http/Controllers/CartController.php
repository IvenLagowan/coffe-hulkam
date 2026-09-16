<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index($cafe_id)
    {
        $cafe = DB::table('cafe')->where('id', $cafe_id)->where('status', 'approved')->first();
        if (!$cafe) abort(404);

        $cart  = session()->get("cart.{$cafe_id}", []);
        $menus = DB::table('menu')->where('cafe_id', $cafe_id)->where('status', 'tersedia')->get();
        return view('user.cart', compact('cart', 'menus', 'cafe'));
    }

    public function add(Request $request, $cafe_id)
    {
        $menuId = $request->menu_id;
        $menu   = DB::table('menu')->where('id', $menuId)->where('cafe_id', $cafe_id)->first();

        if (!$menu) {
            return back()->with('error', 'Menu tidak ditemukan.');
        }

        $cafe = DB::table('cafe')->where('id', $cafe_id)->first();
        if (!$cafe || !$cafe->is_open) {
            return back()->with('error', 'Cafe sedang tutup. Tidak dapat memesan makanan/minuman.');
        }

        $cart = session()->get("cart.{$cafe_id}", []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['jumlah'] += (int) $request->jumlah ?? 1;
        } else {
            $cart[$menuId] = [
                'menu_id'   => $menu->id,
                'nama_menu' => $menu->nama_menu,
                'harga'     => $menu->harga,
                'jumlah'    => (int) ($request->jumlah ?? 1),
            ];
        }

        session()->put("cart.{$cafe_id}", $cart);
        return back()->with('success', '"' . $menu->nama_menu . '" berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $cafe_id, $menuId)
    {
        $cart = session()->get("cart.{$cafe_id}", []);
        if (isset($cart[$menuId])) {
            $jumlah = (int) $request->jumlah;
            if ($jumlah <= 0) {
                unset($cart[$menuId]);
            } else {
                $cart[$menuId]['jumlah'] = $jumlah;
            }
            session()->put("cart.{$cafe_id}", $cart);
        }
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove($cafe_id, $menuId)
    {
        $cart = session()->get("cart.{$cafe_id}", []);
        if (isset($cart[$menuId])) {
            unset($cart[$menuId]);
            session()->put("cart.{$cafe_id}", $cart);
        }
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear($cafe_id)
    {
        session()->forget("cart.{$cafe_id}");
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    public function checkout($cafe_id)
    {
        $cafe = DB::table('cafe')->where('id', $cafe_id)->where('status', 'approved')->first();
        if (!$cafe) abort(404);

        if (!$cafe->is_open) {
            return redirect()->route('cafe.detail', ['identifier' => $cafe->id])->with('error', 'Cafe sedang tutup. Tidak dapat melakukan checkout.');
        }

        $cart = session()->get("cart.{$cafe_id}", []);
        if (empty($cart)) {
            return redirect()->route('cart.index', ['cafe_id' => $cafe_id])->with('error', 'Keranjang kosong!');
        }
        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['jumlah']);
        return view('user.checkout', compact('cart', 'total', 'cafe'));
    }
}
