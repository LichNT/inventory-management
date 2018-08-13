@component('components.modal-update', [
   'type' => 'update-trinhdongoaingu',
   'title' => __('model.trinh_do_ngoai_ngu'),
   'width' => '35%',
   'route' => 'danhmuc.trinhdongoaingu.update',
   'data' => $trinhdongoaingu,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$trinhdongoaingu->ma}}" autofocus tabindex="1" required>

            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$trinhdongoaingu->ten}}" tabindex="2" required>

            <label for="mo_ta" class="control-label">Mô tả</label>
            <input type="text" class="form-control" id="mo_ta" name="mo_ta" value="{{$trinhdongoaingu->mo_ta}}" tabindex="3">

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $trinhdongoaingu->trang_thai,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent