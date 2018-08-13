@component('components.box-search',['routerName' => 'dangkyungdungchamcong', 'search' => (empty($search)?null:$search)])
    <div class="row">
        <div class="col-md-6">
            <label>{{$ten_hien_thi_mien}}</label>
            @component('components.select2', [
                    'placeholder' => 'Chọn',
                    'data' => $miens,
                    'text' => 'ten',
                    'id'=>'search_mien',
                    'none_required'=>true,
                    'value' => 'id',
                    'name' => 'search_mien',
                    'idSelected' => $search_mien,
                    'required' => false,
                ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label>{{$ten_hien_thi_chi_nhanh}}</label>
            @component('components.select2', [
                    'placeholder' => 'Chọn',
                    'data' => $chinhanhs,
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
    </div>
    <div class="row">
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
            <label>Cửa hàng</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $cuahangs,
                'text' => 'ma_ten',
                'id'=>'search_cua_hang',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_cua_hang',
                'idSelected' => $search_cua_hang,
                'required' => false,
            ])
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">            
            @component('components.multiple-select-boolean', [
                'label' => 'Trạng thái cấp mã thẻ',
                'placeholder' => 'Chọn',
                'true_text' => 'Đã cấp mã thẻ',
                'false_text' => 'Chưa cấp mã thẻ',
                'name' => 'search_created',
                'selected' => $search_created,
                'required' => false,
            ])
            @endcomponent
        </div>        
    </div>
@endComponent