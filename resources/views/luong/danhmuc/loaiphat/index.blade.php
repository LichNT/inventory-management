@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.loai_phat')}}</h1>
@endsection

@section('content')
    <div>
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-12 pull-right">
                        <a href="#" data-toggle="modal" data-target="#modal-add-loaiphat" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        @include('luong.danhmuc.loaiphat.add')
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6">
                            @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'luong.danhmuc.loaiphat',])
                            @endComponent
                        </div>
                        <div class="col-sm-6">
                            <div id="search" class="dataTables_filter">
                                @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'luong.danhmuc.loaiphat', 'search' => (empty($search) ? null : $search)])
                                @endComponent
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                                <thead>
                                <tr role="row">
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Tên</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">Số tiền</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">Mô tả</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">Trạng thái</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center">Chỉnh sửa</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center;">Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $loaiphat)
                                    <tr role="row">
                                        <td tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">{{$loaiphat->ten}}</td>
                                        <td tabindex="0" rowspan="1" colspan="1" style="width: 40%;">{{number_format($loaiphat->so_tien)}}</td>
                                        <td tabindex="0" rowspan="1" colspan="1" style="width: 40%;">{{$loaiphat->mo_ta}}</td>
                                        <td style="text-align: center;">
                                            @if ($loaiphat->inactive)
                                                <small  class="label bg-navy flat">{{__('system.inactive')}}</small>
                                            @else
                                                <small class="label bg-olive flat">{{__('system.active')}}</small>
                                            @endif
                                        </td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-update-loaiphat-' . $loaiphat->id }}">
                                                <i class="fa fa-edit" ></i>
                                            </a>
                                            @include('luong.danhmuc.loaiphat.detail')
                                        </td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-loaiphat-' . $loaiphat->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @include('luong.danhmuc.loaiphat.delete')
                                        </td>
                                @endforeach

                                </tbody>
                                <tfoot>

                                @if (count($data) >= 10)
                                        <tr role="row">
                                            <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Tên</th>
                                            <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">Số tiền</th>
                                            <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">Mô tả</th>
                                            <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">Trạng thái</th>
                                            <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center">Chỉnh sửa</th>
                                            <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center;">Xóa</th>
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
    </div>
@endsection
@section('script')    
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection