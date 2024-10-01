$(document).ready(function () {
 
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