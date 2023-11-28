$(document).ready(function () { 
// tenant type
$("#tenanttypecheck").hide();
  let tenanttypeError = true;
  $("#LeaseTenantClientType").keyup(function () {
      validateTenantType();
  });
  function validateTenantType() {
      let textValue = $("#LeaseTenantClientType").val();
      if (textValue.length == "") {
          $("#tenanttypecheck").show();
          tenanttypeError = false;
          return false;
      } else {
        tenanttypeError = true;
          $("#tenanttypecheck").hide();
      }
  }  
// tenant name
$("#tenantnamecheck").hide();
  let tenantnameError = true;
  $("#LeaseTenantName").keyup(function () {
      validateTenantName();
  });
  function validateTenantName() {
      let textValue = $("#LeaseTenantName").val();
      if (textValue.length == "") {
          $("#tenantnamecheck").show();
          tenantnameError = false;
          return false;
      } else {
        tenantnameError = true;
          $("#tenantnamecheck").hide();
      }
  } 
//property type
$("#propertytypecheck").hide();
  let propertytypeError = true;
  $("#LeasePropertyType").keyup(function () {
      validatePropertyType();
  });
  function validatePropertyType() {
      let textValue = $("#LeasePropertyType").val();
      if (textValue.length == "") {
          $("#propertytypecheck").show();
          propertytypeError = false;
          return false;
      } else {
        propertytypeError = true;
          $("#propertytypecheck").hide();
      }
  }
//property type
$("#propertyaddresscheck").hide();
  let propertyaddressError = true;
  $("#LeasePropertyAddress").keyup(function () {
      validatePropertyAddress();
  });
  function validatePropertyAddress() {
      let textValue = $("#LeasePropertyAddress").val();
      if (textValue.length == "") {
          $("#propertyaddresscheck").show();
          propertyaddressError = false;
          return false;
      } else {
        propertyaddressError = true;
          $("#propertyaddresscheck").hide();
      }
  }
  //inspection period
$("#inspectionscheck").hide();
let inspectionsError = true;
$("#LeaseInspectionPeriod").keyup(function () {
    validateInspection();
});
function validateInspection() {
    let textValue = $("#LeaseInspectionPeriod").val();
    if (textValue.length == "") {
        $("#inspectionscheck").show();
        inspectionsError = false;
        return false;
    } else {
        inspectionsError = true;
        $("#inspectionscheck").hide();
    }
}
 //rent review period
 $("#rentreviewcheck").hide();
 let rentreviewError = true;
 $("#LeaseRentReviewPeriod").keyup(function () {
     validateRentReview();
 });
 function validateRentReview() {
     let textValue = $("#LeaseRentReviewPeriod").val();
     if (textValue.length == "") {
         $("#rentreviewcheck").show();
         rentreviewError = false;
         return false;
     } else {
        rentreviewError = true;
         $("#rentreviewcheck").hide();
     }
 }
  //valid from
  $("#validfromcheck").hide();
  let validfromError = true;
  $("#LeaseValidFrom").keyup(function () {
      validateValidFrom();
  });
  function validateValidFrom() {
      let textValue = $("#LeaseValidFrom").val();
      if (textValue.length == "") {
          $("#validfromcheck").show();
          validfromError = false;
          return false;
      } else {
        validfromError = true;
          $("#validfromcheck").hide();
      }
  }
   //valid to
   $("#validtocheck").hide();
   let validtoError = true;
   $("#LeaseValidTo").keyup(function () {
       validateValidTo();
   });
   function validateValidTo() {
       let textValue = $("#LeaseValidTo").val();
       if (textValue.length == "") {
           $("#validtocheck").show();
           validtoError = false;
           return false;
       } else {
        validtoError = true;
           $("#validtocheck").hide();
       }
   }
//valid area taken
$("#areatakencheck").hide();
let areatakenError = true;
$("#AreaTaken").keyup(function () {
    validateAreaTaken();
});
function validateAreaTaken() {
    let textValue = $("#AreaTaken").val();
    if (textValue.length == "") {
        $("#areatakencheck").show();
        areatakenError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#areatakencheck").show();
        $("#areatakencheck").html("**at least two digits allowed");
        areatakenError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#areatakencheck").show();
                $("#areatakencheck").html("**digits only or (3.5)");
                areatakenError = false;
                return false;
            }else{
                areatakenError = true;
                $("#areatakencheck").hide();
            }
    }
}
 //valid rental currency
 $("#rentalcurrencycheck").hide();
 let rentalcurrencyError = true;
 $("#RentCurrency").keyup(function () {
     validateRentCurrency();
 });
function validateRentCurrency() {
    let textValue = $("#RentCurrency").val();
    if (textValue.length == "") {
        $("#rentalcurrencycheck").show();
        rentalcurrencyError = false;
        return false;
    } else {
        rentalcurrencyError = true;
        $("#rentalcurrencycheck").hide();
    }
}
//rate sqm
$("#ratesqmcheck").hide();
let ratesqmError = true;
$("#RateSqm").keyup(function () {
    validateRateSqm();
});
function validateRateSqm() {
    let textValue = $("#RateSqm").val();
    if (textValue.length == "") {
        $("#ratesqmcheck").show();
        ratesqmError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#ratesqmcheck").show();
                $("#ratesqmcheck").html("**digits only or (3.5)");
                ratesqmError = false;
                return false;
            }else{
                ratesqmError = true;
                $("#ratesqmcheck").hide();
            }
    }
}
//expected rental
$("#expectedrentalcheck").hide();
let expectedrentalError = true;
$("#ExpectedRental").keyup(function () {
    validateExpectedRent();
});
function validateExpectedRent() {
    let textValue = $("#ExpectedRental").val();
    if (textValue.length == "") {
        $("#expectedrentalcheck").show();
        expectedrentalError = false;
        return false;
    } else if (textValue.length < 2) {
        $("#expectedrentalcheck").show();
        $("#expectedrentalcheck").html("**at least two digits allowed");
        expectedrentalError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#expectedrentalcheck").show();
                $("#expectedrentalcheck").html("**digits only or (13.5)");
                expectedrentalError = false;
                return false;
            }else{
                expectedrentalError = true;
                $("#expectedrentalcheck").hide();
            }
    }
}
//rate sqm
$("#propertydescriptioncheck").hide();
let propertydescriptionError = true;
$("#PropertyDescription").keyup(function () {
    validatePropertyDescription();
});
function validatePropertyDescription() {
    let textValue = $("#PropertyDescription").val();
    if (textValue.length == "") {
        $("#propertydescriptioncheck").show();
        propertydescriptionError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#propertydescriptioncheck").show();
        $("#propertydescriptioncheck").html("**invalid description");
        propertydescriptionError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#propertydescriptioncheck").show();
                $("#propertydescriptioncheck").html("**follow the required format");
                propertydescriptionError = false;
                return false;
            }else{
                propertydescriptionError = true;
                $("#propertydescriptioncheck").hide();
            }
    }
}

 //valid operation cost & currency
 $("#operationcurrencycheck").hide();
 $("#operationalcostcheck").hide();
 let operationcostcurrencyError = true;
 $("#OperationCurrency").keyup(function() {
    validateOperationCostCurrency();
 });
 $("#OperationalCost").keyup(function() {
    validateOperationCostCurrency();
 });
function validateOperationCostCurrency(){
    let OperationCurrencyVal       = $("#OperationCurrency").val();
    let OperationalCostVal         = $("#OperationalCost").val();
    if (OperationCurrencyVal != '' && OperationalCostVal == ''){
        $("#operationalcostcheck").show();
        $("#operationcurrencycheck").hide();
        operationcostcurrencyError = false;
        return false;
    }else if (OperationCurrencyVal == '' && OperationalCostVal != ''){
        $("#operationalcostcheck").hide();
        $("#operationcurrencycheck").show();
        operationcostcurrencyError = false;
        return false;
    }else if (OperationCurrencyVal != '' && OperationalCostVal != ''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(OperationalCostVal);
        if (charscheck == true){
             $("#operationalcostcheck").show();
            $("#operationalcostcheck").html("**digits only or (13.5)");
            operationcostcurrencyError = false;
            return false;
        }else{
            operationcostcurrencyError = true;
            $("#operationcurrencycheck").hide();
            $("#operationalcostcheck").hide();
        }
    }else {
            operationcostcurrencyError = true;
            $("#operationcurrencycheck").hide();
            $("#operationalcostcheck").hide()
    }
}
//valid rates cost & currency
$("#ratescurrencycheck").hide();
$("#ratescostcheck").hide();
let ratescostcurrencyError = true;
$("#RatesCost").keyup(function() {
   validateRatesCostCurrency();
});
$("#RatesCurrency").keyup(function() {
    validateRatesCostCurrency();
});
function validateRatesCostCurrency(){
    let RatesCurrencyVal        = $("#RatesCurrency").val();
    let RatesCostVal            = $("#RatesCost").val();
    if (RatesCurrencyVal != '' && RatesCostVal == ''){
        $("#ratescostcheck").show();
        $("#ratescurrencycheck").hide();
        ratescostcurrencyError = false;
        return false;
    }else if (RatesCurrencyVal == '' && RatesCostVal != ''){
        $("#ratescostcheck").hide();
        $("#ratescurrencycheck").show();
        ratescostcurrencyError = false;
        return false;
    }else if (RatesCurrencyVal != '' && RatesCostVal != ''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(RatesCostVal);
        if (charscheck == true){
             $("#ratescostcheck").show();
            $("#ratescostcheck").html("**digits only or (13.5)");
            ratescostcurrencyError = false;
            return false;
        }else{
            ratescostcurrencyError = true;
            $("#ratescurrencycheck").hide();
            $("#ratescostcheck").hide();
        }
    }else {
            ratescostcurrencyError = true;
            $("#ratescurrencycheck").hide();
            $("#ratescostcheck").hide()
    }
}
//valid deposit amt & currency
$("#depositcurrencycheck").hide();
$("#depositpaidcheck").hide();
let depositamtcurrencyError = true;
$("#DepositCurrency").keyup(function() {
   validateDepositAmtCurrency();
});
$("#DepositPaid").keyup(function() {
    validateDepositAmtCurrency();
});
function validateDepositAmtCurrency(){
    let DepositCurrencyVal         = $("#DepositCurrency").val();
    let DepositAmtVal              = $("#DepositPaid").val();
    if (DepositCurrencyVal != '' && DepositAmtVal == ''){
        $("#depositpaidcheck").show();
        $("#depositcurrencycheck").hide();
        depositamtcurrencyError = false;
        return false;
    }else if (DepositCurrencyVal == '' && DepositAmtVal != ''){
        $("#depositpaidcheck").hide();
        $("#depositcurrencycheck").show();
        depositamtcurrencyError = false;
        return false;
    }else if (DepositCurrencyVal != '' && DepositAmtVal != ''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(DepositAmtVal);
        if (charscheck == true){
             $("#depositpaidcheck").show();
            $("#depositpaidcheck").html("**digits only or (13.5)");
            depositamtcurrencyError = false;
            return false;
        }else{
            depositamtcurrencyError = true;
            $("#depositcurrencycheck").hide();
            $("#depositpaidcheck").hide();
        }
    }else {
            depositamtcurrencyError = true;
            $("#depositcurrencycheck").hide();
            $("#depositpaidcheck").hide()
    }
}
//valid bal bd amt & currency
$("#bdcurrencycheck").hide();
$("#bdamountcheck").hide();
let balbdamtcurrencyError = true;
$("#BalanceBDCurrency").keyup(function() {
   validateBalbdAmtCurrency();
});
$("#BDamount").keyup(function() {
    validateBalbdAmtCurrency();
});
function validateBalbdAmtCurrency(){
    let BalBDCurrencyVal           = $("#BalanceBDCurrency").val();
    let BalBDCostVal               = $("#BDamount").val();
    if (BalBDCurrencyVal != '' && BalBDCostVal == ''){
        $("#bdamountcheck").show();
        $("#bdcurrencycheck").hide();
        balbdamtcurrencyError = false;
        return false;
    }else if (BalBDCurrencyVal == '' && BalBDCostVal != ''){
        $("#bdamountcheck").hide();
        $("#bdcurrencycheck").show();
        balbdamtcurrencyError = false;
        return false;
    }else if (BalBDCurrencyVal != '' && BalBDCostVal != ''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(BalBDCostVal);
        if (charscheck == true){
             $("#bdamountcheck").show();
            $("#bdamountcheck").html("**digits only or (13.5)");
            balbdamtcurrencyError = false;
            return false;
        }else{
            balbdamtcurrencyError = true;
            $("#bdamountcheck").hide();
            $("#bdcurrencycheck").hide();
        }
    }else {
            balbdamtcurrencyError = true;
            $("#bdamountcheck").hide();
            $("#bdcurrencycheck").hide()
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
// btn submit 
$("#btn-submit-lease").click(function () {
    try {
        validateTenantType();validateTenantName(); validatePropertyType();
        validatePropertyAddress(); validateInspection(); validateRentReview();
        validateValidFrom(); validateValidTo();validateRentCurrency();
        validatePropertyDescription();validateOperationCostCurrency();
        validateRatesCostCurrency();validateDepositAmtCurrency();validateBalbdAmtCurrency();
        if(tenanttypeError==true && tenantnameError==true && propertytypeError==true &&
            propertyaddressError==true && inspectionsError==true && rentreviewError==true &&
            validfromError==true && validtoError==true && rentalcurrencyError==true &&
            propertydescriptionError == true &&  operationcostcurrencyError ==true &&
            ratescostcurrencyError==true && depositamtcurrencyError==true && balbdamtcurrencyError==true){
                //valid response
                var PropertyTypeVal            = $("#LeasePropertyType").val();
                var LeaseFromVal               = $("#LeaseValidFrom").val();
                var LeaseToVal                 = $("#LeaseValidTo").val();
                var Date_LeaseFromVal          = new Date(LeaseFromVal);
                var Date_LeaseToVal            = new Date(LeaseToVal);
                var AreaTakenVal               = $("#AreaTaken").val();
                var OccupiedAreaVal            = $("#OccupiedArea").val();
                var TotalAreaAvailableVal      = $("#AvailableLettableArea").val();
                let RemainingArea              = (parseFloat(TotalAreaAvailableVal) - 
                (parseFloat(OccupiedAreaVal) + parseFloat(AreaTakenVal)));
                if (Date_LeaseFromVal >= Date_LeaseToVal){
                    $("#validfromcheck").show();
                    $("#validfromcheck").html("**invalid lease period**");
                    return false;
                }else{
                    if (PropertyTypeVal == 1){ //residential
                        validateExpectedRent();
                        if(expectedrentalError == true){return true;}else{return false;}
                    }else{ //commercial
                        validateAreaTaken(); validateRateSqm();
                        if(areatakenError==true && ratesqmError==true){
                            if(RemainingArea < 1){
                            $("#areatakencheck").show();
                            $("#areatakencheck").html("**area allocated is more than available space**"); 
                            return false 
                            }else{ return true;}
                           }
                        else{return false;}
                    }
                }
            }else{//invalid response
            return false;
        }   
    } catch (err) {
        alert(err.message);
        return false;
    }
});
// button reject 
$("#reject-lease").click(function () {
    validateReasons();
    if(reasonsError == true ){
        //valid
        return true;
    }else{
        //failed
        return false;
    }
});
// btn edit 
$("#btn-edit-lease").click(function () {
    try {
        validateTenantType();validateTenantName(); validatePropertyType();
        validatePropertyAddress(); validateInspection(); validateRentReview();
        validateValidFrom(); validateValidTo();validateRentCurrency();
        validatePropertyDescription();validateOperationCostCurrency();
        validateRatesCostCurrency();validateDepositAmtCurrency();validateBalbdAmtCurrency();
        if(tenanttypeError==true && tenantnameError==true && propertytypeError==true &&
            propertyaddressError==true && inspectionsError==true && rentreviewError==true &&
            validfromError==true && validtoError==true && rentalcurrencyError==true &&
            propertydescriptionError == true &&  operationcostcurrencyError ==true &&
            ratescostcurrencyError==true && depositamtcurrencyError==true && balbdamtcurrencyError==true){
                //valid response
                var PropertyTypeVal            = $("#LeasePropertyType").val();
                var LeaseFromVal               = $("#LeaseValidFrom").val();
                var LeaseToVal                 = $("#LeaseValidTo").val();
                var Date_LeaseFromVal          = new Date(LeaseFromVal);
                var Date_LeaseToVal            = new Date(LeaseToVal);
                var AreaTakenVal               = $("#AreaTaken").val();
                var OccupiedAreaVal            = $("#OccupiedArea").val();
                var TotalAreaAvailableVal      = $("#AvailableLettableArea").val();
                let RemainingArea              = (parseFloat(TotalAreaAvailableVal) - 
                (parseFloat(OccupiedAreaVal) + parseFloat(AreaTakenVal)));
                if (Date_LeaseFromVal >= Date_LeaseToVal){
                    $("#validfromcheck").show();
                    $("#validfromcheck").html("**invalid lease period**");
                    return false;
                }else{
                    if (PropertyTypeVal == 1){ //residential
                        validateExpectedRent();
                        if(expectedrentalError == true){return true;}else{return false;}
                    }else{ //commercial
                        validateAreaTaken(); validateRateSqm();
                        if(areatakenError==true && ratesqmError==true){
                            if(RemainingArea < 1){
                            $("#areatakencheck").show();
                            $("#areatakencheck").html("**area allocated is more than available space**"); 
                            return false 
                            }else{ return true;}
                           }
                        else{return false;}
                    }
                }
            }else{//invalid response
            return false;
        }   
    } catch (err) {
        alert(err.message);
        return false;
    }
});

// btn submit 
$("#btn-submit-lease-new").click(function () {
    try {
        validateTenantType();validateTenantName(); validatePropertyType();
        validatePropertyAddress(); validateInspection(); validateRentReview();
        validateValidFrom(); validateValidTo();validateRentCurrency();
        validatePropertyDescription();
      
        if(tenanttypeError==true && tenantnameError==true && propertytypeError==true &&
            propertyaddressError==true && inspectionsError==true && rentreviewError==true &&
            validfromError==true && validtoError==true && rentalcurrencyError==true &&
            propertydescriptionError == true ){
                //valid response
                var PropertyTypeVal            = $("#LeasePropertyType").val();
                var LeaseFromVal               = $("#LeaseValidFrom").val();
                var LeaseToVal                 = $("#LeaseValidTo").val();
                var Date_LeaseFromVal          = new Date(LeaseFromVal);
                var Date_LeaseToVal            = new Date(LeaseToVal);
                var AreaTakenVal               = $("#AreaTaken").val();
                var OccupiedAreaVal            = $("#OccupiedArea").val();
                var TotalAreaAvailableVal      = $("#AvailableLettableArea").val();
                let RemainingArea              = (parseFloat(TotalAreaAvailableVal) - 
                (parseFloat(OccupiedAreaVal) + parseFloat(AreaTakenVal)));
                if (Date_LeaseFromVal >= Date_LeaseToVal){
                    $("#validfromcheck").show();
                    $("#validfromcheck").html("**invalid lease period**");
                    return false;
                }else{
                    if (PropertyTypeVal == 1){ //residential
                        validateExpectedRent();
                        if(expectedrentalError == true){return true;}else{return false;}
                    }else{ //commercial
                        validateAreaTaken(); validateRateSqm();
                        if(areatakenError==true && ratesqmError==true){
                            if(RemainingArea < 1){
                            $("#areatakencheck").show();
                            $("#areatakencheck").html("**area allocated is more than available space**"); 
                            return false 
                            }else{ return true;}
                           }
                        else{return false;}
                    }
                }
            }else{//invalid response
            return false;
        }   
    } catch (err) {
        alert(err.message);
        return false;
    }
});
});