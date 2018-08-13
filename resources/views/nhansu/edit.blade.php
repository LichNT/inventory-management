@extends('nhansu.edit-layout')

@section('title_detail')
    LÝ LỊCH
@endsection

@section('content_detail')
    <form action="{{ route('nhansu.update.chung', $nhansu->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="col-md-12">
                        <div class="file-upload" >
                            <div class="image-upload-wrap" style="{{empty($nhansu->hinh_anh)? '':'display:none'}}">
                                <input class="file-upload-input" type='file' accept="image/*" name="urlImages" />
                                <div class="drag-text">
                                    <h3>Tải ảnh đại diện</h3>
                                </div>
                            </div>
                            <div class="file-upload-content" style="{{empty($nhansu->hinh_anh)? '':'display:block'}}">
                                <img class="file-upload-image" src="{{empty($nhansu->hinh_anh)? '#':url($nhansu->hinh_anh)}}" alt="your image" />
                                <div class="image-title-wrap">
                                    <br/>
                                    <button class="btn bg-olive btn-flat" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Thay ảnh đại diện
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label>Mã
                        <span style="color:red">*</span>
                    </label>
                    <input type="text" class="form-control" placeholder="Mã" name="ma" tabindex="1" value="{{$nhansu->ma}}" autofocus readonly>
                    @if ($errors->has('ma'))
                        <span class="help-block" style="color:red">
                            <strong>{{ $errors->first('ma') }}</strong>
                        </span>
                    @endif
                    <label>Họ và tên
                        <span style="color:red">*</span>
                    </label>
                    <input type="text" class="form-control" placeholder="Họ và tên" name="ho_ten" tabindex="2" value="{{$nhansu->ho_ten}}" >
                    @if ($errors->has('ho_ten'))
                        <span class="help-block" style="color:red">
                            <strong>{{ $errors->first('ho_ten') }}</strong>
                        </span>
                    @endif
                    <br/>
                    <label>Mã thẻ chấm công
                    </label>
                    <input type="text" class="form-control"  name="ma_the_cham_cong"  value="{{$nhansu->ma_the_cham_cong}}" autofocus readonly>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Ngày sinh</label>
                            <input type="text" class="form-control datemask" id="ngay_sinh" name="ngay_sinh" tabindex="3" value="{{$nhansu->ngay_sinh}}">
                        </div>
                        <div class="col-md-6">
                            @component('components.group-checkbox', [ 'title' => 'Giới tính', 'name' => 'gioi_tinh', 'title_active'
                            => 'Nam', 'title_inactive' => 'Nữ', 'value_active' => 1, 'value_inactive' => 0, 'value' =>$nhansu->gioi_tinh,
                            'tabindex' => 4, ]) @endcomponent
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nơi sinh</label>
                            <input type="text" class="form-control" placeholder="Nơi sinh" name="noi_sinh" tabindex="5" value="{{$nhansu->noi_sinh}}">
                        </div>
                        <div class="col-md-6">
                            <label for="first_name">Quê quán</label>
                            <input type="text" class="form-control" placeholder="Quê quán" name="que_quan" tabindex="6" value="{{$nhansu->que_quan}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Quốc tịch</label>
                            @component('components.select', [ 'data' => $quoc_gias, 'text' => 'ten', 'name' => 'quoc_tich', 'value' => 'id', 'none_required'
                            => true, 'id' => 'quoc_tich', 'tabindex' => 6, 'idSelected' => $nhansu->quoc_tich ]) @endcomponent
                        </div>
                        <div class="col-md-4">
                            <label for="first_name">Tôn giáo</label>
                            @component('components.select',[ 'data' => $ton_giaos, 'text' => 'ten', 'name' => 'id_ton_giao', 'value' => 'id', 'none_required'
                            => true, 'id' => 'ton_giao', 'tabindex' => 7, 'idSelected' => $nhansu->id_ton_giao ]) @endcomponent
                        </div>
                        <div class="col-md-4">
                            <label>Dân tộc</label>
                            @component('components.select', [ 'data' => $dan_tocs, 'text' => 'ten', 'name' => 'dan_toc', 'value' => 'id', 'none_required'
                            => true, 'id' => 'dan_toc', 'tabindex' => 8, 'idSelected' => $nhansu->dan_toc ]) @endcomponent
                        </div>
                    </div>
                    <label>CMND/ Căn cước công dân</label>
                    <input type="text" class="form-control" placeholder="CMND" name="cmnd" tabindex="9" value="{{$nhansu->cmnd}}">
                    @if ($errors->has('cmnd'))
                        <span class="help-block" style="color:red">
                            <strong>{{ $errors->first('cmnd') }}</strong>
                        </span>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <label>Ngày cấp</label>
                            <input type="text" class="form-control datemask" id="ngay_cap" name="ngay_cap" tabindex="10" value="{{$nhansu->ngay_cap}}">
                        </div>
                        <div class="col-md-6">
                            <label>Nơi cấp</label>
                            <input type="text" class="form-control" placeholder="Nơi cấp" name="noi_cap" tabindex="11" value="{{$nhansu->noi_cap}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Gia cảnh</label>
                            @component('components.select',[ 'data' => $gia_canhs, 'text' => 'ten', 'name' => 'gia_canh', 'value' => 'ma', 'none_required'
                            => true, 'id' => 'gia_canh', 'tabindex' => 12, 'idSelected' => $nhansu->gia_canh ]) @endcomponent
                        </div>
                        <div class="col-md-6">
                            <label> Trình độ văn hóa</label>
                            @component('components.select',[ 'data' => $trinh_do_van_hoas, 'text' => 'ten', 'name' => 'id_trinh_do_van_hoa', 'value'
                            => 'id', 'none_required' => true, 'id' => 'id_trinh_do_van_hoa', 'tabindex' => 13, 'idSelected' => $nhansu->id_trinh_do_van_hoa
                            ]) @endcomponent
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <label>Hộ khẩu thường trú</label>
                    <input type="text" class="form-control" placeholder="Hộ khẩu thường trú" name="ho_khau_thuong_tru" tabindex="14" value="{{$nhansu->ho_khau_thuong_tru}}">                    
                    <label>Chỗ ở hiện nay</label>
                    <input type="text" class="form-control" placeholder="Chỗ ở hiện tại" name="cho_o_hien_tai" tabindex="17" value="{{$nhansu->cho_o_hien_tai}}">                    
                    <label>Số điện thoại</label>
                    <input type="text" class="form-control" placeholder="Số điện thoại" name="so_dien_thoai" tabindex="21" value="{{$nhansu->so_dien_thoai}}">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" tabindex="22" value="{{$nhansu->email}}">
                    <label>Trình độ</label>
                    <input type="text" class="form-control" placeholder="Trình độ" name="trinh_do" tabindex="23" value="{{$nhansu->trinh_do}}">
                    <label>Chuyên ngành</label>
                    <input type="text" class="form-control" placeholder="Chuyên ngành" name="chuyen_nganh" tabindex="24" value="{{$nhansu->chuyen_nganh}}">
                </div>
            </div>
            <hr>
            <div class="row">
                
                <div class="col-md-4">
                    <label >Tài khoản ngân hàng</label>
                    <input type="text" class="form-control" placeholder="Tài khoản ngân hàng" name="tai_khoan_ngan_hang" tabindex="25" value="{{$nhansu->tai_khoan_ngan_hang}}">
                    @if ($errors->has('tai_khoan_ngan_hang'))
                        <span class="help-block" style="color:red">
                                <strong>{{ $errors->first('tai_khoan_ngan_hang') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="col-md-4">
                    <label >Mã số thuế</label>
                    <input type="text" class="form-control  input-sm" name="ma_so_thue" tabindex="26" value="{{$nhansu->ma_so_thue}}">
                </div>
                @if ($errors->has('ma_so_thue'))
                    <span class="help-block" style="color:red">
                                <strong>{{ $errors->first('ma_so_thue') }}</strong>
                            </span>
                @endif
                <div class="col-md-4">           
                <label >Phân loại nhân viên</label>
                    @component('components.select', ['data' => $trang_thai_nhan_su,'value'=>'id' ,'text' => 'ten', 'name' => 'trang_thai_nhan_su','idSelected'=>$nhansu->trang_thai_nhan_su,'none_required'=>true])
                    @endcomponent
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Sơ yếu lí lịch',                          
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->so_yeu_li_lich,
                'name'=>'so_yeu_li_lich'    
                ])
                @endcomponent
                </div>
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Bản sao CMND',                              
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->ban_sao_cmnd,  
                'name'=>'ban_sao_cmnd'  
                ])
                @endcomponent
                </div>
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Bản sao hộ khẩu',                              
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->ban_sao_ho_khau,
                'name'=>'ban_sao_ho_khau'       
                ])
                @endcomponent
                </div>
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Bản sao giấy khai sinh',                             
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->ban_sao_giay_khai_sinh, 
                'name'=>'ban_sao_giay_khai_sinh'     
                ])
                @endcomponent
                </div>
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Bản sao bằng cấp chứng chỉ',                              
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->ban_sao_bang_cap_chung_chi, 
                'name'=>'ban_sao_bang_cap_chung_chi'   
                ])
                @endcomponent
                </div>
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Ảnh 3x4',                              
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->anh, 
                'name'=>'anh' 
                ])
                @endcomponent
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Số sổ BHXH',                              
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->so_so_bhxh, 
                'name'=>'so_so_bhxh' 
                ])
                @endcomponent
                </div>
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Quyết định nghỉ việc cơ quan cũ',                                
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->quyet_dinh_nghi_viec,
                'name'=>'quyet_dinh_nghi_viec'    
                ])
                @endcomponent
                </div>
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Thông tin tài khoản cá nhân',                                
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->tai_khoan_ca_nhan,  
                'name'=>'tai_khoan_ca_nhan' 
                ])
                @endcomponent
                </div>
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Giấy KSK',                             
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->co_giay_ksk, 
                'name'=>'co_giay_ksk'     
                ])
                @endcomponent
                </div>
                <div class="col-md-2">
                @component('components.checkbox', [
                'title' => 'Cam kết thuế',                             
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->cam_ket_thue, 
                'name'=>'cam_ket_thue'     
                ])
                @endcomponent
                </div>
            </div>
        </div>                           
        <div class="box-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn bg-olive btn-flat pull-right" id="submit" tabindex="35"><i class="fa fa-check"></i> {{__('button.edit_nhan_su')}}</button>
                    <a class="btn btn-default btn-flat" href="{{route('nhansu')}}" tabindex="34"><i class="fa fa-undo"></i> {{__('button.back')}}</a>
                </div>        
            </div>
        </div>
    </form>
@endsection
@section('script')
<script src="{{ asset('js/min/uploadimage.min.js') }}"></script>
@endsection
