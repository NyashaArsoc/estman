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