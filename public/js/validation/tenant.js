$(document).ready(function () {
    //client type
    $("#tenanttypecheck").hide();
	let tenanttypeError = true;
    $("#TenantClientType").keyup(function () {
		validateTenantType();
	});
    function validateTenantType() {
		let textValue = $("#TenantClientType").val();
		if (textValue.length == "") {
			$("#tenanttypecheck").show();
			tenanttypeError = false;
			return false;
		} else {
            tenanttypeError = true;
			$("#tenanttypecheck").hide();
		}
	}
     //valid firstname
     $("#firstnamecheck").hide();
     let firstnameError = true;
     $("#FirstName").keyup(function () {
         validateFirstName();
     });
     function validateFirstName() {
         let textValue = $("#FirstName").val();
         if (textValue.length == "") {
             $("#firstnamecheck").show();
             firstnameError = false;
             return false;
         } else if (textValue.length < 3) {
             $("#firstnamecheck").show();
             $("#firstnamecheck").html("**invalid firstname");
             firstnameError = false;
             return false;
         } else {
             const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
                 charscheck =  specialChars.test(textValue);
                 if (charscheck == true){
                      $("#firstnamecheck").show();
                     $("#firstnamecheck").html("**follow the required format");
                     firstnameError = false;
                     return false;
                 }else{
                     firstnameError = true;
                     $("#firstnamecheck").hide();
                 }
         }
     }
   //valid lastname
   $("#lastnamecheck").hide();
   let lastnameError = true;
   $("#LastName").keyup(function () {
       validateLastName();
   });
   function validateLastName() {
       let textValue = $("#LastName").val();
       if (textValue.length == "") {
           $("#lastnamecheck").show();
           lastnameError = false;
           return false;
       } else if (textValue.length < 3) {
           $("#lastnamecheck").show();
           $("#lastnamecheck").html("**invalid lastname");
           lastnameError = false;
           return false;
       } else {
           const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
           charscheck =  specialChars.test(textValue);
           if (charscheck == true){
                $("#lastnamecheck").show();
               $("#lastnamecheck").html("**follow the required format");
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
   $("#NationalIDNumber").keyup(function () {
       validateNationalID();
   });
   function validateNationalID() {

       let textValue = $("#NationalIDNumber").val();
       if (textValue.length == "") {
           $("#nationalidcheck").show();
           nationalidError = false;
           return false;
       } else if (10 > textValue.length  || textValue.length > 12 ) {
           $("#nationalidcheck").show();
           $("#nationalidcheck").html("**invalid id number");
           nationalidError = false;
           return false;
       } else {
               const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~a-z/\s/]/;
               charscheck         =  specialChars.test(textValue);
               if (charscheck == true){
                    $("#nationalidcheck").show();
                   $("#nationalidcheck").html("**follow the required format 20222222A00");
                    nationalidError = false;
                   return false;
               }else{
                   nationalidError = true;
                   $("#nationalidcheck").hide();
               }
       }
   }
    //valid company name
    $("#companynamecheck").hide();
    let companynameError = true;
    $("#CompanyName").keyup(function () {
        validateCompanyName();
    });
    function validateCompanyName() {
       let textValue = $("#CompanyName").val();
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
  $("#CompanyNumber").keyup(function () {
      validateCompanyNumber();
  });
  function validateCompanyNumber() {
      let textValue = $("#CompanyNumber").val();
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
    //valid cell
    $("#cellcheck").hide();
    let cellError = true;
    $("#Cell").keyup(function () {
        validateCell();
    });
    function validateCell() {
       let cellValue = $("#Cell").val();
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
   //valid email
   $("#emailcheck").hide();
   let emailError = true;
   $("#Email").keyup(function () {
       validateEmail();
   });
   function validateEmail() {
    let emailValue = $("#Email").val();
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
 $("#ContactFirstName").keyup(function () {
     validateContactFirstName();
 });
 function validateContactFirstName() {
    let textValue = $("#ContactFirstName").val();
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
$("#ContactLastName").keyup(function () {
    validateContactLastName();
});
function validateContactLastName() {
    let textValue = $("#ContactLastName").val();
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
 $("#ContactCell").keyup(function () {
     validateContactCell();
 });
 function validateContactCell() {
     let textValue = $("#ContactCell").val();
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
  $("#ContactEmail").keyup(function () {
      validateContactEmail();
  });
  function validateContactEmail() {
      let textValue = $("#ContactEmail").val();
      if (textValue.length == "") {
          $("#contactemailcheck").show();
          contactemailError = false;
          return false;
      } else {
          const emailvalid = document.getElementById("ContactEmail");
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
//valid keen person firstname
$("#keenfirstnamecheck").hide();
let keenfirstnameError = true;
$("#KeenFirstName").keyup(function () {
    validateKeenFirstName();
});
function validateKeenFirstName() {
   let textValue = $("#KeenFirstName").val();
   if (textValue.length == "") {
       $("#keenfirstnamecheck").show();
       keenfirstnameError = false;
       return false;
   } else if (textValue.length < 3) {
       $("#keenfirstnamecheck").show();
       $("#keenfirstnamecheck").html("**invalid firstname");
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
$("#KeenLastName").keyup(function () {
    validateKeenLastName();
});
function validateKeenLastName() {
    let textValue = $("#KeenLastName").val();
    if (textValue.length == "") {
        $("#keenlastnamecheck").show();
        keenlastnameError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#keenlastnamecheck").show();
        $("#keenlastnamecheck").html("**invalid lastname");
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
$("#KeenCell").keyup(function () {
    validateKeenCell();
});
function validateKeenCell() {
    let textValue = $("#KeenCell").val();
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
//valid keen email
$("#keenemailcheck").hide();
let keenemailError = true;
$("#KeenEmail").keyup(function () {
    validateKeenEmail();
});
function validateKeenEmail() {
    let textValue = $("#KeenEmail").val();
    if (textValue.length == "") {
        $("#keenemailcheck").show();
        keenemailError = false;
        return false;
    } else {
        const emailvalid = document.getElementById("KeenEmail");
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
}
    //valid reasons
    $("#reasonscheck").hide();
    let reasonsError = true;
    $("#ReasonsForDecline").keyup(function () {
        validateReasons();
    });
    function validateReasons() {
        let textValue = $("#ReasonsForDecline").val();
        if (textValue.length == "") {
            $("#reasonscheck").show();
            reasonsError = false;
            return false;
        } else if (textValue.length < 3) {
            $("#reasonscheck").show();
            $("#reasonscheck").html("**write a proper reason");
            reasonsError = false;
            return false;
        } else {
            const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9]/;
                charscheck =  specialChars.test(textValue);
                if (charscheck == true){
                     $("#reasonscheck").show();
                    $("#reasonscheck").html("**follow the required format");
                    reasonsError = false;
                    return false;
                }else{
                  reasonsError = true;
                    $("#reasonscheck").hide();
                }
        }
    }
 
//button submit
    $("#btn-add-submit").click(function () {
        validateTenantType();
        try {
            if (tenanttypeError == true ){
                var TenantTypeVal = $("#TenantClientType").val();
                if(TenantTypeVal == 1){
                    //------------individual------------//
                    validateFirstName(); validateLastName();  validateNationalID();
                    validateCell();validateEmail(); validateKeenEmail(); 
                    validateKeenLastName();validateKeenFirstName();validateKeenCell();
                    if(firstnameError == true && lastnameError == true &&
                        cellError == true && emailError == true && keenemailError == true
                        && keencellError == true && keenlastnameError == true && keenfirstnameError == true){
                            //--------------valid input-----------
                            return true;
                        }else{
                            //-------------invalid input-----------
                            return false;
                        }
                }else{
                    //---------------------corporate-------------
                    validateCompanyName();validateCompanyNumber();
                    validateCell();validateEmail();
                    validateContactFirstName(); validateContactLastName();
                    validateContactCell();validateContactEmail(); 
                    if(companynameError == true && companynumberError == true &&
                        cellError == true && emailError == true &&
                        contactcellError == true && contactemailError == true &&
                        contactfirstnameError == true && contactlastnameError == true){
                            //--------------valid input-----------
                            return true;
                        }else{
                            //-------------invalid input-----------
                            return false;
                        }
                }
            }else{
                 //-------------invalid input-----------
                 return false;
            }
        } catch (err) {
            alert(err.message);
            return false;
        }
    });
 // button reject 
 $("#reject-tenant").click(function () {
    validateReasons();

    if(reasonsError == true ){
        //valid
        return true;
    }else{
        //failed
        return false;
    }

});
     //button edit 
     $("#btn-edit-submit").click(function () {
        validateTenantType();
        try {
            if (tenanttypeError == true ){
                var TenantTypeVal = $("#TenantClientType").val();
                if(TenantTypeVal == 1){
                    //------------individual------------//
                    validateFirstName(); validateLastName();  validateNationalID();
                    validateCell();validateEmail(); validateKeenCell(); validateKeenEmail;
                    validateKeenFirstName(); validateKeenLastName();
                    if(firstnameError == true && lastnameError == true &&
                        cellError == true && emailError == true && keencellError == true &&
                        keenemailError == true && keenfirstnameError == true && keenlastnameError == true){
                            //--------------valid input-----------
                            return true;
                        }else{
                            //-------------invalid input-----------
                            return false;
                        }
                }else{
                    //---------------------corporate-------------
                    validateCompanyName();validateCompanyNumber();
                    validateCell();validateEmail();
                    validateContactFirstName(); validateContactLastName();
                    validateContactCell();validateContactEmail(); 
                    if(companynameError == true && companynumberError == true &&
                        cellError == true && emailError == true &&
                        contactcellError == true && contactemailError == true &&
                        contactfirstnameError == true && contactlastnameError == true){
                            //--------------valid input-----------
                            return true;
                        }else{
                            //-------------invalid input-----------
                            return false;
                        }
                }
            }else{
                 //-------------invalid input-----------
                 return false;
            }
        } catch (err) {
            alert(err.message);
            return false;
        }
    });

});