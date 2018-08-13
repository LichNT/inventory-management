
function getChild(name,event,chil_id,chil) {
  var parent = $(event.target).val();
  var children = JSON.parse($(`#${chil}_hidden`).attr('data'));
    $(`#${chil_id} option`).each(function () {
      if ($(this).val() != '') {
        $(this).remove();
      }
    });
    $.each(children, function (key, value) {
      if (value[name] == parent) {
        $(`#${chil_id}`).append('<option value="' + value.id + '" >' + value.ten + '</option>');
      }
    });
}


window.onload=function() {

  var bac = JSON.parse($('#bac_id').attr('data'));

  $('#ngach_id').change(function () {
    $('#bac_id option').each(function () {
      if ($(this).val() != '') {
        $(this).remove();
      }
    });
    $.each(bac, function (key, value) {
      if (value['ngach_id'] == $('#ngach_id').val()) {
        $("#bac_id").append('<option value="' + value.id + '" >' + value.ten + '</option>');
      }
    });
  })

}