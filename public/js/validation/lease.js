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
 //maintenance period
 $("#maintenancecheck").hide();
 let maintenanceError = true;
 $("#LeaseMaintenancePeriod").keyup(function () {
     validateMaintenance();
 });
 function validateMaintenance() {
     let textValue = $("#LeaseMaintenancePeriod").val();
     if (textValue.length == "") {
         $("#maintenancecheck").show();
         maintenanceError = false;
         return false;
     } else {
        maintenanceError = true;
         $("#maintenancecheck").hide();
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
    } else if (textValue.length < 2) {
        $("#ratesqmcheck").show();
        $("#ratesqmcheck").html("**at least two digits allowed");
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
//operational cost
$("#operationalcostcheck").hide();
let operationalcostError = true;
$("#OperationalCost").keyup(function () {
    validateOperationalCost();
});
function validateOperationalCost() {
    let textValue = $("#OperationalCost").val();
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#operationalcostcheck").show();
                $("#operationalcostcheck").html("**digits only or (13.5)");
                operationalcostError = false;
                return false;
            }else{
                operationalcostError = true;
                $("#operationalcostcheck").hide();
            }
}
//rates cost
$("#ratescostcheck").hide();
let ratescostError = true;
$("#RatesCost").keyup(function () {
    validateRatesCost();
});
function validateRatesCost() {
    let textValue = $("#RatesCost").val();
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#ratescostcheck").show();
                $("#ratescostcheck").html("**digits only or (13.5)");
                ratescostError = false;
                return false;
            }else{
                ratescostError = true;
                $("#ratescostcheck").hide();
            }
}
 //valid deposit currency
 $("#depositcurrencycheck").hide();
 let depositcurrencyError = true;
 $("#DepositCurrency").keyup(function () {
     validateDepositCurrency();
 });
function validateDepositCurrency() {
    let textValue = $("#DepositCurrency").val();
    if (textValue.length == "") {
        $("#depositcurrencycheck").show();
        depositcurrencyError = false;
        return false;
    } else {
        depositcurrencyError = true;
        $("#depositcurrencycheck").hide();
    }
}
//deposit paid
$("#depositpaidcheck").hide();
let depositpaidError = true;
$("#DepositPaid").keyup(function () {
    validateDepositPaid();
});
function validateDepositPaid() {
    let textValue = $("#DepositPaid").val();
    if (textValue.length == "") {
        $("#depositpaidcheck").show();
        depositpaidError = false;
        return false;
    }else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#depositpaidcheck").show();
                $("#depositpaidcheck").html("**digits only or (13.5)");
                depositpaidError = false;
                return false;
            }else{
                depositpaidError = true;
                $("#depositpaidcheck").hide();
            }
    }
}
 //valid balance bd currency
 $("#bdcurrencycheck").hide();
 let bdcurrencyError = true;
 $("#BalanceBDCurrency").keyup(function () {
     validateDepositCurrency();
 });
function validateDepositCurrency() {
    let textValue = $("#BalanceBDCurrency").val();
    if (textValue.length == "") {
        $("#depositcurrencycheck").show();
        bdcurrencyError = false;
        return false;
    } else {
        bdcurrencyError = true;
        $("#depositcurrencycheck").hide();
    }
}
//deposit paid
$("#bdamountcheck").hide();
let bdamountError = true;
$("#BDamount").keyup(function () {
    validateBDAmount();
});
function validateBDAmount() {
    let textValue = $("#BDamount").val();
    if (textValue.length == "") {
        $("#bdamountcheck").show();
        bdamountError = false;
        return false;
    }else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#bdamountcheck").show();
                $("#bdamountcheck").html("**digits only or (13.5)");
                bdamountError = false;
                return false;
            }else{
                bdamountError = true;
                $("#bdamountcheck").hide();
            }
    }
}
// btn submit 
$("#btn-submit-lease").click(function () {
    try {
        validateTenantType();validateTenantName(); validatePropertyType();
        validatePropertyAddress(); validateInspection(); validateMaintenance();
        validateValidFrom(); validateValidTo();
        if(tenanttypeError==true && tenantnameError==true && propertytypeError==true &&
            propertyaddressError==true && inspectionsError==true && maintenanceError==true &&
            validfromError==true && validtoError==true){
                //valid response
                return true;
            }else{//invalid response
            return false;
        }   
    } catch (err) {
        alert(err.message);
        return false;
    }
});
});