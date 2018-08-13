<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class DoanhSoCuaHang extends Model
{
    protected $fillable = [
    'id_cua_hang',
    'thang',
    'nam',
    'ngay_bat_dau',
    'ngay_ket_thuc',
    'muc_tieu_doanh_so',
    'doanh_so_thuc_te',
    'hieu_suat'
    ];

    protected $dates = [
        'ngay_bat_dau',
        'ngay_ket_thuc',
    ];

    public function setNgayBatDauAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_bat_dau'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_bat_dau'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
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
                $this->attributes['ngay_ket_thuc'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['ngay_ket_thuc'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['ngay_ket_thuc']=null;
        }

    }

    public function setMucTieuDoanhSoAttribute($value) {
        if(empty($value)){
            $this->attributes['muc_tieu_doanh_so']=null;
        }
        else{
            $this->attributes['muc_tieu_doanh_so'] = str_replace(',', '', $value);
        }
        if($this->attributes['muc_tieu_doanh_so']&& !empty($this->attributes['doanh_so_thuc_te'])){
            $this->attributes['hieu_suat']=$this->attributes['doanh_so_thuc_te']/$this->attributes['muc_tieu_doanh_so'];
        }
        else{
            $this->attributes['hieu_suat']=null;
        }

    }

    public function setDoanhSoThucTeAttribute($value) {
        if(empty($value)){
            $this->attributes['doanh_so_thuc_te']=null;
        }
        else{
            $this->attributes['doanh_so_thuc_te'] = str_replace(',', '', $value);
        }
        if($this->attributes['muc_tieu_doanh_so']&& !empty($this->attributes['doanh_so_thuc_te'])){
            $this->attributes['hieu_suat']=$this->attributes['doanh_so_thuc_te']/$this->attributes['muc_tieu_doanh_so'];
        }
        else{
            $this->attributes['hieu_suat']=null;
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
