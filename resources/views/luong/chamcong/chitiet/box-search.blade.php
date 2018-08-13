@component('components.box-search', ['routerName' => 'luong.chamcong.chitiet','id'=>$ten_bang, 'search' => (empty($search)? null: $search)])
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
                'label' => 'Phòng ban',
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
    </div>
@endcomponent

