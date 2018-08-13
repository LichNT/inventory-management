@component('components.confirm-delete',
[
    'route' => 'nhansu.delete',
    'method' => 'delete',
    'data' => $nhansu,
    'type' => 'delete-nhansu',
    'title' => __('model.nhan_su'),
    'width' => '25%',
])
    <div class="row">
        <div class="overlay">
            <i class="fa fa-refresh fa-spin" style="font-size:20px"></i>
        </div>
        <div class="info-box-nhansu" style="border: 1px solid #f39c12;margin-left: 10px;margin-right: 10px;">
        </div>
        <div class="title_chitiet"></div>
            
        <ul class="list_relationship_nhan_su">

       </ul>
    </div>
@endcomponent
