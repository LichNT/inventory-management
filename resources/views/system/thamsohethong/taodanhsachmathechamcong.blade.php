@component('components.modals', [ 'title' => 'Tạo danh sách mã chấm công', 'width' => '30%', 'idModal' => 'modal-taodanhsachmathechamcong',
])
<form class="form-horizontal" action="{{ route('system.thamsohethong.taomathechamcong') }}" method="POST" onsubmit="document.getElementById('onsubmit').disabled=true">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="row">            
            <div class="col-sm-12">
                <label class="control-label">Số lượng <span style="color:red">*</span></label>
                <input type="number" class="form-control" value="{{old('quantity', 100)}}" name="quantity" placeholder="Số lượng mã chấm công cần tạo" tabindex="2" min="1" max="1000">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">
            <i class="fa fa-close"></i> {{__('button.close')}}
        </button>
        <button type="submit" id="onsubmit" class="btn btn-flat bg-olive">
            <i class="fa fa-check"></i> {{__('button.confirm')}}
        </button>
    </div>
</form>
@endcomponent