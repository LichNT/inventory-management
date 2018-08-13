<?php

namespace App\Observers;

use App\DanToc;
use App\Traits\GetDataCache;

class DanTocObserver
{
    use GetDataCache;

    public function created(DanToc $model){
        $this->forgetByName('DanToc');
    }

    public function updated(DanToc $model){
        $this->forgetByName('DanToc');
    }

    public function deleted(DanToc $model){
        $this->forgetByName('DanToc');
    }
}