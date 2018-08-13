@component('components.confirm-delete',
[
    'route' => 'luong.danhmuc.loaiphat.delete',
    'method' => 'delete',
    'data' => $loaiphat,
    'type' => 'delete-loaiphat',
    'title' => __('model.loai_phat'),
    'width' => '35%'
])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required disabled value="{{$loaiphat->ten}}" required autofocus placeholder="Tối đa 255 kí tự">
            <label for="name" class="control-label">Số tiền(vnđ)</label>
            <input type="name" class="form-control" id="so_tien" name="so_tien" disabled tabindex="1" required value="{{number_format($loaiphat->so_tien)}}" >
            <label class="control-label">Mô tả</label>
            <textarea class="form-control" name="mo_ta" disabled tabindex="2">{{$loaiphat->mo_ta}}</textarea>
            @component('components.group-checkbox', [
               'title' => 'Trạng thái',
               'id' => 'inactive',
               'name' => 'inactive',
               'title_active' => __('system.active'),
               'title_inactive' => __('system.inactive'),
               'value_active' => 0,
               'value_inactive' => 1,
               'disabled'=>'disabled',
               'value' => $loaiphat->inactive,
           ])
            @endcomponent
        </div>
    </div>

@endcomponent