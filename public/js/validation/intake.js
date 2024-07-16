 //valid type
 $("#clientypecheck").hide();
 let clienttypeError = true;
 
 $("#clienttype").keyup(function () {
     validateClientType();
 });
 function validateClientType() {
     let clienttypeError = $("#clienttype").val();
     if (clienttypeError.length == "") {
         $("#clientypecheck").show();
         clienttypeError = false;
         return false;
     } else {
        clienttypeError = true;
         $("#clientypecheck").hide();
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
              $("#lastnamecheck").html("**follow the required format");
              lastnameError = false;
              return false;
          }else{
              lastnameError = true;
              $("#lastnamecheck").hide();
          }
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
   //valid cell
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
/*---------------------button submit------------------------------------------*/
// add val new client
$("#btn-val-new-client").click(function () {
    validateClientType();
    try {
        if (clienttypeError == true ){
            var ClientTypeVal = $("#clienttype").val();
            if(ClientTypeVal == 1){
                //------------individual------------//
                validateFirstName(); validateLastName();  validateNationalID();
                validateCell();validateEmail(); 
                if(firstnameError == true && lastnameError == true &&
                    cellError == true && emailError == true){
                        //--------------valid input-----------
                        return true;
                    }else{
                        //-------------invalid input-----------
                        return false;
                    }
            }else{
                //---------------------corporate-------------
                validateCompanyName();validateCell();validateEmail();
                validateContactFirstName(); validateContactLastName();
                validateContactCell();validateContactEmail(); 
                if(companynameError == true && cellError == true && emailError == true &&
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
     

  
  
 