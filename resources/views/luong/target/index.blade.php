@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.target')}}</h1>
@endsection

@section('content')
<div class="box">
        <div class="box-header">
            <div class="row">                
                <form action="{{ route('upload.target') }}" id="form_import" method="POST"  enctype="multipart/form-data" onsubmit="document.getElementById('submit').disabled=true">
                    {{ csrf_field() }}
                    <div class="col-xs-12 pull-right">
                        <a href="#" data-toggle="modal" data-target="#modal-add-target" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        <a href="#" data-toggle="modal" data-target="#modal-add-coppy" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Copy</i>
                        </a>
                                              
                        <div class="btn bg-olive btn-file btn-flat">
                            <i class="fa fa-file-excel-o"></i> Cập nhật từ file Excel
                            <input type="file"  name="import_excel"  onchange="form.submit()" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                        </div>
                        <button type="button" id="btnXuatExcel" class="btn bg-default btn-flat" onclick="download('{{route('download.template.target')}}',null,null)">
                            <i class="fa fa-file-excel-o"> File mẫu target</i>
                        </button>
                    </div>   
                </form>
                @include('luong.target.add')
                @include('luong.target.coppy')  
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'luong.target'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        @include('luong.target.box-search')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th >Tên cửa hàng</th>
                                <th >Loại target</th>
                                <th >Số tiền(vnđ)</th>
                                <th >Tháng</th>
                                <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $target)
                                <tr role="row">
                                    <td >{{$target->cuaHang->ten}}</td>
                                    <td >{{$target->loaiTarget->ten}}</td>
                                    <td class="maskmoney">{{number_format($target->so_tien)}}</td>
                                    <td >
                                        {{$target->tu_ngay}}
                                    </td>

                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-target-' . $target->id }}">
                                            <i class="fa fa-edit" ></i>
                                        </a>
                                        @include('luong.target.detail')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-target-' . $target->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('luong.target.delete')
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>

                            @if (count($data) > 10)
                                    <tr role="row">
                                        <th >Tên cửa hàng</th>
                                        <th >Loại target</th>
                                        <th >Số tiền(vnđ)</th>
                                        <th >Tháng</th>
                                        <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                                        <th style="width: 5%; text-align: center;">Xóa</th>
                                </tr>
                            @endif
                            </tfoot>
                        </table>
                    </div>
                </div>
                @component('components.pagination', ['pageShow' => 3, 'data' => $data])
                @endComponent
            </div>
        </div>
    </div>

@endsection
@section('script')    
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection