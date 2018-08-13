
function deleteNhanSu(id){
  $(".info-box-nhansu").empty();
  $(".title_chitiet").empty();
  $(".list_relationship_nhan_su").empty();
  $(".overlay").show();
  $(".info-box-nhansu").hide();
  if(id){
    $.ajax({
      type:"GET",
      url:"/nhansu/delete/"+id+"",
      success:function(res){
        if(res){
          if(res.length >0){
            $(".overlay").hide();
            $(".info-box-nhansu").show();
            $(".info-box-nhansu").append(
              '<span class="info-box-icon bg-red" style="width:30px;height: 50px;">' +
              '<i class="fa fa-exclamation-triangle" style="font-size:22px;position: absolute ;top:30px;left:15px"></i>'+
              '</span><div class="info-box-content" style="margin-left:10px;height: 50px;"> ' +
              '<span style="text-align: center;margin: 1px auto;display: inherit;">' +
              'Bạn không thể xoá nhân sự này, vì có dữ liệu liên quan đến nhân sự này</span>')

            $(".title_chitiet").append(' <br/> <span style="margin-left: 10px; font-weight: bold">Chi tiết:</span>');
            $.each(res,function(key,value){
              $(".list_relationship_nhan_su").append('<li><a style="margin-right:4px" href="'+value.link+'">'+value.ten+'</a></li>');
            });
            $(".delete").attr('disabled','disabled')
          }else {
            $(".overlay").hide();
            $(".info-box-nhansu").show();
            $(".delete").prop('disabled', false);
            $(".info-box-nhansu").append(
                '<span class="info-box-icon bg-yellow" style="width:30px;height: 50px;">' +
                '<i class="fa fa-question-circle" style="font-size:20px;position: absolute ;top:30px;left:15px"></i></span> ' +
                '<div class="info-box-content" style="margin-left:10px;height: 50px;"> ' +
                '<span style="text-align: center;margin: 7px auto;display: inherit;">' +
                'Bạn có chắn chắn muốn xoá nhân sự?</span>  ')
          }

        }else{
            $(".overlay").hide();
            $(".info-box-nhansu").show();
        $("#list_relationship_nhan_su").empty();
  }
      }
    });
  }else{
    $("#list_relationship_nhan_su").empty();
  }
}