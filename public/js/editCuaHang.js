
var quan_huyen =JSON.parse($('#quan_huyen_hidden').attr('data'));

$('#tinh_thanh').change(function () {
  $('#quan_huyen option').each(function() {
    if ( $(this).val() != '' ) {
      $(this).remove();
    }
  });
  $.each( quan_huyen, function( key, value ) {
    if(value['tinh_thanh_id'] == $('#tinh_thanh').val()){
      $("#quan_huyen").append('<option value="'+value.id+'" >'+value.ten+'</option>');
    }
  });
})


var chinhanhs =JSON.parse($('#chi_nhanh_hidden').attr('data'));

    $('#mien').change(function () {
        $('#chi_nhanh option').each(function() {
          if ( $(this).val() != '' ) {
            $(this).remove();
          }
        });
        $.each( chinhanhs, function( key, value ) {
          if(value['parent_id'] == $('#mien').val()){
            $("#chi_nhanh").append('<option value="'+value.id+'" >'+value.ten+'</option>');
          }
        });
      });

    var tinhs =JSON.parse($('#tinh_hidden').attr('data'));

    $('#chi_nhanh').change(function () {

        $('#tinh option').each(function() {
        if ( $(this).val() != '' ) {
            $(this).remove();
        }
        });
        $.each( tinhs, function( key, value ) {
        if(value['parent_id'] == $('#chi_nhanh').val()){
            $("#tinh").append('<option value="'+value.id+'" >'+value.ten+'</option>');
        }
        });
    });
