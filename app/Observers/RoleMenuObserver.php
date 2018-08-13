<?php

namespace App\Observers;

use App\RoleMenu;
use App\Traits\GetDataCache;

class RoleMenuObserver
{
    use GetDataCache;

    public function created(RoleMenu $model){
        $this->forgetByName('RoleMenu');
    }

    public function updated(RoleMenu $model){
        $this->forgetByName('RoleMenu');
    }

    public function deleted(RoleMenu $model){
        $this->forgetByName('RoleMenu');
    }
}