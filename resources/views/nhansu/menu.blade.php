<div class="box box-solid">
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">      
            <li  class="{{(empty($activeMenu)||$activeMenu=="chung" ) ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.chung',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Lý lịch</a>
            </li>
            <li  class="{{$activeMenu=="congtac"  ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.phongban',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Quá trình công tác</a>
            </li>
            <li  class="{{$activeMenu=="giamtrugiacanh"  ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.giamtrugiacanh',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Giảm trừ gia cảnh</a>
            </li>
            <li  class="{{$activeMenu=="dongphuc"  ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.dongphuc',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Đồng phục</a>
            </li>
            <li  class="{{$activeMenu=="luong"  ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.luong',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Lương</a>
            </li>
            <li class="{{$activeMenu=="baohiem"  ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.baohiem',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Bảo hiểm</a>
            </li>
            <li  class="{{$activeMenu=="theodoihopdong"  ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.theodoihopdong',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Theo dõi hợp đồng</a>
            </li>
            <li class="{{$activeMenu=="hosonhansu"  ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.hosonhansu',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Hồ sơ nhân sự</a>
            </li>
            <li  class="{{$activeMenu=="nghidacbiet"  ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.nghidacbiet',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Nghỉ đặc biệt</a>
            </li>
            <li  class="{{$activeMenu=="lichsuthaydoi"  ?  "active":""}}">
                <a href="{{ URL::route('nhansu.update.lichsuthaydoi',$nhansu->id)}}">@component('components.iconMenu') @endcomponent Lịch sử thay đổi</a>
            </li>
        </ul>
    </div>
</div>