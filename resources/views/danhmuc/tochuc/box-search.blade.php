@component('components.box-search', ['routerName' => 'danhmuc.tochuc', 'search' => (empty($search) ? null: $search)])
    <div class="row">
        <div class=" col-md-6">
            @component('components.multiple-select', [
                'label' => 'Trực thuộc',
                'placeholder' => 'Chọn Trực thuộc',
                'data' => $all_to_chuc,
                'text' => 'ten',
                'id'=>'search_truc_thuoc',
                'value' => 'id',
                'name' => 'search_truc_thuoc',
                'selected' => $search_truc_thuoc,
                'required' => false,
            ])
            @endcomponent
            
        </div>

        <div class=" col-md-6">           
            @component('components.multiple-select', [
                'label' => 'Loại',
                'placeholder' => 'Chọn Loại',
                'data' => $loai_to_chucs,
                'text' => 'ten',
                'id'=>'search_loai_to_chuc',
                'value' => 'id',
                'name' => 'search_loai_to_chuc',
                'selected' => $search_loai_to_chuc,
                'required' => false,
            ])
            @endcomponent
        </div>
        
        <div class="col-md-6">
        @component('components.multiple-select-boolean', [
            'label' => 'Trạng thái',
            'placeholder' => 'Chọn',
            'true_text' => __('system.inactive2'),
            'false_text' => __('system.active2'),
            'name' => 'search_trang_thai',
            'selected' => $search_trang_thai,
            'required' => false,
        ])
        @endcomponent
    </div>
@endcomponent