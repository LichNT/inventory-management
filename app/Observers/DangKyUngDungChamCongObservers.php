<?php

namespace App\Observers;

use App\DangKyUngDungChamCong;
use App\Mail\DangKyUngDungChamCongThanhCong;
use Mail;
/**
 * Created by PhpStorm.
 * User: tong.dv
 * Date: 07/11/2017
 * Time: 14:23
 */
class DangKyUngDungChamCongObservers
{
    public function created(DangKyUngDungChamCong $model){
        if(isset($model->email)) {
            Mail::to($model->email)->send(new DangKyUngDungChamCongThanhCong($model));
        }
    }
}