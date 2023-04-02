<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\ProdukInven;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public static function getProduct(Request $request)
    {
        $tanggal = null;
        $product = Produk::with(['produk_inven', 'opname_detail.opname', 'opname_detail.opname_detail_produk']);
        if($request->tanggal != null && $request->tanggal != "") {
            $tanggal = $request->tanggal;
            $product = Produk::with(['produk_inven' => function($q) use ($tanggal) {
                return $q->whereDate('created_at', '<=', $tanggal);
            }]);
            /*
            $product = $product->where(function($q) use ($tanggal) {
                return $q->whereHas('produk_inven', function($q) use ($tanggal) {
                    return $q->whereDate('created_at', $tanggal);
                })->orWhereDate('created_at', $tanggal);
            });
            */
            $product->with(['opname_detail' => function($q) use ($tanggal) {
                return $q->with('opname')->with('opname_detail_produk')->whereHas('opname', function($q1) use ($tanggal) {
                    return $q1->whereDate('created_at', '<=', $tanggal);
                });
            }]);
        }
        if($request->kategori != null && $request->kategori != "") {
            $product = $product->where('kategori', $request->kategori);
        }
        $product = $product->get();

        foreach($product as $p) {
            $p->kadaluarsa = ProdukInven::selectRaw('*, DATEDIFF(kadaluarsa, "'.Carbon::now()->format('Y-m-d').'") AS `sisa_hari`')
                ->with('produk')->where('status', 'Visible')
                ->where('produk_id', $p->id)
                ->having('sisa_hari', '<=', '20')->having('sisa_hari', '>=', '0')
                ->where('jenis', 'Masuk')
                ->orderBy('sisa_hari');
            if($tanggal != null)
            $p->kadaluarsa = $p->kadaluarsa->whereDate('created_at', '<=', $tanggal);
            $p->kadaluarsa = $p->kadaluarsa->get();

            if($p->opname_detail->count() > 0) {
                $od = $p->opname_detail->last();
                $p->produk_inven_f = $p->produk_inven->filter(function ($item) use ($od) {
                    return Carbon::parse($item->created_at)->gt(Carbon::parse($od->opname->created_at));
                })->values();
                $p->qty_awal = $od->qty_actual;
                $p->qty_akhir = $p->qty_awal;

                $count = 0;
                foreach($p->produk_inven_f as $f) {
                    if($tanggal == null) {
                        if($f->jenis == 'Masuk')
                            $p->qty_akhir += $f->jumlah;
                        else
                            $p->qty_akhir -= $f->jumlah;
                    } else {
                        if(substr($f->created_at, 0, 10) == $tanggal) {
                            if($f->jenis == 'Masuk')
                                $count += $f->jumlah;
                            else
                                $count -= $f->jumlah;
                        } else if(Carbon::parse($f->created_at)->lt(Carbon::parse($tanggal))) {
                            if($f->jenis == 'Masuk')
                                $p->qty_awal += $f->jumlah;
                            else
                                $p->qty_awal -= $f->jumlah;
                        }
                    }
                }
                if($tanggal != null)
                    $p->qty_akhir = $p->qty_awal+$count;

                $p->produk_inven_masuk = $p->produk_inven_f->where('jenis', 'Masuk')->values();
                $p->produk_inven_keluar = $p->produk_inven_f->where('jenis', 'Keluar')->values();
            } else {
                $p->produk_inven_f = null;
                
                if($tanggal != null) {
                    $count = 0;
                    foreach($p->produk_inven as $f) {
                        if(substr($f->created_at, 0, 10) == $tanggal) {
                            if($f->jenis == 'Masuk')
                                $count += $f->jumlah;
                            else
                                $count -= $f->jumlah;
                        } else if(Carbon::parse($f->created_at)->lt(Carbon::parse($tanggal))) {
                            if($f->jenis == 'Masuk')
                                $p->qty_awal += $f->jumlah;
                            else
                                $p->qty_awal -= $f->jumlah;
                        }
                    }
                    $p->qty_akhir = $p->qty_awal+$count;
                }

                $p->produk_inven_masuk = $p->produk_inven->where('jenis', 'Masuk')->values();
                $p->produk_inven_keluar = $p->produk_inven->where('jenis', 'Keluar')->values();
            }
            
            if($tanggal != null) {
                $p->produk_inven_masuk = $p->produk_inven_masuk->filter(function ($item) use ($tanggal) {
                    return substr($item->created_at, 0, 10) == $tanggal;
                })->values();
                $p->produk_inven_keluar = $p->produk_inven_keluar->filter(function ($item) use ($tanggal) {
                    return substr($item->created_at, 0, 10) == $tanggal;
                })->values();
            }
        }
        return $product;
    }

    public function index(Request $request)
    {
        $kategoriList = Produk::selectRaw('DISTINCT `kategori`')->get();
        $product = ProductController::getProduct($request);
        // $product = Produk::all();
        return view('product', ['produk' => $product, 'kategori' => $request->kategori, 'tanggal' => $request->tanggal, 'kategoriList' => $kategoriList]);
    }

    public function delete($id)
    {
        $rowAffected = Produk::where('id', $id)->delete();
        if($rowAffected > 0)
            return redirect()->route('product')->with(['msg' => 'Berhasil menghapus produk']);
        return redirect()->route('product')->with(['errmsg' => 'Gagal menghapus produk']);
    }

    public function edit($id = null)
    {
        $produk = null;
        $kategori = Produk::selectRaw('DISTINCT `kategori`')->get();

        if($id != null)
            $produk = Produk::with('produk_inven')->with('opname_detail.opname')->find($id);
        return view('edit.product', ['produk' => $produk, 'kategori' => $kategori, 'id' => $id]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required',
            'besaran' => 'required|numeric',
            'satuan' => 'required',
            'kategori' => 'required',
            'ket' => 'required',

        ], 
        [
            'nama.required' => 'Nama Produk Tidak Boleh Kosong!',
            'besaran.required' => 'Besaran Produk Tidak Boleh Kosong!',
            'satuan.required' => 'Satuan Produk Tidak Boleh Kosong!',
            'kategori.required' => 'Kategori Produk Tidak Boleh Kosong!',
            'ket.required' => 'Keterangan Masa Kadaluwarsa Produk Tidak Boleh Kosong!',
        ]);

        $produk = null;
        
        if($request->id != null && $request->id != ""){
            $produk = Produk::find($request->id);
        }
        else{
            $produk = new Produk;
        }
        $produk->created_by = session('user')->id;
        $produk->nama = $request->nama;
        $produk->besaran = $request->besaran;
        $produk->satuan = $request->satuan;
        $produk->kategori = $request->kategori;
        $produk->ket = $request->ket;
        if($request->qty_awal != null) {
            $produk->qty_awal = $request->qty_awal;
            $produk->qty_akhir = $request->qty_awal;
        }
        if($request->qty_awal == null) {
            $produk->qty_awal = "0";
        }
        $produk->updated_by = session('user')->id;
        if($produk->save()) {
            if($request->id != null && $request->id != ""){
                return redirect()->route('product', ['id' => $produk->id])->with(['msg' => 'Berhasil menyimpan perubahan data produk']);
            }
            else {
                return redirect()->route('product')->with(['msg' => 'Berhasil menambahkan produk baru']);
            }
        }
        return redirect()->back()->with(['errmsg' => 'Gagal menyimpan produk']);
    }

    public function export(Request $request)
    {
        $product = ProductController::getProduct($request);
        return Excel::download(new ProductExport($product), "Expor Produk ".Carbon::now()->format('Y-m-d H:i:s').".xlsx");
    }
}
