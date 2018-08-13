<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Scopes\CompanyScope;
class ThamSoTinhLuong extends Model
{
    protected $fillable = [
        
        'id_chuc_vu',
        'id_loai_hop_dong', 
        'so_tien',  
        'inactive',
        'ngay_hieu_luc',
        'ngay_het_hieu_luc',
        'company_id'  
    ];
    protected $dates = [
        'ngay_hieu_luc',
        'ngay_het_hieu_luc'  
    ];

    public function setNgayHieuLucAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_hieu_luc'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_hieu_luc'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_hieu_luc'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
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
                $this->attributes['ngay_het_hieu_luc'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_het_hieu_luc'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }
        else{
            $this->attributes['ngay_het_hieu_luc']=null;
        }

    }

    public function setSoTienAttribute($value) {
        if(empty($value)){
            $this->attributes['so_tien']=null;
        }
        else{
        $this->attributes['so_tien'] = str_replace(',', '', $value);
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

   public function loaiHopDong()
    {
        return $this->belongsTo('App\LoaiHopDong', 'id_loai_hop_dong', 'id')->withDefault();
    }

    public function chucVu()
    {
        return $this->belongsTo('App\ChucVu', 'id_chuc_vu', 'id')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());        
    }
}
