<?php

namespace App;

use App\Scopes\CompanyScope;
use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class LoaiNghiDacBiet extends Model
{
    protected $fillable = ['ma', 'ten', 'trang_thai'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
        static::addGlobalScope(new OrderByScope());
    }
}
