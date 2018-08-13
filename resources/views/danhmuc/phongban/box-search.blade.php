@component('components.box-search', ['routerName' => 'danhmuc.phongban', 'search' => (empty($search) ? null: $search)])
    <div class="row">
        <div class=" col-md-6">
            @component('components.multiple-select', [
                'label' => 'Trực thuộc',
                'placeholder' => 'Chọn Trực thuộc',
                'data' => $phongban_parents,
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
                'data' => $loai_phong_bans,
                'text' => 'ten',
                'id'=>'search_phong_ban',
                'value' => 'id',
                'name' => 'search_phong_ban',
                'selected' => $search_phong_ban,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
        @component('components.multiple-select-boolean', [
            'label' => 'Trạng thái',
            'placeholder' => 'Chọn',
            'true_text' => __('system.active2'),
            'false_text' => __('system.inactive2'),
            'name' => 'search_trang_thai',
            'selected' => $search_trang_thai,
            'required' => false,
        ])
        @endcomponent
    </div>
    </div>
@endcomponent