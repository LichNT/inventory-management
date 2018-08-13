@extends('layouts.form')


@section('content')
    <div>
        <div class="box">
            <div class="box-header">
                <h3 class="title_master_form">Danh sách phụ cấp lương {{$ten_bac}}</h3>
                <div class="row">
                    <div class="col-xs-12 pull-right">
                        <a href="#" data-toggle="modal" data-target="#modal-add-bacluong" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        @include('danhmuc.chucvu.bacluong.phucap.add')
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6">
                            @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'bacluong.phucap','id'=>$bac_id])
                            @endComponent
                        </div>
                        <div class="col-sm-6">
                            <div id="search" class="dataTables_filter">
                                @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'bacluong.phucap','id'=>$bac_id, 'search' => (empty($search) ? null : $search)])
                                @endComponent
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                                <thead>
                                <tr role="row">
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Tên phụ cấp</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">Số tiền(vnđ)</th>
                                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%; text-align: center;">Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $phucap)
                                    <tr role="row">
                                        <td tabindex="0" rowspan="1" colspan="1" style="width: 30%; ">{{$phucap->loaiPhuCap->ten}}</td>
                                        <td tabindex="0" rowspan="1" colspan="1" class="maskmoney" style="width: 30%; ">{{isset($phucap->so_tien)?number_format($phucap->so_tien):''}}</td>
                                       
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-phucap-' . $phucap->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @include('danhmuc.chucvu.bacluong.phucap.delete')
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
            <div class="box-footer">
                <a class="btn btn-default btn-flat" href="{{route('danhmuc.chucvu')}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection