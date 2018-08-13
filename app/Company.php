<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['code', 'name', 'active', 'parent_id'];

    public function parent(){
        return $this->beLongsTo('App\Company', 'parent_id', 'id');
    }

    public function childs() {
        return $this->hasMany('App\Company','parent_id','id') ;
    }
}
