<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TinhThanh;

class QuanHuyen extends Model
{
    protected $fillable = ['ma','ten','tinh_thanh_id','trang_thai','mo_ta'];

    public function tinh_thanh() {
        return $this->belongsTo('App\TinhThanh', 'tinh_thanh_id')->withDefault();
    }
}
