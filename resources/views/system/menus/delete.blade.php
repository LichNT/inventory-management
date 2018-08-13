@component('components.confirm-delete', 
    [ 
        'route' => 'system.menus.delete', 
        'method' => 'delete', 
        'data' => $menu, 
        'type' => 'delete-menu',
        'title' => __('model.menu'),
        'width' => '35%',
    ])
    <div class="row">
        <div class="col-sm-6">
            <label for={{ 'inputName-detail-' .$menu->id}} class="control-label">Tên</label>
            <input type="text" class="form-control" id={{ 'inputName-detail-' .$menu->id}} value="{{$menu->name}}" name="name" disabled>

            <label for={{ 'inputRouter_link-detail-' .$menu->id}} class="control-label">Router Link</label>
            <input type="text" class="form-control" id={{ 'inputRouterLink-detail-' .$menu->id}} value="{{$menu->router_link}}" name="router_link" disabled>

            <label for=id={{ 'inputFa_icon-detail-' . $menu->id}} class="control-label">fa_icon</label>
            <input type="text" class="form-control" id={{ 'inputFa_icon-detail-' .$menu->id}} value="{{$menu->fa_icon}}" name="fa_icon" disabled>
        </div>
        <div class="col-sm-6">
            <label for={{ 'inputParen_ID-detail-' . $menu->id}} class="control-label">Danh mục cha</label>
            @if(!empty($menu->parent))
                <input type="text" class="form-control" id={{ 'inputParent_id-detail-' . $menu->id}} value="{{$menu->parent->name}}" name="parent_id" disabled>
            @else
                <input type="text" class="form-control" id={{ 'inputParent_id-detail-' . $menu->id}} value="Trống" name="parent_id" disabled>
            @endif

            <label for={{ 'inputOrder-detail-' .$menu->id}} class="control-label">Order</label>
            <input type="text" class="form-control" id={{ 'inputOrder-detail-' .$menu->id}} value="{{$menu->order}}" name="order" disabled>

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'inputActive-detail-' . $menu->id,
                'name' => 'active',
                'title_active' => 'Đang hoạt động',
                'title_inactive' => 'Ngừng hoạt động',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $menu->active,
                'disabled' => true           
            ])
            @endcomponent
        </div>    
    </div>
@endcomponent