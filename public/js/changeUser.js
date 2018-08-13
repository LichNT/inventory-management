window.onload=function(){

  var chinhanhs = JSON.parse($('#chi_nhanh').attr('data'));

  $('#mien').change(function () {
    $('#chi_nhanh option').each(function () {
      if ($(this).val() != '') {
        $(this).remove();
      }
    });
    $.each(chinhanhs, function (key, value) {
      if (value['parent_id'] == $('#mien').val()) {
        $("#chi_nhanh").append('<option value="' + value.id + '" >' + value.ten + '</option>');
      }
    });
  });
};
function getChild(name,event,chil_id,chil) {


  var parent = $(event.target).val();
  var children = JSON.parse($(`#${chil}_hidden`).attr('data'));
  $(`#${chil_id} option`).each(function () {
    if ($(this).val() != '') {
      $(this).remove();
    }
  });
  $.each(children, function (key, value) {
    if (value['parent_id'] == parent) {

      $(`#${chil_id}`).append('<option value="' + value.id + '" >' + value.ten + '</option>');
    }
  });
}

