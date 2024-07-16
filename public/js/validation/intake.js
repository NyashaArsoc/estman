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
 //valid client name
 $("#propertyclientnamecheck").hide();
 let propertyclientnameError = true;
 $("#propertyclientname").keyup(function () {
    validatePropertyClientName();
 });
 function validatePropertyClientName() {
     let textValue = $("#propertyclientname").val();
     if (textValue.length == "") {
         $("#propertyclientnamecheck").show();
         propertyclientnameError = false;
         return false;
     } else {
        propertyclientnameError = true;
         $("#propertyclientnamecheck").hide();
     }
 }
 //valid property type
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
  //valid property province
  $("#propertyprovincecheck").hide();
  let propertyprovinceError = true;
  $("#propertyprovince").keyup(function () {
     validatePropertyProvince();
  });
  function validatePropertyProvince() {
      let textValue = $("#propertyprovince").val();
      if (textValue.length == "") {
          $("#propertyprovincecheck").show();
          propertyprovinceError = false;
          return false;
      } else {
        propertyprovinceError = true;
          $("#propertyprovincecheck").hide();
      }
  }
   //valid property town
   $("#propertytowncheck").hide();
   let propertytownError = true;
   $("#propertytown").keyup(function () {
      validatePropertyTown();
   });
   function validatePropertyTown() {
       let textValue = $("#propertytown").val();
       if (textValue.length == "") {
           $("#propertytowncheck").show();
           propertytownError = false;
           return false;
       } else {
        propertytownError = true;
           $("#propertytowncheck").hide();
       }
   }
    //valid property surbub
    $("#propertysurbubcheck").hide();
    let propertysurbubError = true;
    $("#propertysurbub").keyup(function () {
       validatePropertySurbub();
    });
    function validatePropertySurbub() {
        let textValue = $("#propertysurbub").val();
        if (textValue.length == "") {
            $("#propertysurbubcheck").show();
            propertysurbubError = false;
            return false;
        } else {
            propertysurbubError = true;
            $("#propertysurbubcheck").hide();
        }
}
//valid property address
$("#propertyaddresscheck").hide();
    let propertyaddressError = true;
    $("#propertyaddress").keyup(function () {
        validatePropertyAddress();
});
function validatePropertyAddress() {
		let textValue = $("#propertyaddress").val();
		if (textValue.length == "") {
			$("#propertyaddresscheck").show();
			propertyaddressError = false;
			return false;
		} else if (textValue.length < 5) {
			$("#propertyaddresscheck").show();
			$("#propertyaddresscheck").html("**invalid address");
			propertyaddressError = false;
			return false;
		} else {
            const specialChars = /[`!@#$%^&*()_\-=\[\]{};':"\\|,.<>?~\/]/;
            charscheck         =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#propertyaddresscheck").show();
                $("#propertyaddresscheck").html("**remove special chars");
                propertyaddressError = false;
                return false;
            }else{
                propertyaddressError = true;
                $("#propertyaddresscheck").hide();
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
// add val save new property on table
$("#add-new-property").click(function () {
    var propertyaddress				=	$('#propertyaddress').val();
	var propertytype				=	$('#propertytype').val();
	var propertyprovince			=	$('#propertyprovince').val();
	var propertytown			    =	$('#propertytown').val();
	var propertysurbub				=	$('#propertysurbub').val();
    var count = $('#tblnewpropertydetails tr').length - 1;

    validatePropertyType();validatePropertyTown();validatePropertyProvince();
    validatePropertySurbub();validatePropertyAddress();
    try {
        if (propertyaddressError == true && propertyprovinceError==true && propertysurbubError==true
            && propertytownError== true && propertytypeError== true ){
        $('#tblnewpropertydetails tbody').append('<tr class="child"><td>'+count+'</td><td><input name="propertytype[]" class="form-control" value='+propertytype+' readonly/></td><td><input name="propertyprovince[]" class="form-control" value='+propertyprovince+' readonly /></td><td><input name="propertytown[]" class="form-control" value='+propertytown+' readonly /></td><td> <input name="propertysurbub[]" class="form-control " value='+propertysurbub+' readonly/></td><td><textarea name="propertyaddress[]" class="form-control" rows="2" cols="4" readonly>'+propertyaddress+'</textarea></td><td><button style="text-align: right;" class="btn btn-danger" type="button" value="Delete" onclick="deletenewpropertyrow(this)">Delete</button></td></tr>');
		$('#propertyaddress').val('');$('#propertytype').val('');$('#propertyprovince').val(''); $('#propertytown').val(''); $('#propertysurbub').val(''); 
		
        return true;
        }else{
             //-------------invalid input-----------
             return false;
        }
    } catch (err) {
        alert(err.message);
        return false;
    }
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
limits = 20;
     

  
  
 