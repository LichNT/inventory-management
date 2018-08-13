function themLuong() {
    var tbody = document.getElementById("chitietluong");
    if (typeof tbody != 'undefined') {
        // input
        var maLuong = document.getElementById("ma_luong");
        var ngachLuong = document.getElementById("ngach_luong");
        var luongVND = document.getElementById("luong_VND");
        var ngayHieuLuc = document.getElementById("ngay_hieu_luc_luong");
        var ngayHetHieuLuc= document.getElementById("ngay_het_hieu_luc_luong");
        var ngayQuyetDinh = document.getElementById("ngay_quyet_dinh_luong");
        var soQuyetDinh = document.getElementById("so_quyet_dinh_luong");
        // validator
        var errors="";
        if(maLuong.value == 'undefined' || maLuong.value == ''){
            errors="Chưa chọn hệ số lương"
        }
        else if(ngayHieuLuc.value == 'undefined' || ngayHieuLuc.value == ''){
            errors="Chưa nhập ngày hiệu lực"
        }
        else if(ngayQuyetDinh.value == 'undefined' || ngayQuyetDinh.value == ''){
            errors="Chưa nhập ngày quyết định"
        }
        else if(soQuyetDinh.value == 'undefined' || soQuyetDinh.value == ''){
            errors="Chưa nhập số quyết định"
        }
        //
        if (errors!="") {
            var alert = document.getElementById("alert_luong");
            alert.innerHTML =
                '<div class="col col-md-12">'
                +'<div class="alert alert-info alert-dismissible">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                + '<h4><i class="icon fa fa-info"></i>'+ errors +'</h4>'
                + '</div>'
                + '</div>';
            return;
        }    

        var luongDataElement = document.getElementById("hiddenLuong");
        var id=new Date().getTime();

        if (luongDataElement) {
            var check=0;
            var luong = JSON.parse(luongDataElement.value);
            luong.forEach(element => {
                if (element.ma_luong == maLuong.value &&
                    element.ngay_hieu_luc_luong == ngayHieuLuc.value &&
                    element.ngay_het_hieu_luc_luong == ngayHetHieuLuc.value &&
                    element.ngay_quyet_dinh_luong == ngayQuyetDinh.value &&
                    element.so_quyet_dinh_luong == soQuyetDinh.value
                ) {
                    var alert = document.getElementById("alert_luong");
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
            luong.push({
                'id':id,
                'ma_luong': maLuong.value,
                'ngay_hieu_luc_luong' : ngayHieuLuc.value,
                'ngay_het_hieu_luc_luong' : ngayHetHieuLuc.value,
                'ngay_quyet_dinh_luong' : ngayQuyetDinh.value,
                'so_quyet_dinh_luong':soQuyetDinh.value,
            });

            luongDataElement.value = JSON.stringify(luong);
           
        }
        
        // add to table        
        var countRow = tbody.getElementsByTagName("tr").length;
        var row = tbody.insertRow(0);
        row.setAttribute('name', 'luong[]');

        var i = 0;
        var cellmaLuong = row.insertCell(i);
        cellmaLuong.innerHTML = maLuong.value
            + '<input type="hidden" name="luong[' + countRow + '][ma_luong]" value="'
            + maLuong.value + '" />';
            
        i++
        var cellNgachLuong = row.insertCell(i);
        cellNgachLuong.innerHTML = ngachLuong.value
            + '<input type="hidden" name="luong[' + countRow + '][ngach_luong]" value="'
            + ngachLuong.value + '" />';

         i++;
        var cellLuongVND = row.insertCell(i);
        cellLuongVND.innerHTML = luongVND.value
            + '<input type="hidden" name="luong[' + countRow + '][luong_VND]" value="'
            + luongVND.value + '" />';
            
                
        i++;
        var cellNgayHieuLuc = row.insertCell(i);
        cellNgayHieuLuc.innerHTML = ngayHieuLuc.value
            + '<input type="hidden" name="luong[' + countRow + '][ngay_hieu_luc]" value="'
            + ngayHieuLuc.value + '" />';

        i++;
        
        var cellNgayHetHieuLuc = row.insertCell(i);
        cellNgayHetHieuLuc.innerHTML = ngayHetHieuLuc.value
            + '<input type="hidden" name="luong[' + countRow + '][ngay_het_hieu_luc]" value="'
            + ngayHetHieuLuc.value + '" />';        

        i++;
        var cellNgayQuyetDinh = row.insertCell(i);
        cellNgayQuyetDinh.innerHTML = ngayQuyetDinh.value
            + '<input type="hidden" name="luong[' + countRow + '][ngay_quyet_dinh]" value="'
            + ngayQuyetDinh.value + '" />';

        i++;
        var cellSoQuyetDinh = row.insertCell(i);
        cellSoQuyetDinh.innerHTML = soQuyetDinh.value
        + '<input type="hidden" name="luong[' + countRow + '][so_quyet_dinh]" value="'
        + soQuyetDinh.value + '" />';

        i++;
        var cellAttactment = row.insertCell(i);
        let inputFileElements = document.getElementById("luong_files").querySelectorAll("input");              
        let spanTextAttactment = document.createElement('span');        

        for (inputIndex = 0; inputIndex < inputFileElements.length; inputIndex++) {            
            let inputElement = document.createElement('input');         
            inputElement.setAttribute('type', 'hidden');
            inputElement.setAttribute('name', 'luong[' + countRow + '][attachment][' + inputIndex + ']');
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
        cellEdit.innerHTML = '<span onclick="deleteRowLuong(this, ' +id +');"><i class="fa fa-trash"></i></span>';
        cellEdit.setAttribute('align', 'center');
    }
}

function deleteRowLuong(row,id)
{  
    var i = row.parentNode.parentNode.rowIndex;    
    document.getElementById("chitietluong").deleteRow(i-1);    
    var quaTrinhCongTacDataElement = document.getElementById("hiddenLuong");    
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