<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukInven;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = null;
        $inven = ProdukInven::with(['produk', 'user'])->whereNotNull('produk_id');
        if($request->tanggal != "" && $request->tanggal != null) {
            $tanggal = $request->tanggal;
            $inven->whereDate('created_at', $tanggal);
        }
        $inven = $inven->get();
        // dd($inven);
        return view('history', ['inven' => $inven, 'tanggal' => $tanggal]);
    }

    public function delete($id)
    {
        $rowAffected = ProdukInven::where('id', $id)->delete();
        if($rowAffected > 0)
        return redirect()->route('history')->with(['msg' => 'Berhasil menghapus produk']);
        return redirect()->route('history')->with(['errmsg' => 'Gagal menghapus produk']);
    }
}
