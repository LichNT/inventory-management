@component('components.box-search', ['routerName' => 'luong.phat', 'search' => (empty($search)? null: $search)])
    <div class="row">
        <div class="col-md-6">
            @component('components.multiple-select', [
                'label' => 'Loại phạt',
                'placeholder' => 'Chọn',
                'data' => $loaiphats,
                'text' => 'ten',
                'id'=>'search_loai_phat',
                'value' => 'id',
                'name' => 'search_loai_phat',
                'selected' => $search_loai_phat,
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
                <input type="text" class="form-control monthmask" id="search_thang" name="search_thang" value="{{isset($search_thang) ? date_format(date_create($search_thang),config('app.format_month')) : null}}">
            </div>
        </div>
    </div>

@endcomponent

