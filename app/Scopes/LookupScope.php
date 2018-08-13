<?php
namespace App\Scopes;
use Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LookupScope implements Scope
{
    
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('company_id', Auth::user()->company_id)->orWhere('loai','root')->orderBy('loai')->orderBy('ten');
    }
}