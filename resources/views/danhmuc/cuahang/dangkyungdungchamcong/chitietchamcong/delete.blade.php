@component('components.confirm-delete',
[
    'route' => 'dangkyungdungchamcong.chitiet.delete',
    'method' => 'delete',
    'data' => $chitiet,
    'type' => 'delete-chitiet',
    'title' => 'chi tiết chấm công'
])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Ghi chú</label>
            <input type="text" class="form-control"  name="ghi_chu" tabindex="1" disabled value="{{$chitiet->ghi_chu}}">
        </div>
        <div class="col-sm-12">
            @component('components.group-checkbox', [
                    'title' => 'Hợp lệ',
                    'id' => 'active',
                    'name' => 'active',
                    'title_active' => 'Hợp lệ',
                    'title_inactive' => 'Không hợp lệ',
                    'value_active' => 1,
                    'value_inactive' => 0,
                    'value' => $chitiet->hop_le,
                    'disabled' => 'disabled'
                ])
            @endcomponent
        </div>
    </div>
@endcomponent