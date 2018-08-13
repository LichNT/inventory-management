@component('components.modal-update', [
   'type' => 'update-luong',
   'title' => 'Cập nhật',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'nhansu.update.luong.edit',
   'data' => $luong,
   'method' => 'PUT'])

    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">Bậc lương</label>
            @component('components.select', [
            'data' => $bacs,
            'idSelected'=>empty($luong->bac_id)? '':$luong->bac_id,'value'=>'id',
            'text' => 'ten', 'name' => 'bac_id',
             'none_required' => true,
             'id'=>"bac".$luong->id, 'tabindex' => 2])
            @endcomponent
            <input type="hidden" id="bac_hidden" data="{{$bacs}}">

        </div>

        <div class="col-md-6">
            <label for="ngay_huong_luong" class="control-label datemask">Ngày hưởng lương<span style="color:red">*</span></label>
            <input type="text" class="form-control datemask"  required name="ngay_huong_luong" tabindex="3" value="{{$luong->ngay_huong_luong}}">
        </div>
        <div class="col-md-6">
            <label for="so_quyet_dinh" class="control-label">Số quyết định</label>
            <input type="text" class="form-control"  name="so_quyet_dinh" tabindex="4" value="{{$luong->so_quyet_dinh}}">
        </div>
        <div class="col-md-6">
            <label for="ngay_ky" class="control-label datemask">Ngày ký</label>
            <input type="text" class="form-control datemask"   name="ngay_ky" tabindex="5" value="{{$luong->ngay_ky}}">
        </div>
        <div class="col-md-6">
            <label for="dien_dai" class="control-label">Diễn giải</label>
            <textarea class="form-control" rows="4" name="dien_dai" tabindex="6">{{$luong->dien_dai}}</textarea>
        </div>
        <div class="col-md-6">
            <label for="he_so_phu_cap_chuc_vu" class="control-label">Hệ số phụ cấp chức vụ</label>
            <input type="number" step="any" class="form-control" name="he_so_phu_cap_chuc_vu" tabindex="7" value="{{$luong->he_so_phu_cap_chuc_vu}}">
        </div>
        <div class="col-md-6">
            <label for="he_so_phu_cap_doc_hai" class="control-label">Hệ số phụ cấp độc hại</label>
            <input type="number" step="any" class="form-control"  name="he_so_phu_cap_doc_hai" tabindex="8" value="{{$luong->he_so_phu_cap_doc_hai}}">
        </div>
        <div class="col-md-6">
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'name' => 'inactive',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 0,
                'value_inactive' => 1,
                'value' => $luong->inactive,
            ])
            @endcomponent
        </div>
    </div>

@endcomponent