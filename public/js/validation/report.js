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
// button property rent roll
$("#btn-prop-roll").click(function () {
    validateRollPeriod(); validatePropertyAddress();
    if(rollperiodError == true && propertyaddressError==true){
        //valid
        return true;
    }else{
        //failed
        return false;
    }
});  
});