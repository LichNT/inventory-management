@component('components.modal-add', [
   'type' => 'bacluong',
   'title' => __('model.phu_cap'),
   'width' => '35%',
   'route' => 'bacluong.phucap.add',
   'id' => $bac_id,
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
                          'none_required'=>'true'
                      ])
            @endcomponent

        </div>
    </div>
@endcomponent