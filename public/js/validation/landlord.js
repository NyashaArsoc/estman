$(document).ready(function () { 
    
    
	
    
    
    

     
    
    
    

    
  

   
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
