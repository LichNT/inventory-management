function attachfiles(event, attacment_box_id, files_hiden_id, reference_type, reference_id, name_array) {
    var attachmentFilesElement = document.getElementById(attacment_box_id);

    if (attachmentFilesElement) {
        if (event.target && event.target.files) {
            let file = event.target.files[0];
            if (file) {
                let fileIcon;
                let fileName;
                let fileSize;
                fileName = file.name.replace(/\n/g, '').trim();
                fileSize = bytesToSize(file.size);
                if (file.size > (32 * 1024 * 1024)) {

                    return false;
                }
                let keyFile = new Date().getTime();

                switch (file.type) {
                    case 'application/pdf':
                        fileIcon = 'fa fa fa-file-pdf-o';
                        break;
                    case 'image/jpeg':
                        fileIcon = 'fa fa-file-image-o';
                        break;
                    case 'image/png':
                        fileIcon = 'fa fa-file-image-o';
                        break;
                    case 'image/jpg':
                        fileIcon = 'fa fa-file-image-o';
                        break;
                    case 'image/gif':
                        fileIcon = 'fa fa-file-image-o';
                        break;
                    case 'text/plain':
                        fileIcon = 'fa fa-file-text-o';
                        break;
                    default:
                        fileIcon = 'fa fa-file-archive-o';
                        let file_extension = fileName.split('.').pop().toLowerCase();
                        let extension_excel = ['xls', 'xlsx'];
                        let extension_doc = ['doc', 'docx'];
                        if (extension_excel.indexOf(file_extension) != -1) {
                            fileIcon = 'fa fa-file-excel-o';
                        }
                        else if (extension_doc.indexOf(file_extension) != -1) {
                            fileIcon = 'fa fa-file-word-o';
                        }
                }

                if (fileName.length > 25) {
                    fileName = fileName.substring(0, 22) + '...';
                }

                let li = document.createElement('li');
                li.setAttribute('id', 'file_' + keyFile);
                let alert = document.createElement("span");
                alert.setAttribute('class', 'text-yellow');
                alert.setAttribute('style', 'margin-left: 10%;')
                alert.setAttribute('id', 'alert_' + keyFile);
                li.appendChild(alert);
                let buttonRemove = document.createElement('a');

                buttonRemove.setAttribute('disabled', 'true');

                buttonRemove.setAttribute('id', 'button_remove_' + keyFile);
                buttonRemove.setAttribute('class', 'btn bg-navy btn-xs pull-right btn-flat');
                buttonRemove.innerHTML = '<i class="fa fa-remove"></i>';
                li.appendChild(buttonRemove);

                let span = document.createElement('span');
                span.setAttribute('class', 'mailbox-attachment-icon');
                span.setAttribute('id', 'image_' + keyFile);

                var i = document.createElement('i')
                i.setAttribute('class', fileIcon);
                i.setAttribute('id', "icon_" + keyFile);
                span.appendChild(i);

                let divFileInfoElement = document.createElement('div');
                divFileInfoElement.setAttribute('class', 'mailbox-attachment-info');

                let linkFileElement = document.createElement('a');
                linkFileElement.setAttribute('class', 'mailbox-attachment-name');
                linkFileElement.setAttribute('id', 'link_' + keyFile);
                linkFileElement.setAttribute('href', '#');
                linkFileElement.innerHTML = '<i class="fa fa-paperclip"></i> ' + fileName;
                divFileInfoElement.appendChild(linkFileElement);

                let spanButtonFileElement = document.createElement('span');
                spanButtonFileElement.setAttribute('class', 'mailbox-attachment-size');
                spanButtonFileElement.innerText = fileSize;

                let buttonFileElement = document.createElement('a');
                buttonFileElement.setAttribute('id', 'button_' + keyFile);
                buttonFileElement.setAttribute('class', 'btn bg-olive btn-xs pull-right flat');
                buttonFileElement.innerHTML = '<i class="fa fa-remove"></i>';

                spanButtonFileElement.appendChild(buttonFileElement);
                divFileInfoElement.appendChild(spanButtonFileElement);
                li.appendChild(span);
                li.appendChild(divFileInfoElement);
                let divProcess = document.createElement('div');
                divProcess.setAttribute('class', 'progress progress-xs');
                divProcess.setAttribute('id', 'progress_' + keyFile);

                let divProcessBar = document.createElement('div');
                divProcessBar.setAttribute('class', 'progress-bar progress-bar-success progress-bar-striped');
                divProcessBar.setAttribute('role', 'progressbar');
                divProcessBar.setAttribute('aria-valuenow', '10');
                divProcessBar.setAttribute('aria-valuemin', '0');
                divProcessBar.setAttribute('aria-valuemax', '100');
                divProcessBar.setAttribute('style', 'width: 10%');
                divProcessBar.setAttribute('id', 'progressbar_' + keyFile);

                let spanStatus = document.createElement('span');
                spanStatus.setAttribute('class', 'sr-only');
                spanStatus.innerText = '10% đã tải';
                spanStatus.setAttribute('id', 'status_' + keyFile);

                divProcessBar.appendChild(spanStatus);
                divProcess.appendChild(divProcessBar);
                li.appendChild(divProcess);
                attachmentFilesElement.appendChild(li);

                uploadSingleFile(file, keyFile, files_hiden_id, fileIcon, reference_type, reference_id, name_array);
            }
        }
    }
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
};

function uploadSingleFile(file, i, files_hiden_id, fileIcon, reference_type, reference_id, name_array) {
    var fileId = i;
    var ajax = new XMLHttpRequest();

    ajax.upload.addEventListener("progress", function (e) {
        var percent = (e.loaded / e.total) * 100;
        $("#status_" + fileId).text(Math.round(percent) + "% đã tải, vui lòng đợi...");
        $('#progressbar_' + fileId).css("width", percent + "%");
    }, false);

    ajax.addEventListener("load", function (e) {
        $("#status_" + fileId).text(event.target.responseText);
        $('#progressbar_' + fileId).css("width", "100%")

        var _buttonFileRight = $('#button_' + fileId);
        _buttonFileRight.html('<i class="fa fa-cloud-download"></i>');

        $("#progressbar_" + fileId).remove();

        if (e.target.response) {
            let response = JSON.parse(e.target.response);
            if (response.data && response.data.url) {
                if (response.data.type == 'png' || response.data.type == 'jpg') {
                    var imageElement = document.getElementById('image_' + i);
                    var iconElement = document.getElementById('icon_' + i);
                    let imgElement = document.createElement('img');
                    imgElement.style.width = "180px";
                    imgElement.style.height = "120px";

                    imgElement.setAttribute('src', response.data.url);
                    imageElement.appendChild(imgElement);
                    imageElement.removeChild(iconElement);
                }
                $("#link_" + fileId).attr('href', '/show/file/' + response.data.file_id);
                $("#link_" + fileId).attr('target', 'blank');
                $('#button_' + fileId).attr('href', '/download/file/' + response.data.file_id);
                $("#button_" + fileId).attr('download', '');
                
                let inputElement = document.createElement('input');
                inputElement.setAttribute('type', 'hidden');
                inputElement.setAttribute('id', 'addInput_' + i);
                inputElement.setAttribute('value', response.data.file_id);
                var index = 0;

                $("#" + files_hiden_id).append(inputElement);
                if (name_array) {
                    let inputFileElements = document.getElementById(files_hiden_id).querySelectorAll("input");

                    for (inputIndex = 0; inputIndex < inputFileElements.length; inputIndex++) {
                        inputFileElements[inputIndex].setAttribute('name', name_array + '[' + inputIndex + ']');
                    }

                    index++;
                }

                var url_file = JSON.stringify(response.data.url);
                let button = document.getElementById('button_remove_' + i);
                button.removeAttribute('disabled');
                button.setAttribute('onclick', 'remove(' + i + ',' + response.data.file_id + ')');
            }
        }
    }, false);

    ajax.addEventListener("error", function (e) {
        $("#status_" + fileId).text("Tải tệp bị lỗi");
        $("#progressbar_" + fileId).remove();
        $("#file_" + fileId).remove();
    }, false);

    ajax.addEventListener("abort", function (e) {
        $("#status_" + fileId).text("Ngừng tải file");
        $("#progressbar_" + fileId).remove();
        $("#file_" + fileId).remove();
    }, false);

    ajax.open("POST", "/upload/file");
    ajax.setRequestHeader('Accept', 'application/json');
    ajax.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr("content"));
    var uploaderForm = new FormData();
    uploaderForm.append("file", file);
    uploaderForm.append("file_icon", fileIcon);

    if (reference_type != undefined) {
        uploaderForm.append("reference_type", reference_type);
    }
    if (reference_id != undefined) {
        uploaderForm.append("reference_id", reference_id);
    }
    ajax.send(uploaderForm);

    var _buttonFileRight = $('#button_' + fileId);

    _buttonFileRight.on('click', function () {
        ajax.abort();
    })
}

function remove(keyFile, file_id,boolen) {
    if(boolen!=undefined){
        var li = document.getElementById('file_' + keyFile);
        var inputHidden=document.getElementById('inputhidden_' + keyFile);
        if(inputHidden){
            inputHidden.remove();
        }
        li.remove();
    }
    else{
        var ajax = new XMLHttpRequest();

        ajax.addEventListener("load", function (e) {
            if (e.target.status == 200) {
                var li = document.getElementById('file_' + keyFile);
                var input = document.getElementById('addInput_' + keyFile);
                li.remove();
                if (input != null) {
                    input.remove();
                }
            }
            else {
                var alert = document.getElementById('alert_' + keyFile);
                alert.innerHTML = 'Lỗi xóa file'
            }
        }, false);
    
        ajax.addEventListener("error", function (e) {
        }, false);
        ajax.open("post", "/remove/file");
        ajax.setRequestHeader('Accept', 'application/json');
        ajax.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr("content"));
        var uploaderForm = new FormData();
        uploaderForm.append("file_id", file_id);
        ajax.send(uploaderForm);
    }
    
}

function downloadFile(file_id) {
    var ajax = new XMLHttpRequest();
    ajax.open("get", "/download/file/" + file_id + "");
    ajax.setRequestHeader('Accept', 'application/json');
    ajax.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr("content"));
    var uploaderForm = new FormData();
    ajax.send(uploaderForm);
}
