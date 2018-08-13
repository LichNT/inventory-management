@component('components.modals', [ 'idModal' => 'modal-' . ($type . '-' . $data->idlichsuduan), 
'title' => (empty($title) ? 'Xác nhận người dùng' : $title)] )
<form class="form-horizontal" action="{{ route($route, $data->idlichsuduan) }}" method="post">
    {{ csrf_field() }}
    {{ method_field('delete') }}
    <div class="box-body">
        <div class="modal-body">                                        
           {{$slot}}     
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
            <i class="fa fa-close"></i>  Đóng
        </button>
        <button type="submit" class="btn btn-primary" autofocus>
            <i class="fa fa-trash"></i> {{isset($buttonName) ? $buttonName : __('button.delete')}}
        </button>
    </div>
</form>
@endcomponent