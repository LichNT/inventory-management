@extends('layouts.app')

@section('title')
    <h1 class="title_master_form">Tham số tính lương</h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">            
            <div class="row">
                <div class="col-xs-12">
                    <div style="float: left;">
                        <a href="#" data-toggle="modal" data-target="{{'#modal-add-tham_so_thuong'}}" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        @include('luong.thamsotinhluong.thamso.add')
                    </div>

                   
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(), 'perPage'=>$perPage, 'data' => $data, 'routerName' => 'danhmuc.thamso'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                       
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr>
                                <th style="width: 10%; ">Tên tham số</th>
                                <th style="width: 20%;">Giá trị </th>
                                <th style="width: 10%;text-align: center;">Từ ngày</th>
                                <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                        
                            @foreach ($data as $thamso)
                                <tr role="row" class="odd">
                                    <td>{{$thamso->ten}}</td>
                                    <td>{{number_format($thamso->gia_tri)}}</td>
                                    <td style="text-align: center;">{{empty($thamso->tu_ngay)?null:Carbon\Carbon::parse($thamso->tu_ngay)->format('d/m/Y')}}</td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-thamsothuong-' . $thamso->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @include('luong.thamsotinhluong.thamso.detail')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-thamsothuong-' . $thamso->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('luong.thamsotinhluong.thamso.delete')
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            @if (count($data) > 10)
                                <tr>
                                    <th style="width: 10%; ">Tên tham số</th>
                                    <th style="width: 20%;">Giá trị </th>
                                    <th style="width: 10%;text-align: center;">Từ ngày</th>
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
