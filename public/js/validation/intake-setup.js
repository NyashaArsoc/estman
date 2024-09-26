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

/*--------------------starting buttons --------------------------*/
 //button currency code
 $("#btn-submit-currency").click(function () {
    validateCurrencyCode();
    try {
        if (currencycodeError == true ){
            //--------------valid input-----------
            return true;
        }else{
             //-------------invalid input-----------
             return false;
        }
    } catch (err) {
        alert(err.message);
        return false;
    }
});