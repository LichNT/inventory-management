@component('components.modal-add', [ 
    'type' => 'role', 
    'title' => __('model.role'),
    'width' => '25%',
    'route' => 'system.roles.add',
    ])
    <div class="row">
        <div class="col-sm-6">
            <label for="code" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="code" value="{{old('code')}}" name="code" placeholder="Mã quyền" autofocus tabindex="1" required>
        </div>
        <div class="col-sm-6">
            <label for="name" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="name" value="{{old('name')}}" name="name" placeholder="Vai trò(role)" tabindex="2" required>
        </div>
    </div>
    <div class="row">          
        <div class="col-sm-12">
            @component('components.group-checkbox', [
                'title' => 'Quyền hệ thống',
                'id' => 'system',
                'name' => 'system',
                'title_active' => 'Có',
                'title_inactive' => 'Không',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => old('active', 1),       
            ])
            @endcomponent

            <label for="description" class="control-label">Ghi chú<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="description" value="{{old('description')}}" name="description" required placeholder="Mô tả chi tiết quyền" tabindex="3">
        </div>    
    </div>   
@endcomponent