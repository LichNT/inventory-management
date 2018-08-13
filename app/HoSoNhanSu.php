<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoSoNhanSu extends Model
{
    protected $fillable = [
        'id_nhan_su',
        'file_name',
        'file_id',
        'id_type',
        'link'
        
        ];

    public function loaiHoSo(){
        return $this->belongsTo('App\Lookup','id_type','id');
    }
}
