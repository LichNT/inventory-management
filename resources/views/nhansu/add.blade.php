@extends('layouts.form') @section('css') @endsection @section('content')
<h2 class="page-header">
    TẠO MỚI THÔNG TIN NHÂN SỰ
</h2>
<form id="customer-add-form" method="POST" enctype="multipart/form-data" action="{{route('nhansu.add')}}" onsubmit="document.getElementById('onsubmit').disabled=true">
    {{csrf_field() }}
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="file-upload">
                        <div class="image-upload-wrap">
                            <input class="file-upload-input" type='file' accept="image/*" name="imageOrder"/>
                            <div class="drag-text">
                                <h3>Tải ảnh</h3>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image" src="#" alt="your image" />
                            <div class="image-title-wrap">
                                <button class="btn bg-olive btn-flat" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Thay ảnh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <label>Mã
                    <span style="color:red">*</span>
                </label>
                <input type="text" class="form-control" placeholder="Mã" name="ma" tabindex="1" readonly value="{{$ma_nhan_su}}" autofocus
                    required> @if ($errors->has('ma'))
                <span class="help-block" style="color:red">
                    <strong>{{ $errors->first('ma') }}</strong>
                </span>
                @endif
                <label>Họ và tên
                    <span style="color:red">*</span>
                </label>
                <input type="text" class="form-control" placeholder="Họ và tên" name="ho_ten" tabindex="2" value="{{old('ho_ten')}}" required> @if ($errors->has('ho_ten'))
                <span class="help-block" style="color:red">
                    <strong>{{ $errors->first('ho_ten') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <label>Ngày sinh</label>
                        <input type="text" class="form-control datemask" id="ngay_sinh" name="ngay_sinh" tabindex="3" value="{{old('ngay_sinh')}}">
                    </div>
                    <div class="col-md-6">
                        @component('components.group-checkbox', [ 'title' => 'Giới tính', 'id' => 'gioi_tinh', 'name' => 'gioi_tinh', 'title_active'
                        => 'Nam', 'title_inactive' => 'Nữ', 'value_active' => 1, 'value_inactive' => 0, 'value' => old('gioi_tinh',
                        1), 'tabindex' => 4, ]) @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Nơi sinh</label>
                        <input type="text" class="form-control" placeholder="Nơi sinh" name="noi_sinh" tabindex="5" value="{{old('noi_sinh')}}">
                    </div>
                    <div class="col-md-6">
                        <label for="first_name">Quê quán</label>
                        <input type="text" class="form-control" placeholder="Quê quán" name="que_quan" tabindex="6" value="{{old('que_quan')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Quốc tịch</label>
                        @component('components.select', [ 'data' => $quoc_gias, 'text' => 'ten', 'name' => 'quoc_tich', 'value' => 'id', 'none_required'
                        => true, 'id' => 'quoc_tich', 'tabindex' => 6, 'idSelected' => old('quoc_tich') ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        <label for="first_name">Tôn giáo</label>
                        @component('components.select',[ 'data' => $ton_giaos, 'text' => 'ten', 'name' => 'ton_giao', 'value' => 'id', 'none_required'
                        => true, 'id' => 'ton_giao', 'tabindex' => 7, 'idSelected' => old('ton_giao') ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        <label>Dân tộc</label>
                        @component('components.select', [ 'data' => $dan_tocs, 'text' => 'ten', 'name' => 'dan_toc', 'value' => 'id', 'none_required'
                        => true, 'id' => 'dan_toc', 'tabindex' => 8, 'idSelected' => old('dan_toc') ]) @endcomponent
                    </div>
                </div>
                <label>CMND/ Căn cước công dân</label>
                <input type="text" class="form-control" placeholder="CMND" name="cmnd" tabindex="9" value="{{old('cmnd')}}"> @if ($errors->has('cmnd'))
                <span class="help-block" style="color:red">
                    <strong>{{ $errors->first('cmnd') }}</strong>
                </span>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <label>Ngày cấp</label>
                        <input type="text" class="form-control datemask" id="ngay_cap" name="ngay_cap" tabindex="10" value="{{old('ngay_cap')}}">
                    </div>
                    <div class="col-md-6">
                        <label>Nơi cấp</label>
                        <input type="text" class="form-control" placeholder="Nơi cấp" name="noi_cap" tabindex="11" value="{{old('noi_cap')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Gia cảnh</label>
                        @component('components.select',[ 'data' => $gia_canhs, 'text' => 'ten', 'name' => 'gia_canh', 'value' => 'ma', 'none_required'
                        => true, 'id' => 'gia_canh', 'tabindex' => 12, 'idSelected' => old('gia_canh') ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        <label> Trình độ văn hóa</label>
                        @component('components.select',[ 'data' => $trinh_do_van_hoas, 'text' => 'ten', 'name' => 'id_trinh_do_van_hoa', 'value'
                        => 'id', 'none_required' => true, 'id' => 'id_trinh_do_van_hoa', 'tabindex' => 13, 'idSelected' =>
                        old('id_trinh_do_van_hoa') ]) @endcomponent
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label>Hộ khẩu thường trú</label>
                <input type="text" class="form-control" placeholder="Hộ khẩu thường trú" name="ho_khau_thuong_tru" tabindex="14" value="{{old('ho_khau_thuong_tru')}}">
                <label>Chỗ ở hiện nay</label>
                <input type="text" class="form-control" placeholder="Chỗ ở hiện nay" name="cho_o_hien_tai" tabindex="17" value="{{old('cho_o_hien_tai')}}">
                <label>Số điện thoại</label>
                <input type="text" class="form-control" placeholder="Số điện thoại" name="so_dien_thoai" tabindex="21" value="{{old('so_dien_thoai')}}">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="Email" name="email" tabindex="22" value="{{old('email')}}">
                <label>Trình độ</label>
                <input type="text" class="form-control" placeholder="Trình độ" name="trinh_do" tabindex="23" value="{{old('trinh_do')}}">
                <label for="first_name">Chuyên ngành</label>
                <input type="text" class="form-control" placeholder="Chuyên ngành" name="chuyen_nganh" tabindex="24" value="{{old('email')}}">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <label>Mã số thuế</label>
                <input type="text" class="form-control" placeholder="Mã số thuế" name="ma_so_thue" tabindex="25" value="{{old('ma_so_thue')}}"> @if ($errors->has('ma_so_thue'))
                <span class="help-block" style="color:red">
                    <strong>{{ $errors->first('ma_so_thue') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-md-4">
                <label>Tài khoản ngân hàng</label>
                <input type="text" class="form-control" placeholder="Tài khoản ngân hàng" name="tai_khoan_ngan_hang" tabindex="26" value="{{old('tai_khoan_ngan_hang')}}"> @if ($errors->has('tai_khoan_ngan_hang'))
                <span class="help-block" style="color:red">
                    <strong>{{ $errors->first('tai_khoan_ngan_hang') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" id="onsubmit" class="btn bg-olive btn-flat pull-right" tabindex="27">
            <i class="fa fa-check"></i> {{__('button.add')}}
        </button>
        <a href="{{route('nhansu')}}" id="btnback" class="btn btn-default btn-flat" tabindex="28">
            <i class="fa fa-undo"></i> {{__('button.back')}}
        </a>
    </div>
</form>
@endsection 

@section('script')
<script src="{{ asset('js/min/uploadimage.min.js') }}"></script>
@endsection