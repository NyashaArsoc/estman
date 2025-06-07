










let isprintedError = true;
$("#isreportprintcheck").hide();
function validateReportPrint() {
    if (!$("#isreportprint").is(":checked")) {
        $("#isreportprintcheck").show();
        isprintedError = false;
        return false;
    }
    $("#isreportprintcheck").hide();
    isprintedError = true;
    return true;
}
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


// btn final approval
$("#btn-val-final-approve").click(function () {
    validateDRC(); validateFairValue();
    validateForcedSaleEstimate(); validateGRC(); validateLandValue();
    validateMarketValue(); validateRentalValue(); validateDepreciationValue();
    validateReportDocument();
    try {
        if (drcError == true && fairvalueError == true && forcedsalestimateError == true &&
            depreciationvalueError == true && grcError == true && landvalueError == true &&
            marketvalueError == true && rentalvalueError == true && reportdocumentError == true) { return true; }
        else { return false; }
    } catch (err) {
        alert(err.message);
        return false;
    }
});
// report printed 
$("#btn-val-isprinted").click(function () {
    validateReportPrint();
    try {
        if (isprintedError == true) { return true; }
        else { return false; }
    } catch (err) {
        alert(err.message);
        return false;
    }
});
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