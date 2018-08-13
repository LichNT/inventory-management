<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportCuaHang extends Model
{
    protected $table='import_cua_hangs';

    protected $fillable = [
        'file_id',
        'ma',
        'ten',
        'ten_dia_diem',
        'dia_chi',
        'quoc_gia',
        'so_dien_thoai',
        'fax',
        'zip-code',
        'ten_chi_nhanh',
        'id_tinh',
        'ngay_dang_ki_kinh_doanh',
        'ngay_khai_truong',
        'ngay_ban_hang',
        'nguoi_dai_dien',
        'nguoi_lien_he',
        'nguoi_cap_nhat',
        'nguoi_tao',
        'active',
        'mo_ta',
        'company_id',

    ];

    function chiNhanh(){
        return $this->belongsTo('App\ToChuc', 'ten_chi_nhanh', 'id')->withDefault();
    }

    function tinh(){
        return $this->belongsTo('App\ToChuc', 'id_tinh', 'id')->withDefault();
    }
}
