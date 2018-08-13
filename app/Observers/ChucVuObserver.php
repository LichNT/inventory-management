<?php

namespace App\Observers;

use App\ChucVu;
use App\Traits\GetDataCache;

class ChucVuObserver
{
    use GetDataCache;

    public function created(ChucVu $model){
        $this->forgetByName('ChucVu');
    }

    public function updated(ChucVu $model){
        $this->forgetByName('ChucVu');
    }

    public function deleted(ChucVu $model){
        $this->forgetByName('ChucVu');
    }
}