@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.bac_luong').' '.$ten_chuc_vu}}</h1>
@endsection

@section('content')
    <div>
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-12 pull-right">
                        <a href="#" data-toggle="modal" data-target="#modal-add-bacluong" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        @include('luong.thamsotinhluong.chucvu.bacluong.add')
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6">
                            @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage])
                            @endComponent
                        </div>
                        <div class="col-sm-6">
                            <div id="search" class="dataTables_filter">
                                @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'luong.chamcong.thamsobacluong','id'=>$id_chuc_vu, 'search' => (empty($search) ? null : $search)])
                                @endComponent 
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                                <thead>
                                <tr role="row">
                                    <th style="width:20%;">Tên</th>    
                                    <th style="text-align: center">Hệ số lương cơ bản</th>                      
                                    <th style="text-align: center">Mức lương cơ bản</th>
                                    <th style="width:10%; text-align: center">Từ ngày</th>
                                    <th style="width:10%; text-align: center">Danh sách phụ cấp</th>
                                    <th style="width:5%; text-align: center">Chỉnh sửa</th>
                                    <th style="width:5%; text-align: center;">Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $bacluong)
                                    <tr role="row">
                                        <td>{{$bacluong->ten}}</td>
                                        <td align="center">{{($bacluong->he_so_luong)}}</td>
                                        <td align="center">{{number_format($bacluong->muc_luong_co_ban)}}</td>
                                        <td style="text-align: center;">{{$bacluong->tu_ngay}}</td>
                                        <td align="center">
                                            <a href="{{route('luong.chamcong.thamsophucap',$bacluong->id)}}">
                                                <i class="fa fa-book"></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-update-bacluong-' . $bacluong->id }}">
                                                <i class="fa fa-edit" ></i>
                                            </a>
                                            @include('luong.thamsotinhluong.chucvu.bacluong.detail')
                                        </td>
                                        <td align="center">
                                        
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-bacluong-' . $bacluong->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @include('luong.thamsotinhluong.chucvu.bacluong.delete')
                                            
                                        </td>
                                @endforeach

                                </tbody>
                                <tfoot>

                                @if (count($data) > 10)
                                    <tr role="row">
                                        <th style="width:20%;">Tên</th>
                                        <th style="text-align: center">Mức lương cơ bản</th>
                                        <th style="width:10%; text-align: center">Danh sách phụ cấp</th>
                                        <th style="width:5%; text-align: center">Chỉnh sửa</th>
                                        <th style="width:5%; text-align: center;">Xóa</th>
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
            <div class="box-footer">
                <a class="btn btn-default btn-flat" href="{{route('luong.chamcong.thamsochucvu',$id_chuc_vu)}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>
            </div>
        </div>
    </div>
@endsection
@section('script')    
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection