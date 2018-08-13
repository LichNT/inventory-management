<?php

namespace App;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;

class ChucVu extends Model
{
    protected $fillable = [
    'ma',
    'ten',
    'trang_thai',
    'company_id',
    'so_tien_hoc_viec_theo_ngay',
    'so_ngay_nghi_trong_thang',
    'so_gio_quy_dinh',
    'so_tien_bao_lanh',
    'so_thang',
];

public function setSoTienBaoLanhAttribute($value) {
    if(empty($value)){
        $this->attributes['so_tien_bao_lanh']=null;
    }
    else{
        $this->attributes['so_tien_bao_lanh'] = str_replace(',', '', $value);
    }
    
}
    public function chiTietCongTacs() {
        return $this->hasMany('App\ChiTietCongTac', 'id_chuc_vu_moi');
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
        static::addGlobalScope(new OrderByScope);
    }
}
