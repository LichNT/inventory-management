@extends('layouts.form') 

@section('content')
<h2 class="page-header">
    THAM SỐ HỆ THỐNG
</h2>

<form action="{{ route('system.thamsohethong.update')}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }} {{ method_field('put') }}    
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <label>Tổng quỹ lương <span style="color:red;font-style:italic">(VNĐ)</span></label>
                <input type="text" class="form-control maskmoney" name="tong_quy_luong" tabindex="1" value="{{empty($thamsohethong->tong_quy_luong)?null:$thamsohethong->tong_quy_luong}}">
            </div>
            <div class="col-md-3">
                <label>Ngày nghỉ lễ <span style="color:black;font-style:italic">(cách nhau bởi dấu phẩy)</span></label>
                <input type="text" class="form-control " placeholder="30/4,1/5,2/9..." name="ngay_nghi_le" tabindex="2" value="{{empty($thamsohethong->ngay_nghi_le)?null:$thamsohethong->ngay_nghi_le}}">
            </div>
            <div class="col-md-3">
                <label>Giảm trừ bản thân <span style="color:red;font-style:italic">(VNĐ)</span></label>
                <input type="text" class="form-control maskmoney" name="giam_tru_ban_than" tabindex="3" value="{{empty($thamsohethong->giam_tru_ban_than)?null:$thamsohethong->giam_tru_ban_than}}">
            </div>
            <div class="col-md-3">
                <label>Giảm trừ phụ thuộc <span style="color:red;font-style:italic">(VNĐ)</span></label>
                <input type="text" class="form-control maskmoney" name="giam_tru_phu_thuoc" tabindex="4" value="{{empty($thamsohethong->giam_tru_phu_thuoc)?null:$thamsohethong->giam_tru_phu_thuoc}}">
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-3">
                <label>Lương làm thêm giờ ngày thường <span style="color:red;font-style:italic">(%)</span></label>
                <input type="text" class="form-control " name="luong_lam_them_gio_ngay_thuong" tabindex="5" value="{{empty($thamsohethong->luong_lam_them_gio_ngay_thuong)?null:$thamsohethong->luong_lam_them_gio_ngay_thuong}}">
            </div>
            <div class="col-md-3">
                <label>Lương làm thêm giờ ngày lễ <span style="color:red;font-style:italic">(%)</span></label>
                <input type="text" class="form-control "  name="luong_lam_them_gio_ngay_le" tabindex="6" value="{{empty($thamsohethong->luong_lam_them_gio_ngay_le)?null:$thamsohethong->luong_lam_them_gio_ngay_le}}">
            </div>
            <div class="col-md-3">
                <label>Lương làm thêm giờ ngày nghỉ <span style="color:red;font-style:italic">(%)</label>
                <input type="text" class="form-control " name="luong_lam_them_gio_ngay_nghi" tabindex="7" value="{{empty($thamsohethong->luong_lam_them_gio_ngay_le)?null:$thamsohethong->luong_lam_them_gio_ngay_le}}">
            </div>
        </div>
        <hr>
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <table class="table">
                <div class="row">
                    <div class="col-sm-12">
                        <thead>
                            <tr role="row">
                                <th style="width: 20%;">Tên bảo hiểm</th>
                                <th style="width: 20%;">Doanh nghiệp <span style="color:red;font-style:italic">(% lương cơ bản)</th>
                                <th style="width: 20%">Người lao động <span style="color:red;font-style:italic">(% lương cơ bản)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row">
                                <td>Bảo hiểm xã hội</td>
                                <td>
                                    <input type="number" class="form-control" step="any" min=0 max=100  name="BHXH_DN" id="BHXH_DN" tabindex="5" value="{{empty($thamsohethong->BHXH_DN)?null:$thamsohethong->BHXH_DN}}">                                                                                                             
                                </td>                                    
                                <td>
                                    <input type="number" class="form-control" step="any" min=0 max=100  name="BHXH_NLD" id="BHXH_NLD" tabindex="6" value="{{empty($thamsohethong->BHXH_NLD)?null:$thamsohethong->BHXH_NLD}}">
                                </td>
                            </tr>
                            <tr role="row">
                                <td>Bảo hiểm y tế</td>
                                <td>
                                    <input type="number" class="form-control" step="any" min=0 max=100  name="BHYT_DN" id="BHYT_DN" tabindex="7" value="{{empty($thamsohethong->BHYT_DN)?null:$thamsohethong->BHYT_DN}}"> </td>
                                <td>
                                    <input type="number" class="form-control" step="any" min=0 max=100  name="BHYT_NLD" id="BHYT_NLD" tabindex="8" value="{{empty($thamsohethong->BHYT_NLD)?null:$thamsohethong->BHYT_NLD}}">
                                </td>
                            </tr>
                            <tr role="row">
                                <td>Bảo hiểm thất nghiệp</td>
                                <td>
                                    <input type="number" class="form-control" step="any" min=0 max=100  name="BHTN_DN" id="BHTN_DN" tabindex="9" value="{{empty($thamsohethong->BHTN_DN)?null:$thamsohethong->BHTN_DN}}"> </td>
                                <td>
                                    <input type="number" class="form-control" step="any" min=0 max=100 name="BHTN_NLD" id="BHTN_NLD" tabindex="10" value="{{empty($thamsohethong->BHTN_NLD)?null:$thamsohethong->BHTN_NLD}}">
                                </td>
                            </tr>
                        </tbody>
                    </div>
                </div>
            </table>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="media">                
                    <div class="media-body">
                        <div class="clearfix">
                            <p class="pull-right">
                                <a href="#" class="btn bg-olive btn-sm flat" data-toggle="modal" data-target="#modal-taodanhsachmathechamcong">
                                    Tạo mới mã thẻ
                                </a>                                
                            </p>
    
                            <h4 style="margin-top: 0">Mã thẻ chấm công</h4>
    
                            <p>Hiện trạng sử dụng mã thẻ chấm công</p>
                            <p style="margin-bottom: 0">
                                <i class="fa fa-check" style="color:red"></i> {{$bangmachamcongs->where('inactive', true)->count()}} đã cấp
                                <i class="fa fa-check" style="color:green"></i> {{$bangmachamcongs->where('inactive', false)->count()}} chưa cấp
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="media">                
                    <div class="media-body">
                        <div class="clearfix">
                            <p class="pull-right">
                                <a href="clearcache" class="btn bg-olive btn-sm flat" >
                                    Clear Cache
                                </a>                                
                            </p>
                            <h5 style="margin-top: 0">Xóa cache</h5>
                            <p>Xóa cache hiện tại</p>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <div class="box-footer">
            <button type="submit" class="btn bg-olive btn-flat pull-right" id="submit" tabindex="35">
                <i class="fa fa-check"></i> {{__('button.edit')}}
            </button>
        </div>
    </div>
</form>

@include('system.thamsohethong.taodanhsachmathechamcong')

@endsection 

@section('script')    
@endsection