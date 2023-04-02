<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpnameDetail extends Model
{
    protected $table = 'tbl_opname_det';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function opname() {
        return $this->belongsTo('App\Models\Opname', 'opname_id');
    }

    public function produk() {
        return $this->belongsTo('App\Models\Produk', 'produk_id');
    }

    public function opname_detail_produk() {
        return $this->hasMany('App\Models\OpnameDetailProduk', 'opname_det_id');
    }
}
