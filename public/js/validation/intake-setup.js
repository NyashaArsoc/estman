//valid currency type
$("#currencycodecheck").hide();
let currencycodeError = true;
$("#currencycode").keyup(function () {
    validateCurrencyCode();
});
function validateCurrencyCode() {
    let textValue = $("#currencycode").val();
    if (textValue.length == "") {
        $("#currencycodecheck").show();
        currencycodeError = false;
        return false;
    } else if (textValue.length < 2 || textValue.length > 3) {
        $("#currencycodecheck").show();
        $("#currencycodecheck").html("**invalid currency code");
        currencycodeError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/a-z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#currencycodecheck").show();
                $("#currencycodecheck").html("**follow the required format (ZWL/GBP)");
                currencycodeError = false;
                return false;
            }else{
                currencycodeError = true;
                $("#currencycodecheck").hide();
            }
    }
}
//valid text description
$("#textdescriptioncheck").hide();
let textdescriptionError = true;
$("#textdescription").keyup(function () {
    validateTextDescription();
});
function validateTextDescription() {
    let textValue = $("#textdescription").val();
    if (textValue.length == "") {
        $("#textdescriptioncheck").show();
        textdescriptionError = false;
        return false;
    } else if (textValue.length < 2 ) {
        $("#textdescriptioncheck").show();
        $("#textdescriptioncheck").html("**invalid text");
        textdescriptionError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#textdescriptioncheck").show();
                $("#textdescriptioncheck").html("**follow the required format (Description)");
                textdescriptionError = false;
                return false;
            }else{
                textdescriptionError = true;
                $("#textdescriptioncheck").hide();
            }
    }
}
/*--------------------starting buttons --------------------------*/
 //button currency code
 $("#btn-submit-currency").click(function () {
    validateCurrencyCode();
    try {
        if (currencycodeError == true ){return true;
        }else{ return false;}
    } catch (err) { return false;}
});
 //button single text
 $("#btn-submit-single-text").click(function () {
    validateTextDescription();
    try {
        if (textdescriptionError == true ){return true;
        }else{ return false; }
    } catch (err) { return false;}
});