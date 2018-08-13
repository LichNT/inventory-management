<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChiTietGiamTruGiaCanh extends Model
{
    protected $fillable = [
        'id_nhan_su',
        'ho_ten',
        'ngay_sinh',
        'gioi_tinh',
        'quan_he',
        'cmnd',
        'thoi_diem_bat_dau',
        'thoi_diem_ket_thuc',
        'ma_so_thue'
        ];
        protected $dates = [
        'ngay_sinh',
        'thoi_diem_bat_dau',
        'thoi_diem_ket_thuc',
    ];

    public function setNgaySinhAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_sinh'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_sinh'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['ngay_sinh'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['ngay_sinh']=null;
        }

    }

    public function setThoiDiemBatDauAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['thoi_diem_bat_dau'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['thoi_diem_bat_dau'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['thoi_diem_bat_dau'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['thoi_diem_bat_dau']=null;
        }

    }

    public function setThoiDiemKetThucAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['thoi_diem_ket_thuc'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['thoi_diem_ket_thuc'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['thoi_diem_ket_thuc'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['thoi_diem_ket_thuc']=null;
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

    
    public function getThoiDiemBatDauAttribute()
    {
        if(!empty($this->attributes['thoi_diem_bat_dau'])){
            return  Carbon::parse($this->attributes['thoi_diem_bat_dau'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getThoiDiemKetThucAttribute()
    {
        if(!empty($this->attributes['thoi_diem_ket_thuc'])){
            return  Carbon::parse($this->attributes['thoi_diem_ket_thuc'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    
}
