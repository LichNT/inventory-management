@component('components.modals', [ 'idModal' => 'modal-enclose-' . $hopdong->id, 'title' => 'Danh sách hồ sơ gắn với hợp đồng',
'buttonName' => 'Cập nhật' ] )
<div class="box-body">
    <div class="modal-body">
        <div class="row">  
            <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr role="row">
                            <th style="width: 15%;">Tên </th>
                            <th style="width: 5%;text-align: center">Tải hồ sơ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($hopdong->hopDongChucVu->attachment as $hopdong)
                        <tr>
                            <td>{{substr($hopdong->name, 11)}}</td>
                            <td align="center">
                                <a href="{{'/download/file/'.$hopdong->file_id}}">
                                    <i class="fa fa-cloud-download bg-olive"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>    
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left flat" data-dismiss="modal" tabindex="9"><i class="fa fa-close"></i> Đóng</button>
        </div>
    </div>
   
</div>
 
@endcomponent