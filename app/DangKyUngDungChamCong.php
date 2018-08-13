<?php

namespace App;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DangKyUngDungChamCong extends Model
{
  

    protected $fillable = [
        'ho_ten',
        'ngay_sinh',
        'cmnd',
        'ma',
        'so_dien_thoai',
        'email',        
        'company_id',
        'id_mien',
        'id_chi_nhanh',
        'id_tinh',
        'id_cua_hang',
        'inactive',
        'created',
        'ma_the_cham_cong',
        'nguoi_sua_id',        
    ];
    protected $dates = [
        'ngay_sinh',
        
    ];
    public function setNgaySinhAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_sinh'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_sinh'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_sinh'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }
    }

    public function getNgaySinhAttribute()
    {
        if(!empty($this->attributes['ngay_sinh'])){
            return  Carbon::parse($this->attributes['ngay_sinh'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    function mien(){
        return $this->belongsTo('App\ToChuc', 'id_mien', 'id')->withDefault();
    }

    function tinh(){
        return $this->belongsTo('App\ToChuc', 'id_tinh', 'id')->withDefault();
    }

    function chinhanh(){
        return $this->belongsTo('App\ToChuc', 'id_chi_nhanh', 'id')->withDefault();
    }
    function cuaHang(){
        return $this->belongsTo('App\CuaHang', 'id_cua_hang', 'id')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope);
    }

}
