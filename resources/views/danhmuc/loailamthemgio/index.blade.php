@extends('layouts.app')

@section('title')
    <h1>LOẠI LÀM THÊM GIỜ</h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-xs-12 pull-right">
                    <a href="#" data-toggle="modal" data-target="{{'#modal-add-loailamthemgio'}}" class="btn btn-flat bg-olive">
                        <i class="fa fa-plus"> Thêm mới</i>
                    </a>
                    @include('danhmuc.loailamthemgio.add')
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(), 'perPage'=>$perPage, 'data' => $data, 'routerName' => 'luong.danhmuc.loailamthemgio'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        <div id="search" class="dataTables_filter">
                            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'luong.danhmuc.loailamthemgio', 'search' => (empty($search) ? null : $search)])
                            @endComponent
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr role="row">
                              
                                <th  style="width: 30%">Loại làm thêm </th>
                                <th  style="width: 20%; text-align: center">Hệ số</th>
                                <th  style="width: 20%; text-align: center">Mức lương/ngày</th>
                                <th  style="width: 20%; text-align: center">Số giờ theo quy định</th>
                                <th  style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th  style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $lamthemgio)
                                <tr role="row" class="odd">
                                    <td >{{$lamthemgio->ten}}</td>
                                    <td style="text-align: center">{{$lamthemgio->he_so}}</td>
                                    <td style="text-align: center">{{$lamthemgio->muc_luong}}</td>
                                    <td style="text-align: center">{{$lamthemgio->so_gio_theo_quy_dinh}}</td>                                    
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-lamthemgio-' . $lamthemgio->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @include('danhmuc.loailamthemgio.detail')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-loailamthemgio-' . $lamthemgio->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('danhmuc.loailamthemgio.delete')
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            @if (count($data) > 10)
                                <tr>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 50px; ">Mã chức vụ</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 199px;">Tên chức vụ </th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 100px; text-align: center">Trạng thái</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 50px; text-align: center">Chỉnh sửa</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 50px; text-align: center;">Xóa</th>
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
