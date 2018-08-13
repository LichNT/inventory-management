@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.chitietbaolanh').' NHÂN VIÊN '.$nhansu->ho_ten}}</h1>
@endsection

@section('content')
<div class="box">
    <div class="box-header">
        <div class="row">
            <div class="col-xs-12 pull-right">
                <a href="#" data-toggle="modal" data-target="#modal-add-chitietbaolanh" class="btn btn-flat bg-olive">
                    <i class="fa fa-plus"> Thêm mới</i>
                </a> 
                @include('luong.danhsachtienbaolanh.chitietbaolanh.add')                       
            </div> 
        </div>
    </div>
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6">
                    @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'luong.phat'])
                    @endComponent
                </div>
                <div class="col-sm-6">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                        <thead>
                        <tr role="row">
                            <th style="width: 20%; ">Loại</th>
                            <th style="width: 20%; text-align:center;">Số tiền</th>
                            <th style="width: 20%; text-align:center; ">Ngày</th>
                            <th style="width: 10%; text-align:center;">Xóa</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr role="row">
                                @if($item->loai)
                                    <td style="width: 20%; ">Nộp tiền bảo lãnh</td>
                                @else
                                <td style="width: 20%; ">Hoàn trả tiền bảo lãnh</td>
                                @endif
                                <td style="width: 20%;text-align:center;">{{number_format($item->so_tien)}}</td>
                                <td style="width: 20%;text-align:center;">{{$item->ngay_thang}}</td>
                                <td align="center">
                                    <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-chitietbaolanh-' . $item->id }}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    @include('luong.danhsachtienbaolanh.chitietbaolanh.delete')
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
        <div class="box-footer">
            <a class="btn btn-default btn-flat" href="{{route('luong.danhsachtienbaolanh')}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>
        </div>
    </div>
</div>
@endsection
@section('script')    
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection