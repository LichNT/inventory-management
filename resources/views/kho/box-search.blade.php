@component('components.box-search', ['routerName' => 'cuahang', 'search' => (empty($search)?null:$search)])
    <div class="row">
        <div class="col-md-6">
            <label>{{$ten_hien_thi_chi_nhanh}}</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $chi_nhanhs,
                'text' => 'ten',
                'id'=>'search_chi_nhanh',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_chi_nhanh',
                'idSelected' => $search_chi_nhanh,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label>{{$ten_hien_thi_tinh}}</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $tinhs,
                'text' => 'ten',
                'id'=>'search_tinh',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_tinh_thanh',
                'idSelected' => $search_tinh_thanh,
            ])
            @endcomponent
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <label>Ngày đăng ký kinh doanh</label><br/>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control datemask" id="search_time_start" name="search_time_start" value="{{isset($search_time_start) ? $search_time_start : null}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control datemask" id="search_time_end" name="search_time_end" value="{{isset($search_time_end) ? $search_time_end : null}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @component('components.multiple-select', [
                'label' => 'Loại cửa hàng',
                'placeholder' => 'Chọn',
                'data' => $loai_cua_hangs,
                'text' => 'ten',
                'id'=>'search_loai_cua_hang',
                'value' => 'ma',
                'name' => 'search_loai_cua_hang',
                'selected' => $search_loai_cua_hang,
                'required' => false,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent
