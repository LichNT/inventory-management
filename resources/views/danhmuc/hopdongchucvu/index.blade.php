@extends('layouts.app')

@section('title')
    <h1 class="title_master_form">{{__('model.hop_dong_chuc_vu')}}</h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">           
            <div class="row">
                <div class="col-xs-12 pull-right">
                    <a href="#" data-toggle="modal" data-target="{{'#modal-add-hopdongchucvu'}}" class="btn btn-flat bg-olive">
                        <i class="fa fa-plus"> Thêm mới</i>
                    </a>
                    @include('danhmuc.hopdongchucvu.add')
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'danhmuc.hopdongchucvu'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        <div id="search" class="dataTables_filter">
                            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'danhmuc.hopdongchucvu', 'search' => (empty($search) ? null : $search)])
                            @endComponent
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 40%; ">Loại hợp đồng</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">Chức vụ</th>
                                <th style="width: 5%;text-align: center">Hợp đồng</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $hopdongchucvu)
                                <tr role="row" class="odd">
                                    <td>{{$hopdongchucvu->loaihopdong->ten}}</td>
                                    <td>{{$hopdongchucvu->chucvu->ten}}</td>

                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-enclose-' . $hopdongchucvu->id }}">
                                            <span class="label bg-maroon flat block">Hợp đồng</span>
                                        </a>
                                        @include('danhmuc.hopdongchucvu.enclose')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-hopdongchucvu-' . $hopdongchucvu->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @include('danhmuc.hopdongchucvu.detail')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-hopdongchucvu-' . $hopdongchucvu->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('danhmuc.hopdongchucvu.delete')
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