@component('components.modal-add', [ 
        'type' => 'menu', 
        'title' => __('model.menu'),
        'route' => 'system.menus.add',
        'width' => '35%',
    ])
    <div class="row">
        <div class="col-sm-6">
            <label for="name" class="control-label">Tên</label>
            <input type="text" class="form-control" id="name" value="{{old('name')}}" name="name" tabindex="1" autofocus required>

            <label for="router_link" class="control-label">Router Link</label>
            <input type="text" class="form-control" id="router_link" value="{{old('router_link')}}" name="router_link" tabindex="2">

            <label for"fa_icon" class="control-label">fa icon</label>
            <input type="text" class="form-control" id="fa_icon" value="{{old('fa_icon')}}" name="fa_icon" placeholder="fa-xxx tham khảo tại https://fontawesome.com/icons" tabindex="3" required>
        </div>
        <div class="col-sm-6">
            <label for="parent_id" class="control-label">Chức năng cha</label>
            @component('components.select', ['data' => $menu_parents, 
                'text' => 'name', 
                'name' => 'parent_id', 
                'value' => 'id',
                'id' => 'parent_id', 
                'none_required' => true,
                'idSelected'=>old('parent_id'),
                'tabindex'=>4
                ])
            @endcomponent

            <label for="order" class="control-label">Order</label>
            <input type="number" class="form-control" id="order"value="{{old('order')}}" name="order" tabindex="5">

            @component('components.group-checkbox', [
                'title' => 'Còn sử dụng',
                'id' => 'active',
                'name' => 'active',
                'title_active' => 'Có',
                'title_inactive' => 'Không',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => old('active',1),                         
            ])
            @endcomponent
        </div>
    </div>       
@endcomponent