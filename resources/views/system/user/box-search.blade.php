@component('components.box-search', ['routerName' => 'users', 'search' => (empty($search)?null:$search)])
    <div class="row">
        <div class="col-md-6">
            @component('components.multiple-select', [
                'placeholder' => 'Chọn',
                'label'=>'Quyền',
                'data' => $roles,
                'text' => 'name',
                'id'=>'search_quyen',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_quyen',
                'selected' => $search_quyen,
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
