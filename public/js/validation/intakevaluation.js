//valid client type
$("#clienttypecheck").hide();
let clienttypeError = true;
$("#clienttype").keyup(function () {
    validateClientType();
});
function validateClientType() {
    let textValue = $("#clienttype").val();
    if (textValue.length == "") {
        $("#clienttypecheck").show();
        clienttypeError = false;
        return false;
    } else {
        clienttypeError = true;
        $("#clienttypecheck").hide();
    }
}
//valid firstname
$("#firstnamecheck").hide();
let firstnameError = true;
$("#firstname").keyup(function () {
    validateFirstName();
});
function validateFirstName() {
    let firstnameValue = $("#firstname").val();
    if (firstnameValue.length == "") {
        $("#firstnamecheck").show();
        firstnameError = false;
        return false;
    } else if (firstnameValue.length < 3) {
        $("#firstnamecheck").show();
        $("#firstnamecheck").html("**invalid firstname");
        firstnameError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
        charscheck = specialChars.test(firstnameValue);
        if (charscheck == true) {
            $("#firstnamecheck").show();
            $("#firstnamecheck").html("**follow the required format/remove space/special");
            firstnameError = false;
            return false;
        } else {
            firstnameError = true;
            $("#firstnamecheck").hide();
        }
    }
}
// lastname
$("#lastnamecheck").hide();
let lastnameError = true;
$("#lastname").keyup(function () {
    validateLastName();
});
function validateLastName() {
    let lastnameValue = $("#lastname").val();
    if (lastnameValue.length == "") {
        $("#lastnamecheck").show();
        lastnameError = false;
        return false;
    } else if (lastnameValue.length < 3) {
        $("#lastnamecheck").show();
        $("#lastnamecheck").html("**invalid lastname");
        lastnameError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
        charscheck = specialChars.test(lastnameValue);
        if (charscheck == true) {
            $("#lastnamecheck").show();
            $("#lastnamecheck").html("**follow the required format/remove space/special");
            lastnameError = false;
            return false;
        } else {
            lastnameError = true;
            $("#lastnamecheck").hide();
        }
    }
}
//cel----------------
$("#cellcheck").hide();
let cellError = true;
$("#cell").keyup(function () {
    validateCell();
});
function validateCell() {
    let cellValue = $("#cell").val();
    if (cellValue.length == "") {
        $("#cellcheck").show();
        cellError = false;
        return false;
    } else if (cellValue.length < 10) {
        $("#cellcheck").show();
        $("#cellcheck").html("**invalid cell");
        cellError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_\-=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(cellValue);
        if (charscheck == true) {
            $("#cellcheck").show();
            $("#cellcheck").html("**follow the required format 0701000123 or +263701000123");
            cellError = false;
            return false;
        } else {
            cellError = true;
            $("#cellcheck").hide();
        }
    }
}
//valid email
$("#emailcheck").hide();
let emailError = true;
$("#email").keyup(function () {
    validateEmail();
});
function validateEmail() {
    let emailValue = $("#email").val();
    if (emailValue.length == "") {
        $("#emailcheck").show();
        emailError = false;
        return false;
    } else {
        const emailvalid = document.getElementById("email");
        emailvalid.addEventListener("blur", () => {
            let regex =
                /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
            let emailvalue = emailvalid.value;
            if (regex.test(emailvalue)) {
                $("#emailcheck").hide();
                emailError = true;
            } else {
                $("#emailcheck").show();
                $("#emailcheck").html("**follow the required format example@example.com");
                emailError = false;
                return false;
            }
        });
    }
}
//valid contact person firstname
$("#contactfirstnamecheck").hide();
let contactfirstnameError = true;
$("#contactfirstname").keyup(function () {
    validateContactFirstName();
});
function validateContactFirstName() {
    let textValue = $("#contactfirstname").val();
    if (textValue.length == "") {
        $("#contactfirstnamecheck").show();
        contactfirstnameError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#contactfirstnamecheck").show();
        $("#contactfirstnamecheck").html("**invalid firstname");
        contactfirstnameError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#contactfirstnamecheck").show();
            $("#contactfirstnamecheck").html("**follow the required format");
            contactfirstnameError = false;
            return false;
        } else {
            contactfirstnameError = true;
            $("#contactfirstnamecheck").hide();
        }
    }
}
//valid contact person lastname
$("#contactlastnamecheck").hide();
let contactlastnameError = true;
$("#contactlastname").keyup(function () {
    validateContactLastName();
});
function validateContactLastName() {
    let textValue = $("#contactlastname").val();
    if (textValue.length == "") {
        $("#contactlastnamecheck").show();
        contactlastnameError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#contactlastnamecheck").show();
        $("#contactlastnamecheck").html("**invalid lastname");
        contactlastnameError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#contactlastnamecheck").show();
            $("#contactlastnamecheck").html("**follow the required format");
            contactlastnameError = false;
            return false;
        } else {
            contactlastnameError = true;
            $("#contactlastnamecheck").hide();
        }
    }
}
//valid contact person cell
$("#contactcellcheck").hide();
let contactcellError = true;
$("#contactcell").keyup(function () {
    validateContactCell();
});
function validateContactCell() {
    let textValue = $("#contactcell").val();
    if (textValue.length == "") {
        $("#contactcellcheck").show();
        contactcellError = false;
        return false;
    } else if (textValue.length < 10) {
        $("#contactcellcheck").show();
        $("#contactcellcheck").html("**invalid cell");
        contactcellError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_\-=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#contactcellcheck").show();
            $("#contactcellcheck").html("**follow the required format 0701000123 or +263701000123");
            contactcellError = false;
            return false;
        } else {
            contactcellError = true;
            $("#contactcellcheck").hide();
        }
    }
}
//valid contact email
$("#contactemailcheck").hide();
let contactemailError = true;
$("#contactemail").keyup(function () {
    validateContactEmail();
});
function validateContactEmail() {
    let textValue = $("#contactemail").val();
    if (textValue.length == "") {
        $("#contactemailcheck").show();
        contactemailError = false;
        return false;
    } else {
        const emailvalid = document.getElementById("contactemail");
        emailvalid.addEventListener("blur", () => {
            let regex =
                /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
            let textValue = emailvalid.value;
            if (regex.test(textValue)) {
                $("#contactemailcheck").hide();
                contactemailError = true;
            } else {
                $("#contactemailcheck").show();
                $("#contactemailcheck").html("**follow the required format example@example.com");
                contactemailError = false;
                return false;
            }
        });
    }
}
//valid company name
$("#companynamecheck").hide();
let companynameError = true;
$("#companyname").keyup(function () {
    validateCompanyName();
});
function validateCompanyName() {
    let textValue = $("#companyname").val();
    if (textValue.length == "") {
        $("#companynamecheck").show();
        companynameError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#companynamecheck").show();
        $("#companynamecheck").html("**invalid company name");
        companynameError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#companynamecheck").show();
            $("#companynamecheck").html("**follow the required format");
            companynameError = false;
            return false;
        } else {
            companynameError = true;
            $("#companynamecheck").hide();
        }
    }
}
//valid property type
$("#propertytypecheck").hide();
let propertytypeError = true;
$("#propertytype").keyup(function () {
    validatePropertyType();
});
function validatePropertyType() {
    let textValue = $("#propertytype").val();
    if (textValue.length == "") {
        $("#propertytypecheck").show();
        propertytypeError = false;
        return false;
    } else {
        propertytypeError = true;
        $("#propertytypecheck").hide();
    }
}
//valid property surbub
$("#propertysurbubcheck").hide();
let propertysurbubError = true;
$("#propertysurbub").keyup(function () {
    validatePropertySurbub();
});
function validatePropertySurbub() {
    let textValue = $("#propertysurbub").val();
    if (textValue.length == "") {
        $("#propertysurbubcheck").show();
        propertysurbubError = false;
        return false;
    } else {
        propertysurbubError = true;
        $("#propertysurbubcheck").hide();
    }
}
//valid property address
$("#propertyaddresscheck").hide();
let propertyaddressError = true;
$("#propertyaddress").keyup(function () {
    validatePropertyAddress();
});
function validatePropertyAddress() {
    let textValue = $("#propertyaddress").val();
    if (textValue.length == "") {
        $("#propertyaddresscheck").show();
        propertyaddressError = false;
        return false;
    } else if (textValue.length < 5) {
        $("#propertyaddresscheck").show();
        $("#propertyaddresscheck").html("**invalid address");
        propertyaddressError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_\-=\[\]{};':"\\|,.<>?~\/]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#propertyaddresscheck").show();
            $("#propertyaddresscheck").html("**remove special chars");
            propertyaddressError = false;
            return false;
        } else {
            propertyaddressError = true;
            $("#propertyaddresscheck").hide();
        }
    }
}
//valid client name
$("#propertyclientnamecheck").hide();
let propertyclientnameError = true;
$("#propertyclientname").keyup(function () {
    validatePropertyClientName();
});
function validatePropertyClientName() {
    let textValue = $("#propertyclientname").val();
    if (textValue.length == "") {
        $("#propertyclientnamecheck").show();
        propertyclientnameError = false;
        return false;
    } else {
        propertyclientnameError = true;
        $("#propertyclientnamecheck").hide();
    }
}

/*---------------------button submit------------------------------------------*/
//button disable submit
function disableButtonAndSubmit(button, id) {
    // Disable the button
    $(button).prop('disabled', true);
    $(button).css('background-color', '#ccc');
    $(button).text('submitting...'); // Change button text
    // Submit the form
    $("#" + id).submit();
}
/*-----------------------------add loan products details table ----------------------- */
$('#add-new-property-item').on('click', function () {
    var propertyaddress = $('#propertyaddress').val();
    var propertytype = $('#propertytype').val();
    var propertysurbub = $('#propertysurbub').val();
    var count = $('#addpropertyitem tr').length - 1;

    validatePropertyAddress(); validatePropertyType(); validatePropertySurbub();

    try {
        if (propertytypeError == true && propertysurbubError == true && propertyaddressError == true && count < 11) {

            var newRow = $('<tr class="child">');

            newRow.append('<td>' + count + '</td>');
            newRow.append('<td><input name="propertytype[]" class="form-control" value="' + propertytype + '" readonly /></td>');
            newRow.append('<td><input name="propertysurbub[]" class="form-control" value="' + propertysurbub + '" readonly /></td>');
            newRow.append('<td><input name="propertyaddress[]" class="form-control" value="' + propertyaddress + '" readonly /></td>');
            newRow.append('<td><button style="text-align: right;" class="btn btn-danger delete-row" type="button">Delete</button></td>');

            $('#addpropertyitem tbody').append(newRow);

            $('#propertyaddress').val(''); $('#propertytype').val(''); $('#propertysurbub').val('');
        } else if (count >= 11) {
            alert("the maximum number of rows (10).");
        }
    } catch (err) {
        alert(err.message);
    }
});
$('#addpropertyitem tbody').on('click', '.delete-row', function () {
    var a = $("#addpropertyitem > tbody > tr").length;
    if (a <= 1) {
        alert("There must be at least one row.");
    } else {
        $(this).closest('tr').remove();
    }
});
// add val new client
$("#btn-val-new-client").click(function () {
    validateClientType(); validateCell(); validateEmail();
    var clienttypevalue = $("#clienttype").val();
    try {
        if (clienttypevalue == 1) {
            validateFirstName(); validateLastName();
            if (cellError == true && emailError == true && clienttypeError == true &&
                firstnameError == true && lastnameError == true) { disableButtonAndSubmit(this, "defaultform"); } else { return false }
        } else {
            validateCompanyName(); validateContactFirstName(); validateContactLastName();
            validateContactCell(); validateContactEmail();
            if (cellError == true && emailError == true && contactcellError == true &&
                contactfirstnameError == true && contactlastnameError == true && contactemailError == true
                && clienttypeError == true && companynameError == true) { disableButtonAndSubmit(this, "defaultform"); } else { return false }
        }
    } catch (err) {
        alert(err.message);
        return false;
    }
});
// add val new property
$("#btn-val-new-property").click(function () {
    validatePropertyClientName();
    try {
        if (propertyclientnameError) { disableButtonAndSubmit(this, "defaultform"); }
        else { return false; }
    } catch (err) {
        alert(err.message);
        return false;
    }
});