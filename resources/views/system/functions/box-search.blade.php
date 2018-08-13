@component('components.box-search', ['routerName' => 'system.functions', 'search' => (empty($search)?null:$search)])
    <div class="row">
        <div class=" col-md-6">
            @component('components.multiple-select',[
                'label' => 'Tìm kiếm theo chức năng',
                'placeholder' => 'Chọn chức năng',
                'data'=>$name_role,
                'text' => 'name',
                'value' => 'id',
                'name' => 'search_chuc_nang',
                'selected'=>$search_chuc_nang,
                'tatca'=>'Tất cả',
                'required'=>false])
            @endcomponent
        </div>

        <div class=" col-md-6">
            @component('components.multiple-select',[
                'label' => 'Tìm kiếm theo danh mục',
                'placeholder' => 'Chọn danh mục',
                'data'=>$name_menu,
                'text' => 'name',
                'value' => 'id',
                'name' => 'search_danh_muc',
                'selected'=>$search_danh_muc,
                'tatca'=>'Tất cả',
                'required'=>false])
            @endcomponent
        </div>
    </div>
@endcomponent


