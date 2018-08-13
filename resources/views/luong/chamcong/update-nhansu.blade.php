@component('components.modal-add', [
   'type' => 'update-nhansu',
   'title' => __('model.update_nhan_su_cham_cong'),
   'width' => '35%',
   'route' => 'luong.chamcong.capnhatnhansu',
   'buttonName'=>'Cập nhật',
   'id' => \Session::has('ten_bang')?\Session::get('ten_bang'):null,
   
   ])
    <div class="row">
        <div class="col-sm-12">
            <span style="text-align: center;margin: 3px auto;display: inherit;">
            Bạn có muốn cập nhật thông tin nhân sự?</span>  
        </div>
    </div>
@endcomponent