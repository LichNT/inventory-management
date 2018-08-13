@component('components.confirm-delete', 
[ 
    'route' => 'danhmuc.tochuc.delete', 
    'method' => 'delete', 
    'data' => $tochuc,
    'width' => '35%',
    'type' => 'delete-tochuc',
    'title' => __('model.to_chuc')   
]) 
   <div class="row">
    <div class="overlay">
            <i class="fa fa-refresh fa-spin" style="font-size:20px"></i>
        </div>
        <div class="info-box-tochuc" style="border: 1px solid #f39c12;margin-left: 10px;margin-right: 10px;">
        </div>
        <div class="title_chitiet"></div>
            
        <ul class="list_child_to_chuc">

       </ul>
    </div>               
@endcomponent