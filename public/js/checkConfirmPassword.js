
function changeConfirmPassword(){
   
    var confirmPassword=document.getElementById('inputComfirmPassword');
    confirmPassword.setCustomValidity("");
 }
 function changePassword(){
   
    var password=document.getElementById('inputNewPassword');
    password.setCustomValidity("");
 }
function checkPassword(){
    var password=document.getElementById('inputNewPassword');
    var confirmPassword=document.getElementById('inputComfirmPassword');
    if(password.value.length<8)
    {
        password.setCustomValidity("Mật khẩu chứa ít nhất 8 ký tự !")  
    }
    else if(password.value!=confirmPassword.value){
        confirmPassword.setCustomValidity("Nhập lại mật khẩu không đúng! ");   
    }

}
 