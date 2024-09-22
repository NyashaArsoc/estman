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
//valid numeric value not required
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
          const emailvalid = document.getElementById("Email");
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
// required general text with Caps
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
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>?~\/s\0-9]/;
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
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>?~\/s\0-9]/;
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
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>?~\/s\0-9]/;
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
    if (textValue.length == "") {
        $("#notrequiredgeneraltextcapscheck").show();
        notrequiredgeneraltextcapsError = false;
        return false;
    } else if (textValue.length < 2) {
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
    validateCurrency();
});
function validateCurrency() {
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
/*-----------------------------add banking details table ----------------------- */
$('#add-banking-item').on('click', function() {
	var currencycode		=	$('#currencycode').val();
	var accountname		=	$('#accountname').val();
	var bankname		=	$('#bankname').val();
	var branch			=	$('#notrequiredgeneraltextcaps').val();
	var accountnumber	=	$('#numericrequired').val();
	var count = $('#landlordbanking tr').length - 1;

    validateAccountName();validateBankName();validateNotRequiredGeneralTextCaps();
    validateNumericValueRequired(); validateCurrency();

    try{
        if(accountnameError==true && banknameError==true && notrequiredgeneraltextcapsError==true &&
            numericrequiredError==true && currencycodeError==true){
                if(branch ==''){ branch = 'n/a'; }
        $('#landlordbanking tbody').append('<tr class="child"><td>'+count+'</td><td><input name="currencycode[]" class="form-control" value='+currencycode+' readonly/></td><td><input name="accountname[]" class="form-control" value='+accountname+' readonly /></td><td><input name="bankname[]" class="form-control" value='+bankname+' readonly /></td><td> <input name="branch[]" class="form-control " value='+branch+' readonly/></td><td><input name="accountnumber[]" class="form-control " value='+accountnumber+' readonly /></td><td><button style="text-align: right;" class="btn btn-danger" type="button" value="delete" onclick="deleteRow(this)">delete</button></td></tr>');
		$('#accountname').val('');  $('#bankname').val('');   $('#notrequiredgeneraltextcaps').val(''); $('#numericrequired').val('');      
            }
    }catch(err){  alert(err.message); }
});
function deletenewpropertyrow(t) {
    var a = $("#tblnewpropertydetails > tbody > tr").length;
    if (1 == a) alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e);
    }
}
var count = 2,
limits = 3;
/*-----------------------------end add banking details table ----------------------- */
/*-----------------------------butn submit ----------------------- */
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