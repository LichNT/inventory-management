@component('components.box-search', ['routerName' => 'detail.cuahang', 'id' => $id, 'search' => (empty($search) ? null : $search)])
    <div class="row">
        <div class="col-md-12">
            @component('components.multiple-select-boolean', [
                'label' => 'Trạng thái import',
                'placeholder' => 'Chọn',
                'true_text' => 'Đã import',
                'false_text' => 'Chưa import',
                'name' => 'search_trang_thai',
                'selected' => $search_trang_thai,
                'required' => false,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent