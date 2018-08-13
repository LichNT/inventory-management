@component('components.modal-update', [
   'type' => 'update-loai_target',
   'title' => __('model.loai_target'),
   'width' => '35%',
   'route' => 'luong.danhmuc.loaitarget.edit',
   'data' => $loaitarget,
   'method' => 'PUT'])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Mã <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ma" tabindex="1" required value="{{$loaitarget->ma}}" required autofocus>
            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{$loaitarget->ten}}" required>

            @component('components.group-checkbox', [
              'title' => 'Trạng thái',
              'id' => 'inactive',
              'name' => 'inactive',
              'title_active' => __('system.active'),
              'title_inactive' => __('system.inactive'),
              'value_active' => 0,
              'value_inactive' => 1,
              'value' => $loaitarget->inactive,
          ])
            @endcomponent
        </div>
    </div>
@endcomponent