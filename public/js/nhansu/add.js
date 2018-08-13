
function themQuaTrinhCongTac() {
    var tbody = document.getElementById("qua_trinh_cong_tac");
    var arrayPhongBan = new Array();
    if (typeof tbody != 'undefined') {
        // input
        var selectedPhongBanMoi = document.getElementById("id_phong_ban_moi");
        var selectedPhongBanCu = document.getElementById("id_phong_ban_cu");
        var selectedCuaHangMoi     = document.getElementById("id_cua_hang_moi");
        var selectedCuaHangCu = document.getElementById("id_cua_hang_cu");
        var selectedChucVuMoi = document.getElementById("id_chuc_vu_moi");
        var selectedChucVuCu = document.getElementById("id_chuc_vu_cu");
        var ngayHieuLuc = document.getElementById("ngay_hieu_luc");
        var ngayHetHieuLuc = document.getElementById("ngay_het_hieu_luc");
        var ngayQuyetDinh = document.getElementById("ngay_quyet_dinh");
        var soQuyetDinh = document.getElementById("so_quyet_dinh");

        // validator
        var errors="";
        if(selectedPhongBanMoi.value == 'undefined' || selectedPhongBanMoi.value == ''){
            errors="Chưa chọn phòng ban"   
        }
        else if(ngayHieuLuc.value == 'undefined' || ngayHieuLuc.value == ''){
            errors="Chưa nhập ngày hiệu lực";
        }
        else if (ngayHetHieuLuc.value == 'undefined' || ngayHetHieuLuc.value == ''){
            errors="Chưa nhập ngày hết hiệu lực"
        }
        else if(ngayQuyetDinh.value == 'undefined' || ngayQuyetDinh.value == ''){
            errors="Chưa nhập ngày quyết định"
        }
        else if(soQuyetDinh.value == 'undefined' || soQuyetDinh.value == ''){
            errors="Chưa nhập số quyết định"
        }
        //
        if (errors!="") {
            var alert = document.getElementById("alert_qua_trinh_cong_tac");
            alert.innerHTML =
                '<div class="col col-md-12">'
                +'<div class="alert alert-info alert-dismissible">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                + '<h4><i class="icon fa fa-info"></i>'+ errors +'</h4>'
                + '</div>'
                + '</div>';
            return;
        }        
        
        var quaTrinhCongTacDataElement = document.getElementById("hiddenPhongBan");
        var id = new Date().getTime();
        if (quaTrinhCongTacDataElement) {
            var check=0;
            var quaTrinhCongTac = JSON.parse(quaTrinhCongTacDataElement.value);
            quaTrinhCongTac.forEach(element => {
                if (element.id_phong_ban_moi == selectedPhongBanMoi.value &&
            element.id_phong_ban_cu == selectedPhongBanCu.value &&
            element.id_cua_hang_moi == selectedCuaHangMoi.value &&
            element.id_cua_hang_cu == selectedCuaHangCu.value &&
            element.id_chuc_vu_moi == selectedChucVuMoi.value &&
            element.id_chuc_vu_cu == selectedChucVuCu.value &&
                    element.ngay_hieu_luc == ngayHieuLuc.value &&
                    element.ngay_het_hieu_luc == ngayHetHieuLuc.value &&
                    element.ngay_quyet_dinh == ngayQuyetDinh.value&&
                    element.so_quyet_dinh == soQuyetDinh.value
                ) {
                    var alert = document.getElementById("alert_qua_trinh_cong_tac");
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
            quaTrinhCongTac.push({
                'id':id,
                'id_phong_ban_moi': selectedPhongBanMoi.value,
                'id_phong_ban_cu': selectedPhongBanCu.value,
                'id_cua_hang_moi': selectedCuaHangMoi.value,
                'id_cua_hang_cu': selectedCuaHangCu.value,
                'id_chuc_vu_moi': selectedChucVuMoi.value,
                'id_chuc_vu_moi': selectedChucVuCu.value,
                'ngay_hieu_luc' : ngayHieuLuc.value,
                'ngay_het_hieu_luc' : ngayHetHieuLuc.value,
                'ngay_quyet_dinh' : ngayQuyetDinh.value,
                'so_quyet_dinh':soQuyetDinh.value,
            });

            quaTrinhCongTacDataElement.value = JSON.stringify(quaTrinhCongTac);
           
        }
        // add to table        
        var countRow = tbody.getElementsByTagName("tr").length;
        var row = tbody.insertRow(0);
        row.setAttribute('name', 'qua_trinh_cong_tac[]');
       
        var i = 0;
        var cellMaPhongBan = row.insertCell(i);
        cellMaPhongBan.innerHTML = selectedPhongBan.options[selectedPhongBan.selectedIndex].text
            + '<input type="hidden" name="qua_trinh_cong_tac[' + countRow + '][ma_phong_ban]" value="'
            + selectedPhongBan.value + '" />';

        i++;
        var cellNgayHieuLuc = row.insertCell(i);
        cellNgayHieuLuc.innerHTML = ngayHieuLuc.value
            + '<input type="hidden" name="qua_trinh_cong_tac[' + countRow + '][ngay_hieu_luc]" value="'
            + ngayHieuLuc.value + '" />';

        i++;
        var cellNgayHetHieuLuc = row.insertCell(i);
        cellNgayHetHieuLuc.innerHTML = ngayHetHieuLuc.value
            + '<input type="hidden" name="qua_trinh_cong_tac[' + countRow + '][ngay_het_hieu_luc]" value="'
            + ngayHetHieuLuc.value + '" />';

        i++;
        var cellNgayQuyetDinh = row.insertCell(i);
        cellNgayQuyetDinh.innerHTML = ngayQuyetDinh.value
            + '<input type="hidden" name="qua_trinh_cong_tac[' + countRow + '][ngay_quyet_dinh]" value="'
            + ngayQuyetDinh.value + '" />';
        i++;
        var cellSoQuyetDinh = row.insertCell(i);
        cellSoQuyetDinh.innerHTML = soQuyetDinh.value
            + '<input type="hidden" name="qua_trinh_cong_tac[' + countRow + '][so_quyet_dinh]" value="'
            + soQuyetDinh.value + '" />';

        i++;
        var cellAttactment = row.insertCell(i);
        let inputFileElements = document.getElementById("qua_trinh_cong_tac_files").querySelectorAll("input");              
        let spanTextAttactment = document.createElement('span');        

        for (inputIndex = 0; inputIndex < inputFileElements.length; inputIndex++) {            
            let inputElement = document.createElement('input');         
            inputElement.setAttribute('type', 'hidden');
            inputElement.setAttribute('name', 'qua_trinh_cong_tac[' + countRow + '][attachment][' + inputIndex + ']');
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
        cellEdit.innerHTML = '<span onclick="deleteRow(this, ' +id +')"><i class="fa fa-trash"></i></span>';
        cellEdit.setAttribute('align', 'center');        
    }
}

function deleteRow(row,id) {
    var i = row.parentNode.parentNode.rowIndex;
    document.getElementById("qua_trinh_cong_tac").deleteRow(i - 1);
    var quaTrinhCongTacDataElement = document.getElementById("hiddenPhongBan");    
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
