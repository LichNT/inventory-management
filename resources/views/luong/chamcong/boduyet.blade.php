@component('components.modal-update', [
   'type' => 'update-boduyet',
   'title' => __('model.bang_cham_cong'),
   'width' => '35%',
   'route' => 'luong.chamcong.boduyet',
   'data' => $item,
   'method' => 'PUT'])
    <div class="row">
        <div class="col-md-12">
            <label>Bạn có muốn bỏ duyệt bảng chấm công?</label>
        </div>
    </div>
@endcomponent