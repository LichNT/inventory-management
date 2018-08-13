@component('components.modal-add', [ 
    'type' => 'user', 
    'title' => __('model.nguoi_dung_he_thong'),
    'width' => '40%',
    'route' => 'users.add',
    ])
    <div class="row">
        <div class="col-sm-6">
            <label for="name" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="name"  value="{{old('name')}}"  name="name" tabindex="1" autofocus required>           

            <label for="email" class="control-label">Email<span style="color:red">*</span></label>
            <input type="email" class="form-control" id="email"  value="{{old('email')}}" name="email" tabindex="3" required>
            @if(Auth::user()->role->code=="sysadmin")
                <label for="role_id" class="control-label">Công ty</label>
                @component('components.select', ['data' => $companies,
                    'text' => 'name',
                    'name' => 'company_id',
                    'value' => 'id',
                    'idSelected'=>  old('company_id'),
                    'tabindex'=>5
                    ])
                @endcomponent
            @endif
            <label for="first_name">{{$ten_hien_thi_mien}}</label>
            @component('components.select', [
                'data' => $miens,
                'text' => 'ten',
                'name' => 'id_mien',
                'value' => 'id',
                'id' => 'mien',
                'none_required'=>true,
                'tabindex' => 6,
                'idSelected' => old('id_mien')
                ])
            @endcomponent
            <label for="password" class="control-label">Mật khẩu<span style="color:red">*</span></label>
            <input type="password" class="form-control"  value="{{old('password')}}" id="password" name="password" tabindex="8" required minlength="6" maxlength="255">
            @component('components.group-checkbox', [
            'title' => 'Hoạt động',
            'id' => 'active',
            'name' => 'active',
            'title_active' => __('system.active2'),
            'title_inactive' => __('system.inactive2'),
            'value_active' => 1,
            'value_inactive' => 0,
            'value' =>old('active',1),
        ])
        @endcomponent

        </div>
        <div class="col-md-6">
        <label for="username" class="control-label">Tài khoản<span style="color:red">*</span></label>
            <input type="text" class="form-control"  value="{{old('username')}}" id="username" name="username" tabindex="2" required>
            
            <label for="role_id" class="control-label">Quyền<span style="color:red">*</span></label>
            @component('components.select', ['data' => $roles, 
                'text' => 'name', 
                'name' => 'role_id', 
                'value' => 'id',
                'id' => 'role_id', 
                'idSelected'=>  old('role_id'),
                'tabindex'=>4
                ])
            @endcomponent

            <label for="first_name">{{$ten_hien_thi_chi_nhanh}}</label>
            @component('components.select', [
                'data' => $chinhanhs,
                'text' => 'ten',
                'name' => 'id_chi_nhanh',
                'value' => 'id',
                'id' => 'chi_nhanh',
                'none_required'=>true,
                'tabindex' => 6,
                'idSelected' => old('id_chi_nhanh')
                ])
            @endcomponent
            <label for="password_confirmation" class="control-label">Nhập lại mật khẩu<span style="color:red">*</span></label>
            <input type="password" class="form-control"  value="{{old('password_confirmation')}}" id="password_confirmation" name="password_confirmation" tabindex="8" required minlength="6" maxlength="255">

        </div>
    </div>

@endcomponent