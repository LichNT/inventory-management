@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.phat')}}</h1>
@endsection

@section('content')
<div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-xs-12 pull-right">
                    @include('luong.phat.add')
                    <form action="{{ route('phat.sync.byexcel') }}" id="form_import" method="POST"  enctype="multipart/form-data" onsubmit="document.getElementById('submit').disabled=true">
                        {{ csrf_field() }}
                        <a href="#" data-toggle="modal" data-target="#modal-add-phat" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        <button type="button" id="btnXuatExcel" class="btn bg-default btn-flat margin" onclick="download('{{route('download.template', 'tem_phat_sync')}}',null,null)">
                            <i class="fa fa-file-excel-o"> File mẫu</i>
                        </button>
                        <div class="btn bg-olive btn-file btn-flat margin">
                            <i class="fa fa-paperclip"></i> Chọn file excel
                            <input type="file"  name="import_excel" onchange="form.submit()">
                        </div>
                    </form>
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
                        @include('luong.phat.box-search')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Tên nhân viên</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Lý do bị phạt</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Số tiền(vnđ)</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Ngày</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center">Chỉnh sửa</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $phat)
                                <tr role="row">
                                    <td tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">{{$phat->nhanSu->ho_ten}}</td>
                                    <td tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">{{$phat->loaiphat->ten}}</td>
                                    <td tabindex="0" rowspan="1" colspan="1" class="maskmoney" style="width: 30%; ">{{number_format($phat->so_tien)}}</td>
                                    <td tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">
                                        {{$phat->ngay}}
                                    </td>

                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-phat-' . $phat->id }}">
                                            <i class="fa fa-edit" ></i>
                                        </a>
                                        @include('luong.phat.detail')
                                    </td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-phat-' . $phat->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('luong.phat.delete')
                                    </td>
                            @endforeach

                            </tbody>
                            <tfoot>

                            @if (count($data) >= 10)
                                    <tr role="row">
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Tên</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Hệ số lương</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">Mô tả</th>
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
    <input type="hidden" id="chi_nhanh_hidden" data="{{$chinhanhs}}">
    <input type="hidden" id="tinh_hidden" data="{{$tinhs}}">
    <input type="hidden" id="cua_hang_hidden" data="{{$cuahangs}}">
@endsection
@section('script')    
    <script src="{{ asset('js/dkChamCong.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection