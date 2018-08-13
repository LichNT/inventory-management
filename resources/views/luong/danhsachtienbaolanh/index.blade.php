@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.tienbaolanh')}}</h1>
@endsection

@section('content')
<div class="box">
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'luong.phat'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                    @include('luong.danhsachtienbaolanh.box-search')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable " role="grid">
                            <thead>
                            <tr role="row">
                                <th style="width: 10%;">{{$ten_hien_thi_mien}}</th>
                                <th style="width: 10%;">{{$ten_hien_thi_chi_nhanh}}</th>
                                <th style="width: 10%;">{{$ten_hien_thi_tinh}}</th>
                                <th style="width: 10%;">Cửa hàng</th>
                                <th style="width: 20%;">Tên nhân viên</th>
                                <th style="width: 10%; text-align:center;">Tổng số tiền đã nộp</th>
                                <th style="width: 10%; text-align:center;">Tổng số tiền phải đóng</th>
                                <th style="width: 10%; text-align:center; ">Tổng số tiền đã trả</th>
                                <th style="width: 10%; text-align:center;">Chi tiết</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $item)
                                <tr role="row">
                                    <td style="width: 10%;">{{$item->mien->ten}}</td>
                                    <td style="width: 10%;">{{$item->chiNhanh->ten}}</td>
                                    <td style="width: 10%;">{{$item->tinh->ten}}</td>
                                    <td style="width: 10%;">{{$item->cuaHang->ten}}</td>
                                    <td style="width: 20%;">{{$item->ho_ten}}</td>
                                    <td style="width: 10%;text-align:center;">{{number_format($item->tong_so_tien_bao_lanh_da_nop)}}</td>
                                    <td style="width: 10%;text-align:center;">{{number_format($item->chucVu->so_tien_bao_lanh*$item->chucVu->so_thang)}}</td>
                                    <td style="width: 10%;text-align:center; ">{{number_format($item->tong_so_tien_bao_lanh_da_tra)}}</td>
                                    <td align="center">
                                        <a href="{{route('chitietbaolanh',$item->id)}}">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                    </td>
                            @endforeach
                            </tbody>
                            <tfoot>

                            @if (count($data) >= 10)
                                <tr>
                                    <th style="width: 20%; ">Tên nhân viên</th>
                                    <th style="width: 10%; ">Tổng số tiền đã nộp</th>
                                    <th style="width: 10%; ">Tổng số tiền phải đóng</th>
                                    <th style="width: 10%; ">Tổng số tiền đã trả</th>
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
<script src="{{ asset('js/nhansu/changeMien.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection