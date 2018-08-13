@component('components.modal-update', [
   'type' => 'update-duyetbangluong',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'luong.chamcong.duyetlaibangluong',
   'data' => $chamcong,
   'method' => 'PUT'])
    <div class="row">
        <div class="col-sm-12">
        <label for="first_name">{{$ten_hien_thi_chi_nhanh}}</label>
            @component('components.select', [
                'data' => $chi_nhanhs,
                'text' => 'ten',
                'name' => 'id_chi_nhanh',
                'value' => 'id',
                'tabindex' => 4,
                'idSelected' => old('id_chi_nhanh')
                ])
            @endcomponent
        </div>
    </div>
@endcomponent