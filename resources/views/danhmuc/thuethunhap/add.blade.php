@component('components.modal-add', [
   'type' => 'thuethunhap',
   'title' => __('model.thue_thu_nhap'),
   'width' => '35%',
   'route' => 'danhmuc.thuethunhap.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label  class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="1" required value="{{old('ten')}}">
            <label  class="control-label">Cận trên</label>
            <input type="text" class="maskmoney form-control" name="can_tren"  tabindex="2"  value="{{old('can_tren')}}">
            <label  class="control-label">Hệ số (%)<span style="color:red">*</span></label>
            <input type="number" class="form-control" step="0.01" name="thue_suat" min=0 max=100 tabindex="3"  value="{{old('thue_suat')}}">
        </div>
    </div>
@endcomponent