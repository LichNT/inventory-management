<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cấu hình ứng dụng chấm công
    |--------------------------------------------------------------------------
    | Số giờ hiệu lực của token cho ứng dụng chấm công   
    |
    */   
    'check_out_live' => env('CHAM_CONG_CHECK_OUT_LIVE', 10),
    'distance_max_valid' => env('CHAM_CONG_DISTANCE_MAX_VALID', 100),
];
