$(document).ready(function () {
  $('#he_so').hide();
  $('#label_he_so').hide();

  $('#check_he_so').on('ifChanged', function(event){
    $('#so_tien').val('');
    $('#he_so').val('');
   $('#so_tien').hide();
   $('#label_so_tien').hide();
    $('#he_so').show();
    $('#label_he_so').show();
  });

  $('#check_so_tien').on("ifChanged",function(event){
    $('#so_tien').val('');
    $('#he_so').val('');
    $('#he_so').hide();
    $('#so_tien').show();
    $('#label_so_tien').show();
    $('#label_he_so').hide();


  });
})
