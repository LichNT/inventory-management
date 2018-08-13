<?php

namespace App\Observers;

use App\Bac;
use App\Traits\GetDataCache;

class BacObserver
{
    use GetDataCache;

    public function created(Bac $model){
        $this->forgetByName('Bac');
    }

    public function updated(Bac $model){
        $this->forgetByName('Bac');
    }

    public function deleted(Bac $model){
        $this->forgetByName('Bac');
    }
}