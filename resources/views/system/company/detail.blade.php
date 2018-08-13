@component('components.modal-update', [    
    'type' => 'update-company',
    'title' => __('model.company'),    
    'width' => '35%',
    'route' => 'companies.update',
    'data' => $company,
    'method' => 'put' 
])

<div class="row">
    <div class="col col-md-12">
        <label  class="control-label">Mã <span style="color:red">*</span></label>
        <input type="text" class="form-control" value="{{$company->code}}" name="code" required>

        <label  class="control-label">Tên <span style="color:red">*</span></label>
        <input type="text" class="form-control" value="{{$company->name}}" name="name" required>

        <label for="role_id" class="control-label">Trực thuộc</label>        
        @component('components.select', ['data' => $companies, 
            'text' => 'name', 
            'name' => 'parent_id', 
            'value' => 'id',
            'id' => 'parent_id', 
            'idSelected'=> $company->parent_id,
            'tabindex'=> 3,
            'none_required' => true,
            ])
        @endcomponent 
              
        @component('components.group-checkbox', [
            'title' => 'Hoạt động',            
            'name' => 'active',
            'title_active' => __('system.active2'),
            'title_inactive' => __('system.inactive2'),
            'value_active' => 1,
            'value_inactive' => 0,
            'value' => $company->active,            
        ])
        @endcomponent             
    </div>                   
</div>
@endcomponent