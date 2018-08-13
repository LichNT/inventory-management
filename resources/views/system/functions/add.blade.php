@component('components.modal-add', [ 
    'type' => 'function', 
    'title' => __('model.function'),
    'width' => '20%',
    'route' => 'system.functions.add',
    ])
    <div class="row">
        <div class="col-sm-12">
            <label for="role" class="control-label">Vai trò người dùng<span style="color:red">*</span></label>
            @component('components.select', ['data' => $name_role, 
                'text' => 'name', 
                'name' => 'role_id', 
                'value' => 'id',
                'id' => 'role',
                'idSelected'=>old('role_id'),
                'tabindex'=>1,
                ])
            @endcomponent 

            <label for='menu' class="control-label">Menu<span style="color:red">*</span></label>
            @component('components.select', ['data' => $name_menu, 
                'text' => 'name', 
                'name' => 'menu_id', 
                'value' => 'id',
                'id' => 'menu',
                'idSelected' => old('menu_id'),
                'tabindex' => 2,
                ])
            @endcomponent

            @component('components.group-checkbox', [
                'title' => 'Trang chủ',
                'id' => 'home_router',
                'name' => 'home_router',
                'title_active' => 'Có',
                'title_inactive' => 'Không',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => old('home_router', 0),            
            ])
            @endcomponent  
        </div>        
    </div>
@endcomponent