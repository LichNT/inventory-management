

    
    $('.list > li a').click(function() {
        $(this).parent().find('ul').toggle();
        $(this).parent().find('ul li ul').hide();
    });
   

