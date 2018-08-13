<div class="modal fade in" id="{{$idModal}}" style="text-align:initial;">
    <div class="modal-dialog" {{empty($width) ? null: 'style=width:'. $width . ';'}}>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{$title}}</h4>
            </div>
            {{ $slot }}            
        </div>        
    </div>    
</div>