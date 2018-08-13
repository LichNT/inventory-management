<div class="box box-solid">
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li  class="{{$activeMenu=="ngaycong"  ?  "active":""}}">
                <a href="{{ route('chamcong.chitiet.ngaycong',[$tenbang,$id]) }}">@component('components.iconMenu') @endcomponent Bảng công</a>
            </li>
            <li  class="{{$activeMenu=="lamthemgio"  ?  "active":""}}">
                <a href="{{ route('chamcong.chitiet.lamthemgio',[$tenbang,$id]) }}">@component('components.iconMenu') @endcomponent Tăng ca</a>
            </li>
            <li  class="{{$activeMenu=="phucap"  ?  "active":""}}">
                <a href="{{route('chamcong.chitiet.phucap',[$tenbang,$id])}}">@component('components.iconMenu') @endcomponent Phụ cấp</a>
            </li>
            <li  class="{{$activeMenu=="dongphuc"  ?  "active":""}}">
                <a href="">@component('components.iconMenu') @endcomponent Thưởng </a>
            </li>
            <li  class="{{$activeMenu=="phat"  ?  "active":""}}">
                <a href="{{route('chamcong.chitiet.phat',[$tenbang,$id])}}">@component('components.iconMenu') @endcomponent Phạt</a>
            </li>

        </ul>
    </div>
</div>