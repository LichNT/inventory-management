@component('components.modal-update', [ 
    'type' => 'auth-changepassword',
    'title' => 'mật khẩu',
    'width' => '25%',
    'route' => 'profile.changepassword',
    'data' => $user,
    'method' => 'post'])

    <div class="row">
        <div class="col-md-12">
            <label for="inputPassword" class="control-label">Mật khẩu</label>
            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Mật khẩu hiện tại">
            
            <label for="inputNewPassword" class="control-label">Mật khẩu mới</label>
            <input type="password" class="form-control" id="inputNewPassword" name="new_password" placeholder="Mật khẩu mới">

            <label for="inputComfirmNewPassword" class="control-label">Nhập lại mật khẩu mới</label>
            <input type="password" class="form-control" id="inputComfirmPassword" name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới">
        </div>        
    </div>        
@endcomponent