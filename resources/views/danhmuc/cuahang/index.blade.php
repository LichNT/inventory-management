@extends('layouts.app')

@section('css')

@endsection
@section('title')
    <h1 class="title_master_form">CỬA HÀNG</h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">            
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('cuahang.sync.byexcel') }}" id="form_import" method="POST"  enctype="multipart/form-data" onsubmit="document.getElementById('submit').disabled=true">
                        {{ csrf_field() }}
                        <a href="{{route('cuahang.add')}}" class="btn bg-olive btn-flat margin">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        <button type="button" id="btnXuatExcelCuaHang" class="btn bg-olive btn-flat margin" onclick="downloadExcelCuaHang()">
                            <i class="fa fa-file-excel-o">  Xuất excel</i>
                        </button>
                        <button type="button" id="btnXuatExcel" class="btn bg-default btn-flat margin" onclick="download('{{route('download.template.cuahang')}}',null,null)">
                            <i class="fa fa-file-excel-o"> File mẫu cập nhật dữ liệu</i>
                        </button>
                        <div class="btn bg-olive btn-file btn-flat margin">
                            <i class="fa  fa-refresh"></i> Cập nhật dữ liệu từ file excel
                            <input type="file"  name="import_excel" onchange="form.submit()" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                        </div>
                        <a href="{{route('import.cuahang')}}" class="btn bg-olive btn-flat margin">
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
                    <div class="col-md-6">
                        @component('components.perpage',['options' => [10, 20, 50, 100], 'default'=> 10, 'data' => $data, 'perPage'=>$perPage, 'routerName' => 'cuahang'])
                        @endComponent
                    </div>
                    <div class="col-md-6">
                        @include('danhmuc.cuahang.box-search')
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <th class="text" style="width:5%;">Trực thuộc</th>
                                    <th class="text" style="width:5%;">Mã</th>
                                    <th class="text" style="width:15%;">Tên địa điểm </th>
                                    <th class="text" style="width:10%;">Tên cửa hàng</th>
                                    <th class="text" style="width:10%" >Ngày Đăng ký kinh doanh</th>
                                    <th class="text" style="width:10%" >Ngày bán hàng</th>
                                    <th class="text" style="width:10%" >Ngày khai trương</th>
                                    <th class="text" style="width:5%">Tỉnh thành</th>
                                    <th class="text" style="width:5%">Quận huyện</th>
                                    <th class="text" style="width:5%;">Số điện thoại</th>
                                    <th class="text" style="width:10%;">Loại cửa hàng</th>
                                    <th style="width:5%;text-align:center;">Doanh số</th>
                                    <th style="width:5%;text-align:center;">Chỉnh sửa</th>
                                    <th style="width:5%;text-align:center;">Xoá</th>
                                </tr>
                                @foreach ($data as $cuahang)
                                    <tr role="row">
                                        <td class="text">{{$cuahang->tinh->ten}}</td>
                                        <td class="text">{{$cuahang->ma}}</td>
                                        <td class="text">{{$cuahang->ten_dia_diem}}</td>
                                        <td class="text"><a href="{{route('cuahang.update',$cuahang->id)}}">{{$cuahang->ten}}</a></td>
                                        <td>
                                            {{isset($cuahang->ngay_dang_ki_kinh_doanh) ? $cuahang->ngay_dang_ki_kinh_doanh : '--'}}
                                        </td>
                                        <td>
                                            {{isset($cuahang->ngay_ban_hang) ? $cuahang->ngay_ban_hang: '--'}}
                                        </td>
                                        <td>
                                            {{isset($cuahang->ngay_khai_truong) ? $cuahang->ngay_khai_truong : '--'}}
                                        </td>
                                        <td>{{isset($cuahang->tinhThanh->ten) ? $cuahang->tinhThanh->ten : '---'}}</td>
                                        <td>{{isset($cuahang->quanHuyen->ten) ? $cuahang->quanHuyen->ten : '---'}}</td>
                                        <td class="text">{{isset($cuahang->so_dien_thoai) ? $cuahang->so_dien_thoai : '---'}}</td>
                                        <td class="text">{{isset($cuahang->loaiCuaHang->ten) ? $cuahang->loaiCuaHang->ten : '---'}}</td>
                                        <td align="center">
                                            <a href="{{route('cuahang.doanhso', $cuahang->id)}}" >
                                                <i class="fa  fa-plus-square"></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a href="{{route('cuahang.update', $cuahang->id)}}" >
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-cuahang-' . $cuahang->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @include('danhmuc.cuahang.delete')
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
    <script src="{{asset('js/cuahang/exportexcel.js')}}"></script>
    <script src="{{ asset('js/searchCuaHang.js') }}"></script>
@endsection
