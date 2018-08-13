<?php

namespace App\Observers;

use App\PhanLoaiNhanVien;
use App\Traits\GetDataCache;

class PhanLoaiNhanVienObserver
{
    use GetDataCache;

    public function created(PhanLoaiNhanVien $model){
        $this->forgetByName('PhanLoaiNhanVien');
    }

    public function updated(PhanLoaiNhanVien $model){
        $this->forgetByName('PhanLoaiNhanVien');
    }

    public function deleted(PhanLoaiNhanVien $model){
        $this->forgetByName('PhanLoaiNhanVien');
    }
}