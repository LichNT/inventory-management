@component('components.modal-add', [ 
    'type' => 'company', 
    'title' => __('model.company'),
    'width' => '35%',
    'route' => 'companies.add',
    ])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Mã <span style="color:red">*</span></label>
            <input type="text" class="form-control" value="{{old('code')}}"  name="code" tabindex="1" autofocus required>           

            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" value="{{old('name')}}" name="name" tabindex="2" required> 
            
            <label for="role_id" class="control-label">Trực thuộc</label>        
            @component('components.select', ['data' => $companies, 
                'text' => 'name', 
                'name' => 'parent_id', 
                'value' => 'id',
                'id' => 'parent_id', 
                'idSelected'=>  old('parent_id'),
                'tabindex'=> 3,
                'none_required' => true
                ])
            @endcomponent

            @component('components.group-checkbox', [
                'title' => 'Hoạt động',
                'id' => 'active',
                'name' => 'active',
                'title_active' => __('system.active2'),
                'title_inactive' => __('system.inactive2'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => old('active', 1),       
            ])
            @endcomponent 
                         
        </div>        
    </div>      
@endcomponent