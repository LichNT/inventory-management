
function confirmDangKyChamCong(id){

  var ajax = new XMLHttpRequest();
    $(".overlay").show();
    $(".ket_qua_tim_kiem").hide();
    $(".khong_tim_thay").empty();
    $(".khong_tim_thay").hide();
    $('#searchnhansu').attr('disabled',true);
    $('#submit_'+id).attr('disabled',true);
    if(id){
      $.ajax({
        type:"GET",
        url:"/dangkyungdungchamcong/search/"+id+"",
        success:function(res){
          $('#searchnhansu').attr('disabled',false);
          $('#submit_'+id).attr('disabled',false);
          if(res.length>0){                   
              $(".overlay").hide();             
              $('#ho_ten_'+id).val(res[0].ho_ten);
              $('#ngay_sinh_'+id).val(res[0].ngay_sinh);
              $('#cmnd_'+id).val(res[0].cmnd);
              $('#ma_'+id).val(res[0].ma);
              $('#so_dien_thoai_'+id).val(res[0].so_dien_thoai);
              $('#email_'+id).val(res[0].email);
            
              $(".ket_qua_tim_kiem").show();
            }
          else {
              $(".overlay").hide();
             
              $(".khong_tim_thay").show();
              $(".khong_tim_thay").append(
                '<span style="text-align: center;padding-top: 15px;display: inherit;">' +
                'Không tìm thấy thông tin nhân sự</span></div>')
            } 
        } ,
        error:function(){
          $('#searchnhansu').attr('disabled',false);
          $('#submit_'+id).attr('disabled',false);
        }      
      });
    }  
  }
  function showForm($id){
    $(".ket_qua_tim_kiem").hide();
    $(".khong_tim_thay").hide();
  }