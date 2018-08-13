<?php

namespace App\Observers;

use App\Lookup;
use App\Traits\GetDataCache;

class LookupObserver
{
    use GetDataCache;

    public function created(Lookup $model){
        $this->forgetByName('Lookup');
    }

    public function updated(Lookup $model){
        $this->forgetByName('Lookup');
    }

    public function deleted(Lookup $model){
        $this->forgetByName('Lookup');
    }
}