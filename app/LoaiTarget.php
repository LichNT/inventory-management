<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;

class LoaiTarget extends Model
{
    protected $fillable = ['ma','ten','inactive', 'company_id'];
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }
}

