<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhat extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id_nhan_su',
        'id_loai_phat',
        'so_tien',
        'ngay'
        ];
    protected $dates = ['ngay'];

    public function setNgayAttribute($value) {

        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }

    }

    public function getNgayAttribute()
    {
        if(!empty($this->attributes['ngay'])){
            return  Carbon::parse($this->attributes['ngay'])->format(config('app.format_date'));
        }
        else{
            return null;
        }

    }

    function loaiPhat(){
        return $this->belongsTo('App\LoaiPhat', 'id_loai_phat', 'id')->withDefault();
    }

    function nhanSu(){
        return $this->belongsTo('App\NhanSu', 'id_nhan_su', 'id')->withDefault();
    }
}
