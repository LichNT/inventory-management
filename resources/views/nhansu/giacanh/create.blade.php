@component('components.modal-add', [
    'type' => 'giacanh',
    'title' => 'Thêm mới gia cảnh',
    'width' => '35%',
    'route' => 'nhansu.update.giacanh.create',
    'id' => $nhansu->id,
    ])

    <div class="row">
        <div class="col-md-6">
            <label for="ho_ten" class="control-label">Họ tên</label>
            <input type="text" class="form-control"  required name="ho_ten" tabindex="1">
        </div>
        <div class="col-md-6">
            <label for="nam_sinh" class="control-label">Năm sinh</label>
            <input type="number" class="form-control"   name="nam_sinh" tabindex="2">
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
                'value' => 1,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label for="quan_he" class="control-label">Quan hệ</label>
            <input type="text" class="form-control"  name="quan_he"  tabindex="5">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label for="nghe_nghiep" class="control-label">Nghề nghiệp</label>
            <input type="text" class="form-control"   name="nghe_nghiep" tabindex="3">
        </div>
        <div class="col-md-6">
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'name' => 'da_chet',
                'title_active' => 'Đã chết',
                'title_inactive' => 'Chưa chết',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => 1,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent