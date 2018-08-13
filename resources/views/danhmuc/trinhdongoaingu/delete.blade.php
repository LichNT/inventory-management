@component('components.confirm-delete',
[
    'route' => 'danhmuc.trinhdongoaingu.delete',
    'method' => 'delete',
    'data' => $trinhdongoaingu,
    'type' => 'delete-trinhdongoaingu',
    'width' => '35%',
    'title' => __('model.trinh_do_ngoai_ngu')
])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã</label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$trinhdongoaingu->ma}}" disabled >

            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$trinhdongoaingu->ten}}" disabled >

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $trinhdongoaingu->trang_thai,
                'disabled' => 'disabled'
            ])
            @endcomponent
        </div>
    </div>
@endcomponent