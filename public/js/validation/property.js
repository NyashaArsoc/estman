$(document).ready(function () { 

//valid security charges
$("#remitcalcdeductionscheck").hide();
$("#securitychargecheck").hide();
let securitychargesError = true;
$("#SecurityCharge").keyup(function () {
    validateSecurityCharge();
});
function validateSecurityCharge() {
    let textPaid        = $("#BillCollections").val();
    let textVal         = $("#BillVAT").val();
    let textRate        = $("#BillRates").val();
    let textOpp         = $("#BillOppC").val();
    let textInt         = $("#BillInterest").val();
    let textCharge_1    = $("#CaretakerCharge").val();
    let textCharge_2    = $("#OtherExpensesCharge").val();
    let textValue       = $("#SecurityCharge").val();
    if(textVal==''){textVal=0;} if(textRate==''){textRate=0;}
    if(textOpp==''){textOpp=0;} if(textInt==''){textInt=0;}
    if(textCharge_1==''){textCharge_1=0;} if(textCharge_2==''){textCharge_2=0;}
    if (textValue.length != "") {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#securitychargecheck").show();
            $("#securitychargecheck").html("**digits only or (3.5)");
            securitychargesError = false;
            return false;
        }else{
            TotalDeductions  = (parseFloat(textVal) +
                parseFloat(textRate) + parseFloat(textOpp) +parseFloat(textInt) +
                parseFloat(textCharge_1) + parseFloat(textCharge_2) + parseFloat(textValue));
            TotalRemittance = textPaid - TotalDeductions;
            securitychargesError = true;
            $("#securitychargecheck").hide();
            $("#remitcalcdeductionscheck").show();
            $("#remitcalcdeductionscheck").html(TotalDeductions);
            $("#remitcalcremittancecheck").show();
            $("#remitcalcremittancecheck").html(TotalRemittance);
        }
    } else if (textValue.length > 12) {
        $("#securitychargecheck").show();
        $("#securitychargecheck").html("**twelve digits allowed");
        securitychargesError = false;
        return false;
    }
}
$("#caretakerchargecheck").hide();
let caretakerchargesError = true;
$("#CaretakerCharge").keyup(function () {
    validateCaretakerCharge();
});
function validateCaretakerCharge() {
    let textPaid        = $("#BillCollections").val();
    let textVal         = $("#BillVAT").val();
    let textRate        = $("#BillRates").val();
    let textOpp         = $("#BillOppC").val();
    let textInt         = $("#BillInterest").val();
    let textCharge_1    = $("#SecurityCharge").val();
    let textCharge_2    = $("#OtherExpensesCharge").val();
    if(textVal==''){textVal=0;} if(textRate==''){textRate=0;}
    if(textOpp==''){textOpp=0;} if(textInt==''){textInt=0;}
    if(textCharge_1==''){textCharge_1=0;} if(textCharge_2==''){textCharge_2=0;}
    let textValue = $("#CaretakerCharge").val();
    if (textValue.length != "") {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#caretakerchargecheck").show();
            $("#caretakerchargecheck").html("**digits only or (3.5)");
            caretakerchargesError = false;
            return false;
        }else{
            TotalDeductions  = (parseFloat(textVal) +
                parseFloat(textRate) + parseFloat(textOpp) +parseFloat(textInt) +
                parseFloat(textCharge_1) + parseFloat(textCharge_2) + parseFloat(textValue));
                TotalRemittance = textPaid - TotalDeductions;
            caretakerchargesError = true;
            $("#caretakerchargecheck").hide();
            $("#remitcalcdeductionscheck").show();
            $("#remitcalcdeductionscheck").html(TotalDeductions);
            $("#remitcalcremittancecheck").show();
            $("#remitcalcremittancecheck").html(TotalRemittance);
        }
    } else if (textValue.length > 12) {
        $("#caretakerchargecheck").show();
        $("#caretakerchargecheck").html("**twelve digits allowed");
        caretakerchargesError = false;
        return false;
    }
}
$("#otherexpensecheck").hide();
let expensechargesError = true;
$("#OtherExpensesCharge").keyup(function () {
    validateOtherExpensesCharge();
});
function validateOtherExpensesCharge() {
    let textPaid        = $("#BillCollections").val();
    let textVal         = $("#BillVAT").val();
    let textRate        = $("#BillRates").val();
    let textOpp         = $("#BillOppC").val();
    let textInt         = $("#BillInterest").val();
    let textCharge_1    = $("#SecurityCharge").val();
    let textCharge_2    = $("#CaretakerCharge").val();
    if(textVal==''){textVal=0;} if(textRate==''){textRate=0;}
    if(textOpp==''){textOpp=0;} if(textInt==''){textInt=0;}
    if(textCharge_1==''){textCharge_1=0;} if(textCharge_2==''){textCharge_2=0;}
    let textValue = $("#OtherExpensesCharge").val();
    if (textValue.length != "") {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#otherexpensecheck").show();
            $("#otherexpensecheck").html("**digits only or (3.5)");
            expensechargesError = false;
            return false;
        }else{
            TotalDeductions  = (parseFloat(textVal) +
                parseFloat(textRate) + parseFloat(textOpp) +parseFloat(textInt) +
                parseFloat(textCharge_1) + parseFloat(textCharge_2) + parseFloat(textValue));
                TotalRemittance = textPaid - TotalDeductions;
            expensechargesError = true;
            $("#otherexpensecheck").hide();
            $("#remitcalcdeductionscheck").show();
            $("#remitcalcdeductionscheck").html(TotalDeductions);
            $("#remitcalcremittancecheck").show();
            $("#remitcalcremittancecheck").html(TotalRemittance);
        }
    } else if (textValue.length > 12) {
        $("#otherexpensecheck").show();
        $("#otherexpensecheck").html("**twelve digits allowed");
        expensechargesError = false;
        return false;
    }
}

// button reject 
$("#btn-pre-remit").click(function () {
    validateSecurityCharge();validateCaretakerCharge();validateOtherExpensesCharge();

    if(securitychargesError == true && caretakerchargesError==true && expensechargesError==true ){
        //valid
        return true;
    }else{
        //failed
        return false;
    }

});
});