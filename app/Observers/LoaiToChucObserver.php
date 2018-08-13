<?php

namespace App\Observers;

use App\LoaiToChuc;
use App\Traits\GetDataCache;

class LoaiToChucObserver
{
    use GetDataCache;

    public function created(LoaiToChuc $model){
        $this->forgetByName('LoaiToChuc');
    }

    public function updated(LoaiToChuc $model){
        $this->forgetByName('LoaiToChuc');
    }

    public function deleted(LoaiToChuc $model){
        $this->forgetByName('LoaiToChuc');
    }
}