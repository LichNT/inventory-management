<?php

namespace App\Observers;

use App\LoaiPhongBan;
use App\Traits\GetDataCache;

class LoaiPhongBanObserver
{
    use GetDataCache;

    public function created(LoaiPhongBan $model){
        $this->forgetByName('LoaiPhongBan');
    }

    public function updated(LoaiPhongBan $model){
        $this->forgetByName('LoaiPhongBan');
    }

    public function deleted(LoaiPhongBan $model){
        $this->forgetByName('LoaiPhongBan');
    }
}