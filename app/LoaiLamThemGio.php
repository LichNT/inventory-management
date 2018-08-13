<?php

namespace App;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class LoaiLamThemGio extends Model
{
    protected $fillable = [ 'ten', 'he_so','muc_luong','so_gio_theo_quy_dinh'];
    public $timestamps =false;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope());
    }
    
}
