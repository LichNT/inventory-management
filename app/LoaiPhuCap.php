<?php

namespace App;

use App\Scopes\CompanyScope;
use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class LoaiPhuCap extends Model
{
    public $timestamps = false;
    protected $fillable =[
        'ten',
        'mo_ta',
        'company_id'
    ];

    function phuCapBacLuong(){
        return $this->hasMany('App\PhuCapBacLuong','id_loai_phu_cap');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
        static::addGlobalScope(new OrderByScope());
    }
}
