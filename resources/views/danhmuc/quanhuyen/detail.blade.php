@component('components.modal-update', [
   'type' => 'update-quanhuyen',
   'title' => __('model.quan_huyen'),
   'width' => '35%',
   'route' => 'danhmuc.quanhuyen.update',
   'data' => $quanhuyen,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Tỉnh, thành phố<span style="color:red">*</span></label>
            @component('components.select', ['data' => $tinhthanhs, 
                'text' => 'ten', 
                'name' => 'tinh_thanh_id', 
                'value' => 'id',
                'id' => 'tinh_thanh_id', 
                'idSelected'=>  $quanhuyen->tinh_thanh_id,
                'tabindex'=> 1
                ])
            @endcomponent

            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$quanhuyen->ma}}" autofocus tabindex="2" required>

            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$quanhuyen->ten}}" tabindex="3" required>

            <label for="mo_ta" class="control-label">Mô tả</label>
            <input type="text" class="form-control" id="mo_ta" name="mo_ta" value="{{$quanhuyen->mo_ta}}" tabindex="4">

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $quanhuyen->trang_thai,
                'tabindex' => 5
            ])
            @endcomponent
        </div>
    </div>
@endcomponent