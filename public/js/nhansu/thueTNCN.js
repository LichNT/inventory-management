$('#loai').change(function(){
    if($('#year').val()!=''){
        if($('#loai').val()==1){
            $('#search_time_start').val('01/'+$('#year').val());
            $('#search_time_end').val('12/'+$('#year').val());
        }
        if($('#loai').val()==2){
            $('#search_time_start').val('01/'+$('#year').val());
            $('#search_time_end').val('06/'+$('#year').val());
        }
        if($('#loai').val()==3){
            $('#search_time_start').val('07/'+$('#year').val());
            $('#search_time_end').val('12/'+$('#year').val());
        }
    }
    
})
