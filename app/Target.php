<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;

class Target extends Model
{
    protected $fillable = [
        'id_cua_hang',
        'id_loai_target',
        'so_tien',
        'tu_ngay',
        'company_id'
    ];

    protected $dates =['tu_ngay'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }

    public function cuaHang() {
        return $this->belongsTo('App\CuaHang', 'id_cua_hang', 'id');
    }

    public function loaiTarget() {
        return $this->belongsTo('App\LoaiTarget', 'id_loai_target', 'id');
    }

    public function setTuNgayAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['tu_ngay'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['tu_ngay'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{

                $this->attributes['tu_ngay'] = Carbon::createFromFormat(config('app.format_month'),$value)->startOfMonth();

            }
        }
        else{
            $this->attributes['tu_ngay']=null;
        }

    }

    public function getTuNgayAttribute()
    {
        if(!empty($this->attributes['tu_ngay'])){
            return  Carbon::parse($this->attributes['tu_ngay'])->format(config('app.format_month'));
        }
        else{
            return null;
        }

    }
}
