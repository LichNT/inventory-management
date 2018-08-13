<?php

namespace App\Traits;

use App\NhanSu;
use Illuminate\Support\Facades\Auth;

trait GenNo
{    
    /**
     * Gen code nhan su with len 5 charactor
     */
    public function genCodeNhanSu()
    {
        $user = Auth::user();

        $companies = $this->getDataByName('Company');

        $nhansu = NhanSu::query()->orderBy('id','desc')->first();
        $company = $companies->firstWhere('id', $user->company_id);        
        if(empty($nhansu)){
            return $company->code.str_pad((string)(1), 5, "0", STR_PAD_LEFT);
        }
        else{
            $ma = intval(substr($nhansu->ma,-5,5));
            return $company->code.str_pad((string)($ma+1), 5, "0", STR_PAD_LEFT);
        }
    } 
}
