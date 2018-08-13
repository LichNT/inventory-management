function addChungChi() {
    var tbody = document.getElementById("chung_chi");

    if (typeof tbody != 'undefined') {
        // input
        var selectedLoaiChungChi = document.getElementById("loai_chung_chi");
        var tenChungChi = document.getElementById("ten_chung_chi");
        var hangChungChi = document.getElementById("hang_chung_chi");
        var soChungChi = document.getElementById("so_chung_chi");
        var ngayCap = document.getElementById("ngay_cap_cc");
        var thoiHan = document.getElementById("thoi_han_cc");
        // validator
        var errors="";
        if(selectedLoaiChungChi.value == 'undefined' || selectedLoaiChungChi.value == ''){
            errors="Chưa chọn loại chứng chỉ"
        }
        else if(tenChungChi.value == 'undefined' || tenChungChi.value == ''){
            errors="Chưa nhập tên chứng chỉ"
        }
        else if (hangChungChi.value == 'undefined' || hangChungChi.value == ''){
            errors="Chưa nhập hạng chứng chỉ"
        }
        else if(soChungChi.value == 'undefined' || soChungChi.value == ''){
            errors="Chưa nhập số chứng chỉ"
        }
        else if(ngayCap.value == 'undefined' || ngayCap.value == ''){
            errors="Chưa nhập ngày cấp chứng chỉ"
        }
        else if(thoiHan.value == 'undefined' || thoiHan.value == ''){
            errors="Chưa nhập ngày hết hạn chứng chỉ"
        }
        //
        if (errors!="") {
            var alert = document.getElementById("alert_chung_chi");
            alert.innerHTML =
                '<div class="col col-md-12">'
                +'<div class="alert alert-info alert-dismissible">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                + '<h4><i class="icon fa fa-info"></i>'+ errors +'</h4>'
                + '</div>'
                + '</div>';
            return;
        }       
        
        var chungChiDataElement = document.getElementById("hiddenChungChi");
        var id=new Date().getTime();
        
        if (chungChiDataElement) {
            var check=0;
            var chungChi = JSON.parse(chungChiDataElement.value);
            chungChi.forEach(element => {
                if (element.loai_chung_chi == selectedLoaiChungChi.value &&
                    element.ten_chung_chi == tenChungChi.value &&
                    element.hang_chung_chi == hangChungChi.value &&
                    element.so_chung_chi == soChungChi.value &&
                    element.ngay_cap == ngayCap.value&&
                    element.thoi_han == thoiHan.value

                ) {
                    var alert = document.getElementById("alert_chung_chi");
                    alert.innerHTML =
                        '<div class="alert alert-info alert-dismissible">'
                        + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                        + '<h4><i class="icon fa fa-info"></i>Trùng dữ liệu</h4>'
                        + '</div>';
                    check=1;
                    return;
                }               
            });
                if(check==1){
                    return
                }
                chungChi.push({
                'id':id,
                'loai_chung_chi': selectedLoaiChungChi.value,
                'ten_chung_chi' : tenChungChi.value,
                'hang_chung_chi' : hangChungChi.value,
                'so_chung_chi' : soChungChi.value,
                'ngay_cap' : ngayCap.value,
                'thoi_han':thoiHan.value,
            });

            chungChiDataElement.value = JSON.stringify(chungChi);
           
        }

        // add to table
        var countRow = tbody.getElementsByTagName("tr").length;
        var row = tbody.insertRow(0);
        row.setAttribute('name', 'chung_chi[]');

        var i = 0;
        var cellLoaiChungChi = row.insertCell(i);
        cellLoaiChungChi.innerHTML = selectedLoaiChungChi.options[selectedLoaiChungChi.selectedIndex].text
        + '<input type="hidden" name="chung_chi[' + countRow + '][loai_chung_chi]" value="'
        + selectedLoaiChungChi.value + '" />';

        i++;
        var cellTenChungChi = row.insertCell(i);
        cellTenChungChi.innerHTML = tenChungChi.value
            + '<input type="hidden" name="chung_chi[' + countRow + '][ten_chung_chi]" value="'
            + tenChungChi.value + '" />';

        i++;
        var cellHangChungChi = row.insertCell(i);
        cellHangChungChi.innerHTML = hangChungChi.value
            + '<input type="hidden" name="chung_chi[' + countRow + '][hang_chung_chi]" value="'
            + hangChungChi.value + '" />';

        i++;
        var cellSoChungChi = row.insertCell(i);
        cellSoChungChi.innerHTML = soChungChi.value
            + '<input type="hidden" name="chung_chi[' + countRow + '][so_chung_chi]" value="'
            + soChungChi.value + '" />';

        i++;
        var cellNgayCap = row.insertCell(i);
        cellNgayCap.innerHTML = ngayCap.value
            + '<input type="hidden" name="chung_chi[' + countRow + '][ngay_cap]" value="'
            + ngayCap.value + '" />';

        i++;
        var cellThoiHan = row.insertCell(i);
        cellThoiHan.innerHTML = thoiHan.value
        + '<input type="hidden" name="chung_chi[' + countRow + '][thoi_han]" value="'
        + thoiHan.value + '" />';

        i++;
        var cellAttactment = row.insertCell(i);
        let inputFileElements = document.getElementById("chung_chi_files").querySelectorAll("input");              
        let spanTextAttactment = document.createElement('span');        

        for (inputIndex = 0; inputIndex < inputFileElements.length; inputIndex++) {            
            let inputElement = document.createElement('input');         
            inputElement.setAttribute('type', 'hidden');
            inputElement.setAttribute('name', 'chung_chi[' + countRow + '][attachment][' + inputIndex + ']');
            inputElement.setAttribute('value', inputFileElements[inputIndex].value);
            cellAttactment.appendChild(inputElement);
        }
        
        if(inputFileElements.length > 0) {
            spanTextAttactment.setAttribute('class', 'label label-success');
            spanTextAttactment.innerText = 'Đính kèm ' + inputFileElements.length + ' tài liệu';
        }
        else{
            spanTextAttactment.setAttribute('class', 'label label-danger');
            spanTextAttactment.innerText = 'Không có tài liệu đính kèm';
        }
        cellAttactment.appendChild(spanTextAttactment);  

        i++;
        var cellEdit = row.insertCell(i);
        cellEdit.innerHTML = '<span onclick="deleteRowCC(this, ' +id +');"><i class="fa fa-trash"></i></span>';
        cellEdit.setAttribute('align', 'center');
    }
}
function deleteRowCC(row,id)
{
    var i = row.parentNode.parentNode.rowIndex;
    document.getElementById("chung_chi").deleteRow(i-1);   
    var quaTrinhCongTacDataElement = document.getElementById("hiddenChungChi");    
    if(quaTrinhCongTacDataElement && quaTrinhCongTacDataElement.value) {
        let valueDetail = JSON.parse(quaTrinhCongTacDataElement.value);
        for (let index = 0; index < valueDetail.length; index++) {
            const element = valueDetail[index];
            if(element.id == id) {
                valueDetail.splice(index, 1);
                break;                
            }
        }        
        quaTrinhCongTacDataElement.value = JSON.stringify(valueDetail);
    }   
}

window.onload = function() {
    
    $('#loai_chung_chi').change(function(){
        var id_LoaiChungChi=$('#loai_chung_chi').val();
        var loaichungchiInputElement = document.getElementById("danhmucchungchi");
        if(id_LoaiChungChi){
            if (loaichungchiInputElement && id_LoaiChungChi) {
                if(id_LoaiChungChi!=8){
                var loaichungchis = JSON.parse(loaichungchiInputElement.value);
                var selectedLoaiChungChi=new Array();       
                loaichungchis.forEach(loaichungchi => {
                    if (loaichungchi.loai_chung_chi == id_LoaiChungChi) {
                        selectedLoaiChungChi.push(loaichungchi) ;
                    }
                });
                    var tenchungchiElement=document.getElementById('ten_chung_chi');
                    var chungchikhac=document.getElementById("chung_chi_khac");
                    if(tenchungchiElement){
                        tenchungchiElement.style.display = "block";
                        tenchungchiElement.removeAttribute('disabled');
                    tenchungchiElement.innerHTML='<option> Chọn</option>';
                    for (let i = 0; i < selectedLoaiChungChi.length; i++) { 
                        tenchungchiElement.innerHTML+='<option value="'+selectedLoaiChungChi[i].ma_chung_chi +'">'+ selectedLoaiChungChi[i].ten_chung_chi+'</option>'
                        }
                    
                    }
                    if(chungchikhac){
                        chungchikhac.setAttribute('disabled', 'disabled');
                        chungchikhac.style.display = "none";
                    }
                }
                else{
                    var chungchikhac=document.getElementById("chung_chi_khac");
                    var tenchungchiElement=document.getElementById('ten_chung_chi');
                    if(tenchungchiElement){
                        tenchungchiElement.style.display = "none";
                        tenchungchiElement.setAttribute('disabled', 'disabled');
                    }
                    if(chungchikhac){
                        chungchikhac.removeAttribute('disabled');
                        chungchikhac.style.display = "block";
                    }
                   

                }
                
                
            }
        }
    });

    $('#ten_chung_chi').change(function(){
        var ma_chung_chi=$('#ten_chung_chi').val();
        var danhmucchungchiInputElement = document.getElementById("danhmucchungchi");
        if(ma_chung_chi){
        
            if (danhmucchungchiInputElement && ma_chung_chi) {
                var chungchis = JSON.parse(danhmucchungchiInputElement.value);
                var selectedChungChi;       
                chungchis.forEach(chungchi => {
                    if (chungchi.ma_chung_chi == ma_chung_chi) {
                        selectedChungChi=chungchi ;
                        return false;
                    }
                });
                if(selectedChungChi){
                    $('#thoihanchungchi').val(selectedChungChi.thoi_han);
                }
            }
        }
    });
    $('#ngay_cap_cc').blur(function(){
       
        var thoihan=$('#thoihanchungchi').val();
       
      if(thoihan){
        thoihan= parseInt(thoihan) ;
          var ngaycap=$('#ngay_cap_cc').val();
          if(ngaycap){
            var res = ngaycap.split("/");
              var ngayhethan=new Date(res[2]+'/'+res[1]+'/'+res[0]);
              ngayhethan.setMonth(ngayhethan.getMonth() +thoihan);
            
              $('#thoi_han_cc').val(ngayhethan.toLocaleDateString());
          }
          else{
            $('#thoi_han_cc').val('');
          }
         
      }
    });
}
