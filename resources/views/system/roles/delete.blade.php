@component('components.confirm-delete',
[
    'route' => 'system.roles.delete',
    'method' => 'delete',
    'data' => $role,
    'type' => 'delete-role',
    'title' => __('model.role'),
    'width' => '25%',
])
    <div class="row">
        <div class="col-sm-12">
            <label for={{'inputCode-delete-' . $role->id}} class="control-label">Mã</label>
            <input type="text" class="form-control" id={{'inputCode-delete-' . $role->id}} value="{{$role->code}}" name="code" disabled>

            <label for={{'inputName-delete-'. $role->id}} class="control-label">Tên</label>
            <input type="text" class="form-control" id={{'inpuName-delete-'. $role->id}} value="{{$role->name}}" name="name" disabled>
        </div>    
    </div>
@endcomponent