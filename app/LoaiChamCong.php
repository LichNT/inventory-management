<?php

namespace App;

use App\Scopes\CompanyScope;
use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class LoaiChamCong extends Model
{
    protected $fillable = ['ten', 'ma','ty_le_huong_luong', 'huong_luong_co_ban','mo_ta','company_id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
        static::addGlobalScope(new OrderByScope());
    }
}
