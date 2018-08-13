<?php

namespace App;

use App\Scopes\CompanyScope;
use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class LoaiPhat extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'ten',
        'so_tien',
        'mo_ta',
        'inactive',
        'company_id'
    ];
    public function setSoTienAttribute($value) {
        if(empty($value)){
            $this->attributes['so_tien']=null;
        }
        else{
            
            $this->attributes['so_tien'] = str_replace(',', '', $value);
        }
       
        
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
        static::addGlobalScope(new OrderByScope());
    }

}
