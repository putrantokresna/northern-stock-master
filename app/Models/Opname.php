<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opname extends Model
{
    protected $table = 'tbl_opname';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function opname_detail() {
        return $this->hasMany('App\Models\OpnameDetail', 'opname_id');
    }
}
