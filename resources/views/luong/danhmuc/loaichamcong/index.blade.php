@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.loai_cham_cong')}}</h1>
@endsection

@section('content')
    <div>
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-12 pull-right">
                        <a href="#" data-toggle="modal" data-target="#modal-add-loaichamcong" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        @include('luong.danhmuc.loaichamcong.add')
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6">
                            @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'luong.danhmuc.loaichamcong',])
                            @endComponent
                        </div>
                        <div class="col-sm-6">
                            <div id="search" class="dataTables_filter">
                                @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'luong.danhmuc.loaichamcong', 'search' => (empty($search) ? null : $search)])
                                @endComponent
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="menus" class="table table-bordered table-striped dataTable " role="grid">
                                <thead>
                                <tr role="row">
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%">Mã</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%">Tên</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;text-align: center; ">Tỉ lệ hưởng lương</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;text-align: center; ">Hưởng lương cơ bản</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%;text-align: center;">Mô tả</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center">Chỉnh sửa</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center;">Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $loaichamcong)
                                    <tr role="row">
                                        <td tabindex="0" rowspan="1" colspan="1" style=" width: 30%;">{{$loaichamcong->ma}}</td>
                                        <td tabindex="0" rowspan="1" colspan="1" style=" width: 30%;">{{$loaichamcong->ten}}</td>
                                        <td tabindex="0" rowspan="1" colspan="1" style="width: 10%;text-align: center; ">{{$loaichamcong->ty_le_huong_luong}}</td>
                                        <td tabindex="0" rowspan="1" colspan="1" style="width: 10%;text-align: center; ">{{($loaichamcong->huong_luong_co_ban)?'Hưởng lương':'Không hưởng lương'}}</td>
                                        <td tabindex="0" rowspan="1" colspan="1" style="width: 30%;text-align: center;">{{$loaichamcong->mo_ta}}</td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-update-loaichamcong-' . $loaichamcong->id }}">
                                                <i class="fa fa-edit" ></i>
                                            </a>
                                            @include('luong.danhmuc.loaichamcong.detail')
                                        </td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-loaichamcong-' . $loaichamcong->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @include('luong.danhmuc.loaichamcong.delete')
                                        </td>
                                @endforeach

                                </tbody>
                                <tfoot>

                                @if (count($data) > 10)
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 30%">Tên</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;text-align: center; ">Tỉ lệ hưởng lương</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;text-align: center; ">Hưởng lương cơ bản</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%;text-align: center;">Mô tả</th>
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