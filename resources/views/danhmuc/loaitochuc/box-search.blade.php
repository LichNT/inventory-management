@component('components.box-search', ['routerName' => 'danhmuc.loaitochuc', 'search' => (empty($search)?null:$search)])
    <div class="row">
        <div class="col-md-6">
                @component('components.multiple-select-boolean', [
                'label' => 'Trạng thái',
                'placeholder' => 'Chọn',
                'true_text' => __('system.inactive'),
                'false_text' => __('system.active'),
                'name' => 'search_trang_thai',
                'selected' => $search_trang_thai,
                'required' => false,
            ])
                @endcomponent
        </div>
    </div>
@endcomponent
