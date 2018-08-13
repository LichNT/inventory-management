@component('components.modals', [ 
    'idModal' => 'modal-' . ($type . '-' . $data['id']),
    'title' => (empty($title) ? __('system.update') : $title),    
    'width' => (empty($width) ? '30%' : $width)])
<form class="form-horizontal" action="{{ route($route, $data['id']) }}" method="POST"  onsubmit="document.getElementById('{{'submit_'.$data['id']}}').disabled=true">
    {{ csrf_field() }}    
    {{ isset($method) ? method_field($method) : null }}
    <div class="modal-body">                                        
        {{$slot}}     
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">
            <i class="fa fa-close"></i> {{__('button.close')}}
        </button>
        <button type="submit" id="{{'submit_'.$data['id']}}" class="btn btn-flat bg-orange">
            <i class="fa fa-pencil"></i> {{isset($buttonName) ? $buttonName : __('button.edit')}}
        </button>
    </div>
</form>
@endcomponent