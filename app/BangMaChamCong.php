<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;

class BangMaChamCong extends Model
{
    protected $fillable = [
        'ma',
        'inactive', 
        'company_id',
        'index'   
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }
}
