
    <div class="box-header">
        <div class="row">
            <div class="col-xs-12 pull-right">
                <a href="#" data-toggle="modal" data-target="{{'#modal-add-phat'}}" class="btn btn-flat bg-olive">
                    <i class="fa fa-plus"> Thêm mới</i>
                </a>
                @include('luong.chamcong.chitiet.phat.add')
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-12">
                    <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                        <thead>
                        <tr role="row">
                            <th>Lý do bị phạt </th>
                            <th >Số tiền</th>
                            <th >Ngày</th>
                            <th style="text-align:center">Chỉnh sửa</th>
                            <th style="text-align:center">Xoá</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data_phat as $item)
                            <tr>
                                <td>{{$item->loaiPhat->ten}}</td>
                                <td>{{number_format($item->so_tien)}}</td>
                                <td>{{$item->ngay}}</td>
                                <td style="text-align:center">
                                    <a href="#" data-toggle="modal" data-target="{{ '#modal-update-phat-' . $item->id }}">
                                        <i class="fa fa-edit" ></i>
                                    </a>
                                    @include('luong.chamcong.chitiet.phat.edit')
                                </td>
                                <td style="text-align:center">
                                    <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-phat-' . $item->id }}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    @include('luong.chamcong.chitiet.phat.delete')
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        @if (count($data_phat) >= 10)
                            <tr role="row">
                                <th>Lý do bị phạt </th>
                                <th style="text-align: center ">Số tiền</th>
                                <th style="width: 10%;text-align: center ">Ngày</th>
                                <th >Chỉnh sửa</th>
                                <th >Xoá</th>
                            </tr>
                        @endif
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>

