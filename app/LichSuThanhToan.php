<?php

namespace App;

use App\Scopes\CompanyScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LichSuThanhToan extends Model
{
    protected $fillable = [
        'so_tien',
        'id_nhan_su',
        'noi_dung',
        'ngay_giao_dich',
        'company_id'
    ];

    protected $dates = ['ngay_giao_dich'];

    public function nhanSu(){
        return $this->belongsTo('App\NhanSu','id_nhan_su')->withDefault();
    }

    public function setNgayGiaoDichAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_giao_dich'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_giao_dich'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_giao_dich'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }
        else{
            $this->attributes['ngay_giao_dich']=null;
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

    public function getNgayGiaoDichAttribute()
    {
        if(!empty($this->attributes['ngay_giao_dich'])){
            return  Carbon::parse($this->attributes['ngay_giao_dich'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
    }
}
