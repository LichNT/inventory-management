<?php

namespace App\Traits;

trait GetDanhMuc {      
    public function getDataByName($name) {
        if($this->has('danh_muc', $name)) {
            return $this->get('danh_muc', $name);
        }
        $model = "App\\" . $name;
        $data = $model::query()->get();
        $this->forever('danh_muc', $name, $data);
        return $data;      
    }

    public function forgetByName($name) {  
        if($this->has('danh_muc', $name)) {
            return $this->forget('danh_muc', $name);
        }             
    }

}