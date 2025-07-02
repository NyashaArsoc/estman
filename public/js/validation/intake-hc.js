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
//date valid from
$("#datefromcheck").hide();
let datefromError = true;
$("#datefrom").keyup(function () {
    validateDateFrom();
});
function validateDateFrom() {
    let textValue = $("#datefrom").val();
    if (textValue.length == "") {
        $("#datefromcheck").show();
        datefromError = false;
        return false;
    } else {
        datefromError = true;
        $("#datefromcheck").hide();
    }
}
//valid to
$("#datetocheck").hide();
let datetoError = true;
$("#dateto").keyup(function () {
    validateDateTo();
});
function validateDateTo() {
    let textValue = $("#dateto").val();
    if (textValue.length == "") {
        $("#datetocheck").show();
        datetoError = false;
        return false;
    } else {
        datetoError = true;
        $("#datetocheck").hide();
    }
}
//validate date bigger than
let daterangeError = true;
function validateDateRange() {
    var date_from = new Date($('#datefrom').val());
    var date_to = new Date($('#dateto').val());
    if (isNaN(date_from.getTime()) || isNaN(date_to.getTime())) {
        $("#datetocheck").show().html("invalid date format.");
        daterangeError = false;
        return false;
    }
    if (date_from > date_to) {
        $("#datetocheck").show().html("invalid date format.");
        daterangeError = false;
        return false;
    } else {
        $("#datetocheck").hide();
        daterangeError = true;
        return true;
    }
}
// not required pdf document
$("#notrequiredpdfcheck").hide();
let notrequiredpdfdocumentError = true;
$("#notrequiredpdf").keyup(function () {
    validateNotRequiredPDFDocument();
});
function validateNotRequiredPDFDocument() {
    let textValue = $("#notrequiredpdf")[0];
    if (textValue.files.length !== 0) {
        var uploadedfile = textValue.files[0];
        // Check the file extension
        var uploadedExtension = uploadedfile.name.split('.').pop().toLowerCase();
        if (uploadedExtension !== 'pdf') {
            $("#notrequiredpdfcheck").show();
            $("#notrequiredpdfcheck").html("**file must be pdf ");
            notrequiredpdfdocumentError = false;
            return false;
        } else {

            if (uploadedfile.size > 2000 * 1024) { // file must be less than 2Mb
                $("#notrequiredpdfcheck").show();
                $("#notrequiredpdfcheck").html("**file must be less that 2MB");
                notrequiredpdfdocumentError = false;
                return false;
            } else {
                notrequiredpdfdocumentError = true;
                $("#notrequiredpdfcheck").hide();
            }
        }
    }
}
// comment highlights not required text
$("#commentshighlightscheck").hide();
let commentshighlightsError = true;
$("#commentshighlights").keyup(function () {
    validateCommentsHighlights();
});
function validateCommentsHighlights() {
    let textValue = $("#commentshighlights").val();
    const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|<>\/?~]/;
    charscheck = specialChars.test(textValue);
    if (charscheck == true) {
        $("#commentshighlightscheck").show();
        $("#commentshighlightscheck").html("**remove characters");
        commentshighlightsError = false;
        return false;
    } else {
        commentshighlightsError = true;
        $("#commentshighlightscheck").hide();
    }
}

let groupWorkdays = [];
let holidayDates = [];
function dayToString(dayIndex) {
    return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][dayIndex];
}
function loadWorkingData(callback) {
    let groupId = $('#myusergroup').val();
    $.get('/hc/leavegroup/working-days/' + groupId, function (data) {
        groupWorkdays = data.workdays;
        holidayDates = data.holidays;
        callback();
    });
}
loadWorkingData(function () {
    $('#datefrom, #dateto').on('change', calculateLeaveDaysTaken);
});
//calculate days taken
function calculateLeaveDaysTaken() {
    var datefrom = new Date($('#datefrom').val());
    var dateto = new Date($('#dateto').val());
    var timediff = dateto.getTime() - datefrom.getTime();
    var daydiff = Math.ceil(timediff / (1000 * 3600 * 24)) + 1;
    if (isNaN(datefrom.getTime()) || isNaN(dateto.getTime())) {
        $('#daysapplied').text('0');
        return;
    }
    // if (daydiff <= 0) { $('#daysapplied').text('0 days'); }
    // else { $('#daysapplied').text(daydiff + ' day' + (daydiff > 1 ? 's' : '')); }
    let count = 0;
    let current = new Date(datefrom);
    while (current <= dateto) {
        let dayStr = dayToString(current.getDay()); // e.g., 'Mon'
        let dateStr = current.toISOString().split('T')[0]; // e.g., '2025-07-09'
        let isHoliday = holidayDates.includes(dateStr);
        let isWorkingDay = groupWorkdays.includes(dayStr);
        let worksOnHoliday = groupWorkdays.includes('Hol');

        if ((isHoliday && worksOnHoliday) || (!isHoliday && isWorkingDay)) {
            count++;
        }
        current.setDate(current.getDate() + 1);
    }
    $('#daysapplied').text(count + ' day' + (count !== 1 ? 's' : ''));

}
$('#datefrom, #dateto').on('change', function () {
    calculateLeaveDaysTaken();
});
//calculate days taken 
let daysufficientError = true;
function calculateDaysDifference() {
    let applied = parseFloat($('#daysapplied').text()) || 0;
    let available = parseFloat($('#daysavailable').text()) || 0;
    $('#daysavailable_input').val(available);
    $('#daysapplied_input').val(applied);
    if (applied > available) {
        $("#insufficientdayscheck").show().html("days not sufficient.");
        daysufficientError = false;
        return false;
    } else {
        $("#insufficientdayscheck").hide();
        daysufficientError = true;
        return true;
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
$("#btn-apply-leave").click(function () {
    validateDateTo(); validateDateFrom(); validateDateRange(); validateLeaveGroupList();
    validateNotRequiredPDFDocument(); validateCommentsHighlights(); calculateDaysDifference();
    if (datetoError == true && datefromError == true && daterangeError == true && leavegroupError == true
        && notrequiredpdfdocumentError == true && commentshighlightsError == true && daysufficientError == true
    ) {
        disableButtonAndSubmit(this, "defaultform");
    } else { return false; }
});