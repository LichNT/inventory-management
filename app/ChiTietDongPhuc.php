<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ChiTietDongPhuc extends Model
{
    protected $fillable=[
        'id_nhan_su',
        'nguoi_tao_id',
        'nguoi_sua_id',
        'so_luong',
        'id_size',
        'huy_dang_ky',
        'ngay_bao_huy',
        'da_phat',
        'ngay_phat',
        'hoan_tra',
        'ngay_hoan',
        'id_trang_thai_dong_phuc',
        'ngay_cap_nhat',
        'hong',
        'ngay_bao_hong',        
    ];

    protected $dates = [
        'ngay_bao_huy',
        'ngay_phat',
        'ngay_hoan',
        'tu_ngay',
        'ngay_bao_hong',
        'ngay_cap_nhat'
    ];


    public function setNgayBaoHuyAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_bao_huy'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_bao_huy'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['ngay_bao_huy'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['ngay_bao_huy']=null;
        }

    }

    public function setNgayCapNhatAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_cap_nhat'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_cap_nhat'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{

                $this->attributes['ngay_cap_nhat'] = Carbon::createFromFormat(config('app.format_date'),$value);

            }
        }
        else{
            $this->attributes['ngay_cap_nhat']=null;
        }

    }

    public function setNgayPhatAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_phat'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_phat'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['ngay_phat'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['ngay_phat']=null;
        }

    }

    public function setNgayHoanAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_hoan'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_hoan'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{

                $this->attributes['ngay_hoan'] = Carbon::createFromFormat(config('app.format_date'),$value);

            }
        }
        else{
            $this->attributes['ngay_hoan']=null;
        }

    }


    public function setNgayBaoHongAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_bao_hong'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_bao_hong'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['ngay_bao_hong'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['ngay_bao_hong']=null;
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
            $this->attributes['tu_ngay']=null;
        }

    }

    public function getNgayBaoHuyAttribute()
    {
        if(!empty($this->attributes['ngay_bao_huy'])){
            return  Carbon::parse($this->attributes['ngay_bao_huy'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getNgayPhatAttribute()
    {
        if(!empty($this->attributes['ngay_phat'])){
            return  Carbon::parse($this->attributes['ngay_phat'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getNgayHoanAttribute()
    {
        if(!empty($this->attributes['ngay_hoan'])){
            return  Carbon::parse($this->attributes['ngay_hoan'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getNgayBaoHongAttribute()
    {
        if(!empty($this->attributes['ngay_bao_hong'])){
            return  Carbon::parse($this->attributes['ngay_bao_hong'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getNgayCapNhatAttribute()
    {
        if(!empty($this->attributes['ngay_cap_nhat'])){
            return  Carbon::parse($this->attributes['ngay_cap_nhat'])->format(config('app.format_date'));
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

    public function nhanSu(){
        return $this->belongsTo('App\NhanSu','id_nhan_su','id');
    }

    public function size(){
        return $this->belongsTo('App\Lookup','id_size','id')->withDefault();
    }

    public function trangThaiDongPhuc(){
        return $this->belongsTo('App\Lookup','id_trang_thai_dong_phuc','id')->withDefault();
    }

    public function nguoi_tao(){
        return $this->belongsTo('App\User','nguoi_tao_id','id');
    }

    public function nguoi_sua(){
        return $this->belongsTo('App\User','nguoi_sua_id','id');
    }
}
