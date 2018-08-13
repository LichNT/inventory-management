@component('components.modal-update', [
   'type' => 'update-moso',
   'title' => __('model.bang_cham_cong'),
   'width' => '35%',
   'route' => 'luong.chamcong.moso',
   'data' => $item,
   'method' => 'PUT'])
    <div class="row">
        <div class="col-md-12">
            <label>Bạn có muốn mở khóa bảng chấm công?</label>
        </div>
    </div>
@endcomponent