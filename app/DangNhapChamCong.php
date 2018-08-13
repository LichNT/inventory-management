<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DangNhapChamCong extends Model
{
    protected $fillable = [
        'nhan_su_id',
        'token',
        'time_expired',
        'is_blacklist',               
        'device_id',               
    ];

    protected $dates = [
        'time_expired',        
    ];

    public function setNgayDangKiKinhDoanhAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['time_expired'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['time_expired'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['time_expired'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }
    }

    public function getNgayKhaiTruongAttribute()
    {
        if(!empty($this->attributes['time_expired'])){
            return  Carbon::parse($this->attributes['time_expired'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    function nhanSu(){
        return $this->belongsTo('App\NhanSu', 'nhan_su_id', 'id')->withDefault();
    }
}
