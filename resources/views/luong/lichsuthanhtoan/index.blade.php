@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.lichsuthanhtoan')}}</h1>
@endsection

@section('content')
<div class="box">
        <div class="box-header">
            <div class="row">                

            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'luong.lichsuthanhtoan'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        @include('luong.lichsuthanhtoan.box-search')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Nhân sự</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 20%; ">Ngày giao dịch</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 20%; ">Số tiền(vnđ)</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Nội dung</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $lichsuthanhtoan)
                                <tr role="row">
                                    <td tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">{{$lichsuthanhtoan->nhanSu->ho_ten}}</td>
                                    <td tabindex="0" rowspan="1" colspan="1" style="width: 20%; ">{{$lichsuthanhtoan->ngay_giao_dich}}</td>
                                    <td tabindex="0" rowspan="1" colspan="1" class="maskmoney" style="width: 20%; ">{{number_format($lichsuthanhtoan->so_tien)}}</td>
                                    <td tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">
                                        {{$lichsuthanhtoan->noi_dung}}
                                    </td>
                            @endforeach

                            </tbody>
                            <tfoot>

                            @if (count($data) >= 10)
                                <tr role="row">
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Nhân sự</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 20%; ">Ngày giao dịch</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 20%; ">Số tiền(vnđ)</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Nội dung</th>
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
    <input type="hidden" id="cua_hang_hidden" data="[]">
    <input type="hidden" id="nhan_su" data="[]">
@endsection
@section('script')  
    <script src="{{ asset('js/dkChamCong.js') }}"></script>  
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection