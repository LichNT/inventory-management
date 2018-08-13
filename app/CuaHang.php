<?php

namespace App;

use App\Scopes\CompanyScope;
use App\Scopes\ChiNhanhScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CuaHang extends Model
{
    protected $fillable = [
        'ma_chi_nhanh',
        'id_mien',
        'id_chi_nhanh',
        'ma',
        'ten',
        'ten_dia_diem',
        'ngay_dang_ki_kinh_doanh',
        'ngay_ban_hang',
        'ngay_khai_truong',
        'quoc_gia',
        'tinh_thanh',
        'quan_huyen',
        'phuong_xa',
        'so_nha',
        'nguoi_dai_dien',
        'so_dien_thoai',
        'email',
        'nguoi_lien_he',
        'loai_cua_hang',
        'active',
        'id_tinh',
        'company_id',
        'source_id',
        'lat',
        'long',
        'fax',
        'zip_code'
    ];

    protected $dates = [
        'ngay_dang_ki_kinh_doanh',
        'ngay_ban_hang',
        'ngay_khai_truong',
    ];

    public function setNgayDangKiKinhDoanhAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_dang_ki_kinh_doanh'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_dang_ki_kinh_doanh'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_dang_ki_kinh_doanh'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }

    }



    public function setNgayBanHangAttribute($value) {

        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_ban_hang'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_ban_hang'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_ban_hang'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }

    }

    public function setNgayKhaiTruongAttribute($value) {
        if(!empty($value)) {
            if ($value instanceof Carbon) {
                $this->attributes['ngay_khai_truong'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_khai_truong'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_khai_truong'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }

    }

    public function getNgayKhaiTruongAttribute()
    {
        if(!empty($this->attributes['ngay_khai_truong'])){
            return  Carbon::parse($this->attributes['ngay_khai_truong'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    public function getNgayBanHangAttribute()
    {
        if(!empty($this->attributes['ngay_ban_hang'])){
            return  Carbon::parse($this->attributes['ngay_ban_hang'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    public function getNgayDangKiKinhDoanhAttribute()
    {
        if(!empty($this->attributes['ngay_dang_ki_kinh_doanh'])){
            return  Carbon::parse($this->attributes['ngay_dang_ki_kinh_doanh'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    public function getMaTenAttribute()
    {
        if(!empty($this->attributes['ma']) || !empty($this->attributes['ten'])){
            return $this->attributes['ma'].'-'.$this->attributes['ten'];
        }
        else{
            return null;
        }

    }


    function loaiCuaHang(){
        return $this->belongsTo('App\Lookup', 'loai_cua_hang', 'ma');
    }

    function tinh(){
        return $this->belongsTo('App\ToChuc', 'id_tinh', 'id')->withDefault();
    }

    function chinhanh(){
        return $this->belongsTo('App\ToChuc', 'id_chi_nhanh', 'id')->withDefault();
    }


    function quocGia(){
            return $this->belongsTo('App\QuocTich', 'quoc_gia', 'ma')->withDefault();
        }

    function tinhThanh(){
        return $this->belongsTo('App\TinhThanh', 'tinh_thanh', 'id')->withDefault();
    }

    function quanHuyen(){
        return $this->belongsTo('App\QuanHuyen', 'quan_huyen', 'id')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
        static::addGlobalScope(new ChiNhanhScope);
    }

}
