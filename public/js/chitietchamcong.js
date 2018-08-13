function chitiet(code_company){
    tenbang = 'cham_cong_nhan_su_'+code_company+'_'+$('#thang').val()+'_'+$('#nam').val();
  window.location='/chamcong/chitiet/'+tenbang+'?nam='+$('#nam').val()+'&thang='+$('#thang').val()
}

function chamCong(ten_bang,id_nhan_su,ngay_so) {
  var ajax = new XMLHttpRequest();
  var uploaderForm = new FormData();
  $( "#div-wrap" ).addClass("box box-danger");
  $("#spin").show();
  uploaderForm.append("id_nhan_su", id_nhan_su); 
  uploaderForm.append("ngay_so", ngay_so); 
  uploaderForm.append("value", $('#'+ngay_so).val());

  ajax.addEventListener("load", function (e) {   
    
    $( "#div-wrap" ).removeClass("box box-danger");
    $("#spin").hide();  
    let response = JSON.parse(e.target.response);
    $('#tong_cong_huong_luong').val(response.result.tong_cong_huong_luong);
   })

  ajax.open("POST", "/chamcong/ngaycong/"+ten_bang);
 
  ajax.setRequestHeader('Accept', 'application/json');
  ajax.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr("content"));
  ajax.send(uploaderForm);

}

function chamGio(ten_bang,id_nhan_su,ngay_so,event) {

  var ajax = new XMLHttpRequest();
  var uploaderForm = new FormData();
  if($(event.target).val()>=24){
    $(event.target).val(24)
  }else if($(event.target).val()<=0){
    $(event.target).val(0)
  }

  $( "#div-wrap-tangca" ).addClass("box box-danger");
  $("#spin-tangca").show();
    uploaderForm.append("id_nhan_su", id_nhan_su);
    uploaderForm.append("ngay_so", ngay_so);
    uploaderForm.append("value", $(event.target).val());
    ajax.addEventListener("load", function (e) {
      let response = JSON.parse(e.target.response);
      $( "#div-wrap-tangca" ).removeClass("box box-danger");
      $("#spin-tangca").hide();
      $('#tong_lam_them_gio').val(response.result.tong_lam_them_gio);
    });
    ajax.addEventListener("error", function (e) {
      $( "#div-wrap-tangca" ).removeClass("box box-danger");
      $("#spin-tangca").hide();
      
  }, false);

    ajax.open("POST", "/chamcong/tangca/" + ten_bang);

    ajax.setRequestHeader('Accept', 'application/json');
    ajax.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr("content"));
    ajax.send(uploaderForm);

}