$(document).ready(function () {
    $(document).keydown(function(e) {
        var keycode = (event.keyCode ? event.keyCode : event.which);        
        if (keycode === 27) $('.close').click();   // esc  
    });    
});