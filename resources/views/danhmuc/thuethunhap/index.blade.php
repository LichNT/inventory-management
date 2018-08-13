@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.thue_thu_nhap')}}</h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">           
            <div class="row">
                <div class="col-xs-12 pull-right">
                    <a href="#" data-toggle="modal" data-target="{{'#modal-add-thuethunhap'}}" class="btn btn-flat bg-olive">
                        <i class="fa fa-plus"> Thêm mới</i>
                    </a>
                    @include('danhmuc.thuethunhap.add')
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'danhmuc.thuethunhap'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        <div id="search" class="dataTables_filter">
                            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'danhmuc.thuethunhap', 'search' => (empty($search) ? null : $search)])
                            @endComponent
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th>Tên</th>
                                <th style="text-align: center">Cận trên</th>
                                <th style="text-align: center">Hệ số (%)</th>
                                <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $thuethunhap)
                                <tr role="row" class="odd">
                                    <td>{{$thuethunhap->ten}}</td>
                                    <td style="text-align: center;">
                                        {{empty($thuethunhap->can_tren)?null:number_format($thuethunhap->can_tren)}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$thuethunhap->thue_suat}}
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-thuethunhap-' . $thuethunhap->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @include('danhmuc.thuethunhap.detail')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-thuethunhap-' . $thuethunhap->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('danhmuc.thuethunhap.delete')
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