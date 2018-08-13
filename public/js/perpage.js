$(document).ready(function () {
    $('#select_perpage').change(function () {
        var inputPerPage = $('<input>').attr("type", "hidden").attr("name", "perpage").val($('#select_perpage').val());
        $('#search-form').append($(inputPerPage));
        $("#search-form").submit();
    });
});