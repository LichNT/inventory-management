@component('components.confirm-delete', 
[ 
    'route' => 'users.delete', 
    'method' => 'delete', 
    'data' => $user, 
    'type' => 'delete-user',
    'title' => __('model.nguoi_dung_he_thong'),    
])
<div class="row">
    <div class="col-sm-12">
        <label for={{'inputName-delete-' . $user->id}} class="control-label">Tên</label>
        <input type="text" class="form-control" id={{'inputName-delete-' . $user->id}} value="{{$user->name}}" name="name" disabled>

        <label for={{'inputUserName-delete-'. $user->id}} class="control-label">Tài khoản</label>
        <input type="text" class="form-control" id={{'inputUserName-delete-'. $user->id}} value="{{$user->username}}" name="username" disabled>
    </div>    
</div>
@endcomponent