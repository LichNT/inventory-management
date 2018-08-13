<?php

namespace App\Observers;

use App\PhongBan;
use App\Traits\GetDataCache;

class PhongBanObserver
{
    use GetDataCache;

    public function created(PhongBan $model){
        $this->forgetByName('PhongBan');
    }

    public function updated(PhongBan $model){
        $this->forgetByName('PhongBan');
    }

    public function deleted(PhongBan $model){
        $this->forgetByName('PhongBan');
    }
}