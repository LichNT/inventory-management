<?php

namespace App;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LoaiToChuc extends Model
{
    protected $fillable = [
        'ten', 
        'ma', 
        'mo_ta', 
        'company_id', 
        'inactive',        
    ];  
    public $timestamps = false;

    public function getTenAttribute()
    {
        $user = Auth::user();
        if(!empty($this->attributes['ten'])){
            if($user['company_id']==4&&$this->attributes['ten']=='Chi Nhánh'){
                return "Khu vực";
            }
            else return $this->attributes['ten'];
        }
        else{
            return $this->attributes['ten'];
        }
    }

    function configToChuc(){
        return $this->hasOne('App\ConfigToChuc', 'id_loai_to_chuc', 'id')
            ->where('company_id',Auth::user()->company_id)->withDefault();
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope());
    }
}
