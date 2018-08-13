<?php

namespace App;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class TrinhDoNgoaiNgu extends Model
{
    protected $fillable = ['ma','ten','trang_thai','mo_ta'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope());
    }
}
