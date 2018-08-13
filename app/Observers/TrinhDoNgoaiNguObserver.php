<?php

namespace App\Observers;

use App\TrinhDoNgoaiNgu;
use App\Traits\GetDataCache;

class TrinhDoNgoaiNguObserver
{
    use GetDataCache;

    public function created(TrinhDoNgoaiNgu $model){
        $this->forgetByName('TrinhDoNgoaiNgu');
    }

    public function updated(TrinhDoNgoaiNgu $model){
        $this->forgetByName('TrinhDoNgoaiNgu');
    }

    public function deleted(TrinhDoNgoaiNgu $model){
        $this->forgetByName('TrinhDoNgoaiNgu');
    }
}