<?php

namespace App\Observers;

use App\CuaHang;
use App\Traits\GetDataCache;

class CuaHangObserver
{
    use GetDataCache;

    public function created(CuaHang $model){
        $this->forgetByName('CuaHang');
    }

    public function updated(CuaHang $model){
        $this->forgetByName('CuaHang');
    }

    public function deleted(CuaHang $model){
        $this->forgetByName('CuaHang');
    }
}