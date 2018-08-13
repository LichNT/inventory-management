function downloadExcel() {
    var btnXuatExcel=document.getElementById('btnXuatExcel');
    btnXuatExcel.disabled=true;
    var ajax = new XMLHttpRequest();
    ajax.responseType = 'blob';

    ajax.addEventListener("load", function (e) {             
        if(e.target.status == 200) {                        
            var disposition = ajax.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);
            var filename = (matches != null && matches[1] ? matches[1] : 'file.xlsx');

            var blob = new Blob([ajax.response], { type: 'application/xlsx' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;
    
            document.body.appendChild(link);
    
            link.click();
    
            document.body.removeChild(link);
           
        }
        btnXuatExcel.disabled=false;
    }, false);

    ajax.addEventListener("error", function (e) {
        btnXuatExcel.disabled="false";
        
    }, false);

    ajax.addEventListener("abort", function (e) {
        btnXuatExcel.disabled=false;
        
    }, false);

    var searchChiNhanh = document.getElementById('search_chi_nhanh');
    var searchTinh = document.getElementById('search_tinh');
     var searchPhongBan = document.getElementById('search_phong_ban');
     var searchBoPhan = document.getElementById('search_bo_phan');
     var searchChucVu = document.getElementById('search_chuc_vu');
     var searchTrinhDoVanHoa = document.getElementById('search_trinh_do_van_hoa');
     var searchLoaiHopDong = document.getElementById('search_loai_hop_dong');
     var searchGioiTinh = document.getElementById('search_gioi_tinh');
     var searchDaNghiViec = document.getElementById('search_da_nghi_viec');
     var searchNgaySinh = document.getElementById('search_ngay_sinh');
     
    var uploaderForm = new FormData();  
    var strUrl='?'; 

    if(searchChiNhanh&&searchChiNhanh.value){
        strUrl+='search_chi_nhanh='+searchChiNhanh.value+'&&';
      }
    if(searchTinh&&searchTinh.value){
    strUrl+='search_tinh='+searchTinh.value+'&&';
    }
   if(searchPhongBan&&searchPhongBan.value){
     strUrl+='search_phong_ban='+searchPhongBan.value+'&&';
   }
   if(searchBoPhan&&searchBoPhan.value){
    strUrl+='search_bo_phan='+searchBoPhan.value+'&&';
  }
   if(searchChucVu){
    let resultChucVu=this.getSelectValues(searchChucVu);
    for(let i=0;i<resultChucVu.length;i++){
     strUrl+='search_chuc_vu[]='+resultChucVu[i]+'&&';
    }
   }
   
   if(searchTrinhDoVanHoa){
    let resultTrinhDoVanHoa=this.getSelectValues(searchTrinhDoVanHoa);
    for(let i=0;i<resultTrinhDoVanHoa.length;i++){
     strUrl+='search_trinh_do_van_hoa[]='+resultTrinhDoVanHoa[i]+'&&';
    }
   }
   if(searchLoaiHopDong){
    let resultLoaiHopDong=this.getSelectValues(searchLoaiHopDong);
    for(let i=0;i<resultLoaiHopDong.length;i++){
     strUrl+='search_loai_hop_dong[]='+resultLoaiHopDong[i]+'&&';
    }
   }

   if(searchGioiTinh){
    let resultGioiTinh=this.getSelectValues(searchGioiTinh);
    for(let i=0;i<resultGioiTinh.length;i++){
     strUrl+='search_gioi_tinh[]='+resultGioiTinh[i]+'&&';
    }
   }
   
   if(searchDaNghiViec){
    let resultDaNghiViec=this.getSelectValues(searchDaNghiViec);
    for(let i=0;i<resultDaNghiViec.length;i++){
     strUrl+='search_da_nghi_viec[]='+resultDaNghiViec[i]+'&&';
    }
   }
   if(searchNgaySinh && searchNgaySinh.value!=''){
    strUrl+='search_ngay_sinh='+searchNgaySinh.value+'&&';
  }
   ajax.open("GET", "/nhansu/exports/excel" + strUrl + "");
     ajax.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr("content"));
     ajax.setRequestHeader("Accept", "xlsx");  
    ajax.send(uploaderForm);     
}
function getSelectValues(select) {
    var result = [];
    var options = select && select.options;
    var opt;
   
    for (var i=0, iLen=options.length; i<iLen; i++) {
      opt = options[i];
   
      if (opt.selected) {
        result.push(opt.value || opt.text);
      }
    }
    return result;
   }