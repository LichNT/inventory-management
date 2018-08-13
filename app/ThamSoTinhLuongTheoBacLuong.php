<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ThamSoTinhLuongTheoBacLuong extends Model
{
    protected $fillable = [
        'id_chuc_vu',
        'ten',
        'he_so_luong',
        'muc_luong_co_ban',
        'company_id',
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

    public function setMucLuongCoBanAttribute($value) {
        if(empty($value)){
            $this->attributes['muc_luong_co_ban']=null;
        }
        else{
            $this->attributes['muc_luong_co_ban'] = str_replace(',', '', $value);
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

    public function thamSoChucVu(){
        return $this->belongsTo('App\ThamSoTinhLuongTheoChucVu','id_chuc_vu', 'id');
    }

    
}
