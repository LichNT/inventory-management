@component('components.box-search', ['routerName' => 'luong.target', 'search' => (empty($search)? null: $search)])
    <div class="row">
        <div class="col-md-6">
            @component('components.multiple-select', [
                'label' => 'Cửa hàng',
                'placeholder' => 'Chọn',
                'data' => $cuahangs,
                'text' => 'ten',
                'id'=>'search_cua_hang',
                'value' => 'id',
                'name' => 'search_cua_hang',
                'selected' => $search_cua_hang,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            @component('components.multiple-select', [
                'label' => 'Loại target',
                'placeholder' => 'Chọn',
                'data' => $loaitargets,
                'text' => 'ten',
                'id'=>'search_loai_target',
                'value' => 'id',
                'name' => 'search_loai_target',
                'selected' => $search_loai_target,
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

