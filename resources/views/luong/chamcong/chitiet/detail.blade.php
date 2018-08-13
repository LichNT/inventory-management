@extends('layouts.form')

@section('content')
<div class="box">
    <div class="box-header">
        <h1 class="page-header" style="text-align:center">PHIẾU LƯƠNG</h1>        
    </div>
    
    <div class="box-body">
        <p class="lead" style="text-align:center;font-weight:bold;"> {{'Tháng '.$thang.' năm '.$nam}} </p> 
        <div class="row">
            <div class="col-md-4 col-md">
                <div class="form-group">
                    <label class="col-sm-5">Họ và tên</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{$nhansu->ho_ten}}" readonly>                        
                    </div>                                        
                </div>
                <br/>
                <div class="form-group">
                    <label class="col-sm-5">Mã nhân sự</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{$nhansu->ma}}" readonly>
                    </div>                                        
                </div>                                          
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-5">Lương cơ bản</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($nhansu->heSoLuong->muc_luong_co_ban)}}" readonly>
                    </div>                                        
                </div>  
                <div class="form-group">
                    <label class="col-sm-5">Tổng phụ cấp</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($tong_phu_cap)}}" readonly>
                    </div>                                        
                </div>                                
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-5">Tổng số công</label>
                    <div class="col-sm-7">
                        <input class="form-control" id="tong_cong_huong_luong" value="{{$chamcongnhansu->tong_cong_huong_luong}}" readonly>
                    </div>                                        
                </div>                    
                <div class="form-group">
                    <label class="col-sm-5">Tổng số giờ làm thêm</label>
                    <div class="col-sm-7">
                        <input class="form-control" id="tong_lam_them_gio" value="{{$chamcongnhansu->tong_lam_them_gio}}" readonly>
                    </div>                                        
                </div>
            </div>
        </div>    
        <div class="row">
            <div class="col-md-4 col-md">
                <div class="form-group">
                    <label class="col-sm-5">Lương thực tế</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($chamcongnhansu->luong_thuc_te)}}" readonly>                        
                    </div>                                        
                </div>
                <br/>              
                <div class="form-group">
                    <label class="col-sm-5">Lương tăng ca</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($chamcongnhansu->luong_thoi_gian)}}" readonly>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <label class="col-sm-5">Thực lĩnh</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($chamcongnhansu->thuc_linh)}}" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-5">Khấu trừ thuế</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($chamcongnhansu->khau_tru_thue_thu_nhap)}}" readonly>                        
                    </div>                                        
                </div>  
                <br/> 
                <div class="form-group">
                    <label class="col-sm-5">Khấu trừ bảo hiểm</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($chamcongnhansu->khau_tru_bao_hiem)}}" readonly>                        
                    </div>                                        
                </div> 
                </br>  
                <div class="form-group">
                    <label class="col-sm-5">Trừ khác</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($chamcongnhansu->tru_khac)}}" readonly>                        
                    </div>                                        
                </div>                                             
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-5">Tiền bảo lãnh</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($chamcongnhansu->khau_tru_tien_bao_lanh)}}" readonly>                        
                    </div>                                        
                </div>  
                <div class="form-group">
                    <label class="col-sm-5">Phạt khác</label>
                    <div class="col-sm-7">
                        <input class="form-control" value="{{number_format($tong_phat)}}" readonly>                        
                    </div>                                        
                </div>             
            </div>
        </div>                        
        <hr> 
        <div class="row">
            <div class="col-md-12">
                @include('luong.chamcong.chitiet.tab-menu')
            </div>    
        </div>                                                           
    </div>
    <div class="box-footer">
        <a class="btn btn-default btn-flat pull-left" href="{{route('luong.chamcong.chitiet',$tenbang)}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>
        <div style="float: left;margin-left: 3px;">
            <form action="{{route('luong.chamcong.resetchamcong',[$tenbang,$id])}}" method="post">
            {{ csrf_field() }}
                <button type="submit"{{$chamcong->khoa_so||$disabled||$chamcong->duyet_bang_luong?'disabled':''}} class="btn btn-default btn-flat" >
                    <i class="fa fa-hourglass-1"> Reset</i>
                </button>
            </form>  
        </div>
        <a href="{{route('luong.chitiet.chamcong.print',[$tenbang,$id])}}" class="btn btn-flat bg-navy pull-right">
            <i class="fa fa-print"> In phiếu lương</i>
        </a>
        <div style="float: right;margin-right: 3px;">
            <form action="{{route('luong.chamcong.capnhatchamcong',[$tenbang,$id])}}" method="post" >
            {{ csrf_field() }}
                <button type="submit"{{$chamcong->khoa_so||$disabled||$chamcong->duyet_bang_luong?'disabled':''}} class="btn bg-olive btn-file btn-flat" >
                    <i class="fa fa-pencil"> Tính bảng lương</i>
                </button>
            </form> 
        </div>        
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/chitietchamcong.js') }}"></script>
@endsection