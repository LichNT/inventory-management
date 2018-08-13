<?php

namespace App\Observers;

use App\LoaiPhat;
use App\Traits\GetDataCache;

class LoaiPhatObserver
{
    use GetDataCache;

    public function created(LoaiPhat $model){
        $this->forgetByName('LoaiPhat');
    }

    public function updated(LoaiPhat $model){
        $this->forgetByName('LoaiPhat');
    }

    public function deleted(LoaiPhat $model){
        $this->forgetByName('LoaiPhat');
    }
}