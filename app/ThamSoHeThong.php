<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\CompanyScope;

class ThamSoHeThong extends Model
{
    protected $table = 'tham_so_he_thongs';
    protected $fillable = [
        'tong_quy_luong',
        'giam_tru_ban_than',
        'giam_tru_phu_thuoc',
        'BHXH_DN',
        'BHXH_NLD',
        'BHYT_DN',
        'BHYT_NLD',
        'BHTN_DN',
        'BHTN_NLD',
        'ngay_nghi_le',
        'company_id',
        'luong_lam_them_gio_ngay_thuong',
        'luong_lam_them_gio_ngay_le',
        'luong_lam_them_gio_ngay_nghi',
    ];

    public function setTongQuyLuongAttribute($value) {
        if(empty($value)){
            $this->attributes['tong_quy_luong']=null;
        }
        else{
            $this->attributes['tong_quy_luong'] = str_replace(',', '', $value);
        }
        
    }

    public function setGiamTruBanThanAttribute($value) {
        if(empty($value)){
            $this->attributes['giam_tru_ban_than']=null;
        }
        else{
            $this->attributes['giam_tru_ban_than'] = str_replace(',', '', $value);
        }
        
    }

    public function setGiamTruPhuThuocAttribute($value) {
        if(empty($value)){
            $this->attributes['giam_tru_phu_thuoc']=null;
        }
        else{
            $this->attributes['giam_tru_phu_thuoc'] = str_replace(',', '', $value);
        }
        
    }

   
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());        
    }

}
