<?php

namespace App;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class MucDongBaoHiem extends Model
{
    public $timestamps = false;
    protected $fillable =[
        'ten',
        'so_tien'
    ];

    public function chiTietBaoHiems() {
        return $this->hasMany('App\ChiTietBaoHiem', 'muc_dong_bao_hiem_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope());
    }
}
