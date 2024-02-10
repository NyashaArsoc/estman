 //valid receipting amount
 $("#receiptaddresscheck").hide();
 let receiptingaddressError = true;
 $("#PropertyAddressDesc").keyup(function () {
     validateReceiptAddress();
 });
function validateReceiptAddress() {
    let textValue = $("#PropertyAddressDesc").val();
    if (textValue.length == "") {
        $("#receiptaddresscheck").show();
        receiptingaddressError = false;
        return false;
    } else {
        receiptingaddressError = true;
        $("#receiptaddresscheck").hide();
    }
}
//valid receipting amount
$("#receiptingcurrencycheck").hide();
let receiptingcurrencyError = true;
$("#ReceiptCurrency").keyup(function () {
    validateReceiptCurrency();
});
function validateReceiptCurrency() {
   let textValue = $("#ReceiptCurrency").val();
   if (textValue.length == "") {
       $("#receiptingcurrencycheck").show();
       receiptingcurrencyError = false;
       return false;
   } else {
       receiptingcurrencyError = true;
       $("#receiptingcurrencycheck").hide();
   }
}
 //valid receipting date
 $("#receiptdatecheck").hide();
 let receiptingdateError = true;
 $("#ReceiptDate").keyup(function () {
     validateReceiptDate();
 });
function validateReceiptDate() {
    let textValue = $("#ReceiptDate").val();
    if (textValue.length == "") {
        $("#receiptdatecheck").show();
        receiptingdateError = false;
        return false;
    } else {
        receiptingdateError = true;
        $("#receiptdatecheck").hide();
    }
}
//valid receipt amount 
$("#receiptamountcheck").hide();
let receiptamountError = true;
$("#ReceiptAmount").keyup(function() {
   validateAmtReceived();
});
function validateAmtReceived(){
    let textValue         = $("#ReceiptAmount").val();
    if (textValue == '' ){
        $("#receiptamountcheck").show();
        receiptamountError = false;
        return false;
    }else{
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
             $("#receiptamountcheck").show();
            $("#receiptamountcheck").html("**digits only or (13.5)");
            receiptamountError = false;
            return false;
        }else{
            receiptamountError = true;
            $("#receiptamountcheck").hide();
        }
    }
}
//valid remittance amount 
$("#amountprocessedcheck").hide();
let amountprocessedError = true;
$("#amountprocessed").keyup(function() {
   validateAmtRemited();
});
function validateAmtRemited(){
    let textValue         = $("#amountprocessed").val();
    if (textValue == '' ){
        $("#amountprocessedcheck").show();
        amountprocessedError = false;
        return false;
    }else{
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
             $("#amountprocessedcheck").show();
            $("#amountprocessedcheck").html("**digits only or (13.5)");
            amountprocessedError = false;
            return false;
        }else{
            amountprocessedError = true;
            $("#amountprocessedcheck").hide();
        }
    }
}
// button process receipt 
$("#add-receipt").click(function () {
    validateAmtReceived(); validateReceiptCurrency();validateReceiptDate();validateReceiptAddress();
    if(receiptamountError == true && receiptingcurrencyError==true && receiptingdateError==true
        && receiptingaddressError==true){
        //valid
        return true;
    }else{
        //failed
        return false;
    }
});
// button process remittance 
$("#btn-remit").click(function () {
    validateAmtRemited
    if(amountprocessedError==true){
        //valid
        return true;
    }else{
        //failed
        return false;
    }
});