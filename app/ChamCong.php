<?php

namespace App;

use App\Scopes\CompanyScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChamCong extends Model
{
    protected $fillable = [
        'ten',
        'ten_bang',
        'nguoi_tao_id',
        'nguoi_sua_id',
        'thang',
        'nam',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'khoa_so',
        'ngay_khoa_so',
        'duyet_bang_luong',
        'ngay_duyet',
        'trang_thai_tra_luong_lan_1',
        'trang_thai_tra_luong_lan_2',
        'inactive',
        'company_id'
    ];
    protected $dates = ['created_at','updated_at','ngay_khoa_so'];

    public function getCreatedAtAttribute()
    {
        if(!empty($this->attributes['created_at'])){
            return  Carbon::parse($this->attributes['created_at'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    public function setNgayKhoaSoAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_khoa_so'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_khoa_so'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_khoa_so'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }
        else{
            $this->attributes['ngay_khoa_so']=null;
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

    public function getNgayDuyetAttribute()
    {
        if(!empty($this->attributes['ngay_duyet'])){
            return  Carbon::parse($this->attributes['ngay_duyet'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    public function getUpdatedAtAttribute()
    {
        if(!empty($this->attributes['updated_at'])){
            return  Carbon::parse($this->attributes['updated_at'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    function nguoiTao(){
        return $this->belongsTo('App\User', 'nguoi_tao_id', 'id')->withDefault();
    }

    function nguoiSua(){
        return $this->belongsTo('App\User', 'nguoi_sua_id', 'id')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CompanyScope());
    }

}
