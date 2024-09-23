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
