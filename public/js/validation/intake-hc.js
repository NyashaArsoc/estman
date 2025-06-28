//valid staff list 
$("#stafflistcheck").hide();
let stafflistError = true;
$("#stafflist").keyup(function () {
    validateStaffList();
});
function validateStaffList() {
    let textValue = $("#stafflist").val();
    if (textValue.length == "") {
        $("#stafflistcheck").show();
        stafflistError = false;
        return false;
    } else {
        stafflistError = true;
        $("#stafflistcheck").hide();
    }
}
//valid leave group list 
$("#leavegroupcheck").hide();
let leavegroupError = true;
$("#leavegroup").keyup(function () {
    validateLeaveGroupList();
});
function validateLeaveGroupList() {
    let textValue = $("#leavegroup").val();
    if (textValue.length == "") {
        $("#leavegroupcheck").show();
        leavegroupError = false;
        return false;
    } else {
        leavegroupError = true;
        $("#leavegroupcheck").hide();
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
//button add staff list 
$("#btn-import-staff").click(function () {
    validateLeaveGroupList(); validateStaffList();
    if (leavegroupError == true && stafflistError == true) {
        disableButtonAndSubmit(this, "defaultform");
    } else { return false; }
});
//button add take-on balances
$("#btn-submit-takeon-days").click(function () {
    validateNumericValueRequired();
    if (numericrequiredError == true) {
        disableButtonAndSubmit(this, "defaultform");
    } else { return false; }
});