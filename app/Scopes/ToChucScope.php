<?php
namespace App\Scopes;
use Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;
class ToChucScope implements Scope
{
    
    public function apply(Builder $builder, Model $model)
    {   
        $user= Auth::user();
       
        if(!empty(Auth::user()->id_chi_nhanh)){
            $tochuc=DB::table('to_chucs')->where('id',$user->id_chi_nhanh)->first();
            if(!empty($tochuc)){
                $builder->where('parent_id',$user->id_chi_nhanh
                )->orWhere('id',$user->id_chi_nhanh)
                ->orWhere('id',$tochuc->parent_id);
            }
            
        }
        
    }
}