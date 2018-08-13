@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.loai_hop_dong')}}</h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">           
            <div class="row">
                <div class="col-xs-12 pull-right">
                    <a href="#" data-toggle="modal" data-target="{{'#modal-add-loaihopdong'}}" class="btn btn-flat bg-olive">
                        <i class="fa fa-plus"> Thêm mới</i>
                    </a>
                    @include('danhmuc.loaihopdong.add')
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'danhmuc.loaihopdong'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        @include('danhmuc.loaihopdong.box-search')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 40%; ">Mã</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">Tên</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center">Trạng thái</th>
                                <th style="width: 5%;text-align: center"></th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $loaihopdong)
                                <tr role="row" class="odd">
                                    <td>{{$loaihopdong->ma}}</td>
                                    <td>{{$loaihopdong->ten}}</td>
                                    <td style="text-align: center;">
                                        @if ($loaihopdong->trang_thai)
                                            <small  class="label bg-olive flat block">{{__('system.active')}}</small>
                                        @else
                                            <small class="label bg-navy flat block">{{__('system.inactive')}}</small>
                                        @endif
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-enclose-' . $loaihopdong->id }}">
                                            <span class="label bg-maroon flat block">Hợp đồng</span>
                                        </a>
                                        @include('danhmuc.loaihopdong.enclose')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-loaihopdong-' . $loaihopdong->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @include('danhmuc.loaihopdong.detail')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-loaihopdong-' . $loaihopdong->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('danhmuc.loaihopdong.delete')
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