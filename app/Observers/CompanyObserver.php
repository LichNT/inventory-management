<?php

namespace App\Observers;

use App\Company;
use App\Traits\GetDataCache;

class CompanyObserver
{
    use GetDataCache;

    public function created(Company $model){
        $this->forgetByName('Company');
    }

    public function updated(Company $model){
        $this->forgetByName('Company');
    }

    public function deleted(Company $model){
        $this->forgetByName('Company');
    }
}