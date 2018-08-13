@extends('layouts.app')

@section('title')
    <h1 class="title_master_form">{{__('model.chuc_vu')}}</h1>    
@endsection

@section('content')
    <div class="box">
        <div class="box-header">            
            <div class="row">
                <div class="col-xs-12">
                    <div style="float: left;">
                        <a href="#" data-toggle="modal" data-target="{{'#modal-add-chucvu'}}" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        @include('luong.thamsotinhluong.chucvu.add')                      
                    </div>                 
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(), 'perPage'=>$perPage, 'data' => $data, 'routerName' => 'danhmuc.chucvu'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        @include('luong.thamsotinhluong.chucvu.box-search') 
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr>
                                <th style="width: 10%; ">Mã chức vụ</th>
                                <th style="width: 20%;">Tên chức vụ </th>
                                <th style="width: 10%; text-align: center;">Số ngày nghỉ trong tháng</th>
                                <th style="width: 10%; text-align: center;">Số tiền học việc theo ngày</th>
                                <th style="width: 10%;text-align: center;">Số giờ quy định</th>                  
                                <th style="width: 10%;text-align: center;">Số tiền bảo lãnh/tháng</th>
                                <th style="width: 10%;text-align: center;">Số tháng nộp tiền bảo lãnh</th>
                                <th style="width: 10%;text-align: center;">Từ ngày</th>
                                <th style="width: 10%;">Danh sách bậc lương</th>
                                <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                        
                            @foreach ($data as $chucvu)
                                <tr role="row" class="odd">
                                    <td>{{$chucvu->ma}}</td>
                                    <td>{{$chucvu->ten}}</td>
                                    <td style="text-align: center;">{{$chucvu->so_ngay_nghi_trong_thang}}</td>
                                    <td style="text-align: center;">{{number_format($chucvu->so_tien_hoc_viec_theo_ngay)}}</td>
                                    <td style="text-align: center;">{{$chucvu->so_gio_quy_dinh}}</td>
                                    <td style="text-align: center;">{{empty($chucvu->so_tien_bao_lanh)? null:number_format($chucvu->so_tien_bao_lanh)}}</td>
                                    <td style="text-align: center;">{{$chucvu->so_thang}}</td>
                                    <td style="text-align: center;">{{$chucvu->tu_ngay}}</td>
                                    <td align="center">
                                        <a href="{{route('luong.chamcong.thamsobacluong',$chucvu->id)}}">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                    </td>                                  
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-chucvu-' . $chucvu->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @include('luong.thamsotinhluong.chucvu.detail')  
                                    </td>
                                    <td align="center">                                     
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-chucvu-' . $chucvu->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>  
                                        @include('luong.thamsotinhluong.chucvu.delete')                                   
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
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
