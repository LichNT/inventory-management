<?php

namespace App;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class TinhThanh extends Model
{
    protected $fillable = ['ma','ten','trang_thai','mo_ta'];


    public function quanHuyens() {
        return $this->hasMany('App\QuanHuyen','tinh_thanh_id','id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope());
    }
}

