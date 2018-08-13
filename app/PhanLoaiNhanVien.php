<?php

namespace App;

use App\Scopes\CompanyScope;
use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class PhanLoaiNhanVien extends Model
{
    protected $fillable = ['ma','ten','trang_thai','mo_ta','company_id'];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
        static::addGlobalScope(new OrderByScope());
    }
}
