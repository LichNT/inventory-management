@component('components.confirm-delete', [ 
    'route' => 'system.functions.delete', 
    'method' => 'delete', 
    'data' => $rolemenu,
    'type'=> 'delete-rolemenu',
    'title' => __('model.function'),
    'width' => '20%',
    ])
    <div class="row">
        <div class="col-sm-12">
            <label for={{ 'inputParen_ID-detail-' . $rolemenu->id}} class="control-label">Role</label>
            <input type="text" class="form-control" id={{ 'inputParent_id-detail-' . $rolemenu->id}} value="{{$rolemenu->role->name}}" name="role_id" disabled>

            <label for={{ 'inputName-detail-' .$rolemenu->id}} class="control-label">Menu </label>
            <input type="text" class="form-control" id={{ 'inputName-detail-' .$rolemenu->id}} value="{{$rolemenu->menu->name}}" name="menu_id" disabled>
        </div>        
    </div>
@endcomponent