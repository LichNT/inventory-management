
function getFileSizeandName(input) {
    var select = $('#uploadTable');
    for (var i = 0; i < input.files.length; i++) {
        var filesizeInBytes = input.files[i].size;
        var filesizeInMB = (filesizeInBytes / (1024 * 1024)).toFixed(2);
        var filename = input.files[i].name;

        select.append($('<tr id=tr' + i + '><td id=filetd' + i + '>' + filename + '</td><td id=filesizetd' + i + '>' + filesizeInMB + ' MB</td><td align="center" id=deletetd' + i + '><span onclick="deleteFile(this)"><i class="fa fa-trash"></i></span></tr>'));
    }
}

function deleteFile(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}