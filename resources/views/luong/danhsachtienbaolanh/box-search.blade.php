@component('components.box-search', ['routerName' => 'luong.danhsachtienbaolanh', 'search' => (empty($search)? null: $search)])
    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_mien}}</label>
            @component('components.select2', ['data' => $miens,'value'=>'id' ,
            'text' => 'ten', 'name' => 'search_mien',
            'none_required' => true,
            'id'=>'mien_moi',
            'idSelected'=>$search_mien,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_chi_nhanh}}</label>
            @component('components.select2', ['data' => $chinhanhs,'value'=>'id' ,'text' => 'ten',
            'name' => 'search_chi_nhanh',
            'none_required' => true,
            'id'=>'chi_nhanh_moi',
            'idSelected'=>$search_chi_nhanh
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_tinh}}</label>
            @component('components.select2', [
            'data' => $tinhs,
            'value'=>'id' ,'text' => 'ten',
            'name' => 'search_tinh',
            'none_required' => true,
            'id'=>'tinh_moi',
            'idSelected'=>$search_tinh
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Cửa hàng</label>
            @component('components.select2', [
            'data' => $cuahangs,
            'value'=>'id' ,'text' => 'ma_ten',
            'name' => 'search_cua_hang',
            'none_required' => true,
            'id'=>'cua_hang_moi',
            'idSelected'=>$search_cua_hang
            ])
            @endcomponent
        </div>
    </div>

@endcomponent

