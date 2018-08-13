@component('components.modal-update', [ 
    'type' => 'update-lookup',
    'title' => __('model.lookup'),   
    'width' => '25%',
    'route' => 'lookup.update',
    'data' => $lookup,
    'method' => 'POST'])

    <div class="row">
        <div class="col-md-12">
            <label for="code" class="control-label">Mã <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" value="{{$lookup->ma}}" name="ma" autofocus tabindex="1" required>

            <label for="ten" class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" value="{{$lookup->ten}}" name="ten" tabindex="2" required>

            <label for="loai" class="control-label">Loại<span style="color:red">*</span></label>
            @component('components.select', ['data' => $loaiLookups, 'text' => 'ten', 'value' => 'ma', 'id' => 'loai', 'name' => 'loai', 'idSelected' => $lookup->loai])
            @endcomponent

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'active',
                'name' => 'active',
                'title_active' => 'Còn sử dụng',
                'title_inactive' => 'Ngừng sử dụng',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $lookup->active,            
            ])
            @endcomponent 
        </div>       
    </div>       
@endcomponent