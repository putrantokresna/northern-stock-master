<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    
    public function produk_inven() {
        return $this->hasMany('App\Models\ProdukInven', 'created_by');
    }

    public function opname() {
        return $this->hasMany('App\Models\Opname', 'created_by');
    }

    public function log() {
        return $this->hasMany('App\Models\Log', 'target_user');
    }

    public function log_read() {
        return $this->hasMany('App\Models\LogRead', 'user_id');
    }
}
