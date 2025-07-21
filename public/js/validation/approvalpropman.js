// reject reason check
$("#rejectreasoncheck").hide();
let rejectionreasonError = true;
$("#rejectreason").keyup(function () {
    validateRejectReasons();
});

function validateRejectReasons() {
    let textValue = $("#rejectreason").val();
    if (textValue.length == "") {
        $("#rejectreasoncheck").show();
        rejectionreasonError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#rejectreasoncheck").show();
        $("#rejectreasoncheck").html("**invalid reason");
        rejectionreasonError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\=\[\]{};':"\\|.<>?~]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#rejectreasoncheck").show();
            $("#rejectreasoncheck").html("**follow the required format");
            rejectionreasonError = false;
            return false;
        } else {
            rejectionreasonError = true;
            $("#rejectreasoncheck").hide();
        }
    }
}
/*------------invoice editing--------- */
//rental 
$("#propitemrentcheck").hide();
let proptotalbillError = true;
$("#rental").keyup(function () {
    validateTotalBilled();
});
//rates 
$("#propitemratecostcheck").hide();
$("#rateslevies").keyup(function () {
    validateTotalBilled();
});
//opp cost 
$("#propitemoperationcostcheck").hide();
$("#operationcosts").keyup(function () {
    validateTotalBilled();
});
function validateTotalBilled() {
    let rentValue = $("#rental").val();
    let rateValue = $("#rateslevies").val();
    let oppcostValue = $("#operationcosts").val();
    let interestValue = $("#interest").val();
    let vaterateValue = parseFloat($("#percentrate").val());
    const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':",\\|<>\/?~a-z/\s/A-Z]/;
    rentcheck = specialChars.test(rentValue);
    ratecheck = specialChars.test(rateValue);
    oppcostcheck = specialChars.test(oppcostValue);
    if (rentcheck == true) {
        $("#propitemrentcheck").show();
        $("#propitemrentcheck").html("**digits only or (3.5)");
        proptotalbillError = false;
        return false;
    }
    if (ratecheck == true) {
        $("#propitemratecostcheck").show();
        $("#propitemratecostcheck").html("**digits only or (3.5)");
        proptotalbillError = false;
        return false;
    }
    if (oppcostcheck == true) {
        $("#propitemoperationcostcheck").show();
        $("#propitemoperationcostcheck").html("**digits only or (3.5)");
        proptotalbillError = false;
        return false;
    }
    $("#propitemrentcheck").hide();
    $("#propitemratecostcheck").hide();
    $("#propitemoperationcostcheck").hide();
    // Calculate VAT based on rental
    var vat = (rentValue * vaterateValue);
    $('#vat').val(vat.toFixed(2));

    //total billed 
    var total = parseFloat(rentValue) + parseFloat(rateValue) + parseFloat(oppcostValue) +
        parseFloat(interestValue) + parseFloat(vat);
    $("#propitemtotalbilledcheck").html(total);
}
let remitbalanceError = true;
function calculateRentRollTotalBalance() {
    let remitbd = $('#remitbd').val() || 0;
    let toremit = $('#toremit').val() || 0;
    let amountremit = $('#amountremit').val() || 0;
    if (!amountremit) {
        $("#amountremitcheck").show();
        $("#amountremitcheck").html("required");
        remitbalanceError = false;
        return false;
    }

    const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z\sA-Z]/;

    let amountremitcharscheck = specialChars.test(amountremit);

    if (amountremitcharscheck) {
        $("#amountremitcheck").show();
        $("#amountremitcheck").html("digits only");
        remitbalanceError = false;
        return false;
    } else {
        $("#amountremitcheck").hide();
        remitbalanceError = true;
    }

    // Proceed with calculations only if input is valid
    let remitbalance = (parseFloat(remitbd) + parseFloat(toremit)) - parseFloat(amountremit);
    $("#remitbalancecdcheck").html(remitbalance.toFixed(2));
}
$("#amountremit").keyup(function () {
    calculateRentRollTotalBalance();
});
/*------------end invoice editing--------- */
/*****************************-------buttons submit ----------------------- */
//button disable submit
function disableButtonAndSubmit(button, id) {
    // Disable the button
    $(button).prop('disabled', true);
    $(button).css('background-color', '#ccc');
    $(button).text('submitting...'); // Change button text
    // Submit the form
    $("#" + id).submit();
}

//button reject entry/landlord
$("#btn-reject-entry").click(function () {
    validateRejectReasons();
    try {
        if (rejectionreasonError == true) {
            disableButtonAndSubmit(this, "defaultform");
        } else {
            return false;
        }
    } catch (err) {
        alert(err.message);
        return false;
    }
});
$("#btn-edit-profoma").click(function () {
    try {
        validateTotalBilled();
        if (proptotalbillError == true) { disableButtonAndSubmit(this, "defaultform"); }
        else { return false; }
    } catch (err) {
        return false;
    }
});
//button process remit
$("#btn-process-remit").click(function () {
    calculateRentRollTotalBalance();
    if (remitbalanceError == true) {
        disableButtonAndSubmit(this, "defaultform");
    } else {
        //failed
        return false;
    }
});