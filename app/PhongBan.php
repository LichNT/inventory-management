<?php

namespace App;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\TrangThaiScope;

class PhongBan extends Model
{
    protected $fillable = [
        'id',
        'ma',
        'ten',
        'trang_thai',
        'loai_phong_ban_id',
        'so_dien_thoai',
        'email',
        'nguoi_lien_he',
        'parent_id',
        'company_id',
        'to_chuc_id'
    ];

    public function loai_phong_ban(){
        return $this->belongsTo('App\LoaiPhongBan','loai_phong_ban_id','id')->withDefault();
    }
    
    public function myParent(){
        return $this->beLongsTo('App\PhongBan', 'parent_id', 'id')->withDefault();
    }

    public function childs() {
        return $this->hasMany('App\PhongBan','parent_id','id');
    }

    public function tinhs() {
        return $this->hasMany('App\CuaHang','id_tinh','id');
    }

    public function nhansus() {
        return $this->hasMany('App\NhanSu','id_phong_ban','id');
    }

    public function bophannhansus() {
        return $this->hasMany('App\NhanSu','id_bo_phan','id');
    }


    public function toChuc() {
        return $this->beLongsTo('App\ToChuc','to_chuc_id','id')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
        static::addGlobalScope(new TrangThaiScope());
    }

}

