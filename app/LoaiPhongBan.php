<?php

namespace App;

use App\Scopes\CompanyScope;
use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class LoaiPhongBan extends Model
{

    protected $fillable = ['ma','ten','trang_thai','company_id'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderByScope());
    }
}
