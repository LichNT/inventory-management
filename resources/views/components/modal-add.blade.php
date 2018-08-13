
@component('components.modals', [
    'idModal' => 'modal-add-' . $type, 
    'title' => (empty($title) ? __('system.title_form_create') : __('system.title_form_create') . ' ' . $title),    
    'width' => (empty($width) ? '30%' : $width)])
<form class="form-horizontal" action="{{ route($route, empty($id)? null: $id) }}" method="POST" {{!empty($enctype)?'enctype='.$enctype:null}} onsubmit="document.getElementById('onsubmit').disabled=true">
    {{ csrf_field() }}        
    <div class="modal-body">                                        
        {{$slot}}     
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">
            <i class="fa fa-close"></i> {{__('button.close')}}
        </button>
        <button type="submit" id="onsubmit" class="btn btn-flat bg-olive">
            <i class="fa fa-check"></i> {{isset($buttonName) ? $buttonName : __('button.add')}}
        </button>
    </div>
</form>
@endcomponent