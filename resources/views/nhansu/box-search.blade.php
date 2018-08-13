@component('components.box-search', ['routerName' => 'nhansu', 'search' => (empty($search)? null: $search)])
    <div class="row">
        <div class="col-md-6">
            <label>{{$ten_hien_thi_chi_nhanh}}</label>
        @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $chi_nhanhs,
                'text' => 'ten',
                'id'=>'search_chi_nhanh',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_chi_nhanh',
                'idSelected' => $search_chi_nhanh,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label>{{$ten_hien_thi_tinh}}</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $tinhs,
                'text' => 'ten',
                'id'=>'search_tinh',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_tinh',
                'idSelected' => $search_tinh,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label>Phòng ban</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $phongbans,
                'text' => 'ten',
                'id'=>'search_phong_ban',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_phong_ban',
                'idSelected' => $search_phong_ban,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label>Bộ phận</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $bophans,
                'text' => 'ten',
                'id'=>'search_bo_phan',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_bo_phan',
                'idSelected' => $search_bo_phan,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            @component('components.multiple-select', [
                'label' => 'Chức vụ',
                'placeholder' => 'Chọn',
                'data' => $chucvus,
                'text' => 'ten',
                'id'=>'search_chuc_vu',
                'value' => 'id',
                'name' => 'search_chuc_vu',
                'selected' => $search_chuc_vu,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            @component('components.multiple-select', [
                'label' => 'Trình độ văn hoá',
                'placeholder' => 'Chọn',
                'data' => $trinhdovanhoas,
                'text' => 'ten',
                'id'=>'search_trinh_do_van_hoa',
                'value' => 'id',
                'name' => 'search_trinh_do_van_hoa',
                'selected' => $search_trinh_do_van_hoa,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            @component('components.multiple-select', [
                'label' => 'Loại hợp đồng',
                'placeholder' => 'Chọn',
                'data' => $loaihopdongs,
                'text' => 'ten',
                'id'=>'search_loai_hop_dong',
                'value' => 'id',
                'name' => 'search_loai_hop_dong',
                'selected' => $search_loai_hop_dong,
                'required' => false,
            ])
            @endcomponent
        </div>
    <div class="col-md-6">
        @component('components.multiple-select-boolean', [
            'label' => 'Giới tính',
            'placeholder' => 'Chọn',
            'true_text' => 'Nam',
            'false_text' => 'Nữ',
            'id' => 'search_gioi_tinh',
            'name' => 'search_gioi_tinh',
            'selected' => $search_gioi_tinh,
            'required' => false,
        ])
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.multiple-select-boolean', [
            'label' => 'Tình trạng',
            'placeholder' => 'Chọn',
            'true_text' => 'Nghỉ việc',
            'false_text' => 'Đang làm việc',
            'name' => 'search_da_nghi_viec',
            'id' => 'search_da_nghi_viec',
            'selected' => $search_da_nghi_viec,
            'required' => false,
        ])
        @endcomponent
    </div>
        <div class="col-md-6">
            <label>Ngày sinh</label><br/>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datemask" id="search_ngay_sinh" name="search_ngay_sinh" value="{{isset($search_ngay_sinh) ? date_format(date_create($search_ngay_sinh),config('app.format_date')) : null}}">
            </div>
        </div>
    </div>

@endcomponent

