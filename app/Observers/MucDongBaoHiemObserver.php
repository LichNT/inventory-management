<?php

namespace App\Observers;

use App\MucDongBaoHiem;
use App\Traits\GetDataCache;

class MucDongBaoHiemObserver
{
    use GetDataCache;

    public function created(MucDongBaoHiem $model){
        $this->forgetByName('MucDongBaoHiem');
    }

    public function updated(MucDongBaoHiem $model){
        $this->forgetByName('MucDongBaoHiem');
    }

    public function deleted(MucDongBaoHiem $model){
        $this->forgetByName('MucDongBaoHiem');
    }
}