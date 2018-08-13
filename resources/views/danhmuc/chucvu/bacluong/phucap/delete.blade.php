@component('components.confirm-delete',
[
    'route' => 'bacluong.phucap.delete',
    'method' => 'delete',
    'data' => $phucap,
    'type' => 'delete-phucap',
    'title' => 'Xóa',
    'width' => '35%'
])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Loại phụ cấp</label>
            @component('components.select', [
                          'data' => $loaiphucaps,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_loai_phu_cap',
                          'name' => 'id_loai_phu_cap',
                          'none_required'=>'true',
                          'idSelected'=>$phucap->id_loai_phu_cap,
                          'disabled'=>'disabled'
                      ])
            @endcomponent
            <label for="name" class="control-label">Số tiền(vnđ)</label>
            <input type="text" disabled class="form-control maskmoney" id="so_tien" name="so_tien" tabindex="1" required value="{{$phucap->so_tien}}" >

        </div>
    </div>
@endcomponent