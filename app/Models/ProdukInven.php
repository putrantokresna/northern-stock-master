<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukInven extends Model
{
    protected $table = 'tbl_produk_inven';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function produk() {
        return $this->belongsTo('App\Models\Produk', 'produk_id');
    }
}
