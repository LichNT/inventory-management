
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-12">
                    <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                        <thead>
                        <tr role="row">
                            <th>Tên phụ cấp </th>
                            <th style="text-align: center ">Số tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($nhansu->heSoLuong->phuCaps as $item)
                            <tr>
                                <td>{{$item->loaiPhuCap->ten}}</td>
                                <td style="text-align: center ">{{number_format($item->so_tien)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        @if (count($nhansu->heSoLuong->phuCaps) >= 10)                           
                            <tr >
                                <th>Tên phụ cấp </th>
                                <th>Số tiền</th>
                            </tr>
                        @endif
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
