function approveentry(that) {
    var proceedto = confirm("proceed to approve this entry?")
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
function approvelease(that) {
    var proceedto = confirm("proceed to approve this lease?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function rejectlease(that) {
    var proceedto = confirm("proceed to reject this lease?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function approveprofomaedited(that) {
    var proceedto = confirm("proceed to approve this edited profoma?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}

function deactivaterecord(that) {
    var proceedto = confirm("proceed to disable this entry?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function rejectapproval(that) {
    var proceedto = confirm("proceed to decline?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function closeportfolio(that) {
    var proceedto = confirm("proceed to close portfolio?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function closeportfolioreview(that) {
    var proceedto = confirm("all corrections completed on this report?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function deleterecord(that) {
    var proceedto = confirm("proceed to delete this entry?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
function activaterecord(that) {
    var proceedto = confirm("proceed to activate this entry?")
    if (proceedto) {
        window.location = anchor.attr("href");
    }
}
//download rent summary
function rentsummary(that) {
    var proceedto = confirm("proceed to download?")
    if (proceedto) {
        var $button = $(that); // Convert 'that' to a jQuery object
        $button.prop("disabled", true)
            .css({ "pointer-events": "none", "background-color": "#ccc", "border-color": "#ccc" })
            .html('loading');
        window.location.href = $button.attr("href");
    }
}