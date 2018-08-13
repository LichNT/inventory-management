@component('components.modal-update', [ 'type' => 'update-import-nhansu', 'title' => __('model.import_data'), 'width' => '60%',
'route' => 'import.update', 'data' => $importnhansu, 'method' => 'put' ])

<div class="row">
    <div class="col-md-6">
        <label>Họ và tên<span style="color:red">*</span></label>
        <input type="text" class="form-control" value="{{$importnhansu->ho_ten}}" name="ho_ten" required tabindex="1">
        @if ($errors->has('ho_ten'))
            <span class="help-block" style="color:red">
                        <strong>{{ $errors->first('ho_ten') }}</strong>
                    </span>
        @endif
        <label>Mã số thuế</label>
        <input type="text" class="form-control" value="{{$importnhansu->ma_so_thue}}" name="ma_so_thue" tabindex="15">
        @if ($errors->has('ma_so_thue'))
            <span class="help-block" style="color:red">
                        <strong>{{ $errors->first('ma_so_thue') }}</strong>
                    </span>
        @endif
    </div>
    <div class="col-md-6">
        <label>CMND</label>
        <input type="text" class="form-control" value="{{$importnhansu->cmnd}}" name="cmnd" tabindex="2">
        @if ($errors->has('cmnd'))
            <span class="help-block" style="color:red">
                        <strong>{{ $errors->first('cmnd') }}</strong>
                    </span>
        @endif
        <label>Tài khoản ngân hàng</label>
        <input type="text" class="form-control" value="{{$importnhansu->tai_khoan_ngan_hang}}" placeholder="Tài khoản ngân hàng" name="tai_khoan_ngan_hang"
               tabindex="14">
        @if ($errors->has('tai_khoan_ngan_hang'))
            <span class="help-block" style="color:red">
                        <strong>{{ $errors->first('tai_khoan_ngan_hang') }}</strong>
                    </span>
        @endif
        <label>Trạng thái import</label>
        @if($importnhansu->active)            
            <input type="text" class="form-control" value="Đã import" tabindex="16" readonly>
        @else
            <input type="text" class="form-control" value="Chưa import" tabindex="18" readonly>
        @endif         
    </div>    
</div>
@endcomponent