<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
   
    protected $fillable = [
        'role_id', 'menu_id', 'home_router'
    ];
    
    public $timestamps = false;

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function menu(){
        return $this->belongsTo('App\Menu');
    }
}
