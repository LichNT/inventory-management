@component('components.confirm-delete', 
[ 
    'route' => 'import.delete.cuahang',
    'method' => 'delete', 
    'data' => $file, 
    'type' => 'delete-import',
    'title' => __('model.import_data'),
    'width' => '25%',    
])
<div class="row">
    <div class="col-sm-12">
        <label class="control-label">Tên</label>
        <input type="text" class="form-control" value="{{$file->name}}"  disabled>

        <label class="control-label">Ngày upoad</label>
        <input type="text" class="form-control"  value="{{$file->created_at}}"  disabled>

        <label class="control-label">Người upload</label>
        <input type="text" class="form-control" value="{{empty($file->user)?null:$file->user->name}}"  disabled>

    </div>    
</div>
@endcomponent