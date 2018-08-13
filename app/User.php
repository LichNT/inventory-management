<?php

namespace App;
use App\Scopes\CompanyScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'avatar_url', 'active', 'role_id','company_id','id_chi_nhanh','id_mien'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatarUrlAttribute()
    {
        if(empty($this->attributes['avatar_url'])){
            return "images/defaults/avatar.png";
        }

        return $this->attributes['avatar_url'];
    }

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function company(){
        return $this->belongsTo('App\Company','company_id','id')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();       
    }
    
    protected $dates = [
        'created_at',
        'updated_at',        
    ];

    function chinhanh(){
        return $this->belongsTo('App\ToChuc', 'id_chi_nhanh', 'id')->withDefault();
    }

    function mien(){
        return $this->belongsTo('App\ToChuc', 'id_mien', 'id')->withDefault();
    }


    public function setUserNameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    public function getUserNameAttribute($value)
    {
        return strtolower($value);
    }
}
