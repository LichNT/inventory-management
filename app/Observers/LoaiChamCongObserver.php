<?php

namespace App\Observers;

use App\LoaiChamCong;
use App\Traits\GetDataCache;

class LoaiChamCongObserver
{
    use GetDataCache;

    public function created(LoaiChamCong $model){
        $this->forgetByName('LoaiChamCong');
    }

    public function updated(LoaiChamCong $model){
        $this->forgetByName('LoaiChamCong');
    }

    public function deleted(LoaiChamCong $model){
        $this->forgetByName('LoaiChamCong');
    }
}