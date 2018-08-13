@component('components.box-search', ['routerName' => 'luong.chamcong', 'search' => (empty($search)? null: $search)])
    <div class="row">
        <div class="col-md-4">
            @component('components.multiple-select-boolean', [
            'label' => 'Trạng thái khóa sổ',
            'placeholder' => 'Chọn',
            'true_text' => 'Đóng',
            'false_text' => 'Mở',
            'name' => 'search_khoa_so',
            'selected' => $search_khoa_so,
            'required' => false,
        ])
            @endcomponent
        </div>

        <div class="col-md-4">
            <label>Năm</label><br/>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control yearmask" id="search_nam" name="search_nam" value="{{$search_nam}}" placeholder="yyyy">
            </div>
        </div>
        <div class="col-md-4">
            <label class="control-label">Tháng</label>
            @component('components.select-month', [
                          'idSelected' => $search_thang,
                          'id' => 'id',
                          'value' => 'id',
                          'name' => 'search_thang',
                          'none_required'=> true
                      ])
            @endcomponent
        </div>
    </div>
@endcomponent

