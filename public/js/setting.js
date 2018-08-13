function changeLayout() {    
    var checkBox = document.getElementById("checkboxFixed");

    if (checkBox.checked == true) {
        $("body").removeClass('fixed');
    } else {              
        $('body').addClass('fixed');
    }
}

function changeMenuLeft() {    
    var checkBox = document.getElementById("checkboxChangeMenuLeft");
    
    if (checkBox.checked == true) {
        $("body").removeClass('sidebar-collapse');
    } else {              
        $('body').addClass('sidebar-collapse');
    }
}