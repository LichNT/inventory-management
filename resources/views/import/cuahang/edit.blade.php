@component('components.modal-update', [ 'type' => 'update-import-cuahang', 'title' => __('model.import_data'), 'width' => '60%',
'route' => 'import.cuahang.update', 'data' => $cuahang, 'method' => 'put' ])

    <div class="row">
        <div class="col-md-6">
            <label>Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" value="{{$cuahang->ma}}" name="ma" required tabindex="1">
            @if ($errors->has('ma'))
                <span class="help-block" style="color:red">
                        <strong>{{ $errors->first('ma') }}</strong>
                    </span>
            @endif
            <label>Tên địa điểm<span style="color:red">*</span></label>
            <input type="text" class="form-control" value="{{$cuahang->ten_dia_diem}}" required placeholder="Tên địa điểm" name="ten_dia_diem" tabindex="3">
            @if ($errors->has('ten_dia_diem'))
                <span class="help-block" style="color:red">
                        <strong>{{ $errors->first('ten_dia_diem') }}</strong>
                    </span>
            @endif
            <label class="control-label">Địa chỉ</label>
            <textarea class="form-control" rows="3" name="dia_chi" placeholder="Địa chỉ" tabindex="5">{{$cuahang->dia_chi}}</textarea>
            <label>Fax</label>
            <input type="text" class="form-control" value="{{$cuahang->fax}}" name="fax"
                   tabindex="7">
        </div>
        <div class="col-md-6">
            <label>Tên cửa hàng<span style="color:red">*</span></label>
            <input type="text" class="form-control" value="{{$cuahang->ten}}" placeholder="Tên cửa hàng" name="ten" required tabindex="2">
            @if ($errors->has('ten'))
                <span class="help-block" style="color:red">
                        <strong>{{ $errors->first('ten') }}</strong>
                    </span>
            @endif
            <label for="first_name">{{$ten_hien_thi_chi_nhanh}}</label>
            @component('components.select', [
                'data' => $chinhanhs,
                'text' => 'ten',
                'name' => 'id_chi_nhanh',
                'value' => 'id',
                'tabindex' => 4,
                'idSelected' =>  $cuahang->ten_chi_nhanh
                ])
            @endcomponent
            <label >Quốc gia</label>
            @component('components.select', [
            'data' => $quoc_gias,
            'text' => 'ten',
            'name' => 'quoc_gia',
            'value' => 'ma',
            'none_required' => true,
            'tabindex' => 6,
            'idSelected' => $cuahang->quoc_gia
            ])
            @endcomponent
            <label>Số điện thoại</label>
            <input type="text" class="form-control" value="{{$cuahang->so_dien_thoai}}" placeholder="Số điện thoại" name="so_dien_thoai"
                   tabindex="8">
            <label>Zip code</label>
            <input type="text" class="form-control" value="{{$cuahang->zip_code}}" name="zip_code" tabindex="9">
            <label>Trạng thái import</label>
            @if($cuahang->active)
                <input type="text" class="form-control" value="Đã import" readonly>
            @else
                <input type="text" class="form-control" value="Chưa import"  readonly>
            @endif
        </div>
    </div>
@endcomponent