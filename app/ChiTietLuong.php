<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChiTietLuong extends Model
{
    protected $fillable = [
        'nhan_su_id',
        'ngay_huong_luong',
        'so_quyet_dinh',
        'ngay_ky',
        'ngach_id',
        'bac_id',
        'he_so_luong',
        'he_so_phu_cap_chuc_vu',
        'he_so_phu_cap_doc_hai',
        'dien_dai',
        'luong_co_ban',
        'tien_phu_cap',
        'inactive'
    ];
    protected $dates = [
        'ngay_huong_luong',
        'ngay_ky'
    ];

    

    function bacLuong(){
        return $this->belongsTo('App\Bac', 'bac_id', 'id')->withDefault();
    }

    public function setHeSoPhuCapChucVuAttribute($value) {
        if(!empty($value)){
            $this->attributes['he_so_phu_cap_chuc_vu']=floatval($value);
        }
        else{
            $this->attributes['he_so_phu_cap_chuc_vu']=null;
        }

    }

    public function setHeSoPhuCapDocHaiAttribute($value) {
        if(!empty($value)){
            $this->attributes['he_so_phu_cap_doc_hai']=floatval($value);
        }
        else{
            $this->attributes['he_so_phu_cap_doc_hai']=null;
        }

    }

    public function setNgayHuongLuongAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_huong_luong'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_huong_luong'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                $this->attributes['ngay_huong_luong'] = Carbon::createFromFormat(config('app.format_date'),$value);
            }
        }
        else{
            $this->attributes['ngay_huong_luong']=null;
        }

    }

    public function setNgayKyAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_ky'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_ky'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                $this->attributes['ngay_ky'] = Carbon::createFromFormat(config('app.format_date'),$value);
            }
        }
        else{
            $this->attributes['ngay_ky']=null;
        }

    }

    public function getNgayKyAttribute()
    {
        if(!empty($this->attributes['ngay_ky'])){
            return  Carbon::parse($this->attributes['ngay_ky'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }
    public function getNgayHuongLuongAttribute()
    {
        if(!empty($this->attributes['ngay_huong_luong'])){
            return  Carbon::parse($this->attributes['ngay_huong_luong'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

}
