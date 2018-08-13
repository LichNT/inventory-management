<?php

namespace App\Observers;

use App\HeDaoTao;
use App\Traits\GetDataCache;

class HeDaoTaoObserver
{
    use GetDataCache;

    public function created(HeDaoTao $model){
        $this->forgetByName('HeDaoTao');
    }

    public function updated(HeDaoTao $model){
        $this->forgetByName('HeDaoTao');
    }

    public function deleted(HeDaoTao $model){
        $this->forgetByName('HeDaoTao');
    }
}