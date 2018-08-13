@component('components.modals', [ 'idModal' => 'modal-enclose-' . $giamtrugiacanh->id, 'title' => 'Danh sách file đính kèm',
'buttonName' => 'Cập nhật' ] )
<div class="box-body">
<div class="modal-body">
<div class="row">
    <div class="col-md-12">
        <div class="btn btn-default btn-file">
            <i class="fa fa-paperclip"></i> Đính kèm tài liệu
            <input type="file" name="attachment" id="{{'thue_attachment'. $giamtrugiacanh->id}}" onchange="attachfiles(event, '{{'thue_attachment_files_'. $giamtrugiacanh->id}}', '{{'thue_files_'. $giamtrugiacanh->id}}','giamtrugiacanh', {{$giamtrugiacanh->id}})">
        </div>
        <p class="help-block">Tối đa. 32MB</p>
    </div>    
    <div class="col-md-12">
        <ul class="mailbox-attachments clearfix" id="{{'thue_attachment_files_'. $giamtrugiacanh->id}}">
            <!--content file--> 
            @foreach($thue->attachment as $files)
            <li id="{{'file_'. $files->file_id}}">
                 <span class="text-yellow" style="margin-left: 10%;" id="{{'alert_'. $files->file_id}}"></span>
                <a class="btn btn-default btn-xs pull-right btn-flat" onclick="remove({{$files->file_id}},{{$files->file_id}})" >
                    <i class="fa fa-remove"></i></a>
                <span class="mailbox-attachment-icon">
                    <i class="{{$files->file_icon}}"></i>
                </span>
                <div class="mailbox-attachment-info">
                    <a class="mailbox-attachment-name" download id="{{$files->file_id}}" href="{{url('download/file/'.$files->file_id)}}" download><i class="fa fa-paperclip"></i> {{(strlen($files->name)>35)? substr($files->name, 11,21) .'...':substr($files->name,11)}}</a>
                    <span class="mailbox-attachment-size">{{$files->file_size}} bytes<a href="{{url('download/file/'.$files->file_id)}}" download id="'button_'. $files->name" class="btn btn-primary btn-xs pull-right">
                    <i class="fa fa-cloud-download"></i></a></span></div> 
                    <div class="progress progress-xs" id="{{'progress_'. $files->file_id}}"></div>
            </li>
            @endforeach
        </ul>
        <div id="{{'thue_files_'. $thue->id}}" class="files">
            <!--input hide file-->                       
        </div>
    </div>    
</div>
</div>
</div>
 <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal" tabindex="9"><i class="fa fa-close"></i> Đóng</button>
            <button type="submit" class="btn btn-flat bg-olive" data-dismiss="modal" tabindex="8"><i class="fa fa-check"></i> {{empty($buttonName) ? 'Cập nhật' : $buttonName}}</button>
        </div>
@endcomponent