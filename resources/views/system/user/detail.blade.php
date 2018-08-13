@component('components.modal-update', [    
    'type' => 'update-user',
    'title' => __('model.nguoi_dung_he_thong'),    
    'width' => '40%',
    'route' => 'users.update',
    'data' => $user,
    'method' => 'post' 
])

<div class="row">
    <div class="col col-md-6">
        <label for={{'inputName-detail-' . $user->id}} class="control-label">Tên<span style="color:red">*</span></label>
        <input type="text" class="form-control" id={{'inputName-detail-' . $user->id}} value="{{$user->name}}" name="name" tabindex=1 required>

        <label for={{'inputEmail-detail-' .$user->id}} class="control-label">Email<span style="color:red">*</span></label>
        <input type="email" class="form-control" id={{'inputEmail-detail-' .$user->id}} value="{{$user->email}}" name="email" tabindex=3 required>
        @if(Auth::user()->role->code=="sysadmin")
        <label for="role_id" class="control-label">Công ty</label>
            @component('components.select', ['data' => $companies,
                'text' => 'name',
                'name' => 'company_id',
                'value' => 'id',
                'idSelected'=> $user->company_id ,
                'tabindex'=>5
                ])
            @endcomponent
        @endif
        <label for="first_name">{{$ten_hien_thi_mien}}</label>
        @component('components.select',[
            'data' => $miens,
            'text' => 'ten',
            'name' => 'id_mien',
            'value' => 'id',
            'chil'=>'chinhanh',
            'parent_name'=>'chinhanh',
            'id_current'=>'1',
            'idChild'=>'chinhanh'.$user->id,
            'on_change'=>true,
            'tabindex' => 6,
            'none_required'=>true,
            'idSelected' =>empty($user->id_mien)? '':$user->id_mien,'value'=>'id',
            ])
        @endcomponent
        <label class="control-label" >Mật khẩu mới</label>
        <input type="password" class="form-control" id="{{'inputPasword-detail-' . $user->id}}" name="password" tabindex="8" placeholder="Mật khẩu hiện mới" minlength="6" maxlength="255">
    </div>
    <div class="col col-md-6">
        <label for={{'inputUserName-detail-' .$user->id}} class="control-label">Tài khoản<span style="color:red">*</span></label>
        <input type="text" class="form-control" id="{{'inputUserName-detail-' .$user->id}}" value="{{$user->username}}" tabindex=2 name="username" required>

        <label for={{'inputRole-detail-' . $user->id}} class="control-label">Quyền<span style="color:red">*</span></label>
        @component('components.select', ['data' => $roles,
            'text' => 'name',
            'name' => 'role_id',
            'value' => 'id',
            'tabindex' => 4,
            'id' => 'inputRole-detail-' . $user->id,
            'idSelected' => $user->role->id]),
           
        @endcomponent
        <label for="first_name">{{$ten_hien_thi_chi_nhanh}}</label>
        @component('components.select', [
            'data' => $user->mien->childs,
            'text' => 'ten',
            'name' => 'id_chi_nhanh',
            'value' => 'id',
            'none_required'=>true,
            'id'=>'chinhanh'.$user->id,
            'tabindex' => 6,
            'idSelected' => empty($user->id_chi_nhanh)? '':$user->id_chi_nhanh,'value'=>'id',
            ])
        @endcomponent
        @component('components.group-checkbox', [
                'title' => 'Hoạt động',
                'id' => 'inputActive-detail-' . $user->id,
                'name' => 'active',
                'title_active' => __('system.active2'),
                'title_inactive' => __('system.inactive2'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $user->active,
            ])
        @endcomponent
    </div>
</div>

@endcomponent