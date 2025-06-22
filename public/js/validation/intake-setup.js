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
    } else if (textValue.length != 3) {
        $("#currencycodecheck").show();
        $("#currencycodecheck").html("**invalid currency code");
        currencycodeError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/a-z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#currencycodecheck").show();
            $("#currencycodecheck").html("**follow the required format (ZWL/GBP)");
            currencycodeError = false;
            return false;
        } else {
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
    } else if (textValue.length < 2) {
        $("#textdescriptioncheck").show();
        $("#textdescriptioncheck").html("**invalid text");
        textdescriptionError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#textdescriptioncheck").show();
            $("#textdescriptioncheck").html("**follow the required format (Description)");
            textdescriptionError = false;
            return false;
        } else {
            textdescriptionError = true;
            $("#textdescriptioncheck").hide();
        }
    }
}
//period
$("#periodrangecheck").hide();
let periodrangeError = true;
$("#periodrange").keyup(function () {
    validatePeriodRange();
});
function validatePeriodRange() {
    let textValue = $("#periodrange").val();
    if (textValue.length == "") {
        $("#periodrangecheck").show();
        periodrangeError = false;
        return false;
    } else {
        periodrangeError = true;
        $("#periodrangecheck").hide();
    }
}
// lease list by tenant
$("#leaselistcheck").hide();
let leasenameError = true;
$("#leaselist").keyup(function () {
    validateLeaseDescription();
});
function validateLeaseDescription() {
    let textValue = $("#leaselist").val();
    if (textValue.length == "") {
        $("#leaselistcheck").show();
        leasenameError = false;
        return false;
    } else {
        leasenameError = true;
        $("#leaselistcheck").hide();
    }
}
//valid numeric value required
$("#numericrequiredcheck").hide();
let numericrequiredError = true;
$("#numericrequired").keyup(function () {
    validateNumericValueRequired();
});
function validateNumericValueRequired() {
    let textValue = $("#numericrequired").val();
    if (textValue.length == "") {
        $("#numericrequiredcheck").show();
        numericrequiredError = false;
        return false;
    } else if (textValue.length < 1) {
        $("#numericrequiredcheck").show();
        $("#numericrequiredcheck").html("**invalid input");
        numericrequiredError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#numericrequiredcheck").show();
            $("#numericrequiredcheck").html("**digits only or (3.5)");
            numericrequiredError = false;
            return false;
        } else {
            numericrequiredError = true;
            $("#numericrequiredcheck").hide();
        }
    }
}
// buying rate 
$("#buyingratecheck").hide();
let buyingrateError = true;
$("#buyingrate").keyup(function () {
    validateBuyingRate();
});
function validateBuyingRate() {
    let textValue = $("#buyingrate").val();
    let SellingValue = $("#SellingRate").val();
    let MeanRate;
    if (textValue.length == "") {
        $("#buyingratecheck").show();
        buyingrateError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#buyingratecheck").show();
            $("#buyingratecheck").html("**digits only or (35.9098)");
            buyingrateError = false;
            return false;
        } else {
            MeanRate = (parseFloat(textValue) + parseFloat(SellingValue)) / 2
            $("#meanratecheck").html(MeanRate);
            buyingrateError = true;
            $("#buyingratecheck").hide();
        }
    }

}
// selling rate 
$("#sellingratecheck").hide();
let sellingrateError = true;
$("#sellingrate").keyup(function () {
    validateSellingRate();
});
function validateSellingRate() {
    let textValue = $("#sellingrate").val();
    let BuyingValue = $("#buyingrate").val();
    let MeanRate;
    if (textValue.length == "") {
        $("#sellingratecheck").show();
        sellingrateError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {

            $("#sellingratecheck").show();
            $("#sellingratecheck").html("**digits only or (35.9098)");
            sellingrateError = false;
            return false;
        } else {
            MeanRate = (parseFloat(textValue) + parseFloat(BuyingValue)) / 2
            $("#meanratecheck").html(MeanRate);
            sellingrateError = true;
            $("#sellingratecheck").hide();
        }
    }

}
//valid maximum days
$("#maximundayscheck").hide();
let maximundaysError = true;
$("#maximundays").keyup(function () {
    validateMaximumDays();
});
function validateMaximumDays() {
    let textValue = $("#maximundays").val();
    if (textValue.length == "") {
        $("#maximundayscheck").show();
        maximundaysError = false;
        return false;
    } else if (textValue.length < 1) {
        $("#maximundayscheck").show();
        $("#maximundayscheck").html("**invalid input");
        maximundaysError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#maximundayscheck").show();
            $("#maximundayscheck").html("**digits only or (35)");
            maximundaysError = false;
            return false;
        } else {
            maximundaysError = true;
            $("#maximundayscheck").hide();
        }
    }
}
//valid client type
$("#requiedselectcheck").hide();
let requiedselectError = true;
$("#requiedselect").keyup(function () {
    validateRequiredSelect();
});
function validateRequiredSelect() {
    let textValue = $("#requiedselect").val();
    if (textValue.length == "") {
        $("#requiedselectcheck").show();
        requiedselectError = false;
        return false;
    } else {
        requiedselectError = true;
        $("#requiedselectcheck").hide();
    }
}
/*--------------------starting buttons --------------------------*/
//button disable submit
function disableButtonAndSubmit(button, id) {
    // Disable the button
    $(button).prop('disabled', true);
    $(button).css('background-color', '#ccc');
    $(button).text('submitting...'); // Change button text
    // Submit the form
    $("#" + id).submit();
}
//button currency code
$("#btn-submit-currency").click(function () {
    validateCurrencyCode();
    try {
        if (currencycodeError == true) {
            return true;
        } else { return false; }
    } catch (err) { return false; }
});
//button single text
$("#btn-submit-single-text").click(function () {
    validateTextDescription();
    try {
        if (textdescriptionError == true) {
            disableButtonAndSubmit(this, "defaultform");
        } else { return false; }
    } catch (err) { return false; }
});
//button lease interest
$("#btn-submit-lease-interest").click(function () {
    validateNumericValueRequired(); validateLeaseDescription(); validatePeriodRange();
    try {
        if (numericrequiredError == true && periodrangeError == true && leasenameError == true) {
            return true;
        } else { return false; }
    } catch (err) { return false; }
});
//button lease interest
$("#btn-submit-vat-config").click(function () {
    validateNumericValueRequired(); validateLeaseDescription();
    try {
        if (numericrequiredError == true && leasenameError == true) {
            return true;
        } else { return false; }
    } catch (err) { return false; }
});
//button add exchange rate
$("#btn-submit-exchange-rate").click(function () {
    validateSellingRate(); validateBuyingRate(); validateCurrencyCode();
    try {
        if (buyingrateError == true && sellingrateError == true && currencycodeError == true) {
            return true;
        } else {
            return false;
        }
    } catch (err) {
        alert(err.message);
        return false;
    }
});
$("#btn-submit-levtype").click(function () { disableButtonAndSubmit(this, "defaultform"); });
//button add days to accrue on leave
$("#btn-setup-typegroup-config").click(function () {
    validateNumericValueRequired(); validateMaximumDays(); validateRequiredSelect();
    try {
        if (numericrequiredError == true && maximundaysError == true && requiedselectError == true) {
            disableButtonAndSubmit(this, "defaultform");
        } else { return false; }
    } catch (err) { return false; }
});
$("#btn-sbt-work-days").click(function () { disableButtonAndSubmit(this, "defaultform"); });