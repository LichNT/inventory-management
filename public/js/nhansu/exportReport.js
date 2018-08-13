function downloadExcel(linkApi) {
    if(linkApi!=undefined){
        var btnXuatExcel=document.getElementById('btnXuatExcel');
        if(btnXuatExcel){
          btnXuatExcel.disabled=true;
        }

        var ajax = new XMLHttpRequest();
        ajax.responseType = 'blob';
    
        ajax.addEventListener("load", function (e) {
            if(btnXuatExcel){
                btnXuatExcel.disabled=false;
              }
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
        }, false);
    
        ajax.addEventListener("error", function (e) {
            if(btnXuatExcel){
                btnXuatExcel.disabled=true;
              }
        }, false);
    
        ajax.addEventListener("abort", function (e) {
            if(btnXuatExcel){
                btnXuatExcel.disabled=true;
              }
        }, false);
        var searchTimeStart = document.getElementById('search_time_start');
        var searchTimeEnd = document.getElementById('search_time_end');
        var strUrl='?';  
    
        if(searchTimeStart && searchTimeStart.value!=''){
            strUrl+='search_time_start='+searchTimeStart.value+'&&';
            }
            if(searchTimeEnd && searchTimeEnd.value!=''){
            strUrl+='search_time_end='+searchTimeEnd.value+'&&';
            }
    
            ajax.open("get",linkApi+strUrl + "");
            ajax.setRequestHeader('Accept', 'xlsx');
            ajax.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr("content"));
                   
        var uploaderForm = new FormData();
        ajax.send(uploaderForm);
    }
    
}