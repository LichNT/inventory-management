function themGiamTruGiaCanh() {
    var tbody = document.getElementById("giam_tru_gia_canh");
    if (typeof tbody != 'undefined') {
        // input
        var hoTenNguoiPhuThuoc = document.getElementById("ho_ten_nguoi_phu_thuoc");
        var ngaySinh = document.getElementById("ngay_sinh_thue");
        var cmtnd= document.getElementById("cmtnd");
        var thoiDiemGiamTru = document.getElementById("thoi_diem_giam_tru");
        var thoiDiemKetThucGiam = document.getElementById("thoi_diem_ket_thuc_giam");
        var quanHeGiaDinh = document.getElementById("quan_he_gia_dinh");
        var maSoThue = document.getElementById("ma_so_thue_nguoi_phu_thuoc");
        var thoiDiemDangKy = document.getElementById("thoi_diem_dang_ky");
        // validator
        var errors="";
        if(hoTenNguoiPhuThuoc.value == 'undefined' || hoTenNguoiPhuThuoc.value == ''){
            errors="Họ tên người phụ thuộc"
        }
        else if(ngaySinh.value == 'undefined' || ngaySinh.value == ''){
            errors="Chưa nhập ngày sinh"
        }
        else if (thoiDiemGiamTru.value == 'undefined' || thoiDiemGiamTru.value == ''){
            errors="Chưa nhập thời điểm giảm trừ"
        }
        else if(thoiDiemKetThucGiam.value == 'undefined' || thoiDiemKetThucGiam.value == ''){
            errors="Chưa nhập thời điểm kết thúc giảm"
        }
        else if(quanHeGiaDinh.value == 'undefined' || quanHeGiaDinh.value == ''){
            errors="Chưa nhập quan hệ gia đình"
        }
        else if(thoiDiemDangKy.value == 'undefined' || thoiDiemDangKy.value == ''){
            errors="Chưa nhập thời điểm đăng ký"
        }
        //
        if (errors!="") {
            var alert = document.getElementById("alert_giam_tru_gia_canh");
            alert.innerHTML =
                '<div class="col col-md-12">'
                +'<div class="alert alert-info alert-dismissible">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                + '<h4><i class="icon fa fa-info"></i>'+ errors +'</h4>'
                + '</div>'
                + '</div>';
            return;
        }    

       
        var GiamTruGiaCanhDataElement = document.getElementById("hiddenGiamTruGiaCanh");
        var id=new Date().getTime();

        if (GiamTruGiaCanhDataElement) {
            var check=0;
            var giamTruGiaCanh = JSON.parse(GiamTruGiaCanhDataElement.value);
            giamTruGiaCanh.forEach(element => {
                if (element.ho_ten_nguoi_phu_thuoc == hoTenNguoiPhuThuoc.value &&
                    element.ngay_sinh == ngaySinh.value &&
                    element.cmtnd == cmtnd.value &&
                    element.thoi_diem_giam_tru == thoiDiemGiamTru.value &&
                    element.thoi_diem_ket_thuc_giam == thoiDiemKetThucGiam.value&&
                    element.quan_he_gia_dinh == quanHeGiaDinh.value&&
                    element.ma_so_thue==maSoThue.value&&
                    element.thoi_diem_dang_ky==thoiDiemDangKy.value
                ) {
                    var alert = document.getElementById("alert_giam_tru_gia_canh");
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
                giamTruGiaCanh.push({
                'id':id,
                'ho_ten_nguoi_phu_thuoc': hoTenNguoiPhuThuoc.value,
                'ngay_sinh' : ngaySinh.value,
                'cmtnd' : cmtnd.value,
                'thoi_diem_giam_tru' : thoiDiemGiamTru.value,
                'thoi_diem_ket_thuc_giam' : thoiDiemKetThucGiam.value,
                'quan_he_gia_dinh' : quanHeGiaDinh.value,
                'ma_so_thue':maSoThue.value,
                'thoi_diem_dang_ky':thoiDiemDangKy.value
            });

            GiamTruGiaCanhDataElement.value = JSON.stringify(giamTruGiaCanh);
           
        }       
        // add to table        
        var countRow = tbody.getElementsByTagName("tr").length;
        var row = tbody.insertRow(0);
        row.setAttribute('name', 'giam_tru_gia_canh[]');

        var i = 0;
        var cellHoTenNguoiPhuthuoc = row.insertCell(i);
        cellHoTenNguoiPhuthuoc.innerHTML = hoTenNguoiPhuThuoc.value
            + '<input type="hidden" name="giam_tru_gia_canh[' + countRow + '][ho_ten_nguoi_phu_thuoc]" value="'
            + hoTenNguoiPhuThuoc.value + '" />';
        
        i++;
        var cellNgaySinh = row.insertCell(i);
        cellNgaySinh.innerHTML = ngaySinh.value
            + '<input type="hidden" name="giam_tru_gia_canh[' + countRow + '][ngay_sinh]" value="'
            + ngaySinh.value + '" />';

        i++;
        
        var cellCmtnd = row.insertCell(i);
        cellCmtnd.innerHTML = cmtnd.value
            + '<input type="hidden" name="giam_tru_gia_canh[' + countRow + '][cmtnd]" value="'
            + cmtnd.value + '" />';        

        i++;
        var cellThoiDiemGiamTru = row.insertCell(i);
        cellThoiDiemGiamTru.innerHTML = thoiDiemGiamTru.value
            + '<input type="hidden" name="giam_tru_gia_canh[' + countRow + '][thoi_diem_giam_tru]" value="'
            + thoiDiemGiamTru.value + '" />';

        i++;
        var cellThoiDiemKetThucGiam = row.insertCell(i);
        cellThoiDiemKetThucGiam.innerHTML = thoiDiemKetThucGiam.value
        + '<input type="hidden" name="giam_tru_gia_canh[' + countRow + '][thoi_diem_ket_thuc_giam]" value="'
        + thoiDiemKetThucGiam.value + '" />';

        i++;
        var cellQuanHeGiaDinh = row.insertCell(i);
        cellQuanHeGiaDinh.innerHTML = quanHeGiaDinh.value
        + '<input type="hidden" name="giam_tru_gia_canh[' + countRow + '][quan_he_gia_dinh]" value="'
        + quanHeGiaDinh.value + '" />';   

        i++;
        var cellMaSoThue = row.insertCell(i);
        cellMaSoThue.innerHTML = maSoThue.value
        + '<input type="hidden" name="giam_tru_gia_canh[' + countRow + '][ma_so_thue]" value="'
        + maSoThue.value + '" />';  

        i++;
        var cellThoiDiemDangKy = row.insertCell(i);
        cellThoiDiemDangKy.innerHTML = thoiDiemDangKy.value
        + '<input type="hidden" name="giam_tru_gia_canh[' + countRow + '][thoi_diem_dang_ky]" value="'
        + thoiDiemDangKy.value + '" />';   
        
        i++;
        var cellAttactment = row.insertCell(i);
        let inputFileElements = document.getElementById("thue_files").querySelectorAll("input");              
        let spanTextAttactment = document.createElement('span');        

        for (inputIndex = 0; inputIndex < inputFileElements.length; inputIndex++) {            
            let inputElement = document.createElement('input');         
            inputElement.setAttribute('type', 'hidden');
            inputElement.setAttribute('name', 'giam_tru_gia_canh[' + countRow + '][attachment][' + inputIndex + ']');
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
        cellEdit.innerHTML = '<span onclick="deleteRowThue(this, ' +id +');"><i class="fa fa-trash"></i></span>';
        cellEdit.setAttribute('align', 'center');
    }
}

function deleteRowThue(row,id)
{  
    var i = row.parentNode.parentNode.rowIndex;    
    document.getElementById("giam_tru_gia_canh").deleteRow(i-1);   
    var quaTrinhCongTacDataElement = document.getElementById("hiddenGiamTruGiaCanh");    
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