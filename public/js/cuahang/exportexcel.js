function downloadExcelCuaHang() {
    var btnXuatExcel=document.getElementById('btnXuatExcelCuaHang');
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
    var searchTimeStart = document.getElementById('search_time_start');
    var searchTimeEnd = document.getElementById('search_time_end');
    var searchTinhThanh = document.getElementById('search_tinh_thanh');
    var searchLoaiCuaHang = document.getElementById('search_loai_cua_hang');
    var searchChiNhanh = document.getElementById('search_chi_nhanh');


    var uploaderForm = new FormData();
    var strUrl='?';
    if(searchTimeStart&&searchTimeStart.value){
        strUrl+='search_time_start='+searchTimeStart.value+'&&';
    }
    if(searchTimeEnd&&searchTimeEnd.value){
        strUrl+='search_time_end='+searchTimeEnd.value+'&&';
    }
    if(searchChiNhanh&&searchChiNhanh.value){
        strUrl+='search_chi_nhanh='+searchChiNhanh.value+'&&';
    }
    if(searchTinhThanh&&searchTinhThanh.value){
        strUrl+='search_tinh_thanh='+searchTinhThanh.value+'&&';
    }

    if(searchLoaiCuaHang){
        let resultLoaiCuaHang=this.getSelectValues(searchLoaiCuaHang);
        for(let i=0;i<resultLoaiCuaHang.length;i++){
            strUrl+='search_loai_cua_hang[]='+resultLoaiCuaHang[i]+'&&';
        }
    }
    ajax.open("GET", "/cuahang/exports/excel" + strUrl + "");
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