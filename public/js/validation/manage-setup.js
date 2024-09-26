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
    } else {
        currencycodeError = true;
        $("#currencycodecheck").hide();
    }
}

/*--------------------starting buttons --------------------------*/
//button add base currency
$("#btn-set-base-currency").click(function () {
    validateCurrencyCode();
    try {
        if (currencycodeError==true){return true;}
        else{ return false; }
    } catch (err) {
        alert(err.message);
        return false;
    }
});