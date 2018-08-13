@component('components.modals', [ 'idModal' => 'modal-enclose-' . $loaihopdong->id, 'title' => 'Danh sách tài liệu loại hợp đồng: ' . $loaihopdong->ten,
'buttonName' => 'Cập nhật', 'width' => '890px' ] )
<div class="box-body">
<div class="modal-body">
<div class="row">
    <div class="col-md-3">
        <label >Chức vụ <span style="color: red">*</span></label>
        @component('components.select2', [
            'data' => $chucvus,
            'text' => 'ten',
            'name' => 'id_chuc_vu',
            'value' =>'id',
            'tabindex' => 1,
            'idSelected'=> old('id_chuc_vu') ])
        @endcomponent
    </div>
    <br/>
    <div class="col-md-12" style="margin-top: 10px">
        <div class="btn bg-olive btn-file btn-flat">
            <i class="fa fa-paperclip"></i> Thêm tài liệu
            <input type="file" name="attachment" id="{{'loai_hop_dong_attachment'.$loaihopdong->id}}" onchange="attachfiles(event, '{{'loai_hop_dong_attachment_files'.$loaihopdong->id}}', '{{''.$loaihopdong->id}}','loai_hop_dong', {{$loaihopdong->id}})" accept=".doc, .docx" >
        </div>
        <p class="help-block">Tối đa 32MB</p>
    </div>    
    <div class="col-md-12">
        <ul class="mailbox-attachments clearfix" id="{{'loai_hop_dong_attachment_files'.$loaihopdong->id}}">
            <!--content file--> 
            @foreach($loaihopdong->attachment as $files)
            <li id="{{'file_'. $files->file_id}}">
                <span class="text-yellow" style="margin-left: 10%;" id="{{'alert_'. $files->file_id}}"></span>
                <a class="btn bg-navy btn-xs pull-right btn-flat" onclick="remove({{$files->file_id}},{{$files->file_id}})" >
                    <i class="fa fa-remove"></i></a>
                <span class="mailbox-attachment-icon">
                    <i class="{{$files->file_icon}}"></i>
                </span>
                <div class="mailbox-attachment-info">
                    <a class="mailbox-attachment-name" id="{{$files->file_id}}" href="{{url('download/file/'.$files->file_id)}}" download><i class="fa fa-paperclip"></i>{{(strlen($files->name)>35)? substr($files->name, 11,21) .'...':substr($files->name,11)}}</a>
                    <span class="mailbox-attachment-size">{{$files->file_size}} bytes<a href="{{url('download/file/'.$files->file_id)}}" download id="'button_'. $files->name" class="btn bg-olive btn-xs pull-right flat">
                    <i class="fa fa-cloud-download"></i></a></span>
                </div> 
                <div class="progress progress-xs" id="{{'progress_'. $files->file_id}}"></div>
            </li>
            @endforeach
        </ul>
        <div id="{{'loaihopdong_files'.$loaihopdong->id}}" class="files">
            <!--input hide file-->                       
        </div>
    </div>    
</div>
</div>
</div>
 <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left flat" data-dismiss="modal" tabindex="9"><i class="fa fa-close"></i> Đóng</button>
            <button type="submit" class="btn btn-flat bg-olive" data-dismiss="modal" tabindex="8"><i class="fa fa-check"></i> {{empty($buttonName) ? 'Cập nhật' : $buttonName}}</button>
        </div>
@endcomponent