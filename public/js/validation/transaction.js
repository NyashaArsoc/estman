 
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