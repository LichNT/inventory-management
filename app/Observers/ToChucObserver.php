<?php
/**
 * Created by PhpStorm.
 * User: Cuong
 * Date: 27/07/2018
 * Time: 9:37 SA
 */

namespace App\Observers;

use App\ToChuc;
use App\Traits\GetDataCache;

class ToChucObserver
{
    use GetDataCache;

    public function created(ToChuc $model){
        $this->forgetByName('ToChuc');
    }

    public function updated(ToChuc $model){
        $this->forgetByName('ToChuc');
    }

    public function deleted(ToChuc $model){
        $this->forgetByName('ToChuc');
    }
}