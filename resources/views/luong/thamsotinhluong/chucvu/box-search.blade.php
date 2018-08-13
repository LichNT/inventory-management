@component('components.box-search', ['routerName' => 'luong.chamcong.thamsochucvu', 'search' => (empty($search)? null: $search)])
    <div class="row">
        <div class="col-md-12">
        @component('components.multiple-select', [
                'label' => 'Chức vụ',
                'placeholder' => 'Chọn',
                'data' => $chucvus,
                'text' => 'ten',
                'id'=>'search_chuc_vu',
                'value' => 'ma',
                'name' => 'search_chuc_vu',
                'selected' => $search_chuc_vu,
                'required' => false,
            ])
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Từ ngày</label><br/>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datemask" id="search_time_start" name="search_time_start" value="{{isset($search_time_start) ? date_format(date_create($search_time_start),config('app.format_date')) : null}}" >
            </div>
        </div>
        <div class="col-md-6">
            <label>Đến ngày</label><br/>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datemask" id="search_time_end" name="search_time_end" value="{{isset($search_time_end) ? date_format(date_create($search_time_end),config('app.format_date')) : null}}">
            </div>
        </div>
    </div>
@endcomponent

