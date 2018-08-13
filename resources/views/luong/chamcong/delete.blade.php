@component('components.confirm-delete',
[
    'route' => 'luong.chamcong.delete',
    'method' => 'delete',
    'data' => $item,
    'type' => 'delete-chamcong',
    'title' => __('model.bang_cham_cong'),
    'width' => '35%'
])
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label">Tên <span style="color:red">*</span></label>
                <input type="text" disabled class="form-control" name="ten" tabindex="1" required value="{{$item->ten}}" autofocus placeholder="Dài không quá 500 ký tự">

                <label class="control-label">Năm <span style="color:red">*</span></label>
                <input type="number" disabled class="form-control" name="nam" tabindex="2" required readonly value="{{$item->nam}}">

                <label class="control-label">Tháng<span style="color:red">*</span></label>
                <input type="number" disabled class="form-control" name="thang" tabindex="2" required readonly value="{{$item->thang}}">

            </div>
        </div>
@endcomponent