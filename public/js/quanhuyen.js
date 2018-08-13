var quan_hien_tai =JSON.parse($('#quan_cho_o_hien_tai').attr('data'));

$('#tinh_cho_o_hien_tai').change(function () {
  $('#quan_cho_o_hien_tai option').each(function() {
    if ( $(this).val() != '' ) {
      $(this).remove();
    }
  });
  $.each( quan_hien_tai, function( key, value ) {
    if(value['tinh_thanh_id'] == $('#tinh_cho_o_hien_tai').val()){
      $("#quan_cho_o_hien_tai").append('<option value="'+value.id+'" >'+value.ten+'</option>');
    }
  });
})

var quan_thuong_tru =JSON.parse($('#quan_ho_khau_thuong_tru').attr('data'));

$('#tinh_ho_khau_thuong_tru').change(function () {
  $('#quan_ho_khau_thuong_tru option').each(function() {
    if ( $(this).val() != '' ) {
      $(this).remove();
    }
  });
  $.each( quan_thuong_tru, function( key, value ) {
    if(value['tinh_thanh_id'] == $('#tinh_ho_khau_thuong_tru').val()){
      $("#quan_ho_khau_thuong_tru").append('<option value="'+value.id+'" >'+value.ten+'</option>');
    }
  });
})

