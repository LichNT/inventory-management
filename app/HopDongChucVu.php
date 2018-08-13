<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HopDongChucVu extends Model
{
    public $timestamps = false;
    protected $fillable= [
        'id_loai_hop_dong',
        'id_chuc_vu'
    ];

    public function loaihopdong(){
        return $this->belongsTo('App\LoaiHopDong','id_loai_hop_dong', 'id')->withDefault();
    }

    public function chucvu(){
        return $this->belongsTo('App\ChucVu','id_chuc_vu', 'id')->withDefault();
    }

    public function attachment()
    {
        return $this->hasMany('App\Attachment','reference_id','id')
            ->where('reference_type','hop_dong_chuc_vu');
    }
}
