var tinhs =JSON.parse($('#search_tinh').attr('data'));

$('#search_chi_nhanh').change(function () {
  $('#search_tinh option').each(function() {
    if ( $(this).val() != '' ) {
      $(this).remove();
    }
  });
  $.each( tinhs, function( key, value ) {
    if(value['parent_id'] == $('#search_chi_nhanh').val()){
      $("#search_tinh").append('<option value="'+value.id+'" >'+value.ten+'</option>');
    }
  });
  if($('#search_chi_nhanh').val() == ''){
    $.each( tinhs, function( key, value ) {
        $("#search_tinh").append('<option value="'+value.id+'" >'+value.ten+'</option>');
    });
  }
});

