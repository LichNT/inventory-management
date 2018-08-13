<?php

namespace App\Observers;

use App\LoaiHopDong;
use App\Traits\GetDataCache;

class LoaiHopDongObserver
{
    use GetDataCache;

    public function created(LoaiHopDong $model){
        $this->forgetByName('LoaiHopDong');
    }

    public function updated(LoaiHopDong $model){
        $this->forgetByName('LoaiHopDong');
    }

    public function deleted(LoaiHopDong $model){
        $this->forgetByName('LoaiHopDong');
    }
}