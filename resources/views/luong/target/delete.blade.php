@component('components.confirm-delete',
[
    'route' => 'luong.target.delete',
    'method' => 'delete',
    'data' => $target,
    'type' => 'delete-target',
    'title' => __('model.target'),
    'width' => '35%',
])
    <div class="row">
        <div class="col-sm-12">
            <label>Chọn cửa hàng</label>
            @component('components.select2', [
                    'disabled'=>'disabled',
                    'placeholder' => 'Chọn',
                    'data' => $cuahangs,
                    'text' => 'ten',
                    'id'=>'id',
                    'value' => 'id',
                    'idSelected' => $target->id_cua_hang,
                    'name' => 'id_cua_hang',

                ])
            @endcomponent
            <label>Chọn loại target</label>
            @component('components.select2', [
                    'disabled'=>'disabled',
                    'placeholder' => 'Chọn',
                    'data' => $loaitargets,
                    'text' => 'ten',
                    'id'=>'loai_target',
                    'value' => 'id',
                    'idSelected' => $target->id_loai_target,
                    'name' => 'id_loai_target',
                ])
            @endcomponent

            <label for="name" class="control-label">Số tiền </label>
            <input type="number" class="form-control" disabled id="ngay" name="so_tien" tabindex="3" value="{{$target->so_tien}}" >

            <label for="name" class="control-label">Từ ngày</label>
            <input type="text" class="form-control datemask" disabled id="ngay" name="tu_ngay" tabindex="3"  value="{{$target->tu_ngay}}" >

        </div>
    </div>
@endcomponent