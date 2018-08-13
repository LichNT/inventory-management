<?php

namespace App\Observers;

use App\TrinhDoChuyenMon;
use App\Traits\GetDataCache;

class TrinhDoChuyenMonObserver
{
    use GetDataCache;

    public function created(TrinhDoChuyenMon $model){
        $this->forgetByName('TrinhDoChuyenMon');
    }

    public function updated(TrinhDoChuyenMon $model){
        $this->forgetByName('TrinhDoChuyenMon');
    }

    public function deleted(TrinhDoChuyenMon $model){
        $this->forgetByName('TrinhDoChuyenMon');
    }
}