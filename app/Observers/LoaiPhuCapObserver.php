<?php

namespace App\Observers;

use App\LoaiPhuCap;
use App\Traits\GetDataCache;

class LoaiPhuCapObserver
{
    use GetDataCache;

    public function created(LoaiPhuCap $model){
        $this->forgetByName('LoaiPhuCap');
    }

    public function updated(LoaiPhuCap $model){
        $this->forgetByName('LoaiPhuCap');
    }

    public function deleted(LoaiPhuCap $model){
        $this->forgetByName('LoaiPhuCap');
    }
}