@component('components.modal-update', [
   'type' => 'update-hopdongchucvu',
   'title' => __('model.hop_dong_chuc_vu'),
   'width' => '35%',
   'route' => 'danhmuc.hopdongchucvu.update',
   'data' => $hopdongchucvu,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Loại hợp đồng  <span style="color:red">*</span></label>
            @component('components.select', [
                          'data' => $loaihopdongs,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_loai_hop_dong',
                          'name' => 'id_loai_hop_dong',
                          'none_required'=>'true',
                           'idSelected'=>$hopdongchucvu->id_loai_hop_dong
                      ])
            @endcomponent
            <label for="name" class="control-label">Loại chức vụ  <span style="color:red">*</span></label>
            @component('components.select', [
                          'data' => $chucvus,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_chuc_vu',
                          'name' => 'id_chuc_vu',
                          'none_required'=>'true',
                          'idSelected'=>$hopdongchucvu->id_chuc_vu

                      ])
            @endcomponent
        </div>
    </div>
@endcomponent