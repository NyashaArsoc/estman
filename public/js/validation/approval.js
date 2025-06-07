











//valid currency code
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
/*------------------------------------submit buttons -----------------*/




// btn invoicing  
$("#btn-val-invoicing").click(function () {
    validateCurrencyCode(); validateMarketValue();
    try {
        if (currencycodeError == true && marketvalueError == true) { return true; }
        else { return false; }
    } catch (err) {
        alert(err.message);
        return false;
    }
});