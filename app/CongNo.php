<?php

namespace App;

use App\Scopes\CompanyScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CongNo extends Model
{
    protected $fillable =['id_nhan_su','thang_nam','so_tien','noi_dung','inactive','company_id'];
    protected $dates =['thang_nam'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
    }

    public function nhanSu() {
        return $this->belongsTo('App\NhanSu', 'id_nhan_su', 'id');
    }

    public function setThangNamAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['thang_nam'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['thang_nam'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfMonth();
            }
            else{

                $this->attributes['thang_nam'] = Carbon::createFromFormat(config('app.format_month'),$value)->startOfMonth();

            }
        }
        else{
            $this->attributes['thang_nam']=null;
        }

    }

    public function getThangNamAttribute()
    {
        if(!empty($this->attributes['thang_nam'])){
            return  Carbon::parse($this->attributes['thang_nam'])->format(config('app.format_month'));
        }
        else{
            return null;
        }

    }
}
