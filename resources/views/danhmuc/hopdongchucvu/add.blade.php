@component('components.modal-add', [
   'type' => 'hopdongchucvu',
   'title' => __('model.hop_dong_chuc_vu'),
   'width' => '35%',
   'route' => 'danhmuc.hopdongchucvu.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Loại hợp đồng  <span style="color:red">*</span></label>
            @component('components.select', [
                          'data' => $loaihopdongs,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_loai_hop_dong',
                          'name' => 'id_loai_hop_dong',
                          'none_required'=>'true'
                      ])
            @endcomponent
            <label for="name" class="control-label">Loại chức vụ  <span style="color:red">*</span></label>
            @component('components.select', [
                          'data' => $chucvus,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_chuc_vu',
                          'name' => 'id_chuc_vu',
                          'none_required'=>'true'
                      ])
            @endcomponent
        </div>
    </div>
@endcomponent