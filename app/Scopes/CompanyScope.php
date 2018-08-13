<?php
namespace App\Scopes;
use Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CompanyScope implements Scope
{
    
    public function apply(Builder $builder, Model $model)
    {
        if(!empty(Auth::user()->company_id)){
            $builder->where('company_id', Auth::user()->company_id);
        }
       
    }
}