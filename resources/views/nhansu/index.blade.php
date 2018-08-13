@extends('layouts.app')

@section('css')

@endsection
@section('title')
<h1 class="title_master_form"> {{__('model.nhan_su')}}</h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">            
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('nhansu.sync.byexcel') }}" id="form_import" method="POST"  enctype="multipart/form-data" onsubmit="document.getElementById('submit').disabled=true">
                            {{ csrf_field() }} 
                        <a href="{{route('nhansu.add')}}" class="btn bg-olive btn-flat margin">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        <button type="button" id="btnXuatExcel" class="btn bg-olive btn-flat margin" onclick="downloadExcel()">
                            <i class="fa fa-file-excel-o">  Xuất excel</i>
                        </button>
                        <button type="button" id="btnXuatExcel" class="btn bg-default btn-flat margin" onclick="download('{{route('download.template.nhansu.update')}}',null,null)">
                            <i class="fa fa-file-excel-o"> File mẫu cập nhật dữ liệu</i>
                        </button> 
                        <div class="btn bg-olive btn-file btn-flat margin">
                            <i class="fa  fa-refresh"></i> Cập nhật dữ liệu từ file excel
                            <input type="file"  name="import_excel" onchange="form.submit()" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                        </div> 
                        <a href="{{route('import')}}" class="btn bg-olive btn-flat margin">
                            <i class="fa fa-cloud-upload"> Import</i>
                        </a>                       
                    </form>
                </div>                
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-md-4">
                        @component('components.perpage',['options' => [10, 20, 50, 100], 'default'=> 10,'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu'])
                        @endComponent
                    </div>
                    <div class="col-md-8">
                        @include('nhansu.box-search')
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <th class="text" style="width:5%;">Mã</th>
                                    <th class="text" style="width:10%;">Họ và tên </th>
                                    <th class="text" style="width:5%;">Ngày sinh</th>
                                    <th class="text" style="width:5%;text-align:center;">Giới tính</th>
                                    <th class="text" style="width:7.5%;" >CMND</th>
                                    <th class="text" style="width:7.5%;" >Mã số thuế</th>
                                    <th class="text" style="width:15%;" >Hộ khẩu thường trú</th>
                                    <th class="text" style="width:7.5%;" >Số điện thoại</th>
                                    <th class="text" style="width:7.5%;" >Chức vụ</th>
                                    <th class="text" style="width:7.5%;" >Phòng ban</th>
                                    <th class="text" style="width:5%;">Loại hợp đồng</th>
                                    <th class="text" style="width:7.5%">{{$ten_hien_thi_chi_nhanh}}</th>
                                    <th style="width:5%;text-align:center;">Chỉnh sửa</th>
                                    <th style="width:5%;text-align:center;">Xoá</th>
                                </tr>
                                @foreach ($data as $nhansu)
                                    <tr role="row">                                        
                                        <td class="text"><a href="{{ route('nhansu.update.chung', $nhansu->id) }}">{{$nhansu->ma}}<a/></td>
                                        <td class="text">{{$nhansu->ho_ten}}</td>
                                        <td class="text">
                                            {{isset($nhansu->ngay_sinh) ? $nhansu->ngay_sinh: '--'}}
                                        </td>
                                        <td align="center">
                                            @if ($nhansu->gioi_tinh==1)
                                                <small class="label bg-olive flat block">Nam</small>
                                            @else
                                                <small class="label bg-maroon flat block">Nữ</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{isset($nhansu->cmnd) ? $nhansu->cmnd : '--'}}
                                        </td>
                                        <td>
                                            {{isset($nhansu->ma_so_thue) ? $nhansu->ma_so_thue : '--'}}
                                        </td>
                                        <td>
                                            {{isset($nhansu->ho_khau_thuong_tru) ? $nhansu->ho_khau_thuong_tru : '--'}}
                                        </td>
                                        <td>
                                            {{isset($nhansu->so_dien_thoai) ? $nhansu->so_dien_thoai : '--'}}
                                        </td>                                       
                                        <td>
                                            {{isset($nhansu->chucVu) ? $nhansu->chucVu->ten : '--'}}
                                        </td>
                                        <td>
                                            {{isset($nhansu->phongBan) ? $nhansu->phongBan->ten : '--'}}
                                        </td>
                                        <td>
                                            {{isset($nhansu->loaiHopDong) ? $nhansu->loaiHopDong->ten : '--'}}
                                        </td>
                                        <td>
                                            {{isset($nhansu->chiNhanh) ? $nhansu->chiNhanh->ten : '--'}}
                                        </td>
                                        <td align="center">
                                            <a href="{{route('nhansu.update', $nhansu->id)}}" >
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                        <a href="#" id="{{'delete_nhan_su_'.$nhansu->id}}" data-toggle="modal" onclick="{{'deleteNhanSu('.$nhansu->id.')'}}" data-target="{{ '#modal-delete-nhansu-' . $nhansu->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('nhansu.delete')
                                    </td>
                                    
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                @component('components.pagination', ['pageShow' => 3, 'data' => $data])
                @endComponent
            </div>
        </div>
        <!-- /.box-body -->
    </div>
@endsection


@section('script')
    <script src="{{asset('js/nhansu/index.js')}}"></script>
    <script src="{{asset('js/nhansu/delete.js')}}"></script>
<script src="{{asset('js/nhansu/exportexcel.js')}}"></script>
<script src="{{ asset('js/searchCuaHang.js') }}"></script>
@endsection
