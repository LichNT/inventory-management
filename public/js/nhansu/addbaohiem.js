function themBaoHiem() {
    var tbody = document.getElementById("bao_hiem");
    
    if (typeof tbody != 'undefined') {
        // input
        var tenBaoHiem = document.getElementById("ten_bao_hiem");
        var soTheBaoHiem= document.getElementById("so_the_bao_hiem");
        var ngayHieuLucBH = document.getElementById("ngay_hieu_luc_bh");
        var ngayHetHieuLucBH = document.getElementById("ngay_het_hieu_luc_bh");
        var SelectedtrangThaiBH = document.getElementById("trang_thai_bh");
        var ghiChu = document.getElementById("ghi_chu");
        // validator
        var errors="";
        if(tenBaoHiem.value == 'undefined' || tenBaoHiem.value == ''){
            errors="Chưa nhập tên bảo hiểm"
        }
        else if(soTheBaoHiem.value == 'undefined' || soTheBaoHiem.value == ''){
            errors="Chưa nhập số thẻ bảo hiểm"
        }
        else if (ngayHieuLucBH.value == 'undefined' || ngayHieuLucBH.value == ''){
            errors="Chưa nhập ngày hiệu lực"
        }
        else if(ngayHetHieuLucBH.value == 'undefined' || ngayHetHieuLucBH.value == ''){
            errors="Chưa nhập ngày hết hiệu lực"
        }
        else if(SelectedtrangThaiBH.value == 'undefined' || SelectedtrangThaiBH.value == ''){
            errors="Chưa chọn trạng thái"
        }
        //
        if (errors!="") {
            var alert = document.getElementById("alert_bao_hiem");
            alert.innerHTML =
                '<div class="col col-md-12">'
                +'<div class="alert alert-info alert-dismissible">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                + '<h4><i class="icon fa fa-info"></i>'+ errors +'</h4>'
                + '</div>'
                + '</div>';
            return;
        }       
    
        
        var baoHiemDataElement = document.getElementById("hiddenBaoHiem");
        var id=new Date().getTime();
        if (baoHiemDataElement) {
            var check=0;
            var baohiem = JSON.parse(baoHiemDataElement.value);
            baohiem.forEach(element => {
                if (
                    element.ten_bao_hiem == tenBaoHiem.value &&
                    element.so_the_bao_hiem == soTheBaoHiem.value &&
                    element.ngay_hieu_luc_bh == ngayHieuLucBH.value &&
                    element.ngay_het_hieu_luc_bh == ngayHetHieuLucBH.value&&
                    element.trang_thai_bh == SelectedtrangThaiBH.value
                ) {
                    var alert = document.getElementById("alert_bao_hiem");
                    alert.innerHTML =
                        '<div class="col col-md-12">'
                        + '<div class="alert alert-info alert-dismissible">'
                        + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                        + '<h4><i class="icon fa fa-info"></i>Trùng dữ liệu</h4>'
                        + '</div>'
                        + '</div>';
                    check=1;
                    return;
                }               
            });
                if(check==1){
                    return
                }
                baohiem.push({   
                    'id':id,                 
                    'ten_bao_hiem' : tenBaoHiem.value ,
                    'so_the_bao_hiem' : soTheBaoHiem.value ,
                    'ngay_hieu_luc_bh': ngayHieuLucBH.value ,
                    'ngay_het_hieu_luc_bh': ngayHetHieuLucBH.value,
                    'trang_thai_bh' : SelectedtrangThaiBH.value,
            });

            baoHiemDataElement.value = JSON.stringify(baohiem);
           
        }
        // add to table        
        var countRow = tbody.getElementsByTagName("tr").length;
        var row = tbody.insertRow(0);
        row.setAttribute('name', 'bao_hiem[]');

        var i = 0;
        var cellTenBaoHiem= row.insertCell(i);
        cellTenBaoHiem.innerHTML = tenBaoHiem.value
            + '<input type="hidden" name="bao_hiem[' + countRow + '][ten_bao_hiem]" value="'
            + tenBaoHiem.value + '" />';

        i++;
        
        var cellSoTheBaoHiem = row.insertCell(i);
        cellSoTheBaoHiem.innerHTML = soTheBaoHiem.value
            + '<input type="hidden" name="bao_hiem[' + countRow + '][so_the_bao_hiem]" value="'
            + soTheBaoHiem.value + '" />';        

        i++;
        var cellNgayHieuLucBH = row.insertCell(i);
        cellNgayHieuLucBH.innerHTML = ngayHieuLucBH.value
            + '<input type="hidden" name="bao_hiem[' + countRow + '][ngay_hieu_luc]" value="'
            + ngayHieuLucBH.value + '" />';

        i++;
        var cellNgayHetHieuLucBH = row.insertCell(i);
        cellNgayHetHieuLucBH.innerHTML = ngayHetHieuLucBH.value
        + '<input type="hidden" name="bao_hiem[' + countRow + '][ngay_het_hieu_luc]" value="'
        + ngayHetHieuLucBH.value + '" />';

        i++;
        var cellTrangThaiBH = row.insertCell(i);
        cellTrangThaiBH.innerHTML =  SelectedtrangThaiBH.options[SelectedtrangThaiBH.selectedIndex].text
        + '<input type="hidden" name="bao_hiem[' + countRow + '][trang_thai]" value="'
        + SelectedtrangThaiBH.value + '" />';  
        i++;
        var cellGhiChu = row.insertCell(i);
        cellGhiChu.innerHTML = ghiChu.value
        + '<input type="hidden" name="bao_hiem[' + countRow + '][ghi_chu]" value="'
        + ghiChu.value + '" />';             

        i++;
        var cellEdit = row.insertCell(i);
        cellEdit.innerHTML = '<span onclick="deleteRowBH(this, ' +id +');"><i class="fa fa-trash"></i></span>';
        cellEdit.setAttribute('align', 'center');
    }
}

function deleteRowBH(row,id)
{  
    var i = row.parentNode.parentNode.rowIndex;    
    document.getElementById("bao_hiem").deleteRow(i-1);   
    var quaTrinhCongTacDataElement = document.getElementById("hiddenBaoHiem");    
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