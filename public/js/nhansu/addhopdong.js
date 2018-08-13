function themHopDong() {
    var tbody = document.getElementById("chitiethopdong");
    if (typeof tbody != 'undefined') {
        // input
        var selectedHopDong = document.getElementById("loai_hop_dong");
        var ngayHieuLuc = document.getElementById("ngay_hieu_luc_hop_dong");
        var ngayHetHieuLuc= document.getElementById("ngay_het_hieu_luc_hop_dong");
        var ngayKyHopDong = document.getElementById("ngay_ky_hop_dong");
        var soHopDong= document.getElementById("so_hop_dong");
        // validator
        var errors="";
        if(selectedHopDong.value == 'undefined' || selectedHopDong.value == ''){
            errors="Chưa chọn loại hợp đồng "
        }
        else if(soHopDong.value == 'undefined' || soHopDong.value == ''){
            errors="Chưa nhập số quyết định"
        }
        else if(ngayHieuLuc.value == 'undefined' || ngayHieuLuc.value == ''){
            errors="Chưa nhập ngày hiệu lực"
        }
        else{
            errors="";
        }
        //
        if (errors!="") {
            var alert = document.getElementById("alert_hop_dong");
            alert.innerHTML =
                '<div class="col col-md-12">'
                +'<div class="alert alert-info alert-dismissible">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                + '<h4><i class="icon fa fa-info"></i>'+ errors +'</h4>'
                + '</div>'
                + '</div>';
            return;
        }    

        var hopDongDataElement = document.getElementById("hiddenHopDong");
        var id=new Date().getTime();

        if (hopDongDataElement) {
            var check=0;
            var hopdong = JSON.parse(hopDongDataElement.value);
            hopdong.forEach(element => {
                if (element.loai_hop_dong == selectedHopDong.value &&
                    element.ngay_hieu_luc_hop_dong == ngayHieuLuc.value &&
                    element.ngay_het_hieu_luc_hop_dong == ngayHetHieuLuc.value &&
                    element.ngay_ky_hop_dong == ngayKyHopDong.value &&
                    element.so_hop_dong == soHopDong.value
                ) {
                    var alert = document.getElementById("alert_hop_dong");
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
            hopdong.push({
                'id':id,
                'loai_hop_dong': selectedHopDong.value,
                'ngay_hieu_luc_hop_dong' : ngayHieuLuc.value,
                'ngay_het_hieu_luc_hop_dong' : ngayHetHieuLuc.value,
                'ngay_ky_hop_dong' : ngayKyHopDong.value,
                'so_hop_dong':soHopDong.value,
            });

            hopDongDataElement.value = JSON.stringify(hopdong);
           
        }
        
        // add to table        
        var countRow = tbody.getElementsByTagName("tr").length;
        var row = tbody.insertRow(0);
        row.setAttribute('name', 'hop_dong[]');

        var i = 0;
        var cellHopDong = row.insertCell(i);
        cellHopDong.innerHTML = selectedHopDong.options[selectedHopDong.selectedIndex].text
            + '<input type="hidden" name="hop_dong[' + countRow + '][loai_hop_dong]" value="'
            + selectedHopDong.value + '" />';
        
        i++;
        var cellNgayHieuLuc = row.insertCell(i);
        cellNgayHieuLuc.innerHTML = ngayHieuLuc.value
            + '<input type="hidden" name="hop_dong[' + countRow + '][ngay_hieu_luc]" value="'
            + ngayHieuLuc.value + '" />';

        i++;
        
        var cellNgayHetHieuLuc = row.insertCell(i);
        cellNgayHetHieuLuc.innerHTML = ngayHetHieuLuc.value
            + '<input type="hidden" name="hop_dong[' + countRow + '][ngay_het_hieu_luc]" value="'
            + ngayHetHieuLuc.value + '" />';        

        i++;
        var cellNgayKyHopDong = row.insertCell(i);
        cellNgayKyHopDong.innerHTML = ngayKyHopDong.value
            + '<input type="hidden" name="hop_dong[' + countRow + '][ngay_ky_hop_dong]" value="'
            + ngayKyHopDong.value + '" />';

        i++;
        var cellSoHopDong = row.insertCell(i);
        cellSoHopDong.innerHTML = soHopDong.value
        + '<input type="hidden" name="hop_dong[' + countRow + '][so_hop_dong]" value="'
        + soHopDong.value + '" />';

        i++;
        var cellAttactment = row.insertCell(i);
        let inputFileElements = document.getElementById("hop_dong_files").querySelectorAll("input");              
        let spanTextAttactment = document.createElement('span');        

        for (inputIndex = 0; inputIndex < inputFileElements.length; inputIndex++) {            
            let inputElement = document.createElement('input');         
            inputElement.setAttribute('type', 'hidden');
            inputElement.setAttribute('name', 'hop_dong[' + countRow + '][attachment][' + inputIndex + ']');
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
        cellEdit.innerHTML = '<span onclick="deleteRowHopDong(this, ' +id +');"><i class="fa fa-trash"></i></span>';
        cellEdit.setAttribute('align', 'center');
    }
}

function deleteRowHopDong(row,id)
{  
    var i = row.parentNode.parentNode.rowIndex;    
    document.getElementById("chitiethopdong").deleteRow(i-1);    
    var quaTrinhCongTacDataElement = document.getElementById("hiddenHopDong");    
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