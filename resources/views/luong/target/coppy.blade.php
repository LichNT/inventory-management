@component('components.modal-add', [
   'type' => 'coppy',
   'title' => __('model.target'),
   'width' => '35%',
   'route' => 'luong.target.coppy'
   ])
    <div class="row">
        <div class="col-sm-12">
        <label for="name" class="control-label">Tháng <span style="color:red">*</span></label>
            <input type="text" class="form-control monthmask" required id="ngay" name="thang_current" tabindex="3"  value="{{\Carbon\Carbon::now()->format('m/Y')}}" >

            <label for="name" class="control-label">Copy từ tháng <span style="color:red">*</span></label>
            <input type="text" class="form-control monthmask" required id="thang_old" name="thang_old" tabindex="3"  value="{{old('thang_old')}}" >

        </div>
    </div>
@endcomponent