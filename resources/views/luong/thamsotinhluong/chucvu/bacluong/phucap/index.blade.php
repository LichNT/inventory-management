@extends('layouts.app')

@section('title')
    <h1>Danh sách phụ cấp lương {{$ten_bac}}  </h1>
@endsection

@section('content')
    <div>
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-12 pull-right">
                        <a href="#" data-toggle="modal" data-target="#modal-add-bacluong" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a>
                        @include('luong.thamsotinhluong.chucvu.bacluong.phucap.add')
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6">
                            @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage])
                            @endComponent
                        </div>
                        <div class="col-sm-6">
                            <div id="search" class="dataTables_filter">
                            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'luong.chamcong.thamsophucap','id'=>$bac_id, 'search' => (empty($search) ? null : $search)])
                                @endComponent 
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                                <thead>
                                <tr role="row">
                                    <th style="width: 20%; ">Tên phụ cấp</th>
                                    <th style="width: 20%; ">Số tiền(vnđ)</th>
                                    <th style="width: 10%; text-align: center">Từ ngày</th>
                                    <th style="width: 10%; text-align: center">Chỉnh sửa</th>
                                    <th style="width: 10%; text-align: center;">Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $phucap)
                                    <tr role="row">
                                        <td style="width: 30%; ">{{empty($phucap->id_loai_phu_cap)? null:App\LoaiPhuCap::findOrFail($phucap->id_loai_phu_cap)->ten}}</td>
                                        <td class="maskmoney" style="width: 30%; ">{{isset($phucap->so_tien)?number_format($phucap->so_tien):''}}</td>
                                        <td style="text-align: center;">{{$phucap->tu_ngay}}</td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-update-phucap-' . $phucap->id }}">
                                                <i class="fa fa-edit" ></i>
                                            </a>
                                            @include('luong.thamsotinhluong.chucvu.bacluong.phucap.detail')
                                        </td>
                                        <td align="center">                
                                          <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-phucap-' . $phucap->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @include('luong.thamsotinhluong.chucvu.bacluong.phucap.delete')                                           
                                        </td>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @component('components.pagination', ['pageShow' => 3, 'data' => $data])
                    @endComponent
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default btn-flat" href="{{route('luong.chamcong.thamsobacluong',$id_chuc_vu)}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection