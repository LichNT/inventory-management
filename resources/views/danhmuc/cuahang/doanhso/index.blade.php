@extends('layouts.app')

@section('title')
    <h1>DOANH SỐ CỬA HÀNG {{$cuahang->ten}}</h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">           
            <div class="row">
                <div class="col-xs-12 pull-right">
                    <a href="#" data-toggle="modal" data-target="{{'#modal-add-doanhso'}}" class="btn btn-flat bg-olive">
                        <i class="fa fa-plus"> Thêm mới</i>
                    </a>
                    @include('danhmuc.cuahang.doanhso.add')
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(), 'perPage' => $perPage, 'data' => $data, 'routerName' => 'cuahang.doanhso','id'=>$cuahang->id])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        <div id="search" class="dataTables_filter">
                            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'cuahang.doanhso','id'=>$cuahang->id, 'search' => (empty($search) ? null : $search)])
                            @endComponent
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th style=" text-align: center">Tháng</th>
                                <th style=" text-align: center">Năm</th>
                                <th style=" text-align: center">Ngày bắt đầu</th>
                                <th style=" text-align: center">Ngày kết thúc</th>
                                <th style=" text-align: center">Mục tiêu doanh số</th>
                                <th style=" text-align: center" >Doanh số thực tế</th>
                                <th style=" text-align: center" >Hiệu suất</th>
                                <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $doanhso)
                                <tr role="row" class="odd">
                                    <td style=" text-align: center">{{$doanhso->thang}}</td>
                                    <td style=" text-align: center">{{$doanhso->nam}}</td>
                                    <td style=" text-align: center">{{$doanhso->ngay_bat_dau}}</td>
                                    <td style=" text-align: center">{{$doanhso->ngay_ket_thuc}}</td>
                                    <td style=" text-align: center">{{$doanhso->muc_tieu_doanh_so}}</td>
                                    <td style=" text-align: center">{{$doanhso->doanh_so_thuc_te}}</td>
                                    <td style=" text-align: center">{{$doanhso->hieu_suat}}</td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-doanhso-' . $doanhso->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @include('danhmuc.cuahang.doanhso.detail')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-doanhso-' . $doanhso->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('danhmuc.cuahang.doanhso.delete')
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

@endsection