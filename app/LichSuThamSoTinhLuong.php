<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LichSuThamSoTinhLuong extends Model
{
    protected $fillable =[
        'ma',
        'ten',
        'gia_tri',
        'tu_ngay',
        'inactive',
        'company_id'
    ];
}
