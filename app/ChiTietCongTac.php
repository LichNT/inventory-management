<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChiTietCongTac extends Model
{
    protected $fillable=[
        'id_nhan_su',
        'ngay_quyet_dinh',
        'so_quyet_dinh',
        'ngay_hieu_luc',
        'ngay_het_hieu_luc',
        'id_phong_ban_cu',
        'id_phong_ban_moi',
        'id_cua_hang_cu',
        'id_cua_hang_moi',
        'id_chuc_vu_moi',
        'id_chuc_vu_cu',
        'active',
        'id_mien_cu',
        'id_mien_moi',
        'id_chi_nhanh_cu',
        'id_chi_nhanh_moi',
        'id_tinh_moi',
        'id_tinh_cu',
        'id_bo_phan_cu',
        'id_bo_phan_moi',
        'ngay_nhan_shop',
    ];

    protected $dates =[
        'ngay_quyet_dinh',
        'ngay_hieu_luc',
        'ngay_het_hieu_luc'

    ];
    public function setNgayQuyetDinhAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_quyet_dinh'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_quyet_dinh'] = Carbon::createFromTimestamp(($value - 25569) * 86400);
            }
            else{

                $this->attributes['ngay_quyet_dinh'] = Carbon::createFromFormat(config('app.format_date'),$value);

            }
        }
        else{
            $this->attributes['ngay_quyet_dinh']=null;
        }

    }

    public function setNgayHieuLucAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_hieu_luc'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_hieu_luc'] = Carbon::createFromTimestamp(($value - 25569) * 86400);
            }
            else{

                $this->attributes['ngay_hieu_luc'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['ngay_hieu_luc']=null;
        }

    }

    public function setNgayHetHieuLucAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_het_hieu_luc'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_het_hieu_luc'] = Carbon::createFromTimestamp(($value - 25569) * 86400);
            }
            else{

                $this->attributes['ngay_het_hieu_luc'] = Carbon::createFromFormat(config('app.format_date'),$value);

            }
        }
        else{
            $this->attributes['ngay_het_hieu_luc']=null;
        }

    }

    public function getNgayQuyetDinhAttribute()
    {
        if(!empty($this->attributes['ngay_quyet_dinh'])){
            return  Carbon::parse($this->attributes['ngay_quyet_dinh'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    public function getNgayHieuLucAttribute()
    {
        if(!empty($this->attributes['ngay_hieu_luc'])){
            return  Carbon::parse($this->attributes['ngay_hieu_luc'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    public function getNgayHetHieuLucAttribute()
    {
        if(!empty($this->attributes['ngay_het_hieu_luc'])){
            return  Carbon::parse($this->attributes['ngay_het_hieu_luc'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }
    public function setNgayNhanShopAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_nhan_shop'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_nhan_shop'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_nhan_shop'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }
        else
        {
            $this->attributes['ngay_nhan_shop'] = null;
        }
    }

    public function getNgayNhanShopAttribute()
    {
        if(!empty($this->attributes['ngay_nhan_shop'])){
            return  Carbon::parse($this->attributes['ngay_nhan_shop'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function nhan_su()
    {
        return $this->belongsTo('App\NhanSu','id_nhan_su','id')->withDefault();
    }

    public function phong_ban_moi()
    {

        return $this->belongsTo('App\PhongBan','id_phong_ban_moi','id')->withDefault([
            'ten'=>'---'
        ]);
    }

    public function phong_ban_cu()
    {
        return $this->belongsTo('App\PhongBan','id_phong_ban_cu','id')->withDefault();
    }

    public function cua_hang_moi(){
        return $this->belongsTo('App\CuaHang','id_cua_hang_moi','id')->withDefault();
    }

    public function cua_hang_cu(){
        return $this->belongsTo('App\CuaHang','id_cua_hang_cu','id')->withDefault();
    }

    public function chuc_vu_moi(){
        return $this->belongsTo('App\ChucVu','id_chuc_vu_moi','id')->withDefault();
    }

    public function chuc_vu_cu(){
        return $this->belongsTo('App\ChucVu','id_chuc_vu_cu','id')->withDefault();
    }

    public function mien_cu(){
        return $this->belongsTo('App\ToChuc','id_mien_cu','id')->withDefault([
            'ten'=>'---'
        ]);
    }

    public function mien_moi(){
        return $this->belongsTo('App\ToChuc','id_mien_moi','id')->withDefault([
            'ten'=>'---'
        ]);
    }

    public function tinh_cu(){
        return $this->belongsTo('App\ToChuc','id_tinh_cu','id')->withDefault([
            'ten'=>'---'
        ]);
    }

    public function tinh_moi(){
        return $this->belongsTo('App\ToChuc','id_tinh_moi','id')->withDefault([
            'ten'=>'---'
        ]);
    }

    public function chi_nhanh_cu(){
        return $this->belongsTo('App\ToChuc','id_chi_nhanh_cu','id')->withDefault([
            'ten'=>'---'
        ]);
    }

    public function chi_nhanh_moi(){
        return $this->belongsTo('App\ToChuc','id_chi_nhanh_moi','id')->withDefault([
            'ten'=>'---'
        ]);
    }

    public function bo_phan_moi(){
        return $this->belongsTo('App\PhongBan','id_bo_phan_moi','id')->withDefault([
            'ten'=>'---'
        ]);
    }
    public function bo_phan_cu(){
        return $this->belongsTo('App\PhongBan','id_bo_phan_cu','id')->withDefault([
            'ten'=>'---'
        ]);
    }

    

    
}
