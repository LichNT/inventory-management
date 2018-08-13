@component('components.modals', [ 'idModal' => 'modal-enclose-' . $hopdongchucvu->id, 'title' => 'Danh sách hồ sơ gắn với hợp đồng: ' . $hopdongchucvu->loaihopdong->ten . '-'. $hopdongchucvu->chucvu->ten,
'buttonName' => 'Cập nhật', 'width' => '890px' ] )
<div class="modal-body">
    <div class="row">        
        <div class="col-md-12">
            <div class="btn bg-olive btn-file btn-flat">
                <i class="fa fa-paperclip"></i> Thêm hồ sơ
                <input type="file" name="attachment" id="{{'hop_dong_chuc_vu_attachment'.$hopdongchucvu->id}}" onchange="attachfiles(event, '{{'hop_dong_chuc_vu_attachment_files'.$hopdongchucvu->id}}', '{{''.$hopdongchucvu->id}}','hop_dong_chuc_vu', {{$hopdongchucvu->id}})" accept=".doc, .docx" >
            </div>
            <p class="help-block">Tối đa 32MB</p>
        </div>                
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="mailbox-attachments clearfix" id="{{'hop_dong_chuc_vu_attachment_files'.$hopdongchucvu->id}}">
                <!--content file--> 
                @foreach($hopdongchucvu->attachment as $files)
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
            <div id="{{'hopdongchucvu_files'.$hopdongchucvu->id}}" class="files">
                <!--input hide file-->                       
            </div>
        </div>
    </div>
</div>
 <div class="modal-footer">
    <button type="button" class="btn btn-default pull-left flat" data-dismiss="modal" tabindex="9"><i class="fa fa-close"></i> {{__('button.close')}}</button>
    <button type="submit" class="btn btn-flat bg-olive" data-dismiss="modal" tabindex="8"><i class="fa fa-check"></i> {{__('button.edit')}}</button>
</div>
@endcomponent