<?php

namespace App\Observers;

use App\QuocTich;
use App\Traits\GetDataCache;

class QuocTichObserver
{
    use GetDataCache;

    public function created(QuocTich $model){
        $this->forgetByName('QuocTich');
    }

    public function updated(QuocTich $model){
        $this->forgetByName('QuocTich');
    }

    public function deleted(QuocTich $model){
        $this->forgetByName('QuocTich');
    }
}