@component('components.confirm-delete', 
[ 
    'route' => 'companies.delete', 
    'method' => 'delete', 
    'data' => $company, 
    'type' => 'delete-company',
    'title' => __('model.company'),    
])
<div class="row">
    <div class="col-sm-12">
        <label  class="control-label">Mã</label>
        <input type="text" class="form-control" value="{{$company->code}}" disabled>
        <label  class="control-label">Tên</label>
        <input type="text" class="form-control" value="{{$company->name}}" disabled>
        <label  class="control-label">Trực thuộc</label>
        <input type="text" class="form-control" value="{{isset($company->parent) ? $company->parent->name : null}}" disabled>        
        @component('components.group-checkbox', [
                'title' => 'Trạng thái',                
                'name' => 'active',
                'title_active' => __('system.active2'),
                'title_inactive' => __('system.inactive2'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $company->active,
                'disabled' => true           
            ])
        @endcomponent
    </div>    
</div>
@endcomponent