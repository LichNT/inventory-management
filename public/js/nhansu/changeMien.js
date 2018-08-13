
window.onload=function(){
    var chi_nhanh_moi =JSON.parse($('#chi_nhanh_moi').attr('data'));
    var cua_hang_moi =JSON.parse($('#cua_hang_moi').attr('data'));
  $('#mien_moi').change(function () {
        $('#chi_nhanh_moi option').each(function() {
          if ( $(this).val() != '' ) {
            $(this).remove();
          }
        });
        $.each(chi_nhanh_moi, function( key, value ) {
          if(value['parent_id'] == $('#mien_moi').val()){
            $("#chi_nhanh_moi").append('<option value="'+value.id+'" >'+value.ten+'</option>');
          }
        });
      });
  var tinh_moi =JSON.parse($('#tinh_moi').attr('data'));
  $('#chi_nhanh_moi').change(function () {
    $('#tinh_moi option').each(function() {
      if ( $(this).val() != '' ) {
        $(this).remove();
      }
    });
    $.each(tinh_moi, function( key, value ) {
      if(value['parent_id'] == $('#chi_nhanh_moi').val()){
        $("#tinh_moi").append('<option value="'+value.id+'" >'+value.ten+'</option>');
      }
    });
    if($('#tinh_moi').val() ==''){
      $('#cua_hang_moi option').each(function() {
        if ( $(this).val() != '' ) {
          $(this).remove();
        }
      });
      $.each( cua_hang_moi, function( key, value ) {
        if(value['id_chi_nhanh'] == $('#chi_nhanh_moi').val()){
          $("#cua_hang_moi").append('<option value="'+value.id+'" >'+value.ten+'</option>');
        }
      });
    }
  });

  $('#tinh_moi').change(function () {
      $('#cua_hang_moi option').each(function() {
        if ( $(this).val() != '' ) {
          $(this).remove();
        }
      });
      $.each( cua_hang_moi, function( key, value ) {
        if(value['id_tinh'] == $('#tinh_moi').val()){
          $("#cua_hang_moi").append('<option value="'+value.id+'" >'+value.ten+'</option>');
        }
      });
    
    });
  }




  