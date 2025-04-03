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
$("#confirmpassword").keyup(function () {
    validateConfirmPassword();
});
function validateConfirmPassword() {
    let textValue       = $("#confirmpassword").val();
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
//old password check
$("#currentpasswordcheck").hide();
let currentpasswordError = true;
$("#currentpassword").keyup(function () {
    validateCurrentPassword();
});
function validateCurrentPassword() {
    let textValue = $("#currentpassword").val();
    if (textValue.length == "") {
        $("#currentpasswordcheck").show();
        currentpasswordError = false;
        return false;
    }else {
        currentpasswordError = true;
        $("#currentpasswordcheck").hide();
    }
}
//button disable submit
function disableButtonAndSubmit(button, id) {
    // Disable the button
    $(button).prop('disabled', true);
    $(button).css('background-color', '#adb2f0');
    $(button).text('submtting...'); // Change button text
    // Submit the form
    $("#" + id).submit();
}
//button signin
$("#btn-submit-login").click(function () {
    validatePassword();validateUsername();
    try {
        if (passwordError == true && usernameError==true ){
            disableButtonAndSubmit(this,"defaultform");
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
  //password expire
  $("#btn-submit-pass-expire").click(function () {
    validateConfirmPassword();validatePassword();validateCurrentPassword();
     try {
         if (confirmpasswordError==true && passwordError== true && currentpasswordError== true){
             return true;
         }else{
              return false;
         }
     } catch (err) {
         alert(err.message);
         return false;
     }
 });