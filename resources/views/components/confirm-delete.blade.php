@component('components.modals', [ 
    'idModal' => 'modal-' . ($type . '-' . $data->id), 
    'title' => (empty($title) ? __('system.title_form_delete') : __('system.title_form_delete') . ' ' . $title),    
    'width' => (empty($width) ? '30%' : $width)])
<form class="form-horizontal" action="{{ route($route,empty($params)? $data->id:$params) }}" method="post" onsubmit="document.getElementById('{{'whilesubmit_'.$data->id}}').disabled=true">
    {{ csrf_field() }}
    {{ method_field('delete') }}
    <div class="modal-body">                                        
        {{$slot}}     
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">
            <i class="fa fa-close"></i> {{__('button.close')}}
        </button>
        <button type="submit" id="{{'whilesubmit_'.$data->id}}" class="btn btn-flat bg-navy delete">
            <i class="fa fa-check"></i> {{isset($buttonName) ? $buttonName : __('button.delete')}}
        </button>
    </div>
</form>
@endcomponent