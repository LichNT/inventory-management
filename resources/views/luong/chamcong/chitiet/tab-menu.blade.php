<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#chamcong" data-toggle="tab" aria-expanded="false">Chấm công</a></li>
        <li class=""><a href="#tangca" data-toggle="tab" aria-expanded="false">Tăng ca</a></li>
        <li class=""><a href="#phucap" data-toggle="tab" aria-expanded="false">Phụ cấp</a></li>
        <li class=""><a href="#phat" data-toggle="tab" aria-expanded="false">Phạt</a></li>
    </ul>
    <fieldset {{$chamcong->khoa_so||$disabled||$chamcong->duyet_bang_luong?'disabled':''}}>
    <div class="tab-content" >
    
        <div class="tab-pane active" id="chamcong">
            @include('luong.chamcong.chitiet.edit')
        </div>
    
        <div class="tab-pane" id="tangca">
            @include('luong.chamcong.chitiet.lamthemgio.index')
        </div>

        <div class="tab-pane" id="phucap">
        @include('luong.chamcong.chitiet.phucap.index')
        </div>
        <div class="tab-pane" id="phat">
        @include('luong.chamcong.chitiet.phat.index')
        </div>
    
    </div>
    </fieldset>
</div>