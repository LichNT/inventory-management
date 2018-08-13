<?php

namespace App\Observers;

use App\LoaiNghiDacBiet;
use App\Traits\GetDataCache;

class LoaiNghiDacBietObserver
{
    use GetDataCache;

    public function created(LoaiNghiDacBiet $model){
        $this->forgetByName('LoaiNghiDacBiet');
    }

    public function updated(LoaiNghiDacBiet $model){
        $this->forgetByName('LoaiNghiDacBiet');
    }

    public function deleted(LoaiNghiDacBiet $model){
        $this->forgetByName('LoaiNghiDacBiet');
    }
}