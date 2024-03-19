//username check
$("#usernamecheck").hide();
let usernameError = true;
$("#username").keyup(function () {
    validateUsername();
});
function validateUsername() {
    let textValue = $("#username").val();
    if (textValue.length == "") {
        $("#usernamecheck").show();
        usernameError = false;
        return false;
    }else {
        usernameError = true;
        $("#usernamecheck").hide();
    }
}
//password check
$("#passwordcheck").hide();
let passwordError = true;
$("#password").keyup(function () {
    validatePassword();
});
function validatePassword() {
    let textValue = $("#password").val();
    if (textValue.length == "") {
        $("#passwordcheck").show();
        passwordError = false;
        return false;
    }else {
        passwordError = true;
        $("#passwordcheck").hide();
    }
}
//password check
$("#confirmpasswordcheck").hide();
let confirmpasswordError = true;
$("#ConfirmPassword").keyup(function () {
    validateConfirmPassword();
});
function validateConfirmPassword() {
    let textValue       = $("#ConfirmPassword").val();
    let passwordValue   = $("#password").val();
    if (textValue.length == "") {
        $("#confirmpasswordcheck").show();
        confirmpasswordError = false;
        return false;
    }else {
        if(textValue != passwordValue){
           $("#confirmpasswordcheck").show();
           $("#confirmpasswordcheck").html("**password mismatch");
           confirmpasswordError = false;
        }else{
           confirmpasswordError = true;
            $("#confirmpasswordcheck").hide();
        }
       
    }
}
//button signin
$("#btn-submit-login").click(function () {
    validatePassword();validateUsername();
    try {
        if (passwordError == true && usernameError==true ){
            return true;
        }else{
             return false;
        }
    } catch (err) {
        alert(err.message);
        return false;
    }
});
 //change password
 $("#btn-user-profile").click(function () {
    validateConfirmPassword();validatePassword();
     try {
         if (confirmpasswordError==true && passwordError== true ){
             return true;
         }else{
              return false;
         }
     } catch (err) {
         alert(err.message);
         return false;
     }
 });