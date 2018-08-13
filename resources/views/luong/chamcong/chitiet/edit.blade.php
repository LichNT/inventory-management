<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
            <div class="col-sm-12">
                <div  id="div-wrap">
                    <div class="overlay" >
                        <i class="fa fa-refresh fa-spin" id="spin" style="display: none"></i>
                    </div>
                    <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>Thứ 2</th>
                                <th>Thứ 3</th>
                                <th>Thứ 4</th>
                                <th>Thứ 5</th>
                                <th>Thứ 6</th>
                                <th>Thứ 7</th>
                                <th>Chủ nhật</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data_chamcong as $key=>$item) @if($key==0&&date('w',strtotime($item['ngay']))!=1)
                            <td colspan="{{(date('w',strtotime($item['ngay']))==0)? 6:date('w',strtotime($item['ngay']))-1}}"></td>
                            @endif @if(date('l',strtotime($item['ngay']))=='Monday')
                            <tr>
                                @endif
                                <td>
                                    {{'Ngày '.($key+1)}} @component('components.select', ['data' => $loaichamcongs, 'value'=>'id' , 'text' => 'ten', 'name' =>
                                    $tenbang, 'id_nhan_su' => $chamcongnhansu->nhan_su_id, 'id'=>$item['ngay_so'], 'chamcong'=>'true', 'idSelected'=>$item['id_loai_cham_cong'],
                                    'none_required'=>true ]) @endcomponent
                                </td>
                                @if(date('l',strtotime($item['ngay']))=='Sunday')
                            </tr>
                            @endif @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            
            </div>
        </div>

    </div>
</div>