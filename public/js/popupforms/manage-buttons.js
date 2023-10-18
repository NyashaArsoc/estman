function approvelandlord(that) {
    var proceedto = confirm("proceed to approve this landlord?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function rejectlandlord(that) {
    var proceedto = confirm("proceed to reject this landlord?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}

function deletelandlord(that) {
    var proceedto = confirm("proceed to delete this landlord?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}

function approvetenant(that) {
    var proceedto = confirm("proceed to approve this tenant?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}

function rejecttenant(that) {
    var proceedto = confirm("proceed to reject this tenant?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}

function approveproperty(that) {
    var proceedto = confirm("proceed to approve this property?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function rejectproperty(that) {
    var proceedto = confirm("proceed to reject this property?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function deleteproperty(that) {
    var proceedto = confirm("proceed to delete this property?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function DeleteLandlord(that) {
    var Func_DeleteLandlord = confirm("Proceed to delete this landlord?")
    if (Func_DeleteLandlord) {
        window.location = anchor.attr("href");
    }
}
function RestoreLandlord(that) {
    var Func_RestoreLandlord = confirm("Proceed to restore this landlord?")
    if (Func_RestoreLandlord) {
        window.location = anchor.attr("href");
    }
}
function ReactivateLandlord(that) {
    var Func_RestoreLandlord = confirm("Proceed to reactivate this landlord?")
    if (Func_RestoreLandlord) {
        window.location = anchor.attr("href");
    }
}