<?php

namespace App;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class Bac extends Model
{
    protected $fillable = [
        'id_chuc_vu',
        'ten',
        'he_so_luong',
        'muc_luong_co_ban',
        'mo_ta',
        'company_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CompanyScope);
    }

    public $timestamps =false;
    public function chucVu(){
        return $this->belongsTo('App\ChucVu','id_chuc_vu', 'id');
    }

    public function phuCaps(){
        return $this->hasMany('App\PhuCapBacLuong','bac_id', 'id');
    }

}
