<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'Trường :attribute phải là đúng hoặc sai.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'Trường :attribute là ngày không hợp lệ.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Trường :attribute phải có định dạng email.',
    'exists'               => 'Trường :attribute được chọn không hợp lệ.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'Trường :attribute phải là số nguyên.',
    'max'                  => [
        'numeric' => 'Trường :attribute không thể lớn hơn :max.',
        'file'    => 'Trường :attribute may not be greater than :max kilobytes.',
        'string'  => 'Trường :attribute không thể lớn hơn :max kí tự.',
        'array'   => 'Trường :attribute may not have more than :max items.',
    ],
    'min'                  => [
        'numeric' => 'The :attribute không thể nhỏ hơn :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute không thể nhỏ hơn :min kí tự.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'numeric'              => 'Trường :attribute phải là số.',
    'required'             => 'Trường :attribute bắt buộc phải nhập.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'Trường :attribute phải là xâu kí tự.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'Trường :attribute đã tồn tại.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'ma' => [
            'required' => 'Trường mã bắt buộc phải nhập.',
            'max' => 'Trường mã không thể lớn hơn :max kí tự.',
            'unique' => 'Trường mã đã tồn tại.',
        ],

        'code' => [
            'required' => 'Trường mã bắt buộc phải nhập.',
            'max' => 'Trường mã không thể lớn hơn :max kí tự.',
            'unique' => 'Trường mã đã tồn tại.',
        ],

        'ten_dia_diem' => [
            'required' => 'Trường Tên địa điểm bắt buộc phải nhập.',
            'max' => 'Trường Tên địa điểm không thể lớn hơn :max kí tự.',
        ],

        'ten' => [
            'required' => 'Trường Tên bắt buộc phải nhập.',
            'max' => 'Trường Tên không thể lớn hơn :max kí tự.',
            'unique' => 'Trường tên đã tồn tại.',
        ],

        'username' => [
            'required' => 'Trường Tên tài khoản bắt buộc phải nhập.',
            'max' => 'Trường Tên Tên tài khoản không thể lớn hơn :max kí tự.',
            'unique' => 'Trường tên Tên tài khoản đã tồn tại.',
        ],

        'name' => [
            'required' => 'Trường Tên bắt buộc phải nhập.',
            'max' => 'Trường Tên không thể lớn hơn :max kí tự.',
            'unique' => 'Trường tên đã tồn tại.',
        ],

        'password' => [
            'required' => 'Trường Mật khẩu bắt buộc phải nhập.',
            'max' => 'Trường Mật khẩu không thể lớn hơn :max kí tự.',
        ],

        'new_password' => [
            'required' => 'Trường Mật khẩu mới bắt buộc phải nhập.',
            'max' => 'Trường Mật khẩu mới không thể lớn hơn :max kí tự.',
        ],

        'thang' => [
            'required' => 'Trường Tháng bắt buộc phải nhập.',
        ],

        'nam' => [
            'required' => 'Trường Năm bắt buộc phải nhập.',
        ],

        'trangthai' => [
            'required' => 'Trường Trạng thái bắt buộc phải nhập.',
            'boolean' => 'Trường Trạng thái phải là đúng hoặc sai.',
        ],

        'inacitve' => [
            'required' => 'Trường Trạng thái bắt buộc phải nhập.',
            'boolean' => 'Trường Trạng thái phải là đúng hoặc sai.',
        ],

        'tinh_thanh_id' => [
            'required' => 'Trường Tỉnh thành bắt buộc phải nhập.',
            'exists' => 'Trường Tỉnh thành được chọn không hợp lệ.',
        ],

        'loai_to_chuc_id' => [
            'required' => 'Trường Loại Tổ chức bắt buộc phải nhập.',
            'exists' => 'Trường Tên địa điểm không thể lớn hơn :max kí tự.',
        ],

        'id_loai_hop_dong' => [
            'required' => 'Trường Loại hợp đồng bắt buộc phải nhập.',
            'exists' => 'Trường Loại hợp đồng được chọn không hợp lệ.',
        ],

        'loai' => [
            'required' => 'Trường Loại bắt buộc phải nhập.',
            'max' => 'Trường Loại không thể lớn hơn :max kí tự.',
        ],

        'active' => [
            'required' => 'Trường Trạng thái bắt buộc phải nhập.',
            'boolean' => 'Trường Trạng thái phải là đúng hoặc sai.',
        ],

        'ho_ten' => [
            'required' => 'Trường Họ tên bắt buộc phải nhập.',
        ],

        'cmnd' => [
            'unique' => 'Trường CMND đã tồn tại.',
        ],

        'tai_khoan_ngan_hang' => [
            'unique' => 'Trường Tài khoản ngân hàng đã tồn tại.',
        ],

        'ma_so_thue' => [
            'unique' => 'Trường Mã số thuế đã tồn tại.',
        ],

        'ngay_hieu_luc' => [
            'required' => 'Trường Ngày hiệu lực bắt buộc phải nhập.',
        ],

        'so_quyet_dinh' => [
            'max' => 'Trường Số quyết định không thể lớn hơn :max kí tự.',
        ],

        'gioi_tinh' => [
            'required' => 'Trường Giới tính bắt buộc phải nhập.',
        ],

        'id_loai_nghi_dac_biet'  =>  [
            'required' => 'Trường Loại nghỉ đặc biệt bắt buộc phải nhập.',
        ],

        'file_ho_so_nhan_su'   =>  [
            'required' => 'Trường Hồ sơ nhân sự bắt buộc phải nhập.',
        ],

        'type'   =>  [
            'required' => 'Trường loại bắt buộc phải nhập.',
        ],

        'so_luong'   =>  [
            'required' => 'Trường Số lượng bắt buộc phải nhập.',
        ],

        'size'   =>  [
            'required' => 'Trường Kích cỡ bắt buộc phải nhập.',
        ],

        'ngay_huong_luong'   =>  [
            'required' => 'Trường Ngày hưởng lươngbắt buộc phải nhập.',
        ],

        'role_id' => [
            'required' => 'Trường Quyền bắt buộc phải nhập.',
            'exists' => 'Trường Quyền được chọn không hợp lệ.',
        ],

        'id_size' => [
            'required' => 'Trường Size bắt buộc phải nhập.',
            'exists' => 'Trường Size được chọn không hợp lệ.',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
