function changesection(select) {
    const value = select.value;
    productsection.style.display = value === 'product' ? 'block' : 'none';
    servicesection.style.display = value === 'service' ? 'block' : 'none';
}


function calculateProductTotal() {
    let productqty = $('#productqty').val() || 0;
    let productrate = $('#productrate').val() || 0;
    let productvat = $('#productvat').val() || 0;
    let totalvalue = ((parseFloat(productqty) * parseFloat(productrate)) + parseFloat(productvat)).toFixed(2);
    $("#producttotal").html(totalvalue);
}
function calculateServiceTotal() {
    let servicerate = $('#servicerate').val() || 0;
    let servicevat = $('#servicevat').val() || 0;
    let totalvalue = (parseFloat(servicerate) + parseFloat(servicevat)).toFixed(2);
    $("#servicetotal").html(totalvalue);
}
$('#productqty, #productvat, #productrate').on('change', function () {
    calculateProductTotal();
});
$('#servicevat, #servicerate').on('change', function () {
    calculateServiceTotal();
});
//valid product Item
$("#productitemcheck").hide();
let productitemError = true;
$("#productitem").keyup(function () {
    validateProductItem();
});
function validateProductItem() {
    let textValue = $("#productitem").val();
    if (textValue.length == "") {
        $("#productitemcheck").show();
        productitemError = false;
        return false;
    } else if (textValue.length < 5) {
        $("#productitemcheck").show();
        $("#productitemcheck").html("**invalid Description");
        productitemError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_\-=\[\]{};':"\\|,.<>?~\/]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#productitemcheck").show();
            $("#productitemcheck").html("**remove special chars");
            productitemError = false;
            return false;
        } else {
            productitemError = true;
            $("#productitemcheck").hide();
        }
    }
}
//valid product Item
$("#serviceitemcheck").hide();
let serviceitemError = true;
$("#serviceitem").keyup(function () {
    validateServiceItem();
});
function validateServiceItem() {
    let textValue = $("#serviceitem").val();
    if (textValue.length == "") {
        $("#serviceitemcheck").show();
        serviceitemError = false;
        return false;
    } else if (textValue.length < 5) {
        $("#serviceitemcheck").show();
        $("#serviceitemcheck").html("**invalid address");
        serviceitemError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_\-=\[\]{};':"\\|,.<>?~\/]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#serviceitemcheck").show();
            $("#serviceitemcheck").html("**remove special chars");
            serviceitemError = false;
            return false;
        } else {
            serviceitemError = true;
            $("#serviceitemcheck").hide();
        }
    }
}
//valid product qty
$("#productqtycheck").hide();
let productqtyError = true;
$("#productqty").keyup(function () {
    validateProductQty();
});
function validateProductQty() {
    let textValue = $("#productqty").val();
    if (textValue.length == "") {
        $("#productqtycheck").show();
        productqtyError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#productqtycheck").show();
            $("#productqtycheck").html("**digits only or (3.5)");
            productqtyError = false;
            return false;
        } else {
            productqtyError = true;
            $("#productqtycheck").hide();
        }
    }
}
//valid product rate
$("#productratecheck").hide();
let productrateError = true;
$("#productrate").keyup(function () {
    validateProductRate();
});
function validateProductRate() {
    let textValue = $("#productrate").val();
    if (textValue.length == "") {
        $("#productratecheck").show();
        productrateError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#productratecheck").show();
            $("#productratecheck").html("**digits only or (3.5)");
            productrateError = false;
            return false;
        } else {
            productrateError = true;
            $("#productratecheck").hide();
        }
    }
}
//valid service rate
$("#serviceratecheck").hide();
let servicerateError = true;
$("#servicerate").keyup(function () {
    validateServiceRate();
});
function validateServiceRate() {
    let textValue = $("#servicerate").val();
    if (textValue.length == "") {
        $("#serviceratecheck").show();
        servicerateError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck = specialChars.test(textValue);
        if (charscheck == true) {
            $("#serviceratecheck").show();
            $("#serviceratecheck").html("**digits only or (3.5)");
            servicerateError = false;
            return false;
        } else {
            servicerateError = true;
            $("#serviceratecheck").hide();
        }
    }
}
//valid product vat
$("#productvatcheck").hide();
let productvatError = true;
$("#productvat").keyup(function () {
    validateProductVaT();
});
function validateProductVaT() {
    let textValue = $("#productvat").val();

    const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
    charscheck = specialChars.test(textValue);
    if (charscheck == true) {
        $("#productvatcheck").show();
        $("#productvatcheck").html("**digits only or (3.5)");
        productvatError = false;
        return false;
    } else {
        productvatError = true;
        $("#productvatcheck").hide();
    }

}
//valid service vat
$("#servicevatcheck").hide();
let servicevatError = true;
$("#servicevat").keyup(function () {
    validateServiceVaT();
});
function validateServiceVaT() {
    let textValue = $("#servicevat").val();
    const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
    charscheck = specialChars.test(textValue);
    if (charscheck == true) {
        $("#servicevatcheck").show();
        $("#servicevatcheck").html("**digits only or (3.5)");
        servicevatError = false;
        return false;
    } else {
        servicevatError = true;
        $("#servicevatcheck").hide();
    }

}
/*-----------------------------add more lines to the requisition ----------------------- */
$('#add-new-product-item').on('click', function () {

    const productitem = $('#productitem').val();
    const productqty = $('#productqty').val();
    const productrate = $('#productrate').val();
    const productvat = $('#productvat').val();
    const producttotal = $('#producttotal').text();
    const count = $('#productbody tr').length - 1;
    validateProductVaT(); validateProductItem(); validateProductQty(); validateProductRate();

    try {
        if (productitemError == true && productqtyError == true && productrateError == true && productvatError == true && count < 11) {

            const newRow = $('<tr class="child">');
            newRow.append('<td><input name="productitem[]" class="form-control" value="' + productitem + '" readonly /></td>');
            newRow.append('<td><input name="productqty[]" class="form-control" value="' + productqty + '" readonly /></td>');
            newRow.append('<td><input name="productrate[]" class="form-control" value="' + productrate + '" readonly /></td>');
            newRow.append('<td><input name="productvat[]" class="form-control" value="' + productvat + '" readonly /></td>');
            newRow.append('<td><input name="producttotal[]" class="form-control" value="' + producttotal + '" readonly /></td>');
            newRow.append('<td><button style="text-align: right;" class="btn btn-danger delete-productrow" type="button">Delete</button></td>');
            $('#productbody tbody').append(newRow);
            $('#productitem').val(''); $('#productqty').val(''); $('#productvat').val(''); $('#productrate').val('');
        } else if (count >= 11) {
            alert("the maximum number of rows (10).");
        }
    } catch (err) {
        alert(err.message);
    }
});
$('#add-new-service-item').on('click', function () {
    const serviceitem = $('#serviceitem').val();
    const servicerate = $('#servicerate').val();
    const servicevat = $('#servicevat').val();
    const servicetotal = $('#servicetotal').text();
    const count = $('#servicebody tr').length - 1;
    validateServiceVaT(); validateServiceItem(); validateServiceRate();
    try {
        if (serviceitemError == true && servicerateError == true && servicevatError == true && count < 11) {

            const newRowService = $('<tr class="child">');
            newRowService.append('<td><input name="serviceitem[]" class="form-control" value="' + serviceitem + '" readonly /></td>');
            newRowService.append('<td><input name="servicerate[]" class="form-control" value="' + servicerate + '" readonly /></td>');
            newRowService.append('<td><input name="servicevat[]" class="form-control" value="' + servicevat + '" readonly /></td>');
            newRowService.append('<td><input name="servicetotal[]" class="form-control" value="' + servicetotal + '" readonly /></td>');
            newRowService.append('<td><button style="text-align: right;" class="btn btn-danger delete-servicerow" type="button">Delete</button></td>');
            $('#servicebody tbody').append(newRowService);
            $('#serviceitem').val(''); $('#servicerate').val(''); $('#servicevat').val('');
        } else if (count >= 11) {
            alert("the maximum number of rows (10).");
        }
    } catch (err) {
        alert(err.message);
    }
});
$('#productbody tbody').on('click', '.delete-productrow', function () {
    var a = $("#productbody > tbody > tr").length;
    if (a <= 1) {
        alert("There must be at least one row.");
    } else {
        $(this).closest('tr').remove();
    }
});
$('#servicebody tbody').on('click', '.delete-servicerow', function () {
    var a = $("#servicebody > tbody > tr").length;
    if (a <= 1) {
        alert("There must be at least one row.");
    } else {
        $(this).closest('tr').remove();
    }
});
//RequisitionType
$("#requisitiontypecheck").hide();
let requisitiontypeError = true;
$("#requisitiontype").keyup(function () {
    validateRequisitionType();
});
function validateRequisitionType() {
    let textValue = $("#requisitiontype").val();
    if (textValue.length == "") {
        $("#requisitiontypecheck").show();
        requisitiontypeError = false;
        return false;
    } else {
        requisitiontypeError = true;
        $("#requisitiontypecheck").hide();
    }
}
//ApprovalMode
$("#approvalmodecheck").hide();
let approvalmodeError = true;
$("#approvalmode").keyup(function () {
    validateApprovalMode();
});
function validateApprovalMode() {
    let textValue = $("#approvalmode").val();
    if (textValue.length == "") {
        $("#approvalmodecheck").show();
        approvalmodeError = false;
        return false;
    } else {
        approvalmodeError = true;
        $("#approvalmodecheck").hide();
    }
}
// approvers
$("#approverscheck").hide();
let approversError = true;
$("#approvers").keyup(function () {
    validateApprovers();
});
function validateApprovers() {
    let textValue = $("#approvers").val();
    if (textValue.length == "") {
        $("#approverscheck").show();
        approversError = false;
        return false;
    } else {
        approversError = true;
        $("#approverscheck").hide();
    }
}
// currencycode
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
//button submit requisition
$("#btn-submit-requisition").click(function () {
    validateRequisitionType(); validateApprovalMode(); validateApprovers(); validateCurrencyCode();
    if (requisitiontypeError == true && approvalmodeError == true && approversError == true && currencycodeError == true) {
        disableButtonAndSubmit(this, "defaultform");
    } else { return false; }
});
