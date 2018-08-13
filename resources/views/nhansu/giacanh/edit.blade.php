@component('components.modal-update', [
   'type' => 'update-giacanh',
   'title' => 'Cập nhật bảo hiểm',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'nhansu.update.giacanh.edit',
   'data' => $giacanh,
   'method' => 'PUT'])

    <div class="row">
        <div class="col-md-6">
            <label for="ho_ten" class="control-label">Họ tên</label>
            <input type="text" class="form-control"  required name="ho_ten" tabindex="1" value="{{$giacanh->ho_ten}}">
        </div>
        <div class="col-md-6">
            <label for="nam_sinh" class="control-label">Năm sinh</label>
            <input type="number" class="form-control"   name="nam_sinh" tabindex="2" value="{{$giacanh->nam_sinh}}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @component('components.group-checkbox', [
                'title' => 'Giới tính',
                'name' => 'gioi_tinh',
                'title_active' => 'Nam',
                'title_inactive' => 'Nữ',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $giacanh->gioi_tinh,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label for="quan_he" class="control-label">Quan hệ</label>
            <input type="text" class="form-control"  name="quan_he"  tabindex="5" value="{{$giacanh->quan_he}}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label for="nghe_nghiep" class="control-label">Nghề nghiệp</label>
            <input type="text" class="form-control"   name="nghe_nghiep" tabindex="3" value="{{$giacanh->nghe_nghiep}}">
        </div>
        <div class="col-md-6">
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'name' => 'da_chet',
                'title_active' => 'Đã chết',
                'title_inactive' => 'Chưa chết',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $giacanh->da_chet,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent