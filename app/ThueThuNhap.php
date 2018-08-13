<?php

namespace App;

use App\Scopes\CompanyScope;
use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class ThueThuNhap extends Model
{
    protected $fillable = ['ten','can_duoi','can_tren','thue_suat','tru_bot','company_id'];
    public $timestamps =false;
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }

    public function setCanTrenAttribute($value) {
        if(empty($value)){
            $this->attributes['can_tren']=null;
        }
        else{
        $this->attributes['can_tren'] = str_replace(',', '', $value);
        }
    }

}
