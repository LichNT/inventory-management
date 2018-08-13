function changeLuong(selectObject,id) {
    
    var heSoLuong_id = selectObject.value;
    
    
    if(heSoLuong_id==""){
        if(id==undefined){
            var ngachluongInputlement = document.getElementById("ngach_luong");
        }
        else{
            var ngachluongInputlement = document.getElementById("ngach_luong_"+id);
        }
        
        if (ngachluongInputlement) {
            ngachluongInputlement.value = "";
        }  
        if(id==undefined){
            var luongVNDInputlement = document.getElementById("luong_VND");
        }
        else{
            var luongVNDInputlement = document.getElementById("luong_VND_"+id);
        }     
        if (luongVNDInputlement) {
            luongVNDInputlement.value = ""+ '   VNĐ';
        }
    }
    if(id==undefined){
        var hesoluongInputElement = document.getElementById("hesoluongs");
    }
    else{
        var hesoluongInputElement = document.getElementById("hesoluongs_"+id);
    }

    if (hesoluongInputElement && heSoLuong_id) {
        var hesoluongs = JSON.parse(hesoluongInputElement.value);
        var selectedHesoluong;

        hesoluongs.forEach(hesoluong => {
            if (hesoluong.ma_luong == heSoLuong_id) {
                selectedHesoluong = hesoluong;
                return false;
            }
        });
       
        if (selectedHesoluong) {
           
            if(selectedHesoluong.ngach_luong){
                if(id==undefined){
                    var ngachluongInputlement = document.getElementById("ngach_luong");
                }
                else{
                    var ngachluongInputlement = document.getElementById("ngach_luong_"+id);
                }
                if (ngachluongInputlement) {
                    ngachluongInputlement.value = selectedHesoluong.ngach_luong;
                }    
            }
            
            if(selectedHesoluong.luong_VND)
            {
                if(id==undefined){
                    var luongVNDInputlement = document.getElementById("luong_VND");
                }
                else{
                    var luongVNDInputlement = document.getElementById("luong_VND_"+id);
                }     
                if (luongVNDInputlement) {
                    luongVNDInputlement.value = selectedHesoluong.luong_VND + '   VNĐ';
                }
            }
            
        }
    }
}

