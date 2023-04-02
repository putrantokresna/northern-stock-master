<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\OpnameDetailProduk;
use App\Models\Produk;
use Carbon\Carbon;
use App\Models\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OpnameExport;
use RealRashid\SweetAlert\Facades\Alert;


class OpnameController extends Controller
{
    public function getOpname($opname, $produk)
    {
        if($opname != null) { 
            foreach($produk as $p) {
                if($p->opname_detail->count() > 0) {
                    $od = null;
                    for($i = $p->opname_detail->count()-1; $i >= 0; $i--) {
                        $od = $p->opname_detail[$i];
                        $dayOpname1 = Carbon::parse(substr($od->opname->created_at, 0, 10));
                        $dayOpname2 = Carbon::parse(substr($opname->created_at, 0, 10));
                        if($dayOpname1->lt($dayOpname2))
                            break;
                        else
                            $od = null;
                    }
                    if($od != null) {
                        $p->produk_inven_fop = $p->produk_inven->filter(function ($item) use ($od, $opname) {
                            $nextOpnameDay = Carbon::parse(substr($opname->created_at, 0, 10))->addDay();
                            return Carbon::parse($item->created_at)->gt(Carbon::parse($od->opname->created_at)) && Carbon::parse($item->created_at)->lt($nextOpnameDay);
                        })->values();
                        
                        $p->produk_inven_masuk = $p->produk_inven_fop->where('jenis', 'Masuk')->values();
                        $p->produk_inven_keluar = $p->produk_inven_fop->where('jenis', 'Keluar')->values();
                    }
                }
            }
        }
    }

    public function index(Request $request)
    {
        $opname = null;
        $tmp = $request->tanggal;
        $request->tanggal = null;
        $produk = ProductController::getProduct($request);
        if($tmp != null) {
            $opname = Opname::with('opname_detail.produk')->whereDate('created_at', $tmp)->first();
        } else {
            $opname = Opname::with('opname_detail.produk')->whereDate('created_at', Carbon::now())->first();
        }
        $kategoriList = Produk::selectRaw('DISTINCT `kategori`')->get();
        if($opname == null && $tmp != null && $tmp != Carbon::now()->format('Y-m-d')) {
            return view('opname', ['opname' => null, 'produk' => [], 'tanggal' => $tmp, 'kategori' => $request->kategori, 'kategoriList' => $kategoriList, 'errmsg' => 'Tidak terdapat stock opname pada '.$tmp, 'msg' => null]);
        }
        OpnameController::getOpname($opname, $produk);
        return view('opname', ['opname' => $opname, 'produk' => $produk, 'tanggal' => $tmp, 'kategori' => $request->kategori, 'kategoriList' => $kategoriList, 'errmsg' => null, 'msg' => null]);
    }

    public function store(Request $request)
    {
        $continue = true;
        $opname = new Opname;
        if(Opname::with('opname_detail.produk')->whereDate('created_at', $request->tanggal)->first() != null) {
            $opname = Opname::with('opname_detail.produk')->whereDate('created_at', $request->tanggal)->first();
            if($opname->opname_detail->count() > 0)
                $continue = false;
        }
        if($continue) {
            $opname->created_by = session('user')->id;
            $produk = ProductController::getProduct($request);
            if($opname->save()) {
                $count = 0;
                for($i=0; $i<count($request->produk_id); $i++) {
                    if(trim($request->qty_actual[$i]) != "") {
                        $p = $produk->where('id', $request->produk_id[$i])->first();
                        $od = new OpnameDetail;
                        $odp_content = explode(";", $request->odp_content[$i]);
                        $odp_jenis = explode(";", $request->odp_jenis[$i]);
                        $od->qty_awal = $request->qty_awal[$i];
                        $od->qty_system = $request->qty_akhir[$i];
                        $od->qty_actual = $request->qty_actual[$i];
                        $od->produk_id = $p->id;
                        $od->opname_id = $opname->id;
                        if($od->save()) {
                            for($j=0; $j<count($odp_content); $j++) {
                                if(trim($odp_content[$j]) != "") {
                                    $odp = new OpnameDetailProduk;
                                    $odp->opname_det_id = $od->id;
                                    $odp->content = $odp_content[$j];
                                    $odp->jenis = $odp_jenis[$j];
                                    $odp->save();
                                }
                            }
                            $count++;
                        }
                    }
                }
                if($count > 0) {
                    $log = new Log;
                    $log->target_user = session('user')->id;
                    $log->content = session('user')->nama.' (ID: '.session('user')->id.') stock opname pada '.substr($opname->created_at, 0, 10);
                    $log->save();
                    return redirect()->route('opname')->with(['msg' => 'Berhasil melakukan opname stok terhadap '.$count.' produk']);
                }
            }
        }
        return redirect()->route('opname')->with(['errmsg' => 'Gagal menyimpan data opname']);
    }
    
    public function export(Request $request)
    {
        $tmp = $request->tanggal;
        $request->tanggal = null;
        $produk = ProductController::getProduct($request);
        if($tmp != null) {
            $opname = Opname::with('opname_detail.produk')->whereDate('created_at', $tmp)->first();
        } else {
            $opname = Opname::with('opname_detail.produk')->whereDate('created_at', Carbon::now())->first();
        }
        OpnameController::getOpname($opname, $produk);
        return Excel::download(new OpnameExport($opname, $produk), "Expor Opname ".Carbon::now()->format('Y-m-d H:i:s').".xlsx");
    }
}
