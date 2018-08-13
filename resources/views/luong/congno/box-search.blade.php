@component('components.box-search', ['routerName' => 'luong.congno', 'search' => (empty($search)? null: $search)])
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
        <div class="col-md-6">
            <label>Nhân sự</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $nhansus,
                'text' => 'ma_ten',
                'id'=>'nhan_su',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_nhan_su',
                'idSelected' => $search_nhan_su,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label>Tháng</label><br/>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control monthmask" id="search_thang" name="search_thang" value="{{isset($search_thang) ? $search_thang : null}}">
            </div>
        </div>
    </div>

@endcomponent

