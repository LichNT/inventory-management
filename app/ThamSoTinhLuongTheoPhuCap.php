<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ThamSoTinhLuongTheoPhuCap extends Model
{
    protected $fillable = [
        'bac_id',
        'id_loai_phu_cap',
        'so_tien',
        'tu_ngay',
        'den_ngay',
    ];

    public function setTuNgayAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['tu_ngay'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['tu_ngay'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['tu_ngay'] = Carbon::createFromFormat(config('app.format_date'),$value);

            }
        }
        else{
            $this->attributes['tu_ngay']=null;
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


    public function getTuNgayAttribute()
    {
        if(!empty($this->attributes['tu_ngay'])){
            return  Carbon::parse($this->attributes['tu_ngay'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    function loaiPhuCap(){
        return $this->belongsTo('App\LoaiPhuCap', 'id_loai_phu_cap', 'id')->withDefault();
    }

    function thamSoBac(){
        return $this->belongsTo('App\ThamSoTinhLuongTheoBacLuong', 'bac_id', 'id')->withDefault();
    }
}
