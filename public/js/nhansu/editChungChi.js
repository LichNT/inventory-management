
function changeChungChi(id,value)
{
    var id_LoaiChungChi=$('#loai_chung_chi_'+id).val();
    var loaichungchiInputElement = document.getElementById("danhmucchungchi");
    if(id_LoaiChungChi){
        if (loaichungchiInputElement && id_LoaiChungChi) {
            if(id_LoaiChungChi!=8){
            var loaichungchis = JSON.parse(loaichungchiInputElement.value);
            var selectedLoaiChungChi=new Array();       
            loaichungchis.forEach(loaichungchi => {
                if (loaichungchi.loai_chung_chi == id_LoaiChungChi) {
                    selectedLoaiChungChi.push(loaichungchi) ;
                }
            });
                var tenchungchiElement=document.getElementById('ten_chung_chi_'+id);
                var chungchikhac=document.getElementById("chung_chi_khac_"+id);
                if(tenchungchiElement){
                    tenchungchiElement.style.display = "block";
                    tenchungchiElement.removeAttribute('disabled');
                tenchungchiElement.innerHTML='<option> Chọn</option>';
                for (let i = 0; i < selectedLoaiChungChi.length; i++) { 
                    if(value==selectedLoaiChungChi[i].ma_chung_chi){
                        tenchungchiElement.innerHTML+='<option selected value="'+selectedLoaiChungChi[i].ma_chung_chi +'">'+ selectedLoaiChungChi[i].ten_chung_chi+'</option>'
                    }
                    else{
                        tenchungchiElement.innerHTML+='<option value="'+selectedLoaiChungChi[i].ma_chung_chi +'">'+ selectedLoaiChungChi[i].ten_chung_chi+'</option>'
                    }
                    
                    }
                
                }
                if(chungchikhac){
                    chungchikhac.setAttribute('disabled', 'disabled');
                    chungchikhac.style.display = "none";
                }
            }
            else{
                var chungchikhac=document.getElementById("chung_chi_khac_"+id);
                var tenchungchiElement=document.getElementById('ten_chung_chi_'+id);
                if(tenchungchiElement){
                    tenchungchiElement.style.display = "none";
                    tenchungchiElement.setAttribute('disabled', 'disabled');
                }
                if(chungchikhac){
                    chungchikhac.removeAttribute('disabled');
                    chungchikhac.style.display = "block";
                    if(value){
                        chungchikhac.value = value;
                    }
                    
                }
               

            }
            
            
        }
    }
}