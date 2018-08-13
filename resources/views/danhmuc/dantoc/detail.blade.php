@component('components.modal-update', [
   'type' => 'update-dantoc',
   'title' => __('model.dan_toc'),
   'width' => '35%',
   'route' => 'danhmuc.dantoc.update',
   'data' => $dantoc,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$dantoc->ma}}" autofocus tabindex="1" required>

            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$dantoc->ten}}" tabindex="2" required>

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $dantoc->trang_thai,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent