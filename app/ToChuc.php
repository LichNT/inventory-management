<?php

namespace App;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ActiveScope;
use App\Scopes\CompanyScope;
use App\Scopes\ToChucScope;

class ToChuc extends Model
{
    protected $fillable = [
        'ten', 
        'ma', 
        'so_dien_thoai', 
        'email', 
        'nguoi_lien_he', 
        'mo_ta', 
        'company_id', 
        'parent_id', 
        'loai_to_chuc_id', 
        'inactive',        
    ];

    function loaiToChuc(){
        return $this->belongsTo('App\LoaiToChuc', 'loai_to_chuc_id', 'id')->withDefault();
    }

    function parent(){
        return $this->belongsTo('App\ToChuc', 'parent_id', 'id')->withDefault();
    }

    public function childs() {
        return $this->hasMany('App\ToChuc','parent_id','id');
    }

    public function cuahangs() {
        return $this->hasMany('App\CuaHang','id_chi_nhanh','id');
    }

    public function nhanSuChiNhanh() {
        return $this->hasMany('App\NhanSu','id_chi_nhanh','id');
    }

    public function nhanSuTinh() {
        return $this->hasMany('App\NhanSu','id_tinh','id');
    }




    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope);

        static::addGlobalScope(new CompanyScope());    
        static::addGlobalScope(new ToChucScope());     
        static::addGlobalScope(new OrderByScope());
    }
}
