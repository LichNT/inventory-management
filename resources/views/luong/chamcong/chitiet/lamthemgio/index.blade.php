
<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
            <div class="col-sm-12">
                <div  id="div-wrap-tangca">
                    <div class="overlay" >
                        <i class="fa fa-refresh fa-spin" id="spin-tangca" style="display: none"></i>
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
                                            
                        @foreach($data_lamthemgio as $key=>$item)
                        
                        @if($key==0&&date('w',strtotime($item['ngay']))!=1)
                        <td colspan="{{(date('w',strtotime($item['ngay']))==0)? 6:date('w',strtotime($item['ngay']))-1}}"></td>
                        @endif
                            @if(date('l',strtotime($item['ngay']))=='Monday')
                            <tr>
                            @endif
                            <td>   
                                    {{'Ngày '.($key+1)}}
                                <input type="number" step="any" class="form-control"  {{'onchange=chamGio("'.$tenbang.'","'.$id_nhan_su.'","'.$item['gio_lam_them'].'",event)'}} {{'id='.$item['gio_lam_them'].''}} name="gio_lam_them" value="{{$item['so_gio']}}">
                            </td>
                            @if(date('l',strtotime($item['ngay']))=='Sunday')
                            </tr>
                            @endif
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>


    

