<?php

namespace App\Observers;

use App\Menu;
use App\Traits\GetDataCache;

class MenuObserver
{
    use GetDataCache;

    public function created(Menu $model){
        $this->forgetByName('Menu');
    }

    public function updated(Menu $model){
        $this->forgetByName('Menu');
    }

    public function deleted(Menu $model){
        $this->forgetByName('Menu');
    }
}