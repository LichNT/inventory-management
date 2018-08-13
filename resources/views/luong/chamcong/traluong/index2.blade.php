@extends('layouts.form')

@section('content')
        <div class="box-header">
            <h3 class="title_master_form">Trả lương lần 2</h3>
            <div class="row">
                <div class="col-xs-12">
                    <div style="float: left;">
                        <form action="{{ route('luong.chamcong.capnhatluonglan2',$ten_bang)}}" method="post" >
                            {{ csrf_field() }}
                            <button type="submit" {{($trang_thai_thanh_toan)?'disabled':null}}  class="btn bg-olive btn-file btn-flat" >
                                <i class="fa fa-refresh"> Cập nhật lương lần 2</i>
                            </button>
                        </form>
                    </div>
                    <div style="float: left; margin-left: 10px">
                        <a href="#" data-toggle="modal"  data-target="{{'#modal-add-thanhtoan2'}}" class="btn btn-flat bg-olive">
                            <i class="fa fa-list"> Thanh toán</i>
                        </a>
                        @if($trang_thai_thanh_toan)
                        @else
                         @include('luong.chamcong.traluong.thanhtoan2')
                        @endif
                    </div>


                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(), 'perPage'=>$perPage, 'data' => $data, 'routerName' => 'danhmuc.thamso'])
                        @endComponent
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                            <thead>
                            <tr>
                                <th style="width: 10%; ">Nhân sự</th>
                                <th style="width: 20%;">Lương lần 2</th>
                                <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($data as $item)
                                <tr role="row" class="odd">
                                    <td>{{$item->ho_ten}}</td>
                                    <td>{{number_format($item->tra_luong_lan_2)}}</td>
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-luonglan2-' . $item->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @include('luong.chamcong.traluong.edit2')
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            @if (count($data) > 10)
                                <tr>
                                    <th style="width: 10%; ">Nhân sự</th>
                                    <th style="width: 20%;">Lương lần 2</th>
                                    <th style="width: 5%; text-align: center">Chỉnh sửa</th>
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
                <a class="btn btn-default btn-flat" href="{{route('luong.chamcong')}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>
            </div>
        </div>
@endsection

@section('script')
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection 
