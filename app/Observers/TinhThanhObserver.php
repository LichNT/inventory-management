<?php


namespace App\Observers;

use App\TinhThanh;
use App\Traits\GetDataCache;

class TinhThanhObserver
{
    use GetDataCache;

    public function created(TinhThanh $model){
        $this->forgetByName('TinhThanh');
    }

    public function updated(TinhThanh $model){
        $this->forgetByName('TinhThanh');
    }

    public function deleted(TinhThanh $model){
        $this->forgetByName('TinhThanh');
    }
}