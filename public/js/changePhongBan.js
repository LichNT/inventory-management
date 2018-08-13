
window.onload=function(){
    var mien_moi =JSON.parse($('#chi_nhanh_moi').attr('data'));
  var tinh_moi =JSON.parse($('#tinh_moi').attr('data'));
  var cua_hang_moi =JSON.parse($('#cua_hang_moi').attr('data'));
  $('#mien_moi').change(function () {
        $('#chi_nhanh_moi option').each(function() {
          if ( $(this).val() != '' ) {
            $(this).remove();
          }
        });
        $.each( mien_moi, function( key, value ) {
          if(value['parent_id'] == $('#mien_moi').val()){
            $("#chi_nhanh_moi").append('<option value="'+value.id+'" >'+value.ten+'</option>');
          }
        });
      });

        $('#chi_nhanh_moi').change(function () {
          $('#tinh_moi option').each(function() {
            if ( $(this).val() != '' ) {
              $(this).remove();
            }
          });
          $.each( tinh_moi, function( key, value ) {
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
          $.each(cua_hang_moi, function( key, value ) {
            if(value['id_tinh'] == $('#tinh_moi').val()){
              $("#cua_hang_moi").append('<option value="'+value.id+'" >'+value.ten+'</option>');
            }
          });

        if($('#tinh_moi').val() ==''){
          console.log('vao1');
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

          var bo_phan =JSON.parse($('#bo_phan_moi').attr('data'));
          $('#phong_ban_moi').change(function () {
              $('#bo_phan_moi option').each(function() {
                if ( $(this).val() != '' ) {
                  $(this).remove();
                }
              });
              $.each(bo_phan, function( key, value ) {              
                if(value['parent_id'] == $('#phong_ban_moi').val()){
                    
                  $("#bo_phan_moi").append('<option value="'+value.id+'" >'+value.ten+'</option>');
                }
              });
            });
}

  