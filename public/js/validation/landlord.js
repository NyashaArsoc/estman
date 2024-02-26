$(document).ready(function () { 
    //valid type
    $("#landlordtypecheck").hide();
	let landlordtypeError = true;
    
	$("#LandlordClientType").keyup(function () {
		validateLandlordType();
	});
    function validateLandlordType() {
		let landlordtypeValue = $("#LandlordClientType").val();
		if (landlordtypeValue.length == "") {
			$("#landlordtypecheck").show();
			landlordtypeError = false;
			return false;
		} else {
            landlordtypeError = true;
			$("#landlordtypecheck").hide();
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

    //valid firstname
    $("#firstnamecheck").hide();
	let firstnameError = true;
	$("#FirstName").keyup(function () {
		validateFirstName();
	});
    function validateFirstName() {
		let firstnameValue = $("#FirstName").val();
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
	$("#LastName").keyup(function () {
		validateLastName();
	});
    function validateLastName() {
		let lastnameValue = $("#LastName").val();
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
    //valid national ID
    $("#nationalidcheck").hide();
	let nationalidError = true;
	$("#NationalIDNumber").keyup(function () {
		validateNationalID();
	});
    function validateNationalID() {

		let nationalidValue = $("#NationalIDNumber").val();
		if (nationalidValue.length == "") {
			$("#nationalidcheck").show();
			nationalidError = false;
			return false;
		} else if (10 > nationalidValue.length  || nationalidValue.length > 12 ) {
			$("#nationalidcheck").show();
			$("#nationalidcheck").html("**invalid id number");
			nationalidError = false;
			return false;
		} else {
                const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~a-z/\s/]/;
                charscheck         =  specialChars.test(nationalidValue);
                if (charscheck == true){
                     $("#nationalidcheck").show();
                    $("#nationalidcheck").html("**follow the required format 20222222Y00");
                     nationalidError = false;
                    return false;
                }else{
                    nationalidError = true;
                    $("#nationalidcheck").hide();
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

   
      //valid type
      $("#banklandlordtypecheck").hide();
      let banklandlordtypeError = true;
      
      $("#BankLandlordClientType").keyup(function () {
          validateBankLandlordType();
      });
      function validateBankLandlordType() {
          let textValue = $("#BankLandlordClientType").val();
          if (textValue.length == "") {
              $("#banklandlordtypecheck").show();
              textValue = false;
              return false;
          } else {
            banklandlordtypeError = true;
              $("#banklandlordtypecheck").hide();
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
    $("#btn-submit").click(function () {
        validateLandlordType();
        try {
            if (landlordtypeError == true ){
                var LandlordTypeVal = $("#LandlordClientType").val();
                if(LandlordTypeVal == 1){
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

     //button save
     $("#add-banking-item").click(function () {
        validateBankName();
        validateAccountNumber();
        validateAccountName();
        validateCurrencyID();
        if(accountnameError == true && banknameError == true &&
            accountnumberError == true && currencyError == true ){
            //valid
           // alert('valid');
            return true;
        }else{
            //failed
           // alert('failed');
            return false;
        }

    });

     //button save
     $("#btn-submit-banking").click(function () {
        validateBankLandlordType();
   
        if(banklandlordtypeError == true ){
            //valid
            return true;
        }else{
            //failed
            return false;
        }

    });
    // button reject 
    $("#reject-landlord").click(function () {
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
            validateLandlordType();
            try {
                if (landlordtypeError == true ){
                    var LandlordTypeVal = $("#LandlordClientType").val();
                    if(LandlordTypeVal == 1){
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
