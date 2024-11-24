//valid currency type
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
    } else if (textValue.length < 2 || textValue.length > 3) {
        $("#currencycodecheck").show();
        $("#currencycodecheck").html("**invalid currency code");
        currencycodeError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/a-z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#currencycodecheck").show();
                $("#currencycodecheck").html("**follow the required format (ZWL/GBP)");
                currencycodeError = false;
                return false;
            }else{
                currencycodeError = true;
                $("#currencycodecheck").hide();
            }
    }
}
//valid text description
$("#textdescriptioncheck").hide();
let textdescriptionError = true;
$("#textdescription").keyup(function () {
    validateTextDescription();
});
function validateTextDescription() {
    let textValue = $("#textdescription").val();
    if (textValue.length == "") {
        $("#textdescriptioncheck").show();
        textdescriptionError = false;
        return false;
    } else if (textValue.length < 2 ) {
        $("#textdescriptioncheck").show();
        $("#textdescriptioncheck").html("**invalid text");
        textdescriptionError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#textdescriptioncheck").show();
                $("#textdescriptioncheck").html("**follow the required format (Description)");
                textdescriptionError = false;
                return false;
            }else{
                textdescriptionError = true;
                $("#textdescriptioncheck").hide();
            }
    }
}
//period
$("#periodrangecheck").hide();
let periodrangeError = true;
$("#periodrange").keyup(function () {
    validatePeriodRange();
});
function validatePeriodRange() {
    let textValue = $("#periodrange").val();
    if (textValue.length == "") {
        $("#periodrangecheck").show();
        periodrangeError = false;
        return false;
    } else {
        periodrangeError = true;
        $("#periodrangecheck").hide();
    }
}
// lease list by tenant
$("#leaselistcheck").hide();
  let leasenameError = true;
  $("#leaselist").keyup(function () {
      validateLeaseDescription();
  });
  function validateLeaseDescription() {
      let textValue = $("#leaselist").val();
      if (textValue.length == "") {
          $("#leaselistcheck").show();
          leasenameError = false;
          return false;
      } else {
        leasenameError = true;
          $("#leaselistcheck").hide();
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
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#numericrequiredcheck").show();
                $("#numericrequiredcheck").html("**digits only or (3.5)");
                numericrequiredError = false;
                return false;
            }else{
                numericrequiredError = true;
                $("#numericrequiredcheck").hide();
            }
    }
}
/*--------------------starting buttons --------------------------*/
 //button currency code
 $("#btn-submit-currency").click(function () {
    validateCurrencyCode();
    try {
        if (currencycodeError == true ){return true;
        }else{ return false;}
    } catch (err) { return false;}
});
 //button single text
 $("#btn-submit-single-text").click(function () {
    validateTextDescription();
    try {
        if (textdescriptionError == true ){return true;
        }else{ return false; }
    } catch (err) { return false;}
});
 //button lease interest
 $("#btn-submit-lease-interest").click(function () {
    validateNumericValueRequired(); validateLeaseDescription();validatePeriodRange();
    try {
        if (numericrequiredError == true && periodrangeError==true && leasenameError==true ){return true;
        }else{ return false;}
    } catch (err) { return false;}
});
 //button lease interest
 $("#btn-submit-vat-config").click(function () {
    validateNumericValueRequired(); validateLeaseDescription();
    try {
        if (numericrequiredError == true && leasenameError==true ){return true;
        }else{ return false;}
    } catch (err) { return false;}
});