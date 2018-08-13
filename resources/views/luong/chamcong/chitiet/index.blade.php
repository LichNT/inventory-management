@extends('layouts.form')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6">
                BẢNG CHẤM CÔNG
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control" id ="nam" name="nam" tabindex="1" required value="{{$chamcong->nam}}" autofocus>
            </div>
            <div class="col-md-2">
                @component('components.select-month', [
                                'idSelected' => $chamcong->thang,
                                'value' => 'id',
                                'name' => 'thang',
                                'id'=>'thang',
                                'none_required'=> true,
                                'tabindex' => 2
                            ])
                @endcomponent
            </div>
            <div class="col-md-2">
                <button type="button" id="btnXuatExcel" class="btn bg-olive btn-file btn-flat btn-block" {{'onclick=chitiet("'.$code_company.'")'}}><i class="fa fa-hourglass-half">  Xem bảng chấm công</i></button>
            </div>
        </div>
    </div>
    <div class="box-header">
        <div class="row">
            <div class="col-xs-12 pull-right">
                <div style="float: left;">
                    <form action="{{ route('luong.chamcong.capnhatnhansu',$ten_bang)}}" method="post" >
                    {{ csrf_field() }}
                        <button type="submit" {{($chamcong->khoa_so||$disabled||$chamcong->duyet_bang_luong)?'disabled':''}}  class="btn bg-olive btn-file btn-flat" >
                            <i class="fa fa-refresh"> Cập nhật tham số tính lương</i>
                        </button>
                    </form> 
                </div>
                <div style="float: left;margin-left:3px;">
                    <form action="{{ route('luong.chamcong.ngayle',$ten_bang)}}" method="post" >
                    {{ csrf_field() }}
                        <button type="submit" {{($chamcong->khoa_so||$disabled||$chamcong->duyet_bang_luong)?'disabled':''}}  class="btn bg-olive btn-file btn-flat" >
                            <i class="fa fa-edit"> Chấm công ngày nghỉ, ngày lễ</i>
                        </button>
                    </form> 
                </div>
                <div style="float: left;margin-left:3px;">
                    <form action="{{URL::route('chamcong.sync.byexcel',$ten_bang)}}" id="form_import" method="POST"  enctype="multipart/form-data" onsubmit="document.getElementById('submit').disabled=true">
                        {{ csrf_field() }}
                        @include('luong.chamcong.add')                        
                        <div class="btn bg-olive btn-file btn-flat">
                            <i class="fa fa-file-excel-o"></i> Cập nhật dữ liệu chấm công
                            <input type="file"  name="import_excel" {{($chamcong->khoa_so||$disabled||$chamcong->duyet_bang_luong)?'disabled':''}}  onchange="form.submit()" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                        </div>
                        <button type="button" id="btnXuatExcel" class="btn bg-default btn-flat" onclick="download('{{route('download.template.chamcong')}}',null,null)">
                            <i class="fa fa-file-excel-o"> File mẫu chấm công</i>
                        </button>
                    </form>
                </div>
                <div style="float: left;margin-left:3px;">
                    <form action="{{ route('luong.chamcong.chamcongcuahang',$ten_bang)}}" method="post" >
                    {{ csrf_field() }}
                        <button type="submit" {{($chamcong->khoa_so||$disabled||$chamcong->duyet_bang_luong)?'disabled':''}}  class="btn bg-olive btn-file btn-flat" >
                            <i class="fa fa-edit">Chấm công cửa hàng</i>
                        </button>
                    </form> 
                </div>
                @if(!empty(Auth::user()->id_chi_nhanh))
                    <div style="float: left;margin-left:3px;">
                        <button {{$disabled?'disabled':null}} data-toggle="modal" data-target="{{'#modal-update-duyetbangluong-'.$chamcong->id}}"  class="btn bg-olive btn-file btn-flat" >
                            <i class="fa fa-edit">Duyệt bảng lương</i>
                        </button>   
                        @include('luong.chamcong.chitiet.duyetbangluong')                
                    </div>
                @else
                    <div style="float: left;margin-left:3px;">
                        <button {{$chamcong->khoa_so||$chamcong->duyet_bang_luong?'disabled':null}} data-toggle="modal" data-target="{{'#modal-update-duyetbangluong-'.$chamcong->id}}"  class="btn bg-olive btn-file btn-flat" >
                            <i class="fa fa-edit">Duyệt lại bảng lương</i>
                        </button>   
                        @include('luong.chamcong.chitiet.duyetlaibangluong')                
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-4">
                    @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage,
                        'data' => $data, 'routerName' => 'luong.chamcong.chitiet'])
                    @endComponent
                </div>
                <div class="col-md-8">
                    @include('luong.chamcong.chitiet.box-search')
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Mã nhân viên</th>
                            <th>Họ tên</th>
                            <th>Mã chấm công</th>
                            <th>Cửa hàng</th>
                            <th>Bộ phận</th>
                            <th>Phòng ban</th>
                            <th>{{$ten_hien_thi_chi_nhanh}}</th>
                            <th>{{$ten_hien_thi_tinh}}</th>
                            <th>Chức vụ </th>
                            <th style="text-align:center;">Số người phụ thuộc</th>     
                            <th style="width: 10%; text-align: center">Trạng thái</th>  
                            <th style="width: 10%; text-align: center">Ngày duyệt</th>      
                            <th style="width: 5%; text-align: center;">Chi tiết</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td><a href="{{ route('luong.chitiet.chamcong',[$ten_bang,$item->id]) }}">{{$item->ma}}</a></td>
                                <td>{{$item->ho_ten}}</td>
                                <td>{{$item->ma_the_cham_cong}}</td>
                                <td>{{isset($item->cua_hang)?$item->cua_hang: ''}}</td>
                                <td>{{isset($item->bo_phan)?$item->bo_phan:''}}</td>
                                <td>{{isset($item->phong_ban)?$item->phong_ban:''}}</td>
                                <td>{{isset($item->chi_nhanh)?$item->chi_nhanh:''}}</td>
                                <td>{{isset($item->tinh)?$item->tinh:''}}</td>
                                <td>{{isset($item->chuc_vu)?$item->chuc_vu:''}}</td>
                                <td align="center">{{number_format($item->so_nguoi_phu_thuoc)}}</td>
                                <td align="center">
                                    @if($item->ktcn_duyet)                                  
                                        @if($item->kttcn_duyet)  
                                            @if($item->gdcn_duyet)  
                                            <small class="label bg-olive flat">Giám đốc CN đã duyệt</small> 
                                            @else
                                            <small class="label bg-olive flat">KTTCH đã duyệt</small> 
                                            @endif                                 
                                        @else
                                        <small class="label bg-olive flat">KTCH đã duyệt</small>
                                        @endif                                        
                                    @else
                                    <small class="label bg-olive flat">Đang tính lương</small> 
                                    @endif
                                </td>
                                <td align="center">
                                    @if($item->ktcn_duyet)                                  
                                        @if($item->kttcn_duyet)  
                                            @if($item->gdcn_duyet)  
                                            {{ Carbon\Carbon::parse($item->ngay_ktcn_duyet)->format(config('app.format_date'))}}
                                            @else
                                            {{Carbon\Carbon::parse($item->ngay_kttcn_duyet)->format(config('app.format_date'))}}
                                            @endif                                 
                                        @else
                                            {{Carbon\Carbon::parse($item->ngay_gdcn_duyet)->format(config('app.format_date'))}}
                                        @endif                                        
                                    @else
                                   
                                    @endif
                                </td>
                                <td align="center">
                                    <a href="{{route('luong.chitiet.chamcong',[$ten_bang,$item->id])}}">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                </td>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            @component('components.pagination', ['pageShow' => 3, 'data' => $data])
            @endComponent
        </div>
        <div class="box-footer">
                <a class="btn btn-default btn-flat" href="{{route('luong.chamcong')}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>
            </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('js/downloadexcel.js')}}"></script>
    <script src="{{asset('js/chitietchamcong.js')}}"></script>
    <script src="{{ asset('js/searchCuaHang.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection