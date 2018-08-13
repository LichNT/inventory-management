
<div class="row invoice-info col-sm-12">
<br>
    <div class="row" >
        <h4>Chấm công</h4><br>
            @foreach($data_cong as $key=>$item)
                @if($item['so_ngay_cong']!=0)
                <div class="col-sm-4 invoice-col">
                    <b>{{$item['ten']}}</b>: {{$item['so_ngay_cong']}}<br>
                </div>
                @endif
            @endforeach
    </div>
    <br>
    <div class="row">
        <h4>Số giờ làm thêm: {{$data_tangca}}</h4><br>
    </div>
</div>
