<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpnameDetailProduk extends Model
{
    protected $table = 'tbl_opname_det_prod';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function opname_detail() {
        return $this->belongsTo('App\Models\OpnameDetail', 'opname_det_id');
    }
}
