function addBangCap() {
    var tbody = document.getElementById("van_bang");

    if (typeof tbody != 'undefined') {
        // input
        var bangCap = document.getElementById("bang_cap");
        var chuyenNganh = document.getElementById("chuyen_nganh_vb");
        var truongDaoTao = document.getElementById("truong_dao_tao_vb");
        var namTotNghiep = document.getElementById("nam_tot_nghiep_vb");
        var selectedXepLoai = document.getElementById("xep_loai_van_bang");
        // validator
        var errors="";
        if(bangCap.value == 'undefined' || bangCap.value == ''){
            errors="Chưa nhập bằng cấp"
        }
        else if(chuyenNganh.value == 'undefined' || chuyenNganh.value == ''){
            errors="Chưa nhập chuyên ngành"
        }
        else if (truongDaoTao.value == 'undefined' || truongDaoTao.value == ''){
            errors="Chưa nhập trường đào tạo"
        }
        else if(namTotNghiep.value == 'undefined' || namTotNghiep.value == ''){
            errors="Chưa nhập năm tốt nghiệp"
        }
        else if(selectedXepLoai.value == 'undefined' || selectedXepLoai.value == ''){
            errors="Chưa chọn xếp loại"
        }
        //
        if (errors!="") {
            var alert = document.getElementById("alert_bang_cap");
            alert.innerHTML =
                '<div class="col col-md-12">'
                +'<div class="alert alert-info alert-dismissible">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                + '<h4><i class="icon fa fa-info"></i>'+ errors +'</h4>'
                + '</div>'
                + '</div>';
            return;
        }    

        var vanBangDataElement = document.getElementById("hiddenVanBang");
        var id=new Date().getTime();
        
        if (vanBangDataElement) {
            var check=0;
            var vangBang = JSON.parse(vanBangDataElement.value);
            vangBang.forEach(element => {
                if (element.bang_cap == bangCap.value &&
                    element.chuyen_nganh == chuyenNganh.value &&
                    element.truong_dao_tao == truongDaoTao.value &&
                    element.nam_tot_nghiep == namTotNghiep.value &&
                    element.xep_loai_van_bang == selectedXepLoai.value
                ) {
                    var alert = document.getElementById("alert_bang_cap");
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
                vangBang.push({
                'id':id,
                'bang_cap': bangCap.value,
                'chuyen_nganh' : chuyenNganh.value,
                'truong_dao_tao' : truongDaoTao.value,
                'nam_tot_nghiep' : namTotNghiep.value,
                'xep_loai_van_bang' : selectedXepLoai.value
            });

            vanBangDataElement.value = JSON.stringify(vangBang);
           
        }

        // add to table
        var countRow = tbody.getElementsByTagName("tr").length;
        var row = tbody.insertRow(0);
        row.setAttribute('name', 'van_bang[]');

        var i = 0;
        var cellBangCap = row.insertCell(i);
        cellBangCap.innerHTML = bangCap.value
            + '<input type="hidden" name="van_bang[' + countRow + '][bang_cap]" value="'
            + bangCap.value + '" />';

        i++;
        var cellChuyenNganh = row.insertCell(i);
        cellChuyenNganh.innerHTML = chuyenNganh.value
            + '<input type="hidden" name="van_bang[' + countRow + '][chuyen_nganh]" value="'
            + chuyenNganh.value + '" />';

        i++;
        var cellTruongDaoTao = row.insertCell(i);
        cellTruongDaoTao.innerHTML = truongDaoTao.value
            + '<input type="hidden" name="van_bang[' + countRow + '][truong_dao_tao]" value="'
            + truongDaoTao.value + '" />';

        i++;
        var cellNamTotNghiep = row.insertCell(i);
        cellNamTotNghiep.innerHTML = namTotNghiep.value
            + '<input type="hidden" name="van_bang[' + countRow + '][nam_tot_nghiep]" value="'
            + namTotNghiep.value + '" />';

        i++;
        var cellXepLoai = row.insertCell(i);
        cellXepLoai.innerHTML = selectedXepLoai.options[selectedXepLoai.selectedIndex].text
            + '<input type="hidden" name="van_bang[' + countRow + '][xep_loai_van_bang]" value="'
            + selectedXepLoai.value + '" />';

        i++;
        var cellAttactment = row.insertCell(i);
        let inputFileElements = document.getElementById("van_bang_files").querySelectorAll("input");              
        let spanTextAttactment = document.createElement('span');        

        for (inputIndex = 0; inputIndex < inputFileElements.length; inputIndex++) {            
            let inputElement = document.createElement('input');         
            inputElement.setAttribute('type', 'hidden');
            inputElement.setAttribute('name', 'van_bang[' + countRow + '][attachment][' + inputIndex + ']');
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
        cellEdit.innerHTML = '<span onclick="deleteRowVB(this, ' +id +');"><i class="fa fa-trash"></i></span>';
        cellEdit.setAttribute('align', 'center');
    }
}
function deleteRowVB(row,id)
{
    var i = row.parentNode.parentNode.rowIndex;
    document.getElementById("van_bang").deleteRow(i-1);
    var quaTrinhCongTacDataElement = document.getElementById("hiddenVanBang");    
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