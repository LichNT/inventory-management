@component('components.confirm-delete',
[
    'route' => 'nhansu.update.giacanh.delete',
    'method' => 'delete',
    'data' => $giacanh,
    'type' => 'delete-giacanh',
    'title' => 'Xóa gia cảnh',
    'width' => '35%'
])

    <div class="row">
        <div class="col-md-6">
            <label for="ho_ten" class="control-label">Họ tên</label>
            <input type="text" class="form-control"  required name="ho_ten" tabindex="1" value="{{$giacanh->ho_ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label for="nam_sinh" class="control-label">Năm sinh</label>
            <input type="number" class="form-control"   name="nam_sinh" tabindex="2" value="{{$giacanh->nam_sinh}}" disabled>
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
                'disabled'=>'disabled'

            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label for="quan_he" class="control-label">Quan hệ</label>
            <input type="text" class="form-control"  name="quan_he"  tabindex="5" value="{{$giacanh->quan_he}}" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label for="nghe_nghiep" class="control-label">Nghề nghiệp</label>
            <input type="text" class="form-control"   name="nghe_nghiep" tabindex="3" value="{{$giacanh->nghe_nghiep}}" disabled>
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
                'disabled'=>'disabled'

            ])
            @endcomponent
        </div>
    </div>
@endcomponent