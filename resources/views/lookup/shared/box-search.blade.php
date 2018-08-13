@component('components.box-search',['routerName' => 'lookup', 'search' => (empty($search)?null:$search)])
    <div class="form-group1">
        <label for="filter">Tìm kiếm theo loại</label>
        @component('components.select',['data'=> $loaiLookups,
        'text' => 'ten',
        'value' => 'ma',
        'name' => 'search_loai',
        'idSelected'=> $search_loai,
        'tatca'=> 'Tất cả',
        'none_required'=>'true'])
        @endcomponent
    </div>
    <br/>
    <div class="form-group1">
        @component('components.multiple-select-boolean', [
            'label' => 'Trạng thái',
            'placeholder' => 'Chọn',
            'true_text' => 'Đang sử dụng',
            'false_text' => 'Ngừng sử dụng',
            'name' => 'search_trang_thai',
            'selected' => $search_trang_thai,
            'required' => false,
        ])
        @endcomponent
    </div>
@endComponent