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