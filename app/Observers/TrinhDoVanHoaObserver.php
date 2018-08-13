<?php

namespace App\Observers;

use App\TrinhDoVanHoa;
use App\Traits\GetDataCache;
/**
 * Created by PhpStorm.
 * User: tong.dv
 * Date: 07/11/2017
 * Time: 14:23
 */
class TrinhDoVanHoaObserver
{
    use GetDataCache;

    public function created(TrinhDoVanHoa $model){
        $this->forgetByName('TrinhDoVanHoa');
    }

    public function updated(TrinhDoVanHoa $model){
        $this->forgetByName('TrinhDoVanHoa');
    }

    public function deleted(TrinhDoVanHoa $model){
        $this->forgetByName('TrinhDoVanHoa');
    }
}