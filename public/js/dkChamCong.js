

  var mien_moi =JSON.parse($('#chi_nhanh_hidden').attr('data'));
  var tinh_moi =JSON.parse($('#tinh_hidden').attr('data'));
  var cua_hang_moi =JSON.parse($('#cua_hang_hidden').attr('data'));
  var nhan_su_data =JSON.parse($('#nhan_su').attr('data'));
 
  function getChild(name,event,chil_id,chil,parent_id,id_current) {

    var parent = $(event.target).val();
    var children = JSON.parse($(`#${chil}_hidden`).attr('data'));
    $(`#${chil_id} option`).each(function () {
      if ($(this).val() != '') {
        $(this).remove();
      }
    });
    $.each(children, function (key, value) {
      if (value[parent_id] == parent) {
        $(`#${chil_id}`).append('<option value="' + value.id + '" >' + value.ten + '</option>');
      }
    });
    if(name =='id_tinh'){
      $(`#cua_hang${id_current} option`).each(function () {
        if ($(this).val() != '') {
          $(this).remove();
        }
      });
      $.each(cua_hang_moi, function (key, value) {
        if (value['id_tinh'] === parent) {
          $(`#cua_hang${id_current}`).append('<option value="' + value.id + '" >' + value.ten + '</option>');
        }
      })

      if(parent==''){

        $(`#cua_hang${id_current} option`).each(function () {
          if ($(this).val() != '') {
            $(this).remove();
          }
        });
        $.each(cua_hang_moi, function (key, value) {
          if (value['id_chi_nhanh'] == $(`#chi_nhanh${id_current}`).val()) {
            $(`#cua_hang${id_current}`).append('<option value="' + value.id + '" >' + value.ten + '</option>');
          }
        })
      }
    }else if(name =='id_chi_nhanh'){
      $(`#cua_hang${id_current} option`).each(function () {
        if ($(this).val() != '') {
          $(this).remove();
        }
      });
      $.each(cua_hang_moi, function (key, value) {
        if (value['id_chi_nhanh'] == parent) {
          $(`#cua_hang${id_current}`).append('<option value="' + value.id + '" >' + value.ten + '</option>');
        }
      })
      if(parent==''){
        $(`#cua_hang${id_current} option`).each(function () {
          if ($(this).val() != '') {
            $(this).remove();
          }
        });
        $.each(cua_hang_moi, function (key, value) {
          if (value['id_mien'] == $(`#mien${id_current}`).val()) {
            $(`#cua_hang${id_current}`).append('<option value="' + value.id + '" >' + value.ten + '</option>');
          }
        })
      }
    } else if(name =='id_mien'){
      $(`#cua_hang${id_current} option`).each(function () {
        if ($(this).val() != '') {
          $(this).remove();
        }
      });
      $.each(cua_hang_moi, function (key, value) {
        if (value['id_mien'] == parent) {
          $(`#cua_hang${id_current}`).append('<option value="' + value.id + '" >' + value.ten + '</option>');
        }
    })
    }
  }

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
    $('#nhan_su option').each(function() {
      if ( $(this).val() != '' ) {
        $(this).remove();
      }
    });

  $.each(nhan_su_data, function( key, value ) {
      if(value['id_mien'] == $('#mien_moi').val()){
        $("#nhan_su").append('<option value="'+value.id+'" >'+value.ho_ten+'</option>');
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

    $('#nhan_su option').each(function() {
      if ( $(this).val() != '' ) {
        $(this).remove();
      }
    });

  $.each(nhan_su_data, function( key, value ) {
      if(value['id_chi_nhanh'] == $('#chi_nhanh_moi').val()){
        $("#nhan_su").append('<option value="'+value.id+'" >'+value.ho_ten+'</option>');
      }
    });

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

    $('#nhan_su option').each(function() {
      if ( $(this).val() != '' ) {
        $(this).remove();
      }
    });

  $.each(nhan_su_data, function( key, value ) {
      if(value['id_tinh'] == $('#tinh_moi').val()){
        $("#nhan_su").append('<option value="'+value.id+'" >'+value.ho_ten+'</option>');
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

      $.each(nhan_su_data, function( key, value ) {
        if(value['id_chi_nhanh'] == $('#chi_nhanh_moi').val()){
          $("#nhan_su").append('<option value="'+value.id+'" >'+value.ho_ten+'</option>');
        }
      });
    }

    
  });

  $('#cua_hang_moi').change(function () {

    $('#nhan_su option').each(function() {
      if ( $(this).val() != '' ) {
        $(this).remove();
      }
    });

  $.each(nhan_su_data, function( key, value ) {
      if(value['id_cua_hang'] == $('#cua_hang_moi').val()){
        $("#nhan_su").append('<option value="'+value.id+'" >'+value.ho_ten+'</option>');
      }
    });

    if($('#cua_hang_moi').val() ==''){
      $.each(nhan_su_data, function( key, value ) {
        if(value['id_tinh'] == $('#tinh_moi').val()){
          $("#nhan_su").append('<option value="'+value.id+'" >'+value.ho_ten+'</option>');
        }
      });
    }
    
  });

  $('#search_mien').change(function () {
    $('#search_chi_nhanh option').each(function() {
      if ( $(this).val() != '' ) {
        $(this).remove();
      }
    });
    $.each( mien_moi, function( key, value ) {
      if(value['parent_id'] == $('#search_mien').val()){
        $("#search_chi_nhanh").append('<option value="'+value.id+'" >'+value.ten+'</option>');
      }
    });
   
  });

  $('#search_chi_nhanh').change(function () {
    $('#search_tinh option').each(function() {
      if ( $(this).val() != '' ) {
        $(this).remove();
      }
    });
    $.each( tinh_moi, function( key, value ) {
      if(value['parent_id'] == $('#search_chi_nhanh').val()){
        $("#search_tinh").append('<option value="'+value.id+'" >'+value.ten+'</option>');
      }
    });

    if($('#search_tinh').val() ==''){
      $('#search_cua_hang option').each(function() {
        if ( $(this).val() != '' ) {
          $(this).remove();
        }
      });
      $.each( cua_hang_moi, function( key, value ) {
        if(value['id_chi_nhanh'] == $('#search_chi_nhanh').val()){
          $("#search_cua_hang").append('<option value="'+value.id+'" >'+value.ten+'</option>');
        }
      });
    }

  });

  $('#search_tinh').change(function () {
    $('#search_cua_hang option').each(function() {
      if ( $(this).val() != '' ) {
        $(this).remove();
      }
    });
    $.each( cua_hang_moi, function( key, value ) {
      if(value['id_tinh'] == $('#search_tinh').val()){
        $("#search_cua_hang").append('<option value="'+value.id+'" >'+value.ten+'</option>');
      }
    });

    if($('#search_tinh').val() ==''){
      $('#search_cua_hang option').each(function() {
        if ( $(this).val() != '' ) {
          $(this).remove();
        }
      });
      $.each( cua_hang_moi, function( key, value ) {
        if(value['id_chi_nhanh'] == $('#search_chi_nhanh').val()){
          $("#search_cua_hang").append('<option value="'+value.id+'" >'+value.ten+'</option>');
        }
      });
    }

    
  });



