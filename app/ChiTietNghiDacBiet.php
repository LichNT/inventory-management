<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChiTietNghiDacBiet extends Model
{
    protected $fillable = ['id_nhan_su', 'id_loai_nghi_dac_biet','ngay_bat_dau','ngay_ket_thuc','trang_thai'];

    protected $dates = [
        'ngay_bat_dau',
        'ngay_ket_thuc',
    ];

    public function loainghidacbiet(){
        return $this->belongsTo('App\LoaiNghiDacBiet','id_loai_nghi_dac_biet','id');
    }

    public function setNgayBatDauAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_bat_dau'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_bat_dau'] = Carbon::createFromTimestamp(($value - 25569) * 86400);
            }
            else{
                $this->attributes['ngay_bat_dau'] = Carbon::createFromFormat(config('app.format_date'),$value);

            }
        }
        else{
            $this->attributes['ngay_bat_dau']=null;
        }

    }

    public function setNgayKetThucAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_ket_thuc'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_ket_thuc'] = Carbon::createFromTimestamp(($value - 25569) * 86400);
            }
            else{

                $this->attributes['ngay_ket_thuc'] = Carbon::createFromFormat(config('app.format_date'),$value);
            }
        }
        else{
            $this->attributes['ngay_ket_thuc']=null;
        }

    }

    public function getNgayBatDauAttribute()
    {
        if(!empty($this->attributes['ngay_bat_dau'])){
            return  Carbon::parse($this->attributes['ngay_bat_dau'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
    }

    public function getNgayKetThucAttribute()
    {
        if(!empty($this->attributes['ngay_ket_thuc'])){
            return  Carbon::parse($this->attributes['ngay_ket_thuc'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

}
