<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'tbl_log';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\Models\User', 'target_user');
    }

    public function log_read() {
        return $this->hasMany('App\Models\LogRead', 'log_id');
    }

    public function produk_inven() {
        return $this->belongsTo('App\Models\ProdukInven', 'inven_id');
    }
}
