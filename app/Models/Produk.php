<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'tbl_produk';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function created_by() {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function updated_by() {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }

    public function opname_detail() {
        return $this->hasMany('App\Models\OpnameDetail', 'produk_id');
    }

    public function produk_inven() {
        return $this->hasMany('App\Models\ProdukInven', 'produk_id');
    }
}
