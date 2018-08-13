<?php

namespace App;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class DanhSachFileImport extends Model
{
    protected $table='danh_sach_file_imports';
    protected $fillable = [
        'name',
        'link',
        'file_id',
        'nguoi_tao',
        'active',
        'company_id',
        'type'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    public function getNgayTaoAttribute($value) {
        if(!empty($value)){
            return date_format(date_create($value),config('app.format_date').' h:m:s');
        }  
    }
    public function setNgayTaoAttribute($value) {
        if(!empty($value)){
            $this->attributes['ngay_tao']=Carbon::createFromFormat(config('app.format_date'),  $value);
        }  
    }
    public function user() {
        return $this->belongsTo('App\User', 'nguoi_tao', 'id');
    }

    public function details() {
        return $this->hasMany('App\ImportNhanSu', 'file_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
    }

    public function detailCuaHangs() {
        return $this->hasMany('App\ImportCuaHang', 'file_id', 'id');
    }
}
