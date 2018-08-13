<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ThamSoTinhLuongTheoChucVu extends Model
{
    protected $fillable = [
        'ma',
        'ten',
        'trang_thai',
        'company_id',
        'so_tien_hoc_viec_theo_ngay',
        'so_ngay_nghi_trong_thang',
        'so_gio_quy_dinh',
        'tu_ngay',
        'so_tien_bao_lanh',
        'so_thang',
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

    public function setSoTienHocViecTheoNgayAttribute($value) {
        if(empty($value)){
            $this->attributes['so_tien_hoc_viec_theo_ngay']=null;
        }
        else{
            $this->attributes['so_tien_hoc_viec_theo_ngay'] = str_replace(',', '', $value);
        }
        
    }

    public function setSoTienBaoLanhAttribute($value) {
        if(empty($value)){
            $this->attributes['so_tien_bao_lanh']=null;
        }
        else{
            $this->attributes['so_tien_bao_lanh'] = str_replace(',', '', $value);
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
}
