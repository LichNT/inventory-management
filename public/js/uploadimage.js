$(document).ready(function () {
    $('input.file-upload-input').change(function(e){ 
        $files = e.target.files;       
        if ($files && $files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.image-upload-wrap').hide();
                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();
                $('.image-title').html($files.name);
            };
            reader.readAsDataURL($files[0]);
        } else {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
    });        
    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
});
