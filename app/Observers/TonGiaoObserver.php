<?php

namespace App\Observers;

use App\TonGiao;
use App\Traits\GetDataCache;
/**
 * Created by PhpStorm.
 * User: tong.dv
 * Date: 07/11/2017
 * Time: 14:23
 */
class TonGiaoObserver
{
    use GetDataCache;

    public function created(TonGiao $model){
        $this->forgetByName('TonGiao');
    }

    public function updated(TonGiao $model){
        $this->forgetByName('TonGiao');
    }

    public function deleted(TonGiao $model){
        $this->forgetByName('TonGiao');
    }
}