
function deleteToChuc(id){
    $(".info-box-tochuc").empty();
    $(".title_chitiet").empty();
    $(".list_child_to_chuc").empty();
    $(".overlay").show();
    $(".info-box-tochuc").hide();
    if(id){
      $.ajax({
        type:"GET",
        url:"/tochuc/showdelete/"+id+"",
        success:function(res){
          if(res){
            if(res.length >0){
              $(".overlay").hide();
              $(".info-box-tochuc").show();
              $(".info-box-tochuc").append(
                '<span class="info-box-icon bg-red" style="width:30px;height: 50px;">' +
                '<i class="fa fa-exclamation-triangle" style="font-size:22px;position: absolute ;top:30px;left:15px"></i>'+
                '</span><div class="info-box-content" style="margin-left:10px;height: 50px;"> ' +
                '<p style="margin-left: 25px ;">' +
                'Bạn không thể xoá tổ chức này, vì có những dữ liệu liên quan đến tổ chức này</span>')
  
              $(".title_chitiet").append(' <br/> <span style="margin-left: 10px; font-weight: bold">Chi tiết:</span>');
              $.each(res,function(key,value){
                $(".list_child_to_chuc").append('<li>'+value.ten+'</li>');
              });
              $(".delete").attr('disabled','disabled')
            }else {
              $(".overlay").hide();
              $(".info-box-tochuc").show();
              $(".delete").prop('disabled', false);
              $(".info-box-tochuc").append(
                  '<span class="info-box-icon bg-yellow" style="width:30px;height: 50px;">' +
                  '<i class="fa fa-question-circle" style="font-size:20px;position: absolute ;top:30px;left:15px"></i></span> ' +
                  '<div class="info-box-content" style="margin-left:10px;height: 50px;"> ' +
                  '<span style="text-align: center;margin: 7px auto;display: inherit;">' +
                  'Bạn có chắn chắn muốn xoá tổ chức ?</span>  ')
            }
  
          }else{
              $(".overlay").hide();
              $(".info-box-tochuc").show();
          $("#list_child_to_chuc").empty();
    }
        }
      });
    }else{
      $("#list_child_to_chuc").empty();
    }
  }