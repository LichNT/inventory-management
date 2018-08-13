<?php
namespace App\Scopes;
use Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OrderByScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy('ten');
    }
}