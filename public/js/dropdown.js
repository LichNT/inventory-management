$(document).ready(function () {
    $('.button-search').click(function(e) {
        if($('#dropdown').hasClass('open')){
            $('#dropdown').removeClass('open');
        }
        else
            $('#dropdown').addClass('open');
    }); 
});