<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\LogRead;

class MessageController extends Controller
{
    public function index(Request $request)
    {
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
            }
            if($lr->status != 'Delete') {
                $lr->status = 'Read';
                $lr->save();
            }
        } 
        return view('message', ['log' => $log]);
    }

    public function delete($id)
    {
        $log = LogRead::where('user_id', session('user')->id)->where('log_id', $id)->first();
        if($log == null) {
            $log = new LogRead;
            $log->user_id = session('user')->id;
            $log->log_id = $id;
        }
        $log->status = 'Delete';
        if($log->save())
            return redirect()->back()->with(['msg' => 'Berhasil menghapus pesan']);
            return redirect()->back()->with(['errmsg' => 'Gagal menghapus pesan']);
    }
}
