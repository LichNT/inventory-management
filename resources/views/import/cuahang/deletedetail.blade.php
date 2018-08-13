@component('components.confirm-delete',
[
    'route' => 'import.detail.delete.cuahang',
    'method' => 'delete',
    'data' => $cuahang,
    'type' => 'detete-import-cuahang',
    'title' => __('model.import_data'),
    'width' => '30%',
])
    <div class="row">
        <div class="col-md-12">
            <label>Mã</label>
            <input type="text" class="form-control" value="{{$cuahang->ma}}"  name="ma" autofocus
                   readonly tabindex="1">

            <label>Tên cửa hàng</label>
            <input type="text" class="form-control" value="{{$cuahang->ten}}" name="ma" readonly tabindex="3">
        </div>
    </div>
@endcomponent