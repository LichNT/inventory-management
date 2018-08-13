@component('components.modal-update', [ 
    'type' => 'update-menu',
    'title' => __('model.menu'),
    'width' => '25%',
    'route' => 'system.menus.update',
    'data' => $menu,
    'method' => 'put'])

    <div class="row">
        <div class="col-md-6">
            <label for={{ 'inputName-detail-'. $menu->id}} class="control-label">Tên</label>
            <input type="text" class="form-control" id={{'inputName-detail-' . $menu->id}} value="{{$menu->name}}" name="name" tabindex="1" autofocus required>

            <label for={{ 'inputRouter_link-detail-'. $menu->id}} class="control-label">Router Link</label>
            <input type="text" class="form-control" id={{'inputRouter_link-detail-' . $menu->id}} value="{{$menu->router_link}}" name="router_link" tabindex="2">
            
            <label for=id={{ 'fa_icon-detail-'. $menu->id}} class="control-label">fa icon</label>
            <input type="text" class="form-control" id={{ 'fa_icon-detail-' . $menu->id}} value="{{$menu->fa_icon}}" name="fa_icon" tabindex="3" required>
        </div>
        <div class="col-md-6">
            <label for={{'parent_id_'. $menu->id}} class="control-label">Chức năng cha</label>
            @component('components.select', ['data' => $menu_parents, 
                'text' => 'name', 
                'name' => 'parent_id', 
                'value' => 'id',
                'id' => 'parent_id_'. $menu->id, 
                'none_required' => true,
                'idSelected' => $menu->parent_id,
                ])
            @endcomponent

            <label for={{ 'order-detail-' . $menu->id}} class="control-label">Order</label>
            <input type="number" class="form-control" id={{ 'order-detail-' . $menu->id}} value="{{$menu->order}}" name="order" required>

            @component('components.group-checkbox', [
                'title' => 'Còn sử dụng',
                'id' => 'active_detail_' . $menu->id,
                'name' => 'active',
                'title_active' => 'Có',
                'title_inactive' => 'Không',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => 1,                         
            ])
            @endcomponent
        </div>
    </div>        
@endcomponent