<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ChiTietBaoLanh extends Model
{
    protected $fillable = [
        'id_nhan_su',
        'so_tien',
        'ngay_thang',
        'loai',
        ];

    public function setSoTienAttribute($value) {
        if(empty($value)){
            $this->attributes['so_tien']=null;
        }
        else{
            
            $this->attributes['so_tien'] = str_replace(',', '', $value);
            
        }
        
    }

    public function setNgayThangAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_thang'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_thang'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_thang'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }
        else{
            $this->attributes['ngay_thang']=null;
        }

    }

    public function getNgayThangAttribute()
    {
        if(!empty($this->attributes['ngay_thang'])){
            return  Carbon::parse($this->attributes['ngay_thang'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }
}
