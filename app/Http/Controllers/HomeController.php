<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukInven;
use App\Models\Produk;
use App\Models\Log;
use App\Models\LogRead;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $request->tanggal = Carbon::now();
        $produk = ProductController::getProduct($request);
        $expInven = ProdukInven::selectRaw('*, DATEDIFF(kadaluarsa, "'.Carbon::now()->format('Y-m-d').'") AS `sisa_hari`')
            ->with('produk')->where('status', 'Visible')->whereNotNull('produk_id')
            ->having('sisa_hari', '<=', '20')->having('sisa_hari', '>=', '0')
            ->where('jenis', 'Masuk')->orderBy('sisa_hari')->get();
        foreach($expInven as $exp) {
            if(Log::where('inven_id', $exp->id)->where('sisa_hari', $exp->sisa_hari)->count() == 0) {
                $log = new Log;
                $log->content = $exp->produk->nama.' (ID: '.$exp->produk->id.') masuk sebanyak '.$exp->jumlah.' pada '.substr($exp->kadaluarsa, 0, 10).', '.$exp->sisa_hari.' hari lagi melewati masa kadaluarsa';
                //$log->target_user = session('user')->id;
                $log->inven_id = $exp->id;
                $log->sisa_hari = $exp->sisa_hari;
                $log->save();
            }
        }
        return view('home', ['expInven' => $expInven, 'produk' => $produk]);
    }

    public function masuk(Request $request)
    {
        $berhasil = 0;
        for($i=0; $i<count($request->jumlah); $i++) {
            $produk = Produk::find($request->produk_id[$i]);
            $inven = new ProdukInven;
            $inven->created_by = session('user')->id;
            $inven->produk_id = $request->produk_id[$i];
            $inven->jumlah = $request->jumlah[$i];
            $inven->jenis = 'Masuk';
            $inven->kadaluarsa = $request->kadaluarsa[$i];
            if($inven->save()) {
                $produk->qty_akhir = $produk->qty_akhir+$request->jumlah[$i];
                if($produk->save()) {
                    $log = new Log;
                    $log->target_user = session('user')->id;
                    $log->content = session('user')->nama.' (ID: '.session('user')->id.') memasukan '.$produk->nama.' (ID: '.$produk->id.') sejumlah '.$request->jumlah[$i].' pada '.substr($inven->created_at, 0, 10);
                    $log->save();
                    $berhasil++;
                }
            }
        }

        $log = Log::with(['log_read' => function($q) {
            return $q->where('user_id', session('user')->id);
        }])->whereDoesntHave('log_read', function($q) {
            return $q->where('user_id', session('user')->id)->where('status', 'Delete');
        });
        if(session('user')->role != 'Admin')
            $log = $log->where(function($q) {
                return $q->where('target_user', session('user')->id)->orWhereNull('target_user');
            });
        $log = $log->orderBy('created_at', 'desc')->get();
        foreach($log as $l) {
            $lr = LogRead::where('user_id', session('user')->id)->where('log_id', $l->id)->first();
            if($lr == null) {
                $lr = new LogRead;
                $lr->user_id = session('user')->id;
                $lr->log_id = $l->id;
                $lr->status = 'New Message';
                $lr->save();
            }
        } 
        return redirect()->route('home')->with(['msg' => $berhasil.' produk berhasil dimasukan']);
    } 

    public function updateMasuk(Request $request)
    {
        $inven = ProdukInven::with('produk')->find($request->id);
        $inven->status = 'Disposed';
        if($inven->save()) {
            $log = new Log;
            $log->target_user = session('user')->id;
            $log->content = session('user')->nama.' (ID: '.session('user')->id.') menandai produk '.$inven->produk->nama.' (ID: '.$inven->produk->id.') yang kadaluarsa pada '.$inven->kadaluarsa.' menjadi \'Habis\'';
            $log->save();
            return redirect()->route('home')->with(['msg' => 'Berhasil mengubah status inventori yang sudah mau kadaluarsa menjadi \'Habis\'']);
        }
        return redirect()->route('home')->with(['errmsg' => 'Gagal mengubah status inventori yang sudah mau kadaluarsa']);
    }

    public function keluar(Request $request)
    {
        $berhasil = 0;
        for($i=0; $i<count($request->jumlah); $i++) {
            $produk = Produk::find($request->produk_id[$i]);
            if($produk != null) {
                $produk->qty_akhir = $produk->qty_akhir-$request->jumlah[$i];
        
                $selisih = $request->jumlah[$i];
                if($produk->qty_akhir < 0) {
                    $selisih = $selisih+$produk->qty_akhir;
                    $produk->qty_akhir = 0;
                }
                $inven = new ProdukInven;
                $inven->created_by = session('user')->id;
                $inven->produk_id = $request->produk_id[$i];
                $inven->jumlah = $selisih;
                $inven->jenis = 'Keluar';
                if($inven->save() && $produk->save()) {
                    $log = new Log;
                    $log->target_user = session('user')->id;
                    $log->content = session('user')->nama.' (ID: '.session('user')->id.') mengeluarkan '.$produk->nama.' (ID: '.$produk->id.') sejumlah '.$request->jumlah[$i].' pada '.substr($inven->created_at, 0, 10);
                    $log->save();
                    $berhasil++;
                }
            }
        }
        if($selisih < 5){
            Alert::warning('WARNING!', 'TERDAPAT PRODUK < 5! SEGARA CEK DAFTAR STOCK!');
            return redirect()->route('home')->with(['msg' => $berhasil.' produk berhasil dikeluarkan']);
        }
        else{
        return redirect()->route('home')->with(['msg' => $berhasil.' produk berhasil dikeluarkan']);
        }
    } 
    
    public function getNotification() {
        
        $log = LogRead::where('status', 'New Message');

        if(session('user')->role != 'Admin')
        {
            $log = $log->where(function($q) {
                return $q->where('target_user', session('user')->id)->orWhereNull('target_user');
            });
        }

        $log = $log->orderBy('created_at', 'desc')->count();
    
        return response($log);
    }
}

