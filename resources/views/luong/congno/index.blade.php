@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.congno')}}</h1>
@endsection

@section('content')
<div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-xs-12 pull-right">
                    <a href="#" data-toggle="modal" data-target="#modal-add-congno" class="btn btn-flat bg-olive">
                        <i class="fa fa-plus"> Thêm mới</i>
                    </a>
                    @include('luong.congno.add')
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'luong.congno'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        @include('luong.congno.box-search')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th >Nhân sự</th>
                                <th >Tháng năm</th>
                                <th >Số tiền(vnđ)</th>
                                <th >Nội dung</th>
                                <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $congno)
                                <tr role="row">
                                    <td >{{$congno->nhanSu->ho_ten}}</td>
                                    <td >{{$congno->thang_nam}}</td>
                                    <td class="maskmoney">{{number_format($congno->so_tien)}}</td>
                                    <td >
                                        {{$congno->noi_dung}}
                                    </td>

                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-congno-' . $congno->id }}">
                                            <i class="fa fa-edit" ></i>
                                        </a>
                                        @include('luong.congno.detail')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-congno-' . $congno->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('luong.congno.delete')
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>

                            @if (count($data) > 10)
                                <tr role="row">
                                    <th >Nhân sự</th>
                                    <th >Tháng năm</th>
                                    <th >Số tiền(vnđ)</th>
                                    <th >Nội dung</th>
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
<input type="hidden" id="chi_nhanh_hidden" data="{{$chinhanhs}}">
<input type="hidden" id="mien_hidden" data="{{$miens}}">
<input type="hidden" id="tinh_hidden" data="{{$tinhs}}">
<input type="hidden" id="cua_hang_hidden" data="{{$cuahangs}}">
<input type="hidden" id="nhan_su" data="{{$nhansus}}">
@endsection
@section('script')
    <script src="{{ asset('js/dkChamCong.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection