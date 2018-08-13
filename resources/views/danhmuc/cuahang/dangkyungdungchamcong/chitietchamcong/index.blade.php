@extends('layouts.form')

@section('content')
    <div class="box-header">
        <h1 class="page-header">Thông tin nhân sự</h1>
    </div>
    <div class="box-body">
        <div class="col-sm-4 invoice-col">
            <b>Họ tên: </b>{{$dangkichamcong->ho_ten}}<br>
            <b>Ngày sinh: </b>{{$dangkichamcong->ngay_sinh}}<br>
            <b>Cửa hàng: </b>{{$dangkichamcong->cuaHang->ten}}
        </div>
        <div class="col-sm-4 invoice-col">
            <b>Mã: </b>{{$dangkichamcong->ma}}<br>
            <b>Số điện thoại: </b>{{$dangkichamcong->so_dien_thoai}}<br>
            <b>Kinh độ: </b>{{$dangkichamcong->cuaHang->long}}
        </div>
        <div class="col-sm-4 invoice-col">
            <b>Mã thẻ chấm công: </b>{{$dangkichamcong->ma_the_cham_cong}}<br>
            <b>Email: </b>{{$dangkichamcong->email}}<br>
            <b>Vĩ độ: </b>{{$dangkichamcong->cuaHang->lat}}
        </div>
    </div>
    <div class="box-header">
        <h2 class="page-header">Chi tiết chấm công</h2>
        <br/>
        <form>
            <div class="row">
                <div class="col-md-2">                    
                    <input type="text" id="search_nam" class="form-control yearmask"  value="{{$search_nam}}" name="search_nam" tabindex="2" placeholder="Năm">
                </div>
                <div class=" col-md-2">                    
                    @component('components.select-month', [
                                  'idSelected' => $search_thang,
                                  'value' => 'id',
                                  'name' => 'search_thang',
                                  'none_required'=> true
                              ])
                    @endcomponent
                </div>
                <div class="col-md-2">                    
                    <button type="submit" class="btn btn-flat bg-olive pull-left">
                        <i class="fa fa-refresh"> Xuất dữ liệu</i>
                    </button>
                </div>
            </div>            
        </form>
    </div>
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6">
                    @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(), 'perPage' => $perPage, 'data' => $data, 'routerName' => 'dangkyungdungchamcong.chitiet','id'=>$dangkichamcong->ma_the_cham_cong])
                    @endComponent
                </div>
                <div class="col-sm-6">
                    @include('danhmuc.cuahang.dangkyungdungchamcong.chitietchamcong.box-search')
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                        <thead>
                        <tr role="row">
                            <th style="text-align: center;" colspan="4">Check-in</th>
                            <th style="text-align: center;" colspan="4">Check-out</th>
                            <th rowspan="2">Ghi chú</th>
                            <th rowspan="2" style="text-align: center;">Hợp lệ</th>
                            <th rowspan="2" style="width: 5%; text-align: center">Chỉnh sửa</th>
                            <th rowspan="2" style="width: 5%; text-align: center">Xóa</th>
                        </tr>
                        <tr role="row">
                            <th>Thời gian</th>
                            <th>Kinh độ</th>
                            <th>Vĩ độ</th>
                            <th style="text-align: center">Khoảng cách (m)</th>
                            <th>Thời gian</th>
                            <th>Kinh độ</th>
                            <th>Vĩ độ</th>
                            <th style="text-align: center">Khoảng cách (m)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $chitiet)
                            <tr role="row" class="odd">
                                <td >{{$chitiet->thoi_gian_check_in}}</td>
                                <td>{{$chitiet->long_check_in}}</td>
                                <td>{{$chitiet->lat_check_in}}</td>
                                <td align="center">{{$chitiet->khoang_cach_check_in}}</td>
                                <td>{{$chitiet->thoi_gian_check_out}}</td>
                                <td>{{$chitiet->long_check_out}}</td>
                                <td>{{$chitiet->lat_check_out}}</td>
                                <td align="center">{{$chitiet->khoang_cach_check_out}}</td>
                                <td>{{$chitiet->ghi_chu}}</td>
                                <td style="text-align: center;">
                                    @if ($chitiet->hop_le===true)
                                        <small  class="label bg-olive flat block">Hợp lệ</small>
                                    @elseif ($chitiet->warning===true)
                                        <small  class="label bg-yellow flat block">Cảnh báo</small>
                                    @else
                                        <small class="label bg-navy flat block">Không hợp lệ</small>
                                    @endif
                                </td>
                                <td align="center">
                                    <a href="#" data-toggle="modal" data-target="{{ '#modal-update-chitiet-' . $chitiet->id }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @include('danhmuc.cuahang.dangkyungdungchamcong.chitietchamcong.edit')
                                </td>
                                <td align="center">
                                    <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-chitiet-' . $chitiet->id }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @include('danhmuc.cuahang.dangkyungdungchamcong.chitietchamcong.delete')
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
@endsection