$(document).ready(function () {
    $(".alert").slideDown("slow").delay(3000).fadeOut(2000, function(){
        $(this).remove();    
    });
});