<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\LookupScope;
class Lookup extends Model
{
    protected $table='lookup';

    public $timestamps=false;

    protected $fillable = [
        'ma', 'ten', 'loai', 'active','company_id'
    ];
    
    public function type_lookup() {
        return $this->belongsTo('App\Lookup', 'loai', 'ma');
    }

    
}
