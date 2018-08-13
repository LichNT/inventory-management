<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ChamCongCuaHang extends Model
{
    protected $fillable = [
        'ma',
        'nguoi_tao_id',
        'nguoi_sua_id',
        'thang',
        'nam',
        'nhan_su_id',
        'cua_hang_id',
        'ma_the_cham_cong',
        'so_gio_lam',
        'do_hieu_qua',
        'don_gia_gio_lam',
        'lat_check_in',
        'long_check_in',
        'long_check_out',
        'lat_check_out',        
        'dia_chi',
        'huyen',
        'tinh',
        'cmnd',
        'hop_le',
        'device_id',
        'duong_dan_anh_check_in',
        'duong_dan_anh_check_out',
        'thoi_gian_check_in',
        'thoi_gian_check_out',
        'checked_out',
        'huy',
        'het_han_check_out',
        'khoa_so',
        'ngay_khoa_so',
        'ghi_chu',
        'khoang_cach_check_in',
        'khoang_cach_check_out',
        'cua_hang_lat',
        'cua_hang_long',
        'warning'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'ngay_khoa_so',  
        'thoi_gian_check_in',
        'thoi_gian_check_out',
        'het_han_check_out',
    ];

    public function setNgayKhoaSoAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_khoa_so'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_khoa_so'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{                
                $this->attributes['ngay_khoa_so'] = Carbon::createFromFormat(config('app.format_date'),$value);               
            }
        }
        else{
            $this->attributes['ngay_khoa_so'] = null;
        }
    }

    public function setHetHanCheckOutAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['het_han_check_out'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['het_han_check_out'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{                
                $this->attributes['het_han_check_out'] = Carbon::createFromFormat(config('app.format_datetime'),$value);               
            }
        }
        else{
            $this->attributes['het_han_check_out'] = null;
        }
    }

    public function setThoiGianCheckInAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['thoi_gian_check_in'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['thoi_gian_check_in'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{                
                $this->attributes['thoi_gian_check_in'] = Carbon::createFromFormat(config('app.format_datetime'), $value);               
            }
        }
        else{
            $this->attributes['thoi_gian_check_in'] = null;
        }
    }

    public function setThoiGianCheckOutAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['thoi_gian_check_out'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['thoi_gian_check_out'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{                
                $this->attributes['thoi_gian_check_out'] = Carbon::createFromFormat(config('app.format_datetime'),$value);               
            }
        }
        else{
            $this->attributes['thoi_gian_check_out'] = null;
        }
    }

    public function getNgayKhoaSoAttribute()
    {
        if(!empty($this->attributes['ngay_khoa_so'])){
            return  Carbon::parse($this->attributes['ngay_khoa_so'])->format(config('app.format_date'));
        }
        else{
            return null;
        }        
    }
    
    public function getThoiGianCheckInAttribute()
    {
        if(!empty($this->attributes['thoi_gian_check_in'])){
            return  Carbon::parse($this->attributes['thoi_gian_check_in'])->format(config('app.format_datetime'));
        }
        else{
            return null;
        }        
    }

    public function getThoiGianCheckOutAttribute()
    {
        if(!empty($this->attributes['thoi_gian_check_out'])){
            return  Carbon::parse($this->attributes['thoi_gian_check_out'])->format(config('app.format_datetime'));
        }
        else{
            return null;
        }        
    }

    public function getHetHanCheckOutAttribute()
    {
        if(!empty($this->attributes['het_han_check_out'])){
            return  Carbon::parse($this->attributes['het_han_check_out'])->format(config('app.format_datetime'));
        }
        else{
            return null;
        }        
    }

    function cuaHang(){
        return $this->belongsTo('App\CuaHang', 'cua_hang_id', 'id')->withDefault();
    }

    function nhanSu(){
        return $this->belongsTo('App\NhanSu', 'nhan_su_id', 'id')->withDefault();
    }
}
