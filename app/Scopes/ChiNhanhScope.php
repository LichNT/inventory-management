<?php
namespace App\Scopes;
use Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ChiNhanhScope implements Scope
{
    
    public function apply(Builder $builder, Model $model)
    {
        $user=Auth::user();
       
        if(!empty(Auth::user()->id_chi_nhanh)){
            $builder->where('id_chi_nhanh', Auth::user()->id_chi_nhanh);
        }
        
    }
}