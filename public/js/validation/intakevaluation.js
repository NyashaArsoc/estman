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
$("#portfolioduedatecheck").hide();
let portfolioduedateError = true;
$("#portfolioduedate").keyup(function () {
    validatePortfolioDueDate();
});
function validatePortfolioDueDate() {
    let textValue = $("#portfolioduedate").val();
    if (textValue.length == "") {
        $("#portfolioduedatecheck").show();
        portfolioduedateError = false;
        return false;
    } else {
        portfolioduedateError = true;
        $("#portfolioduedatecheck").hide();
    }
}
//valid total number of portfolio
$("#totalnumberpropertyportfoliocheck").hide();
let totalnumberpropertyportfolioError = true;
$("#totalnumberpropertyportfolio").keyup(function () {
    validateNoOfPortfolioProperty();
});
function validateNoOfPortfolioProperty() {
    let textValue = $("#totalnumberpropertyportfolio").val();
    if (textValue.length == "") {
        $("#totalnumberpropertyportfoliocheck").show();
        totalnumberpropertyportfolioError = false;
        return false;
    } else if (textValue.length < 1) {
        $("#totalnumberpropertyportfoliocheck").show();
        $("#totalnumberpropertyportfoliocheck").html("**at least ten properties");
        totalnumberpropertyportfolioError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#totalnumberpropertyportfoliocheck").show();
            $("#totalnumberpropertyportfoliocheck").html("**digits only or (35)");
            totalnumberpropertyportfolioError = false;
            return false;
        } else {
            totalnumberpropertyportfolioError = true;
            $("#totalnumberpropertyportfoliocheck").hide();
        }
    }
}
//valid valuationpaymentagreement
$("#valuationpaymentagreementcheck").hide();
let valuationpaymentagreementError = true;
$("#valuationpaymentagreement").keyup(function () {
    validateValuationPaymentAgreement();
});
function validateValuationPaymentAgreement() {
    let textValue = $("#valuationpaymentagreement").val();
    if (textValue.length == "") {
        $("#valuationpaymentagreementcheck").show();
        valuationpaymentagreementError = false;
        return false;
    } else {
        valuationpaymentagreementError = true;
        $("#valuationpaymentagreementcheck").hide();
    }
}
//valid valuationpurpose
$("#valuationpurposecheck").hide();
let valuationpurposeError = true;
$("#valuationpurpose").keyup(function () {
    validateValuationPurpose();
});
function validateValuationPurpose() {
    let textValue = $("#valuationpurpose").val();
    if (textValue.length == "") {
        $("#valuationpurposecheck").show();
        valuationpurposeError = false;
        return false;
    } else {
        valuationpurposeError = true;
        $("#valuationpurposecheck").hide();
    }
}
//valid valuationtype 
$("#valuationtypecheck").hide();
let valuationtypeError = true;
$("#valuationtype").keyup(function () {
    validateClientContactName();
});
function validateValuationType() {
    let textValue = $("#valuationtype").val();
    if (textValue.length == "") {
        $("#valuationtypecheck").show();
        valuationtypeError = false;
        return false;
    } else {
        valuationtypeError = true;
        $("#valuationtypecheck").hide();
    }
}
//valid client contact name
$("#clientcontactnamecheck").hide();
let clientcontactnameError = true;
$("#clientcontactname").keyup(function () {
    validateClientContactName();
});
function validateClientContactName() {
    let textValue = $("#clientcontactname").val();
    if (textValue.length == "") {
        $("#clientcontactnamecheck").show();
        clientcontactnameError = false;
        return false;
    } else {
        clientcontactnameError = true;
        $("#clientcontactnamecheck").hide();
    }
}
//valid valuationpaymentagreement
$("#valuernamecheck").hide();
let valuernameError = true;
$("#valuername").keyup(function () {
    validateValuationValuerName();
});
function validateValuationValuerName() {
    let textValue = $("#valuername").val();
    if (textValue.length == "") {
        $("#valuernamecheck").show();
        valuernameError = false;
        return false;
    } else {
        valuernameError = true;
        $("#valuernamecheck").hide();
    }
}
//valid valuationpaymentagreement
$("#portfolionamecheck").hide();
let portfolionameError = true;
$("#portfolioname").keyup(function () {
    validateInstructionPortfolioName();
});
function validateInstructionPortfolioName() {
    let textValue = $("#portfolioname").val();
    if (textValue.length == "") {
        $("#portfolionamecheck").show();
        portfolionameError = false;
        return false;
    } else {
        portfolionameError = true;
        $("#portfolionamecheck").hide();
    }
}
$("#reasonscheck").hide();
let reasonsError = true;
$("#reasonsfordecline").keyup(function () {
    validateReasonsComment();
});
function validateReasonsComment() {
    let textValue = $("#reasonsfordecline").val();
    if (textValue.length == "") {
        $("#reasonscheck").show();
        reasonsError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#reasonscheck").show();
        $("#reasonscheck").html("**write a proper comment");
        reasonsError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#reasonscheck").show();
            $("#reasonscheck").html("**follow the required format");
            reasonsError = false;
            return false;
        } else {
            reasonsError = true;
            $("#reasonscheck").hide();
        }
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
// add val create portfolio
$("#btn-val-new-portfolio").click(function () {
    validatePortfolioDueDate(); validateNoOfPortfolioProperty();
    validateValuationPaymentAgreement(); validateValuationPurpose();
    validateValuationType(); validateClientContactName();
    try {
        if (portfolioduedateError == true && totalnumberpropertyportfolioError == true &&
            valuationpaymentagreementError == true && valuationpurposeError == true &&
            valuationtypeError == true && clientcontactnameError == true) {
            disableButtonAndSubmit(this, "defaultform");
        } else { return false; }
    } catch (err) {
        return false;
    }
});
// add val new portfolio instruction
$("#btn-val-instr-portfolio-1").click(function () {
    validateValuationValuerName(); validateInstructionPortfolioName();
    try {
        if (valuernameError == true && portfolionameError == true) { disableButtonAndSubmit(this, "defaultform"); }
        else { return false; }
    } catch (err) {
        return false;
    }
});
$("#btn-allocate").click(function () {
    disableButtonAndSubmit(this, "defaultform");
});
// add val new normal instruction
$("#btn-val-instr-normal-1").click(function () {
    validateValuationValuerName(); validatePortfolioDueDate();
    validateValuationPaymentAgreement(); validateValuationPurpose();
    validateValuationType(); validateClientContactName();
    try {
        if (valuernameError == true && valuationpaymentagreementError == true && portfolioduedateError == true &&
            valuationpurposeError == true && valuationtypeError == true &&
            clientcontactnameError == true) { disableButtonAndSubmit(this, "defaultform"); }
        else { return false; }
    } catch (err) {
        return false;
    }
});