@component('components.modal-update', [ 
    'type' => 'update-role',
    'title' => __('model.role'),
    'width' => '25%',
    'route' => 'system.roles.update',
    'data' => $role,
    'method' => 'put'])

    <div class="row">
        <div class="col-md-6">
            <label for={{'inputCode-detail-' . $role->id}} class="control-label">Mã<span style="color:red">*</span></label>
            @if ($role->system)
            <input type="text" class="form-control" id={{'inputCode-detail-' . $role->id}} value="{{$role->code}}" name="code" tabindex="1" required autoficus readonly>
            @else
                <input type="text" class="form-control" id={{'inputCode-detail-' . $role->id}} value="{{$role->code}}" name="code" tabindex="1" required autoficus> 
            @endif            
        </div>
        <div class="col-md-6">
            <label for="{{'inputName-detail-' .$role->id}}" class="control-label">Vai trò(role)<span style="color:red">*</span></label>
            <input type="text" class="form-control" id={{'inputName-detail-' .$role->id}} value="{{$role->name}}" name="name" required tabindex="2">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="{{'inputDescription-detail-' . $role->id}}" class="control-label">Ghi chú<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="{{'inputDescription-detail-' .$role->id}}" name="description" required placeholder="Mô tả chi tiết quyền" value="{{$role->description}}" tabindex="3">
        </div>        
    </div>    
@endcomponent