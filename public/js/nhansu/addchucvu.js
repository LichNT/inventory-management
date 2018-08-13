function themChucVu() {
    var tbody = document.getElementById("chuc_vu");
   

    if (typeof tbody != 'undefined') {
        // input
        var selectedChucVu = document.getElementById("ma_chuc_vu");
        var ngayHieuLucCV = document.getElementById("ngay_hieu_luc_cv");
        var ngayHetHieuLucCV = document.getElementById("ngay_het_hieu_luc_cv");
        var soQuyetDinh = document.getElementById("so_quyet_dinh_cv");
        var ngayQuyetDinh = document.getElementById("ngay_quyet_dinh_cv");
        // validator
        var errors="";
        if(selectedChucVu.value == 'undefined' || selectedChucVu.value == ''){
            errors="Chưa chọn chức vụ"
        }
        else if(ngayHieuLucCV.value == 'undefined' || ngayHieuLucCV.value == ''){
            errors="Chưa nhập ngày hiệu lực"
        }
        else if (ngayHetHieuLucCV.value == 'undefined' || ngayHetHieuLucCV.value == ''){
            errors="Chưa nhập ngày hết hiệu lực"
        }
        else if(soQuyetDinh.value == 'undefined' || soQuyetDinh.value == ''){
            errors="Chưa nhập số quyết định"
        }
        else if(ngayQuyetDinh.value == 'undefined' || ngayQuyetDinh.value == ''){
            errors="Chưa nhập ngày quyết định"
        }
        //
        if (errors!="") {
            var alert = document.getElementById("alert");
            alert.innerHTML =
                '<div class="col col-md-12">'
                +'<div class="alert alert-info alert-dismissible">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                + '<h4><i class="icon fa fa-info"></i>'+ errors +'</h4>'
                + '</div>'
                + '</div>';
            return;
        }       
        
        var chucVuDataElement = document.getElementById("hiddenChucVu");
        var id=new Date().getTime();
        
        if (chucVuDataElement) {
            var check=0;
            var chucVu = JSON.parse(chucVuDataElement.value);
            chucVu.forEach(element => {
                if (element.ma_chuc_vu == selectedChucVu.value &&
                    element.ngay_hieu_luc_cv == ngayHieuLucCV.value &&
                    element.ngay_het_hieu_luc_cv == ngayHetHieuLucCV.value &&
                    element.so_quyet_dinh_cv == soQuyetDinh.value&&
                    element.ngay_quyet_dinh_cv == ngayQuyetDinh.value
                ) {
                    var alert = document.getElementById("alert");
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
                chucVu.push({
                'id':id,
                'ma_chuc_vu': selectedChucVu.value,
                'ngay_hieu_luc_cv' : ngayHieuLucCV.value,
                'ngay_het_hieu_luc_cv' : ngayHetHieuLucCV.value,
                'so_quyet_dinh_cv' : soQuyetDinh.value,
                'ngay_quyet_dinh_cv' : ngayQuyetDinh.value,
            });

            chucVuDataElement.value = JSON.stringify(chucVu);
           
        }
        
        // add to table 
        
        var countRow = tbody.getElementsByTagName("tr").length;
        var row = tbody.insertRow(0);
        row.setAttribute('name', 'chuc_vu[]');

        var i = 0;
        var cellMaChucVu= row.insertCell(i);
        cellMaChucVu.innerHTML = selectedChucVu.options[selectedChucVu.selectedIndex].text
        + '<input type="hidden" name="chuc_vu[' + countRow + '][ma_chuc_vu]" value="'
        + selectedChucVu.value + '" />';

        i++;
        
        var cellNgayHieuLucCV = row.insertCell(i);
        cellNgayHieuLucCV.innerHTML = ngayHieuLucCV.value
            + '<input type="hidden" name="chuc_vu[' + countRow + '][ngay_hieu_luc]" value="'
            + ngayHieuLucCV.value + '" />';

        i++;
        var cellNgayHetHieuLucCV = row.insertCell(i);
        cellNgayHetHieuLucCV.innerHTML = ngayHetHieuLucCV.value
        + '<input type="hidden" name="chuc_vu[' + countRow + '][ngay_het_hieu_luc]" value="'
        + ngayHetHieuLucCV.value + '" />';

        i++;
        var cellNgayQuyetDInh = row.insertCell(i);
        cellNgayQuyetDInh.innerHTML = ngayQuyetDinh.value
        + '<input type="hidden" name="chuc_vu[' + countRow + '][ngay_quyet_dinh]" value="'
        + ngayQuyetDinh.value + '" />';   

        i++;
        var cellSoQuyetDinh = row.insertCell(i);
        cellSoQuyetDinh.innerHTML = soQuyetDinh.value
        + '<input type="hidden" name="chuc_vu[' + countRow + '][so_quyet_dinh]" value="'
        + soQuyetDinh.value + '" />'; 
        
        i++;
        var cellAttactment = row.insertCell(i);
        let inputFileElements = document.getElementById("chuc_vu_files").querySelectorAll("input");              
        let spanTextAttactment = document.createElement('span');        

        for (inputIndex = 0; inputIndex < inputFileElements.length; inputIndex++) {            
            let inputElement = document.createElement('input');         
            inputElement.setAttribute('type', 'hidden');
            inputElement.setAttribute('name', 'chuc_vu[' + countRow + '][attachment][' + inputIndex + ']');
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
        cellEdit.innerHTML = '<span onclick="deleteRowCV(this, ' +id +');"><i class="fa fa-trash"></i></span>';
        cellEdit.setAttribute('align', 'center');
    }
}

function deleteRowCV(row,id)
{  
    var i = row.parentNode.parentNode.rowIndex;    
    document.getElementById("chuc_vu").deleteRow(i-1);    
    var quaTrinhCongTacDataElement = document.getElementById("hiddenChucVu");    
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