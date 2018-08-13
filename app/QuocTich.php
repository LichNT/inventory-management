<?php

namespace App;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class QuocTich extends Model
{
    protected $table ='quoc_tichs';
    protected $fillable = ['ma','ten','trang_thai'];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope());
    }
}
