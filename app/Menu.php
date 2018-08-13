<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'parent_id','router_link', 'fa_icon', 'order', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'active', 'order'
    ];
    
    public $timestamps = false;

    public function children()
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id')
            ->with('children');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_menus', 'menu_id', 'role_id');
    }

    public function parent(){
        return $this->beLongsTo('App\Menu', 'parent_id', 'id');
    }

    public function scopeOfRole($query, $roleId) {
        return $query->whereHas('roles', function ($query) use($roleId){
            $query->where('roles.id', $roleId);
        });
    }

    public function scopeFirstLevel($query) {
        return $query->whereNull('parent_id');
    }
}
