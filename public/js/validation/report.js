$(document).ready(function () { 
// rent rol propety type
$("#propertyaddresscheck").hide();
  let propertyaddressError = true;
  $("#PropertyAddress").keyup(function () {
      validatePropertyAddress();
  });
  function validatePropertyAddress() {
      let textValue = $("#PropertyAddress").val();
      if (textValue.length == "") {
          $("#propertyaddresscheck").show();
          propertyaddressError = false;
          return false;
      } else {
        propertyaddressError = true;
          $("#propertyaddresscheck").hide();
      }
  } 
//rent-roll period
$("#rollperiodcheck").hide();
  let rollperiodError = true;
  $("#RollPeriod").keyup(function () {
      validateRollPeriod();
  });
  function validateRollPeriod() {
      let textValue = $("#RollPeriod").val();
      if (textValue.length == "") {
          $("#rollperiodcheck").show();
          rollperiodError = false;
          return false;
      } else {
        rollperiodError = true;
          $("#rollperiodcheck").hide();
      }
  } 
//rent-roll period
$("#rollcurrencycheck").hide();
  let rollcurrencyError = true;
  $("#RollCurrency").keyup(function () {
      validateRollCurrency();
  });
  function validateRollCurrency() {
      let textValue = $("#RollCurrency").val();
      if (textValue.length == "") {
          $("#rollcurrencycheck").show();
          rollcurrencyError = false;
          return false;
      } else {
        rollcurrencyError = true;
          $("#rollcurrencycheck").hide();
      }
  } 
// button property rent roll
$("#btn-prop-roll").click(function () {
    validateRollPeriod(); validatePropertyAddress();validateRollCurrency();
    if(rollperiodError == true && propertyaddressError==true && rollcurrencyError==true){
        //valid
        return true;
    }else{
        //failed
        return false;
    }
});  
});