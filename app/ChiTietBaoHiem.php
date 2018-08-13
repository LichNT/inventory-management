<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ChiTietBaoHiem extends Model
{
    protected $fillable = [
    'id_nhan_su',
    'ten',
    'thang_bat_dau',
    'thang_chuyen_bao_hiem_ve_chi_nhanh',
    'thang_dung_dong_bao_hiem',
    'muc_dong_bao_hiem_xa_hoi',
    'tu_ngay',
    'toi_ngay',
    'muc_dong_bao_hiem_id',
    'id_tinh_thanh'
    ];
    protected $dates = [
    'thang_bat_dau',
    'thang_chuyen_bao_hiem_ve_chi_nhanh',
    'thang_dung_dong_bao_hiem',
    'tu_ngay',
    'toi_ngay'
];
    public function setThangBatDauAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['thang_bat_dau'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['thang_bat_dau'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['thang_bat_dau'] = Carbon::createFromFormat(config('app.format_month'),$value)->startOfMonth();
               
            }
        }
        else{
            $this->attributes['thang_bat_dau']=null;
        }

    }

    public function setThangChuyenBaoHiemVeChiNhanhAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['thang_chuyen_bao_hiem_ve_chi_nhanh'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['thang_chuyen_bao_hiem_ve_chi_nhanh'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['thang_chuyen_bao_hiem_ve_chi_nhanh'] = Carbon::createFromFormat(config('app.format_month'),$value)->startOfMonth();
                
            }
        }
        else{
            $this->attributes['thang_chuyen_bao_hiem_ve_chi_nhanh']=null;
        }
    }

    public function setThangDungDongBaoHiemAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['thang_dung_dong_bao_hiem'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['thang_dung_dong_bao_hiem'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                $this->attributes['thang_dung_dong_bao_hiem'] = Carbon::createFromFormat(config('app.format_month'),$value)->startOfMonth();
            }
        }
        else{
            $this->attributes['thang_dung_dong_bao_hiem'] =null;
        }

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
                $this->attributes['tu_ngay'] = Carbon::createFromFormat(config('app.format_date'),$value);
            }
        }
        else{
            $this->attributes['tu_ngay'] = null;
        }
    }

    public function setToiNgayAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['toi_ngay'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['toi_ngay'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                $this->attributes['toi_ngay'] = Carbon::createFromFormat(config('app.format_date'),$value);
            }
        }
        else{
            $this->attributes['toi_ngay']=null;
        }

    }

    public function setMucDongBaoHiemXaHoiAttribute($value) {
        if(empty($value)){
            $this->attributes['muc_dong_bao_hiem_xa_hoi']=null;
        }
        else{
        $this->attributes['muc_dong_bao_hiem_xa_hoi'] = str_replace(',', '', $value);
        }
    }

    public function getMucDongBaoHiemXaHoiAttribute($value) {
        if(empty($value)){
            return null;
        }
        else{
            return number_format($value);
        }
    }

    public function getThangBatDauAttribute()
    {
        if(!empty($this->attributes['thang_bat_dau'])){
            return  Carbon::parse($this->attributes['thang_bat_dau'])->format(config('app.format_month'));
        }
        else{
            return null;
        }
        
    }

    public function getThangChuyenBaoHiemVeChiNhanhAttribute()
    {
        if(!empty($this->attributes['thang_chuyen_bao_hiem_ve_chi_nhanh'])){
            return  Carbon::parse($this->attributes['thang_chuyen_bao_hiem_ve_chi_nhanh'])->format(config('app.format_month'));
        }
        else{
            return null;
        }
        
    }

    public function getThangDungDongBaoHiemAttribute()
    {
        if(!empty($this->attributes['thang_dung_dong_bao_hiem'])){
            return  Carbon::parse($this->attributes['thang_dung_dong_bao_hiem'])->format(config('app.format_month'));
        }
        else{
            return null;
        }
        
    }

    public function getTuNgayAttribute()
    {
        if(!empty($this->attributes['tu_ngay'])){
            return  Carbon::parse($this->attributes['tu_ngay'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getToiNgayAttribute()
    {
        if(!empty($this->attributes['toi_ngay'])){
            return  Carbon::parse($this->attributes['toi_ngay'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }


    public function nhanSu()
    {
        return $this->belongsTo('App\NhanSu', 'id_nhan_su', 'id')->withDefault();
    }

    public function tinhThanh()
    {
        return $this->belongsTo('App\TinhThanh', 'id_tinh_thanh', 'id')->withDefault();
    }

    public function mucDongBaoHiem()
    {
        return $this->belongsTo('App\MucDongBaoHiem', 'muc_dong_bao_hiem_id', 'id')->withDefault();
    }
}
