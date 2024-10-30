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
            charscheck =  specialChars.test(firstnameValue);
            if (charscheck == true){
                 $("#firstnamecheck").show();
                $("#firstnamecheck").html("**follow the required format/remove space/special");
                firstnameError = false;
                return false;
            }else{
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
        charscheck =  specialChars.test(lastnameValue);
        if (charscheck == true){
             $("#lastnamecheck").show();
            $("#lastnamecheck").html("**follow the required format/remove space/special");
            lastnameError = false;
            return false;
        }else{
            lastnameError = true;
            $("#lastnamecheck").hide();
        }
    }
}
//valid national ID
$("#nationalidcheck").hide();
let nationalidError = true;
$("#nationalid").keyup(function () {
    validateNationalID();
});
function validateNationalID() {
    let textValue = $("#nationalid").val();
    if (textValue.length == "") {
        $("#nationalidcheck").show();
        nationalidError = false;
        return false;
  }else if (textValue.length == 11 || textValue.length == 12) {
      const specialChars =  /^(\d{8}|\d{9})[A-Z]\d{2}$/;
      charscheck =  specialChars.test(textValue);
      if (charscheck == true){
        nationalidError = true;
          $("#nationalidcheck").hide();
      }else{
          $("#nationalidcheck").show();
          $("#nationalidcheck").html("**follow the required format 22113344H55");
          nationalidError = false;
          return false;
      }
  }else {
      $("#nationalidcheck").show();
      $("#nationalidcheck").html("**invalid id number");
      nationalidError = false;
      return false;
        
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
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#companynamecheck").show();
                $("#companynamecheck").html("**follow the required format");
                companynameError = false;
                return false;
            }else{
                companynameError = true;
                $("#companynamecheck").hide();
            }
    }
}
//valid company number
$("#companynumbercheck").hide();
let companynumberError = true;
$("#companynumber").keyup(function () {
    validateCompanyNumber();
});
function validateCompanyNumber() {
    let textValue = $("#companynumber").val();
    if (textValue.length == "") {
        $("#companynumbercheck").show();
        companynumberError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#companynumbercheck").show();
        $("#companynumbercheck").html("**invalid reg number");
        companynumberError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>?~a-z\sA-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#companynumbercheck").show();
                $("#companynumbercheck").html("**follow the required format 000/00");
                companynumberError = false;
                return false;
            }else{
                companynumberError = true;
                $("#companynumbercheck").hide();
            }
    }
}
//valid numeric value not required eg VAT or property stories
$("#numericnotrequiredcheck").hide();
let numericnotrequiredError = true;
$("#numericnotrequired").keyup(function () {
    validateNumericValueNotRequired();
});
function validateNumericValueNotRequired() {
    let textValue = $("#numericnotrequired").val();
    if (textValue.length < 1) {
        $("#numericnotrequiredcheck").show();
        $("#numericnotrequiredcheck").html("**invalid input");
        numericnotrequiredError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#numericnotrequiredcheck").show();
                $("#numericnotrequiredcheck").html("**digits only or (35)");
                numericnotrequiredError = false;
                return false;
            }else{
                numericnotrequiredError = true;
                $("#numericnotrequiredcheck").hide();
            }
    }
}
//valid numeric value not required
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
                $("#numericrequiredcheck").html("**digits only or (35)");
                numericrequiredError = false;
                return false;
            }else{
                numericrequiredError = true;
                $("#numericrequiredcheck").hide();
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
       charscheck         =  specialChars.test(cellValue);
       if (charscheck == true){
            $("#cellcheck").show();
           $("#cellcheck").html("**follow the required format 0701000123 or +263701000123");
           cellError = false;
           return false;
       }else{
           cellError = true;
           $("#cellcheck").hide();
       }
   }
}
 // address check
 $("#billingaddresscheck").hide();
 let billingaddressError = true;
 $("#billingaddress").keyup(function () {
     validateBillingAddress();
 }); 
 function validateBillingAddress() {
     let textValue = $("#billingaddress").val();
     if (textValue.length == "") {
         $("#billingaddresscheck").show();
         billingaddressError = false;
         return false;
     }else if (textValue.length < 3) {
         $("#billingaddresscheck").show();
         $("#billingaddresscheck").html("**invalid address");
         billingaddressError = false;
         return false;
     }else {
         const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|<>\/?~]/;
         charscheck =  specialChars.test(textValue);
         if (charscheck == true){
              $("#billingaddresscheck").show();
             $("#billingaddresscheck").html("**remove characters");
             billingaddressError = false;
             return false;
         }else{
            billingaddressError = true;
             $("#billingaddresscheck").hide();
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
           charscheck =  specialChars.test(textValue);
           if (charscheck == true){
                $("#contactfirstnamecheck").show();
               $("#contactfirstnamecheck").html("**follow the required format");
               contactfirstnameError = false;
               return false;
           }else{
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
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
             $("#contactlastnamecheck").show();
            $("#contactlastnamecheck").html("**follow the required format");
            contactlastnameError = false;
            return false;
        }else{
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
        charscheck         =  specialChars.test(textValue);
        if (charscheck == true){
             $("#contactcellcheck").show();
            $("#contactcellcheck").html("**follow the required format 0701000123 or +263701000123");
            contactcellError = false;
            return false;
        }else{
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
// required general text with Caps ****removed caps**** eg bank branch
$("#requiredgeneraltextcapscheck").hide();
let requiredgeneraltextcapsError = true;
$("#requiredgeneraltextcaps").keyup(function () {
    validateRequiredGeneralTextCaps();
});
function validateRequiredGeneralTextCaps() {
    let textValue = $("#requiredgeneraltextcaps").val();
    if (textValue.length == "") {
        $("#requiredgeneraltextcapscheck").show();
        requiredgeneraltextcapsError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#requiredgeneraltextcapscheck").show();
        $("#requiredgeneraltextcapscheck").html("**invalid text");
        requiredgeneraltextcapsError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>?~0-9]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#requiredgeneraltextcapscheck").show();
                $("#requiredgeneraltextcapscheck").html("**follow the required format");
                requiredgeneraltextcapsError = false;
                return false;
            }else{
                requiredgeneraltextcapsError = true;
                $("#requiredgeneraltextcapscheck").hide();
            }
    }
}
// required acount name
$("#accountnamecheck").hide();
let accountnameError = true;
$("#accountname").keyup(function () {
    validateAccountName();
});
function validateAccountName() {
    let textValue = $("#accountname").val();
    if (textValue.length == "") {
        $("#accountnamecheck").show();
        accountnameError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#accountnamecheck").show();
        $("#accountnamecheck").html("**invalid text");
        accountnameError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#accountnamecheck").show();
                $("#accountnamecheck").html("**follow the required format");
                accountnameError = false;
                return false;
            }else{
                accountnameError = true;
                $("#accountnamecheck").hide();
            }
    }
}
// required acount name
$("#banknamecheck").hide();
let banknameError = true;
$("#bankname").keyup(function () {
    validateBankName();
});
function validateBankName() {
    let textValue = $("#bankname").val();
    if (textValue.length == "") {
        $("#banknamecheck").show();
        banknameError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#banknamecheck").show();
        $("#banknamecheck").html("**invalid text");
        banknameError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#banknamecheck").show();
                $("#banknamecheck").html("**follow the required format");
                banknameError = false;
                return false;
            }else{
                banknameError = true;
                $("#banknamecheck").hide();
            }
    }
}
// not required general text with Caps
$("#notrequiredgeneraltextcapscheck").hide();
let notrequiredgeneraltextcapsError = true;
$("#notrequiredgeneraltextcaps").keyup(function () {
    validateNotRequiredGeneralTextCaps();
});
function validateNotRequiredGeneralTextCaps() {
    let textValue = $("#notrequiredgeneraltextcaps").val();
         if (textValue.length < 2) {
        $("#notrequiredgeneraltextcapscheck").show();
        $("#notrequiredgeneraltextcapscheck").html("**invalid text");
        notrequiredgeneraltextcapsError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>?~\/s\0-9]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#notrequiredgeneraltextcapscheck").show();
                $("#notrequiredgeneraltextcapscheck").html("**follow the required format");
                notrequiredgeneraltextcapsError = false;
                return false;
            }else{
                notrequiredgeneraltextcapsError = true;
                $("#notrequiredgeneraltextcapscheck").hide();
            }
    }
}
//valid currency
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

  //landlord name
  $("#landlordlistcheck").hide();
  let landlordnameError = true;
  $("#landlordlist").keyup(function () {
      validateLandlordName();
  });
  function validateLandlordName() {
      let textValue = $("#landlordlist").val();
      if (textValue.length == "") {
          $("#landlordlistcheck").show();
          landlordnameError = false;
          return false;
      } else {
        landlordnameError = true;
          $("#landlordlistcheck").hide();
      }
  }
    //Province check
$("#provincecheck").hide();
let provinceError = true;
$("#province").keyup(function () {
    validateProvince();
});
function validateProvince() {
    let textValue = $("#province").val();
    if (textValue.length == "") {
        $("#provincecheck").show();
        provinceError = false;
        return false;
    } else {
        provinceError = true;
        $("#provincecheck").hide();
    }
} 
//valid city
$("#citycheck").hide();
let cityError = true;
$("#city").keyup(function () {
    validateCity();
});
function validateCity() {
    let textValue = $("#city").val();
    if (textValue.length == "") {
        $("#citycheck").show();
        cityError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#citycheck").show();
        $("#citycheck").html("**invalid");
        cityError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#citycheck").show();
                $("#citycheck").html("**follow the required format");
                cityError = false;
                return false;
            }else{
                cityError = true;
                $("#citycheck").hide();
            }
    }
}
    //PropType check
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
 // stand number
 $("#standnumbercheck").hide();
 let standnumberError = true;
 $("#standnumber").keyup(function () {
     validateStandNumber();
 }); 
 function validateStandNumber() {
     let textValue = $("#standnumber").val();
         const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|<>\/?~]/;
         charscheck =  specialChars.test(textValue);
         if (charscheck == true){
              $("#standnumbercheck").show();
             $("#standnumbercheck").html("**remove characters");
             standnumberError = false;
             return false;
         }else{
            standnumberError = true;
             $("#standnumbercheck").hide();
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
         charscheck =  specialChars.test(textValue);
         if (charscheck == true){
              $("#commentshighlightscheck").show();
             $("#commentshighlightscheck").html("**remove characters");
             commentshighlightsError = false;
             return false;
         }else{
            commentshighlightsError = true;
             $("#commentshighlightscheck").hide();
         }
}
//valid add rooms
$("#roomscheck").hide();
let roomsError = true;
$("#rooms").keyup(function () {
    validateAddRooms();
});
function validateAddRooms() {
    let textValue = $("#rooms").val();
    if (textValue.length == "") {
        $("#roomscheck").show();
        roomsError = false;
        return false;
    } else if (textValue.length > 2) {
        $("#roomscheck").show();
        $("#roomscheck").html("**two digits allowed");
        roomsError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#roomscheck").show();
                $("#roomscheck").html("**digits only");
                roomsError = false;
                return false;
            }else{
                roomsError = true;
                $("#roomscheck").hide();
            }
    }
}
//valid add bedrooms
$("#bedroomscheck").hide();
let bedroomsError = true;
$("#bedrooms").keyup(function () {
    validateAddBedRooms();
});
function validateAddBedRooms() {
    let textValue = $("#bedrooms").val();
    if (textValue.length == "") {
        $("#bedroomscheck").show();
        bedroomsError = false;
        return false;
    } else if (textValue.length > 2) {
        $("#bedroomscheck").show();
        $("#bedroomscheck").html("**two digits allowed");
        bedroomsError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#bedroomscheck").show();
                $("#bedroomscheck").html("**digits only");
                bedroomsError = false;
                return false;
            }else{
                bedroomsError = true;
                $("#bedroomscheck").hide();
            }
    }
}
//valid total area 
$("#totalareacheck").hide();
let totalareaError = true;
$("#totalarea").keyup(function () {
    validateAddTotalArea();
});
function validateAddTotalArea() {
    let textValue = $("#totalarea").val();
    if (textValue.length == "") {
        $("#totalareacheck").show();
        totalareaError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#totalareacheck").show();
        $("#totalareacheck").html("**at least two digits allowed");
        totalareaError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#totalareacheck").show();
                $("#totalareacheck").html("**digits only or (3.5)");
                totalareaError = false;
                return false;
            }else{
                totalareaError = true;
                $("#totalareacheck").hide();
            }
    }
}
//validate rental from lease rate*area taken
function validateLeaseRentalSqm(){
    let rateValue = $("#expectedrate").val();
    let areaValue = $("#lettablearea").val();
    if (areaValue.length != "" && rateValue.length != "") {
        $rentalexp = rateValue * areaValue;
        $("#rentalcalculatedcheck").show();
        $("#rentalcalculatedcheck").html($rentalexp);
        return true;
    }
    $("#rentalcalculatedcheck").hide();
}
//valid lettable area 
$("#lettableareacheck").hide();
let lettableareaError = true;
$("#lettablearea").keyup(function () {
    validateAddLettableArea();
    validateLeaseRentalSqm();
});
function validateAddLettableArea() {
    let textValue = $("#lettablearea").val();

    if (textValue.length == "") {
        $("#lettableareacheck").show();
        lettableareaError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#lettableareacheck").show();
        $("#lettableareacheck").html("**atleast two digits allowed");
        lettableareaError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#lettableareacheck").show();
                $("#lettableareacheck").html("**digits only or (3.5)");
                lettableareaError = false;
                return false;
            }else{
                lettableareaError = true;
                    $("#lettableareacheck").hide();
                
            }
    }
}
//valid rate/sqm
$("#expectedratecheck").hide();
let expectedrateError = true;
$("#expectedrate").keyup(function () {
    validateAddExpectedRate();
    validateLeaseRentalSqm()
});
function validateAddExpectedRate() {
    let textValue = $("#expectedrate").val();
    if (textValue.length == "") {
        $("#expectedratecheck").show();
        expectedrateError = false;
        return false;
    } else if (textValue.length > 4) {
        $("#expectedratecheck").show();
        $("#expectedratecheck").html("**four digits allowed");
        expectedrateError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#expectedratecheck").show();
                $("#expectedratecheck").html("**digits only or (3.5)");
                expectedrateError = false;
                return false;
            }else{
                expectedrateError = true;
                $("#expectedratecheck").hide();
            }
    }
}
//valid rental
$("#expectedrentalcheck").hide();
let expectedrentalError = true;
$("#expectedrental").keyup(function () {
    validateAddExpectedRental();
});
function validateAddExpectedRental() {
    let textValue = $("#expectedrental").val();
    if (textValue.length == "") {
        $("#expectedrentalcheck").show();
        expectedrentalError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#expectedrentalcheck").show();
        $("#expectedrentalcheck").html("**atleast two digits allowed");
        expectedrentalError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#expectedrentalcheck").show();
                $("#expectedrentalcheck").html("**digits only or (3.5)");
                expectedrentalError = false;
                return false;
            }else{
                expectedrentalError = true;
                $("#expectedrentalcheck").hide();
            }
    }
}
//commission type
$("#commissiontypecheck").hide();
let commissiontypeError = true;
$("#commissiontype").keyup(function () {
    validateCommissionType();
});
function validateCommissionType() {
    let textValue = $("#commissiontype").val();
    if (textValue.length == "") {
        $("#commissiontypecheck").show();
        commissiontypeError = false;
        return false;
    } else {
       commissiontypeError = true;
        $("#commissiontypecheck").hide();
    }
} 
//valid CommissionPercentage
$("#commissionpercentcheck").hide();
let commissionpercentError = true;
$("#commissionpercentage").keyup(function () {
    validateCommissionPercent();
});
function validateCommissionPercent() {
    let textValue = $("#commissionpercentage").val();
    if (textValue.length == "") {
        $("#commissionpercentcheck").show();
        commissionpercentError = false;
        return false;
    } else if (textValue.length > 5) {
        $("#commissionpercentcheck").show();
        $("#commissionpercentcheck").html("**three digits allowed");
        commissionpercentError = false;
        return false;
    } else {
        const specialChars = /^\d+(\.\d+)?$/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                commissionpercentError = true;
                $("#commissionpercentcheck").hide();
            }else{
                $("#commissionpercentcheck").show();
                $("#commissionpercentcheck").html("**digits only or (3.5)");
                commissionpercentError = false;
                return false;
            }
    }
}
  // signed pdf document eg mandate/lease agreement
$("#requiredsignedpdfcheck").hide();
  let requiredsignedpdfdocumentError = true;
$("#requiredsignedpdf").keyup(function () {
      validateRequiredSignedPDFDocument();
}); 
function validateRequiredSignedPDFDocument() {
      let textValue = $("#requiredsignedpdf")[0];
      if (textValue.files.length === 0) {
          $("#requiredsignedpdfcheck").show();
          requiredsignedpdfdocumentError = false;
          return false;
      }else {
          var uploadedfile = textValue.files[0];
          // Check the file extension
          var uploadedExtension = uploadedfile.name.split('.').pop().toLowerCase();
          if (uploadedExtension !== 'pdf') {
              $("#requiredsignedpdfcheck").show();
              $("#requiredsignedpdfcheck").html("**file must be pdf ");
              requiredsignedpdfdocumentError = false;
              return false;
            }else{
              
              if (uploadedfile.size > 2000*1024){ // file must be less than 2Mb
                   $("#requiredsignedpdfcheck").show();
                  $("#requiredsignedpdfcheck").html("**file must be less that 2MB");
                  requiredsignedpdfdocumentError = false;
                  return false;
              }else{
                requiredsignedpdfdocumentError = true;
                  $("#requiredsignedpdfcheck").hide();
              }
            } 
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
            }else{
              
              if (uploadedfile.size > 2000*1024){ // file must be less than 2Mb
                   $("#notrequiredpdfcheck").show();
                  $("#notrequiredpdfcheck").html("**file must be less that 2MB");
                  notrequiredpdfdocumentError = false;
                  return false;
              }else{
                notrequiredpdfdocumentError = true;
                  $("#notrequiredpdfcheck").hide();
              }
            }
        } 
}
//function to check if lettable < total area
let lettabletotalareaError = true;
function validateLettable_TotalArea(){
    var lettable = parseFloat($("#lettablearea").val());
    var totalarea = parseFloat($("#totalarea").val());
     //check if all are numbers
     if (isNaN(lettable) || isNaN(totalarea) ) {
        alert("Please enter valid number.");
        lettabletotalareaError = false;
        return false;
      }
      if (lettable >= totalarea) {
        alert("lettable must be less.");
        lettabletotalareaError = false;
        return false;
      }
      lettabletotalareaError = true;
      return true;
}
//valid keen person firstname
$("#keenfirstnamecheck").hide();
let keenfirstnameError = true;
$("#keenfirstname").keyup(function () {
    validateKeenFirstName();
});
function validateKeenFirstName() {
   let textValue = $("#keenfirstname").val();
   if (textValue.length == "") {
       $("#keenfirstnamecheck").show();
       keenfirstnameError = false;
       return false;
   } else if (textValue.length < 3) {
       $("#keenfirstnamecheck").show();
       $("#keenfirstnamecheck").html("**invalid");
       keenfirstnameError = false;
       return false;
   } else {
       const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
           charscheck =  specialChars.test(textValue);
           if (charscheck == true){
                $("#keenfirstnamecheck").show();
               $("#keenfirstnamecheck").html("**follow the required format");
               keenfirstnameError = false;
               return false;
           }else{
            keenfirstnameError = true;
               $("#keenfirstnamecheck").hide();
           }
   }
}
//valid keen person lastname
$("#keenlastnamecheck").hide();
let keenlastnameError = true;
$("#keenlastname").keyup(function () {
    validateKeenLastName();
});
function validateKeenLastName() {
    let textValue = $("#keenlastname").val();
    if (textValue.length == "") {
        $("#keenlastnamecheck").show();
        keenlastnameError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#keenlastnamecheck").show();
        $("#keenlastnamecheck").html("**invalid");
        keenlastnameError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
             $("#keenlastnamecheck").show();
            $("#keenlastnamecheck").html("**follow the required format");
            keenlastnameError = false;
            return false;
        }else{
            keenlastnameError = true;
            $("#keenlastnamecheck").hide();
        }
    }
}
//valid keen person cell
$("#keencellcheck").hide();
let keencellError = true;
$("#keencell").keyup(function () {
    validateKeenCell();
});
function validateKeenCell() {
    let textValue = $("#keencell").val();
    if (textValue.length == "") {
        $("#keencellcheck").show();
        keencellError = false;
        return false;
    } else if (textValue.length < 10) {
        $("#keencellcheck").show();
        $("#keencellcheck").html("**invalid cell");
        keencellError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_\-=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
        charscheck         =  specialChars.test(textValue);
        if (charscheck == true){
             $("#keencellcheck").show();
            $("#keencellcheck").html("**follow the required format 0701000123 or +263701000123");
            keencellError = false;
            return false;
        }else{
            keencellError = true;
            $("#keencellcheck").hide();
        }
    }
}
//valid keen email not required
$("#keenemailcheck").hide();
let keenemailError = true;
$("#keenemail").keyup(function () {
    validateKeenEmail();
});
function validateKeenEmail() {
    let textValue = $("#keenemail").val();
        const emailvalid = document.getElementById("keenemail");
        emailvalid.addEventListener("blur", () => {
            let regex =
            /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
            let textValue = emailvalid.value;
            if (regex.test(textValue)) {
                $("#keenemailcheck").hide();
                keenemailError = true;
            } else {
                $("#keenemailcheck").show();
                $("#keenemailcheck").html("**follow the required format example@example.com");
                keenemailError = false;
                return false;
            }
        });
}
// tenant list by client type
$("#tenantlistcheck").hide();
  let tenantnameError = true;
  $("#tenantlist").keyup(function () {
      validateTenantName();
  });
  function validateTenantName() {
      let textValue = $("#tenantlist").val();
      if (textValue.length == "") {
          $("#tenantlistcheck").show();
          tenantnameError = false;
          return false;
      } else {
        tenantnameError = true;
          $("#tenantlistcheck").hide();
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
  //inspection period
  $("#periodlistcheck").hide();
  let periodlistError = true;
  $("#periodlist").keyup(function () {
      validatePeriodList();
  });
  function validatePeriodList() {
      let textValue = $("#periodlist").val();
      if (textValue.length == "") {
          $("#periodlistcheck").show();
          periodlistError = false;
          return false;
      } else {
        periodlistError = true;
          $("#periodlistcheck").hide();
      }
  }
//rent review period
$("#rentreviewcheck").hide();
let rentreviewError = true;
$("#rentreviewperiod").keyup(function () {
    validateRentReview();
});
function validateRentReview() {
    let textValue = $("#rentreviewperiod").val();
    if (textValue.length == "") {
        $("#rentreviewcheck").show();
        rentreviewError = false;
        return false;
    } else {
       rentreviewError = true;
        $("#rentreviewcheck").hide();
    }
}
//valid balance bd input eg lease bd on new lease
$("#balancebdinputcheck").hide();
let leasebalancebdinputError = true;
$("#balancebdinput").keyup(function() {
   validateLeaseBalanceBDInput();
});

function validateLeaseBalanceBDInput(){
    let textValue         = $("#balancebdinput").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#balancebdinputcheck").show();
           $("#balancebdinputcheck").html("**digits only or (13.5)");
           leasebalancebdinputError = false;
           return false;
       }else{
        leasebalancebdinputError = true;
           $("#balancebdinputcheck").hide();
       }
    }else {
        leasebalancebdinputError = true;
       $("#balancebdinputcheck").hide();
   }
}
//valid lease item rate cost
$("#leaseratescostcheck").hide();
let leaseratecostError = true;
$("#leaseratescost").keyup(function() {
   validateLeaseRatesCost();
});

function validateLeaseRatesCost(){
    let textValue         = $("#leaseratescost").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#leaseratescostcheck").show();
           $("#leaseratescostcheck").html("**digits only or (13.5)");
           leaseratecostError = false;
           return false;
       }else{
        leaseratecostError = true;
           $("#leaseratescostcheck").hide();
       }
    }
}
//valid lease item operation cost
$("#leaseoperationcostcheck").hide();
let leaseoperationcostError = true;
$("#leaseoperationalcost").keyup(function() {
    validateLeaseOperationalCost();
});

function validateLeaseOperationalCost(){
    let textValue         = $("#leaseoperationalcost").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#leaseoperationcostcheck").show();
           $("#leaseoperationcostcheck").html("**digits only or (13.5)");
           leaseoperationcostError = false;
           return false;
       }else{
        leaseoperationcostError = true;
           $("#leaseoperationcostcheck").hide();
       }
    }
}
//valid lease item deposit
$("#leasedepositpaidcheck").hide();
let leasedepositcheckError = true;
$("#leasedepositpaid").keyup(function() {
   validateLeaseDepositPaid();
});

function validateLeaseDepositPaid(){
    let textValue         = $("#leasedepositpaid").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#leasedepositpaidcheck").show();
           $("#leasedepositpaidcheck").html("**digits only or (13.5)");
           leasedepositcheckError = false;
           return false;
       }else{
        leasedepositcheckError = true;
           $("#leasedepositpaidcheck").hide();
       }
    }
}
//valid lease item admin
$("#leaseadminpaidcheck").hide();
let leaseadmincheckError = true;
$("#leaseadminpaid").keyup(function() {
   validateLeaseAdminPaid();
});
function validateLeaseAdminPaid(){
    let textValue         = $("#leaseadminpaid").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#leaseadminpaidcheck").show();
           $("#leaseadminpaidcheck").html("**digits only or (13.5)");
           leaseadmincheckError = false;
           return false;
       }else{
        leaseadmincheckError = true;
           $("#leaseadminpaidcheck").hide();
       }
    }
}
//valid currency
$("#leaseitemcurrencycodecheck").hide();
let leaseitemcurrencycodeError = true;
$("#leaseitemcurrencycode").keyup(function () {
    validateLeaseItemCurrencyCode();
});
function validateLeaseItemCurrencyCode() {
    let textValue = $("#leaseitemcurrencycode").val();
    if (textValue.length == "") {
        $("#leaseitemcurrencycodecheck").show();
        leaseitemcurrencycodeError = false;
        return false;
    } else {
        leaseitemcurrencycodeError = true;
        $("#leaseitemcurrencycodecheck").hide();
    }
}
//validate date bigger than
let daterangeError = true;
function validateDateRange() {
    var date_from          = new Date($ ('#datefrom').val());
    var date_to            = new Date($ ('#dateto').val());
    if (date_from >= date_to){
        $("#datetocheck").show();
        $("#datetocheck").html("invalid date range");
        daterangeError = false;
        return false;
    }else{
        $("#datetocheck").hide();
        daterangeError = true;
        return true;
    } 
}
/*-----------------------------buttons submit ----------------------- */
/*-----------------------------add banking details table ----------------------- */
$('#add-banking-item').on('click', function() {
	var currencycode		=	$('#currencycode').val();
	var accountname		=	$('#accountname').val();
	var bankname		=	$('#bankname').val();
	var branch			=	$('#notrequiredgeneraltextcaps').val();
	var accountnumber	=	$('#numericrequired').val();
	var count = $('#landlordbanking tr').length - 1;

    validateAccountName();validateBankName();validateNotRequiredGeneralTextCaps();
    validateNumericValueRequired(); validateCurrencyCode();

    try{
        if(accountnameError==true && banknameError==true && notrequiredgeneraltextcapsError==true &&
            numericrequiredError==true && currencycodeError==true){
                if(branch ==''){ branch = 'n/a'; }
        $('#landlordbanking tbody').append('<tr class="child"><td>'+count+'</td><td><input name="currencycode[]" class="form-control" value='+currencycode+' readonly/></td><td><input name="accountname[]" class="form-control" value='+accountname+' readonly /></td><td><input name="bankname[]" class="form-control" value='+bankname+' readonly /></td><td> <input name="branch[]" class="form-control " value='+branch+' readonly/></td><td><input name="accountnumber[]" class="form-control " value='+accountnumber+' readonly /></td><td><button style="text-align: right;" class="btn btn-danger" type="button" value="delete" onclick="deletelandlordbankrow(this)">delete</button></td></tr>');
		$('#accountname').val('');  $('#bankname').val('');   $('#notrequiredgeneraltextcaps').val(''); $('#numericrequired').val('');      
            }
    }catch(err){  alert(err.message); }
});
function deletelandlordbankrow(t) {
    var a = $("#landlordbanking > tbody > tr").length;
    if (1 == a) alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e);
    }
}
var count = 2,
limits = 3;
/*-----------------------------end add banking details table ----------------------- */
/*-----------------------------add lease addtional information details table ----------------------- */
$('#add-lease-item').on('click', function() {
	var currencycode		=	$('#leaseitemcurrencycode').val();
	var balancebd		    =	$('#balancebdinput').val();
	var rateutilities		=	$('#leaseratescost').val();
	var operationalcost		=	$('#leaseoperationalcost').val();
	var depositpaid	        =	$('#leasedepositpaid').val();
    var adminpaid	        =	$('#leaseadminpaid').val();
	var count = $('#leaseitems tr').length - 1;

    validateLeaseItemCurrencyCode();validateLeaseRatesCost();validateLeaseBalanceBDInput();
    validateLeaseOperationalCost();validateLeaseDepositPaid();validateLeaseAdminPaid();

    try{
        if(leaseitemcurrencycodeError==true && leasebalancebdinputError==true && leaseratecostError==true 
        && leaseoperationcostError==true && leasedepositcheckError==true && leaseadmincheckError==true){
            if(balancebd ==''){balancebd = 0;}
            if(rateutilities ==''){rateutilities = 0;}
            if(operationalcost ==''){operationalcost = 0;}
            if(depositpaid ==''){depositpaid = 0;}
            if(adminpaid ==''){adminpaid = 0;}
        $('#leaseitems tbody').append('<tr class="child"><td>'+count+'</td><td><input name="leaseitemcurrencycode[]" class="form-control" value='+currencycode+' readonly/></td><td><input name="leasebalancebd[]" class="form-control" value='+balancebd+' readonly /></td><td><input name="leaseratescost[]" class="form-control" value='+rateutilities+' readonly /></td><td> <input name="leaseoperationalcost[]" class="form-control " value='+operationalcost+' readonly/></td><td><input name="leasedepositpaid[]" class="form-control " value='+depositpaid+' readonly /></td><td><input name="leaseadminpaid[]" class="form-control " value='+adminpaid+' readonly /></td><td><button style="text-align: right;" class="btn btn-danger" type="button" value="delete" onclick="deleteleaseitemrow(this)">delete</button></td></tr>');
		$('#balancebdinput').val('');  $('#leaseratescost').val('');   $('#leaseoperationalcost').val(''); $('#leasedepositpaid').val(''); $('#leaseadminpaid').val('');      
            }
    }catch(err){  alert(err.message); }
});
function deleteleaseitemrow(t) {
    var a = $("#leaseitems > tbody > tr").length;
    if (1 == a) alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e);
    }
}
var count = 2,
limits = 3;
/*-----------------------------end add addtional information details  table ----------------------- */
$("#btn-add-landlord").click(function () {
    validateBillingAddress();validateCell();validateContactCell();validateContactEmail();
    validateContactLastName(); validateContactFirstName();validateEmail();validateClientType();
    var clienttypevalue = $("#clienttype").val();
    try{
        if(clienttypevalue == 1){
            validateFirstName();validateLastName(); validateNationalID();
            if(billingaddressError==true && cellError==true && emailError==true &&
                contactcellError==true && contactfirstnameError==true && contactlastnameError==true &&
                contactemailError==true && clienttypeError==true && firstnameError==true && 
                lastnameError==true && nationalidError==true){return true}else{return false}
        }else{
            validateCompanyName();validateCompanyNumber();validateNumericValueNotRequired();
            if(billingaddressError==true && cellError==true && emailError==true &&
                contactcellError==true && contactfirstnameError==true && contactlastnameError==true &&
                contactemailError==true && clienttypeError==true && companynameError==true && 
                companynumberError && numericnotrequiredError==true){
                return true;}else{ return false;}
        }
    }catch(err){return false;}
});
//button submit new property 
$("#btn-add-property").click(function () {
    try {
        validateLandlordName(); validateProvince();validateCity();validatePropertyType();
        validateRequiredGeneralTextCaps();validateBillingAddress();validateStandNumber();
        validateCommentsHighlights();validateCurrencyCode();validateCommissionType();
        validateCommissionPercent();validateRequiredSignedPDFDocument();validateNotRequiredPDFDocument();
        
        if(landlordnameError==true && provinceError==true && cityError==true && propertytypeError==true
            && requiredgeneraltextcapsError==true && billingaddressError==true && standnumberError==true
            && commentshighlightsError==true && currencycodeError==true && commissiontypeError==true &&
            commissionpercentError==true && requiredsignedpdfdocumentError==true && notrequiredpdfdocumentError==true){
                var propertytypevalue =  $("#propertytype").val();
                if(propertytypevalue==1){//residential property 
                validateAddRooms();validateAddBedRooms();validateNumericValueRequired();
                validateNumericValueNotRequired();
                if(roomsError==true && bedroomsError==true && numericrequiredError==true && 
                    numericnotrequiredError==true){return true;}else{return false;}
                }else{// not residential ie commercial
                    validateAddTotalArea();validateAddLettableArea();validateAddExpectedRate();
                    validateLettable_TotalArea();
                    if(totalareaError==true && lettableareaError==true && expectedrateError==true &&
                        lettabletotalareaError==true){
                        return true;}else{return false;}
                }
        }else{return false;}
    } catch (err) {
        alert(err.message);
        return false;
    }  
});
//button submit new tenant
$("#btn-add-tenant").click(function () {
    validateClientType();validateBillingAddress();validateCell();validateEmail();
    var clienttypevalue = $("#clienttype").val();
    try {
        if(clienttypevalue == 1){
            validateFirstName();validateLastName(); validateNationalID();validateKeenEmail();
            validateKeenLastName();validateKeenFirstName();validateKeenCell();
            if(billingaddressError==true && cellError==true && emailError==true &&
                clienttypeError==true && firstnameError==true && keencellError==true && keenemailError==true
               && lastnameError==true && nationalidError==true && keenfirstnameError==true &&
            keenlastnameError==true){return true}else{return false}
        }else{
            validateCompanyName();validateCompanyNumber();validateNumericValueNotRequired();
            validateContactCell();validateContactEmail();validateContactLastName();
             validateContactFirstName();
            if(billingaddressError==true && cellError==true && emailError==true &&
                contactcellError==true && contactfirstnameError==true && contactlastnameError==true &&
                contactemailError==true && clienttypeError==true && companynameError==true && 
                companynumberError && numericnotrequiredError==true){
                return true;}else{ return false;}
        }
    } catch (err) {
        alert(err.message);
        return false;
    }
});
// --------------btn add new lease
$("#btn-add-lease").click(function () {
    try {
        validateTenantName();validateLandlordName();validateBillingAddress();validateDateFrom();
        validateDateTo();validateRentReview();validatePeriodList();validateCurrencyCode();validateDateRange();
        validateRequiredSignedPDFDocument();
        var propertytype    =  $("#propertytype").val();
        if(tenantnameError==true && landlordnameError==true && billingaddressError==true && 
            datefromError==true && datetoError==true && rentreviewError==true && periodlistError==true &&
            currencycodeError==true && daterangeError==true && requiredsignedpdfdocumentError==true){
            if(propertytype == 1) {//residential 
                validateAddExpectedRental();
                if(expectedrateError == true && expectedrentalError==true){
                    return true;}else{return false;}
            }else{ validateAddLettableArea(); validateAddExpectedRate();
                if(lettableareaError==true && expectedrateError==true){return true;}else{return false;}
             }
        }else{return false;}
            
            
    } catch (err) {
        alert(err.message);
        return false;
    }
});
// -----------btn edit landlord 
$("#btn-edit-landlord").click(function () {
    validateBillingAddress();validateCell();validateClientType();validateEmail();
    var clienttypevalue = $("#clienttype").val();
    try{
        if(clienttypevalue == 1){
            validateFirstName();validateLastName(); validateNationalID();
            if(billingaddressError==true && cellError==true && emailError==true 
                 && clienttypeError==true && firstnameError==true && 
                lastnameError==true && nationalidError==true){return true}else{return false}
        }else{
            validateCompanyName();validateCompanyNumber();validateNumericValueNotRequired();
            if(billingaddressError==true && cellError==true && emailError==true
                 && clienttypeError==true && companynameError==true && 
                companynumberError && numericnotrequiredError==true){
                return true;}else{ return false;}
        }
    }catch(err){return false;}
});
//--------- btn add landlord new contact 
$("#btn-add-landlord-contact").click(function () {
    validateContactCell();validateContactEmail();
    validateContactLastName(); validateContactFirstName();
    try{
            if(contactcellError==true && contactfirstnameError==true && contactlastnameError==true &&
                contactemailError==true ){return true}else{return false}
    }catch(err){return false;}
});
//--------- btn edit landlord bank
$("#btn-edit-landlord-bank").click(function () {
    validateAccountName();validateBankName();validateNotRequiredGeneralTextCaps();
    validateNumericValueRequired(); validateCurrencyCode();
    try{
        if(accountnameError==true && banknameError==true && notrequiredgeneraltextcapsError==true &&
            numericrequiredError==true && currencycodeError==true){
                return true;}else{ return false;}
    }catch(err){ return false;}
});
//button submit new property 
$("#btn-edit-property").click(function () {
    try {
         validateProvince();validateCity();validatePropertyType();
        validateRequiredGeneralTextCaps();validateBillingAddress();validateStandNumber();
        validateCommentsHighlights();validateCurrencyCode();
        validateCommissionPercent();
        
        if(provinceError==true && cityError==true && propertytypeError==true
            && requiredgeneraltextcapsError==true && billingaddressError==true && standnumberError==true
            && commentshighlightsError==true && currencycodeError==true && 
            commissionpercentError==true ){
                var propertytypevalue =  $("#propertytype").val();
                if(propertytypevalue=='Residential Building'){//residential property 
                validateAddRooms();validateAddBedRooms();validateNumericValueRequired();
                validateNumericValueNotRequired();
                if(roomsError==true && bedroomsError==true && numericrequiredError==true && 
                    numericnotrequiredError==true){return true;}else{return false;}
                }else{// not residential ie commercial
                    validateAddTotalArea();validateAddLettableArea();validateAddExpectedRate();
                    validateLettable_TotalArea();
                    if(totalareaError==true && lettableareaError==true && expectedrateError==true &&
                        lettabletotalareaError==true){
                        return true;}else{return false;}
                }
        }else{return false;}
    } catch (err) {
        alert(err.message);
        return false;
    }  
});
//btn add lease rates 
$("#btn-add-lease-rate").click(function () {
    validateCurrencyCode();validateLeaseOperationalCost();
    validateLeaseRatesCost();
    try{
            if(currencycodeError==true && leaseoperationcostError==true && leaseratecostError==true  )
                {return true}else{return false}
    }catch(err){return false;}
});
// --------------btn edit lease
$("#btn-edit-lease").click(function () {
    try {
        validateBillingAddress();validateDateFrom();
        validateDateTo();validateRentReview();validatePeriodList();
        validateCurrencyCode();validateDateRange();
       
        var propertytype    =  $("#propertytype").val();
        if(billingaddressError==true && 
            datefromError==true && datetoError==true && rentreviewError==true && periodlistError==true &&
            currencycodeError==true && daterangeError==true){
            if(propertytype == 1) {//residential 
                validateAddExpectedRental();
                if(expectedrateError == true && expectedrentalError==true){
                    return true;}else{return false;}
            }else{ validateAddLettableArea(); validateAddExpectedRate();
                if(lettableareaError==true && expectedrateError==true){return true;}else{return false;}
             }
        }else{return false;}
            
            
    } catch (err) {
        alert(err.message);
        return false;
    }
});
//btn add lease prepay/arrears 
$("#btn-add-lease-prepay").click(function () {
    validateCurrencyCode();validateLeaseRatesCost();
    try{
            if(currencycodeError==true && leaseratecostError==true  )
                {return true}else{return false}
    }catch(err){return false;}
});