@component('components.modal-update', [
   'type' => 'update-loaitochuc',
   'title' => __('model.loai_to_chuc'),
   'width' => '35%',
   'route' => 'danhmuc.loaitochuc.update',
   'data' => $loaitochuc,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$loaitochuc->ma}}" autofocus tabindex="1" required>

            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$loaitochuc->ten}}" tabindex="2" required>
            <label for="ten" class="control-label">Mô tả</label>
            <input type="text" class="form-control" id="ten" name="mo_ta" value="{{$loaitochuc->mo_ta}}" tabindex="3" >

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'inactive',
                'name' => 'inactive',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 0,
                'value_inactive' => 1,
                'value' => $loaitochuc->inactive,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent