$(document).ready(function () { 
    //valid type
    $("#landlordtypecheck").hide();
	let landlordtypeError = true;

    $("#PropertyLandlordClientType").keyup(function () {
		validateLandlordType();
	});
    function validateLandlordType() {
		let landlordtypeValue = $("#PropertyLandlordClientType").val();
		if (landlordtypeValue.length == "") {
			$("#landlordtypecheck").show();
			landlordtypeError = false;
			return false;
		} else {
            landlordtypeError = true;
			$("#landlordtypecheck").hide();
		}
	}
  //landlord name
$("#landlordnamecheck").hide();
  let landlordnameError = true;
  $("#PropertyLandlordName").keyup(function () {
      validateLandlordName();
  });
  function validateLandlordName() {
      let textValue = $("#PropertyLandlordName").val();
      if (textValue.length == "") {
          $("#landlordnamecheck").show();
          landlordnameError = false;
          return false;
      } else {
        landlordnameError = true;
          $("#landlordnamecheck").hide();
      }
  }   
    //Province check
$("#provincecheck").hide();
let provinceError = true;
$("#Province").keyup(function () {
    validateProvince();
});
function validateProvince() {
    let textValue = $("#Province").val();
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
$("#City").keyup(function () {
    validateCity();
});
function validateCity() {
    let textValue = $("#City").val();
    if (textValue.length == "") {
        $("#citycheck").show();
        cityError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#citycheck").show();
        $("#citycheck").html("**invalid city name");
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
$("#PropertyType").keyup(function () {
        validatePropertyType();
});
function validatePropertyType() {
        let textValue = $("#PropertyType").val();
        if (textValue.length == "") {
            $("#propertytypecheck").show();
            propertytypeError = false;
            return false;
        } else {
            propertytypeError = true;
            $("#propertytypecheck").hide();
        }
}
//valid location
$("#locationcheck").hide();
let locationError = true;
$("#LocationSurburb").keyup(function () {
    validateLocation();
});
function validateLocation() {
    let textValue = $("#LocationSurburb").val();
    if (textValue.length == "") {
        $("#locationcheck").show();
        locationError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#locationcheck").show();
        $("#locationcheck").html("**invalid location name");
        locationError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~0-9/\s/]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#locationcheck").show();
                $("#locationcheck").html("**follow the required format");
                locationError = false;
                return false;
            }else{
                locationError = true;
                $("#locationcheck").hide();
            }
    }
}
//valid address
$("#propertyaddresscheck").hide();
let propertyaddressError = true;
$("#PropertyAddress").keyup(function () {
    validateAddress();
});
function validateAddress() {
    let textValue = $("#PropertyAddress").val();
    if (textValue.length == "") {
        $("#propertyaddresscheck").show();
        propertyaddressError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#propertyaddresscheck").show();
        $("#propertyaddresscheck").html("**invalid address name");
        propertyaddressError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#propertyaddresscheck").show();
                $("#propertyaddresscheck").html("**follow the required format");
                propertyaddressError = false;
                return false;
            }else{
                propertyaddressError = true;
                $("#propertyaddresscheck").hide();
            }
    }
}
//valid add rooms
$("#addroomscheck").hide();
let addroomsError = true;
$("#AddRooms").keyup(function () {
    validateAddRooms();
});
function validateAddRooms() {
    let textValue = $("#AddRooms").val();
    if (textValue.length == "") {
        $("#addroomscheck").show();
        addroomsError = false;
        return false;
    } else if (textValue.length > 2) {
        $("#addroomscheck").show();
        $("#addroomscheck").html("**two digits allowed");
        addroomsError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#addroomscheck").show();
                $("#addroomscheck").html("**digits only");
                addroomsError = false;
                return false;
            }else{
                addroomsError = true;
                $("#addroomscheck").hide();
            }
    }
}
//valid add bedrooms
$("#addbedroomscheck").hide();
let addbedroomsError = true;
$("#AddBedrooms").keyup(function () {
    validateAddBedRooms();
});
function validateAddBedRooms() {
    let textValue = $("#AddBedrooms").val();
    if (textValue.length == "") {
        $("#addbedroomscheck").show();
        addbedroomsError = false;
        return false;
    } else if (textValue.length > 2) {
        $("#addbedroomscheck").show();
        $("#addbedroomscheck").html("**two digits allowed");
        addbedroomsError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#addbedroomscheck").show();
                $("#addbedroomscheck").html("**digits only");
                addbedroomsError = false;
                return false;
            }else{
                addbedroomsError = true;
                $("#addbedroomscheck").hide();
            }
    }
}
//valid add bathrooms
$("#addbathroomscheck").hide();
let addbathroomsError = true;
$("#AddBathrooms").keyup(function () {
    validateAddBathRooms();
});
function validateAddBathRooms() {
    let textValue = $("#AddBathrooms").val();
    if (textValue.length == "") {
        $("#addbathroomscheck").show();
        addbathroomsError = false;
        return false;
    } else if (textValue.length > 2) {
        $("#addbathroomscheck").show();
        $("#addbathroomscheck").html("**two digits allowed");
        addbathroomsError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#addbathroomscheck").show();
                $("#addbathroomscheck").html("**digits only");
                addbathroomsError = false;
                return false;
            }else{
                addbathroomsError = true;
                $("#addbathroomscheck").hide();
            }
    }
}
//valid total area 
$("#addtotalareacheck").hide();
let addtotalareaError = true;
$("#AddTotalArea").keyup(function () {
    validateAddTotalArea();
});
function validateAddTotalArea() {
    let textValue = $("#AddTotalArea").val();
    if (textValue.length == "") {
        $("#addtotalareacheck").show();
        addtotalareaError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#addtotalareacheck").show();
        $("#addtotalareacheck").html("**at least two digits allowed");
        addtotalareaError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#addtotalareacheck").show();
                $("#addtotalareacheck").html("**digits only or (3.5)");
                addtotalareaError = false;
                return false;
            }else{
                addtotalareaError = true;
                $("#addtotalareacheck").hide();
            }
    }
}
//valid lettable area 
$("#addlettableareacheck").hide();
let addlettableareaError = true;
$("#AddLettableArea").keyup(function () {
    validateAddLettableArea();
});
function validateAddLettableArea() {
    let textValue = $("#AddLettableArea").val();
    if (textValue.length == "") {
        $("#addlettableareacheck").show();
        addlettableareaError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#addlettableareacheck").show();
        $("#addlettableareacheck").html("**atleast two digits allowed");
        addlettableareaError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#addlettableareacheck").show();
                $("#addlettableareacheck").html("**digits only or (3.5)");
                addlettableareaError = false;
                return false;
            }else{
                var totalareavalue = $("#AddTotalArea").val();
                if ( totalareavalue < textValue){
                    // check if total area is bigger that lettable
                    $("#addlettableareacheck").show();
                $("#addlettableareacheck").html("**lettable area is too big");
                addlettableareaError = false;
                return false;
                }else{
                    addlettableareaError = true;
                    $("#addlettableareacheck").hide();
                }
            }
    }
}
 //rental currency
 $("#addcurrencycheck").hide();
 let rentalcurrencyError = true;
 $("#Currency").keyup(function () {
     validateCurrency();
 });
 function validateCurrency() {
     let textValue = $("#Currency").val();
     if (textValue.length == "") {
         $("#addcurrencycheck").show();
         rentalcurrencyError = false;
         return false;
     } else {
        rentalcurrencyError = true;
         $("#addcurrencycheck").hide();
     }
 } 
//valid rate/sqm
$("#addexpectedratecheck").hide();
let addexpectedrateError = true;
$("#AddExpectedRate").keyup(function () {
    validateAddExpectedRate();
});
function validateAddExpectedRate() {
    let textValue = $("#AddExpectedRate").val();
    if (textValue.length == "") {
        $("#addexpectedratecheck").show();
        addexpectedrateError = false;
        return false;
    } else if (textValue.length > 4) {
        $("#addexpectedratecheck").show();
        $("#addexpectedratecheck").html("**four digits allowed");
        addexpectedrateError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#addexpectedratecheck").show();
                $("#addexpectedratecheck").html("**digits only or (3.5)");
                addexpectedrateError = false;
                return false;
            }else{
                addexpectedrateError = true;
                $("#addexpectedratecheck").hide();
            }
    }
}
//valid rental
$("#addexpectedrentalcheck").hide();
let addexpectedrentalError = true;
$("#AddExpectedRental").keyup(function () {
    validateAddExpectedRental();
});
function validateAddExpectedRental() {
    let textValue = $("#AddExpectedRental").val();
    if (textValue.length == "") {
        $("#addexpectedrentalcheck").show();
        addexpectedrentalError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#addexpectedrentalcheck").show();
        $("#addexpectedrentalcheck").html("**atleast two digits allowed");
        addexpectedrentalError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#addexpectedrentalcheck").show();
                $("#addexpectedrentalcheck").html("**digits only or (3.5)");
                addexpectedrentalError = false;
                return false;
            }else{
                addexpectedrentalError = true;
                $("#addexpectedrentalcheck").hide();
            }
    }
}
 //commission type
 $("#commissiontypecheck").hide();
 let commissiontypeError = true;
 $("#CommissionType").keyup(function () {
     validateCommissionType();
 });
 function validateCommissionType() {
     let textValue = $("#CommissionType").val();
     if (textValue.length == "") {
         $("#commissiontypecheck").show();
         commissiontypeError = false;
         return false;
     } else {
        commissiontypeError = true;
         $("#commissiontypecheck").hide();
     }
 } 
//valid rate/sqm
$("#commissionpercentcheck").hide();
let commissionpercentError = true;
$("#CommissionPercentage").keyup(function () {
    validateCommissionPercent();
});
function validateCommissionPercent() {
    let textValue = $("#CommissionPercentage").val();
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
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#commissionpercentcheck").show();
                $("#commissionpercentcheck").html("**digits only or (3.5)");
                commissionpercentError = false;
                return false;
            }else{
                commissionpercentError = true;
                $("#commissionpercentcheck").hide();
            }
    }
}
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
//valid security charges
$("#remitcalcdeductionscheck").hide();
$("#securitychargecheck").hide();
let securitychargesError = true;
$("#SecurityCharge").keyup(function () {
    validateSecurityCharge();
});
function validateSecurityCharge() {
    let textPaid        = $("#BillCollections").val();
    let textVal         = $("#BillVAT").val();
    let textRate        = $("#BillRates").val();
    let textOpp         = $("#BillOppC").val();
    let textInt         = $("#BillInterest").val();
    let textCharge_1    = $("#CaretakerCharge").val();
    let textCharge_2    = $("#OtherExpensesCharge").val();
    let textValue       = $("#SecurityCharge").val();
    if(textVal==''){textVal=0;} if(textRate==''){textRate=0;}
    if(textOpp==''){textOpp=0;} if(textInt==''){textInt=0;}
    if(textCharge_1==''){textCharge_1=0;} if(textCharge_2==''){textCharge_2=0;}
    if (textValue.length != "") {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#securitychargecheck").show();
            $("#securitychargecheck").html("**digits only or (3.5)");
            securitychargesError = false;
            return false;
        }else{
            TotalDeductions  = (parseFloat(textVal) +
                parseFloat(textRate) + parseFloat(textOpp) +parseFloat(textInt) +
                parseFloat(textCharge_1) + parseFloat(textCharge_2) + parseFloat(textValue));
            TotalRemittance = textPaid - TotalDeductions;
            securitychargesError = true;
            $("#securitychargecheck").hide();
            $("#remitcalcdeductionscheck").show();
            $("#remitcalcdeductionscheck").html(TotalDeductions);
            $("#remitcalcremittancecheck").show();
            $("#remitcalcremittancecheck").html(TotalRemittance);
        }
    } else if (textValue.length > 12) {
        $("#securitychargecheck").show();
        $("#securitychargecheck").html("**twelve digits allowed");
        securitychargesError = false;
        return false;
    }
}
$("#caretakerchargecheck").hide();
let caretakerchargesError = true;
$("#CaretakerCharge").keyup(function () {
    validateCaretakerCharge();
});
function validateCaretakerCharge() {
    let textPaid        = $("#BillCollections").val();
    let textVal         = $("#BillVAT").val();
    let textRate        = $("#BillRates").val();
    let textOpp         = $("#BillOppC").val();
    let textInt         = $("#BillInterest").val();
    let textCharge_1    = $("#SecurityCharge").val();
    let textCharge_2    = $("#OtherExpensesCharge").val();
    if(textVal==''){textVal=0;} if(textRate==''){textRate=0;}
    if(textOpp==''){textOpp=0;} if(textInt==''){textInt=0;}
    if(textCharge_1==''){textCharge_1=0;} if(textCharge_2==''){textCharge_2=0;}
    let textValue = $("#CaretakerCharge").val();
    if (textValue.length != "") {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#caretakerchargecheck").show();
            $("#caretakerchargecheck").html("**digits only or (3.5)");
            caretakerchargesError = false;
            return false;
        }else{
            TotalDeductions  = (parseFloat(textVal) +
                parseFloat(textRate) + parseFloat(textOpp) +parseFloat(textInt) +
                parseFloat(textCharge_1) + parseFloat(textCharge_2) + parseFloat(textValue));
                TotalRemittance = textPaid - TotalDeductions;
            caretakerchargesError = true;
            $("#caretakerchargecheck").hide();
            $("#remitcalcdeductionscheck").show();
            $("#remitcalcdeductionscheck").html(TotalDeductions);
            $("#remitcalcremittancecheck").show();
            $("#remitcalcremittancecheck").html(TotalRemittance);
        }
    } else if (textValue.length > 12) {
        $("#caretakerchargecheck").show();
        $("#caretakerchargecheck").html("**twelve digits allowed");
        caretakerchargesError = false;
        return false;
    }
}
$("#otherexpensecheck").hide();
let expensechargesError = true;
$("#OtherExpensesCharge").keyup(function () {
    validateOtherExpensesCharge();
});
function validateOtherExpensesCharge() {
    let textPaid        = $("#BillCollections").val();
    let textVal         = $("#BillVAT").val();
    let textRate        = $("#BillRates").val();
    let textOpp         = $("#BillOppC").val();
    let textInt         = $("#BillInterest").val();
    let textCharge_1    = $("#SecurityCharge").val();
    let textCharge_2    = $("#CaretakerCharge").val();
    if(textVal==''){textVal=0;} if(textRate==''){textRate=0;}
    if(textOpp==''){textOpp=0;} if(textInt==''){textInt=0;}
    if(textCharge_1==''){textCharge_1=0;} if(textCharge_2==''){textCharge_2=0;}
    let textValue = $("#OtherExpensesCharge").val();
    if (textValue.length != "") {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#otherexpensecheck").show();
            $("#otherexpensecheck").html("**digits only or (3.5)");
            expensechargesError = false;
            return false;
        }else{
            TotalDeductions  = (parseFloat(textVal) +
                parseFloat(textRate) + parseFloat(textOpp) +parseFloat(textInt) +
                parseFloat(textCharge_1) + parseFloat(textCharge_2) + parseFloat(textValue));
                TotalRemittance = textPaid - TotalDeductions;
            expensechargesError = true;
            $("#otherexpensecheck").hide();
            $("#remitcalcdeductionscheck").show();
            $("#remitcalcdeductionscheck").html(TotalDeductions);
            $("#remitcalcremittancecheck").show();
            $("#remitcalcremittancecheck").html(TotalRemittance);
        }
    } else if (textValue.length > 12) {
        $("#otherexpensecheck").show();
        $("#otherexpensecheck").html("**twelve digits allowed");
        expensechargesError = false;
        return false;
    }
}
//button submit
$("#btn-submit-add").click(function () {
        try {
            validateLandlordType();validateLandlordName();validateProvince();
            validateCity();validatePropertyType();validateLocation();
            validateAddress();validateCurrency();validateCommissionType();
            validateCommissionPercent();
            if(landlordtypeError == true && landlordnameError== true && provinceError == true
                && cityError == true && propertytypeError == true && locationError == true &&
                propertyaddressError == true && rentalcurrencyError == true && 
                commissiontypeError == true && commissionpercentError == true){
                //valid for above check the property type
                var PropertyTypeVal = $("#PropertyType").val();
                if (PropertyTypeVal == 1){ //residential
                    validateAddRooms(); validateAddBathRooms(); validateAddBedRooms();
                    validateAddExpectedRental();
                    if (addroomsError == true && addbedroomsError == true && 
                        addbathroomsError == true && addexpectedrentalError == true){
                        return true;
                        }else{
                            return false;
                        }
                }else{ // commercial or any other
                    validateAddTotalArea(); validateAddExpectedRate(); validateAddLettableArea();
                    if (addtotalareaError == true && addexpectedrateError == true &&
                        addlettableareaError == true){
                            return true;
                        }else{
                            return false;
                        }
                }
                }else{
                    return false;
                }
        } catch (err) {
            alert(err.message);
            return false;
        }
       
    });
 // button reject 
 $("#reject-property").click(function () {
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
$("#btn-submit-edit").click(function () {
    try {
        validateLandlordType();validateLandlordName();validateProvince();
        validateCity();validatePropertyType();validateLocation();
        validateAddress();validateCurrency();validateCommissionType();
        validateCommissionPercent();
        if(landlordtypeError == true && landlordnameError== true && provinceError == true
            && cityError == true && propertytypeError == true && locationError == true &&
            propertyaddressError == true && rentalcurrencyError == true && 
            commissiontypeError == true && commissionpercentError == true){
            //valid for above check the property type
            var PropertyTypeVal = $("#PropertyType").val();
            if (PropertyTypeVal == 1){ //residential
                validateAddRooms(); validateAddBathRooms(); validateAddBedRooms();
                validateAddExpectedRental();
                if (addroomsError == true && addbedroomsError == true && 
                    addbathroomsError == true && addexpectedrentalError == true){
                    return true;
                    }else{
                        return false;
                    }
            }else{ // commercial or any other
                validateAddTotalArea(); validateAddExpectedRate(); validateAddLettableArea();
                if (addtotalareaError == true && addexpectedrateError == true &&
                    addlettableareaError == true){
                        return true;
                    }else{
                        return false;
                    }
            }
            }else{
                return false;
            }
    } catch (err) {
        alert(err.message);
        return false;
    }
   
});

// button reject 
$("#btn-pre-remit").click(function () {
    validateSecurityCharge();validateCaretakerCharge();validateOtherExpensesCharge();

    if(securitychargesError == true && caretakerchargesError==true && expensechargesError==true ){
        //valid
        return true;
    }else{
        //failed
        return false;
    }

});
});