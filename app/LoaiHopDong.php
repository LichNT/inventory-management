<?php

namespace App;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;
class LoaiHopDong extends Model
{
    protected $fillable = ['ma', 'ten', 'trang_thai','company_id'];

    public function attachment()
    {
        return $this->hasMany('App\Attachment','reference_id','id')
        ->where('reference_type','loai_hop_dong');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
        static::addGlobalScope(new OrderByScope());
    }
}
