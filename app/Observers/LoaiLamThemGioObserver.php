<?php

namespace App\Observers;

use App\LoaiLamThemGio;
use App\Traits\GetDataCache;

class LoaiLamThemGioObserver
{
    use GetDataCache;

    public function created(LoaiLamThemGio $model){
        $this->forgetByName('LoaiLamThemGio');
    }

    public function updated(LoaiLamThemGio $model){
        $this->forgetByName('LoaiLamThemGio');
    }

    public function deleted(LoaiLamThemGio $model){
        $this->forgetByName('LoaiLamThemGio');
    }
}