@component('components.box-search', ['routerName' => 'dangkyungdungchamcong.chitiet','id'=>$dangkichamcong->ma_the_cham_cong, 'search' => (empty($search)? null: $search)])
    <div class="row">
        <div class="col-md-6">
            @component('components.multiple-select-boolean', [
                'label' => 'Hợp lệ',
                'placeholder' => 'Chọn',
                'true_text' => 'Hợp lệ',
                'false_text' => 'Không hợp lệ',
                'id' => 'search_hop_le',
                'name' => 'search_hop_le',
                'selected' => $search_hop_le,
                'required' => false,
            ])
            @endcomponent
        </div>
        <br/>
        <div class="col-md-6">
            @component('components.checkbox', [
                'title' => 'Cảnh báo',
                'value_checked' => 1,
                'value_unchecked' => 0,
                'value' => $search_canh_bao,
                'name'=>'search_canh_bao' ,
            ])
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Check in từ ngày</label><br/>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datemask" id="search_start_time" name="search_start_time" value="{{isset($search_start_time) ? date_format(date_create($search_start_time),config('app.format_date')) : null}}">
            </div>
        </div>
        <div class="col-md-6">
            <label>Đến ngày</label><br/>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datemask" id="search_end_time" name="search_end_time" value="{{isset($search_end_time) ? date_format(date_create($search_end_time),config('app.format_date')) : null}}">
            </div>
        </div>
    </div>

@endcomponent

