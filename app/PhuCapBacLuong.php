<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhuCapBacLuong extends Model
{
    public $timestamps = false;
    protected $fillable = ['bac_id','id_loai_phu_cap','so_tien'];

    public function setSoTienAttribute($value) {
        if(empty($value)){
            $this->attributes['so_tien']=null;
        }
        else{
        $this->attributes['so_tien'] = str_replace(',', '', $value);
        }
    }
    
    function loaiPhuCap(){
        return $this->belongsTo('App\LoaiPhuCap', 'id_loai_phu_cap', 'id')->withDefault();
    }

    public function bac(){
        return $this->belongsTo('App\Bac','bac_id', 'id');
    }
}
