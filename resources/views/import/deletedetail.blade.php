@component('components.confirm-delete', 
[ 
    'route' => 'import.detail.delete', 
    'method' => 'delete', 
    'data' => $importnhansu, 
    'type' => 'detete-import-nhansu',
    'title' => __('model.import_data'),
    'width' => '30%',
])
<div class="row">
    <div class="col-md-12">
        <label>Họ tên</label>
        <input type="text" class="form-control" value="{{$importnhansu->ho_ten}}" placeholder="Họ và tên" name="ho_ten" autofocus
            readonly tabindex="1">

        <label>CMND</label>
        <input type="text" class="form-control" value="{{$importnhansu->cmnd}}" name="cmnd" readonly tabindex="3">
    </div>   
</div>
@endcomponent