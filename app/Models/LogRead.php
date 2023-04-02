<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRead extends Model
{
    protected $table = 'tbl_log_read';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function log() {
        return $this->belongsTo('App\Models\Log', 'log_id');
    }
}
