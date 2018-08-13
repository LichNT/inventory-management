function download() {
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
  var searchMien = document.getElementById('mien_moi');
  var searchTinh = document.getElementById('tinh_moi');
  var searchChiNhanh = document.getElementById('chi_nhanh_moi');
  var search = document.getElementById('search');
  var searchTimeStart = document.getElementById('search_time_start');
  var searchTimeEnd = document.getElementById('search_time_end');


  var uploaderForm = new FormData();
  var strUrl='?';
  if(searchMien&&searchMien.value){
    strUrl+='search_mien='+searchMien.value+'&&';
  }
  if(searchChiNhanh&&searchChiNhanh.value){
    strUrl+='search_chi_nhanh='+searchChiNhanh.value+'&&';
  }
  if(searchTinh&&searchTinh.value){
    strUrl+='search_tinh='+searchTinh.value+'&&';
  }
  if(searchTimeStart&&searchTimeStart.value){
    strUrl+='search_time_start='+searchTimeStart.value+'&&';
  }

  if(searchTimeEnd && searchTimeEnd.value){
    strUrl+='search_time_end='+searchTimeEnd.value+'&&';
  }

  if(search && search.value){
    strUrl+='search='+search.value+'&&';
  }
  ajax.open("GET", "/report/nhansuTGS" + strUrl + "");
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