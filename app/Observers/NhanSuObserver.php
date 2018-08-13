<?php

namespace App\Observers;

use App\NhanSuLog;
use App\NhanSu;
use App\Traits\GetDataCache;
/**
 * Created by PhpStorm.
 * User: tong.dv
 * Date: 07/11/2017
 * Time: 14:23
 */
class NhanSuObserver
{
    use GetDataCache;

    public function created(NhanSu $model){
        $info = $model->toArray();
        $info['change_code'] = 'C';
        $info['change_content'] = 'Thêm mới thông tin nhân sự';
        NhanSuLog::create($info);    
    }

    public function updating(NhanSu $nhansu){        
        if($nhansu->isDirty()){
            $info = $nhansu->toArray();
            $info['change_code'] = 'U';
            $info['change_content'] = "";
            foreach($nhansu->getFillable() as $field) {
                if($nhansu->isdirty($field)) {
                    if(!empty($info['change_content'])) {
                        $info['change_content'] = $info['change_content'] . ';';
                    }
                    $info['change_content'] = $info['change_content'] . $field . '->' . $nhansu->$field; 
                } 
            }            
            NhanSuLog::create($info);
        }       
    }

    public function updated(NhanSu $nhansu){
        if(!empty($nhansu['ma_the_cham_cong'])){
            $this->forget('nhansu_chamcongcuahang', $nhansu['ma_the_cham_cong']);
        }
    }

    public function deleting(NhanSu $model){
        $info = $model->toArray();
        $info['change_code'] = 'D';
        NhanSuLog::create($info);
    }
}