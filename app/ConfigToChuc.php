<?php

namespace App;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class ConfigToChuc extends Model
{
    protected $table = 'config_to_chucs';
    protected $fillable = [
        'ten_hien_thi',
        'id_loai_to_chuc',
        'company_id'
    ];

    function loaiToChuc(){
        return $this->belongsTo('App\LoaiToChuc', 'id_loai_to_chuc', 'id')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
    }
}
