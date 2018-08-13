<?php

namespace App\Observers;

use App\HopDongChucVu;
use App\Traits\GetDataCache;

class HopDongChucVuObserver
{
    use GetDataCache;

    public function created(HopDongChucVu $model){
        $this->forgetByName('HopDongChucVu');
    }

    public function updated(HopDongChucVu $model){
        $this->forgetByName('HopDongChucVu');
    }

    public function deleted(HopDongChucVu $model){
        $this->forgetByName('HopDongChucVu');
    }
}