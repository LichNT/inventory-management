<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\ChiNhanhScope;
class TheoDoiHopDong extends Model
{
    protected $table = 'theo_doi_hop_dongs';

    protected $fillable = [
        'id_nhan_su',
        'loai_hop_dong',
        'so_quyet_dinh',
        'ngay_hieu_luc',
        'ngay_het_hieu_luc',
        'ngay_quyet_dinh',
        'trang_thai',
        'id_chuc_vu'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'ngay_hieu_luc',
        'ngay_het_hieu_luc',
        'ngay_quyet_dinh',
    ];

    public function setNgayHieuLucAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_hieu_luc'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_hieu_luc'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['ngay_hieu_luc'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
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
                $this->attributes['ngay_het_hieu_luc'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['ngay_het_hieu_luc'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['ngay_het_hieu_luc']=null;
        }

    }

    public function setNgayQuyetDinhAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_quyet_dinh'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_quyet_dinh'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{
                
                $this->attributes['ngay_quyet_dinh'] = Carbon::createFromFormat(config('app.format_date'),$value);
               
            }
        }
        else{
            $this->attributes['ngay_quyet_dinh']=null;
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
    
    public function getNgayQuyetDinhAttribute()
    {
        if(!empty($this->attributes['ngay_quyet_dinh'])){
            return  Carbon::parse($this->attributes['ngay_quyet_dinh'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function nhanSu()
    {
        return $this->belongsTo('App\NhanSu', 'id_nhan_su', 'id');
    }

    public function loaiHopDong()
    {
        return $this->belongsTo('App\LoaiHopDong', 'loai_hop_dong', 'id')->withDefault();
    }

    public function chucVu()
    {
        return $this->belongsTo('App\ChucVu', 'id_chuc_vu', 'id')->withDefault();
    }


    public function hopDongChucVu(){
        return $this->belongsTo('App\HopDongChucVu','loai_hop_dong','id_loai_hop_dong')->where('id_chuc_vu',empty($this->id_chuc_vu)?null:$this->id_chuc_vu)
        ->withDefault();
    }
}
