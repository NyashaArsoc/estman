//valid market value
$("#marketvaluecheck").hide();
let marketvalueError = true;
$("#marketvalue").keyup(function () {
    validateMarketValue();
});
function validateMarketValue() {
    let textValue = $("#marketvalue").val();
    if (textValue.length == "") {
        $("#marketvaluecheck").show();
        marketvalueError = false;
        return false;
    } else if (textValue.length < 1) {
        $("#marketvaluecheck").show();
        $("#marketvaluecheck").html("**invalid input");
        marketvalueError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#marketvaluecheck").show();
                $("#marketvaluecheck").html("**digits only or (35)");
                marketvalueError = false;
                return false;
            }else{
                marketvalueError = true;
                $("#marketvaluecheck").hide();
            }
    }
}
//valid DPN value
$("#depreciationvaluecheck").hide();
let depreciationvalueError = true;
$("#depreciationvalue").keyup(function () {
    validateDepreciationValue();
});
function validateDepreciationValue() {
    let textValue = $("#depreciationvalue").val();
    if (textValue.length == "") {
        $("#depreciationvaluecheck").show();
        depreciationvalueError = false;
        return false;
    } else if (textValue.length < 1) {
        $("#depreciationvaluecheck").show();
        $("#depreciationvaluecheck").html("**invalid input");
        depreciationvalueError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#depreciationvaluecheck").show();
                $("#depreciationvaluecheck").html("**digits only or (35)");
                depreciationvalueError = false;
                return false;
            }else{
                depreciationvalueError = true;
                $("#depreciationvaluecheck").hide();
            }
    }
}
//valid rental value
$("#rentalvaluecheck").hide();
let rentalvalueError = true;
$("#rentalvalue").keyup(function () {
    validateRentalValue();
});
function validateRentalValue() {
    let textValue = $("#rentalvalue").val();
 if (textValue.length < 1) {
        $("#rentalvaluecheck").show();
        $("#rentalvaluecheck").html("**invalid input");
        rentalvalueError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#rentalvaluecheck").show();
                $("#rentalvaluecheck").html("**digits only or (35)");
                rentalvalueError = false;
                return false;
            }else{
                rentalvalueError = true;
                $("#rentalvaluecheck").hide();
            }
    }
}
//valid forcedsalestimate
$("#forcedsalestimatecheck").hide();
let forcedsalestimateError = true;
$("#forcedsalestimate").keyup(function () {
    validateForcedSaleEstimate();
});
function validateForcedSaleEstimate() {
    let textValue = $("#forcedsalestimate").val();
    if (textValue.length == "") {
        $("#forcedsalestimatecheck").show();
        forcedsalestimateError = false;
        return false;
    } else if (textValue.length < 1) {
        $("#forcedsalestimatecheck").show();
        $("#forcedsalestimatecheck").html("**invalid");
        forcedsalestimateError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#forcedsalestimatecheck").show();
                $("#forcedsalestimatecheck").html("**digits only or (35)");
                forcedsalestimateError = false;
                return false;
            }else{
                forcedsalestimateError = true;
                $("#forcedsalestimatecheck").hide();
            }
    }
}
//valid fairvalue
$("#fairvaluecheck").hide();
let fairvalueError = true;
$("#fairvalue").keyup(function () {
    validateFairValue();
});
function validateFairValue() {
    let textValue = $("#fairvalue").val();
    if (textValue.length == "") {
        $("#fairvaluecheck").show();
        fairvalueError = false;
        return false;
    } else if (textValue.length < 1) {
        $("#fairvaluecheck").show();
        $("#fairvaluecheck").html("**invalid");
        fairvalueError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#fairvaluecheck").show();
                $("#fairvaluecheck").html("**digits only or (35)");
                fairvalueError = false;
                return false;
            }else{
                fairvalueError = true;
                $("#fairvaluecheck").hide();
            }
    }
}
//valid landvalue
$("#landvaluecheck").hide();
let landvalueError = true;
$("#landvalue").keyup(function () {
    validateLandValue();
});
function validateLandValue() {
    let textValue = $("#landvalue").val();
    if (textValue.length == "") {
        $("#landvaluecheck").show();
        landvalueError = false;
        return false;
    } else if (textValue.length < 1) {
        $("#landvaluecheck").show();
        $("#landvaluecheck").html("**invalid");
        landvalueError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#landvaluecheck").show();
                $("#landvaluecheck").html("**digits only or (35)");
                landvalueError = false;
                return false;
            }else{
                landvalueError = true;
                $("#landvaluecheck").hide();
            }
    }
}
//valid drc
$("#drccheck").hide();
let drcError = true;
$("#drc").keyup(function () {
    validateDRC();
});
function validateDRC() {
    let textValue = $("#drc").val();
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#drccheck").show();
                $("#drccheck").html("**digits only or (35)");
                drcError = false;
                return false;
            }else{
                drcError = true;
                $("#drccheck").hide();
            }
}
//valid grc
$("#grccheck").hide();
let grcError = true;
$("#grc").keyup(function () {
    validateGRC();
});
function validateGRC() {
    let textValue = $("#grc").val();
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#grccheck").show();
                $("#grccheck").html("**digits only or (35)");
                grcError = false;
                return false;
            }else{
                grcError = true;
                $("#grccheck").hide();
            }
}
  // report document 
$("#reportdocumentcheck").hide();
  let reportdocumentError = true;
$("#reportdocument").keyup(function () {
      validateReportDocument();
}); 
function validateReportDocument() {
      let textValue = $("#reportdocument")[0];
      if (textValue.files.length === 0) {
          $("#reportdocumentcheck").show();
          reportdocumentError = false;
          return false;
      }else {
          var uploadedfile = textValue.files[0];
          // Check the file extension
          var uploadedExtension = uploadedfile.name.split('.').pop().toLowerCase();
          if (uploadedExtension !== 'doc') {
              $("#reportdocumentcheck").show();
              $("#reportdocumentcheck").html("**file must be document ");
              reportdocumentError = false;
              return false;
            }else{
              
              if (uploadedfile.size > 2000*1024){ // file must be less than 2Mb
                   $("#reportdocumentcheck").show();
                  $("#reportdocumentcheck").html("**file must be less that 2MB");
                  reportdocumentError = false;
                  return false;
              }else{
                  reportdocumentError = true;
                  $("#reportdocumentcheck").hide();
              }
            } 
      }
}
  // stk reportschedule
$("#reportschedulecheck").hide();
  let reportscheduleError = true;
  $("#reportschedule").keyup(function () {
      validateReportSchedule();
}); 
function validateReportSchedule() {
      let textValue = $("#reportschedule")[0];
      if (textValue.files.length === 0) {
          $("#reportschedulecheck").show();
          reportscheduleError = false;
          return false;
      }else {
          var uploadedfile = textValue.files[0];
          // Check the file extension
          var uploadedExtension = uploadedfile.name.split('.').pop().toLowerCase();
          if (uploadedExtension !== 'xls') {
              $("#reportschedulecheck").show();
              $("#reportschedulecheck").html("**file must be xls ");
              reportscheduleError = false;
              return false;
            }else{
              
              if (uploadedfile.size > 1000*1024){
                   $("#reportschedulecheck").show();
                  $("#reportschedulecheck").html("**file must be less that 1MB");
                  reportscheduleError = false;
                  return false;
              }else{
                  reportscheduleError = true;
                  $("#reportschedulecheck").hide();
              }
            } 
      }
}
//valid property Std Number
$("#standnumbercheck").hide();
    let standnumberError = true;
    $("#standnumber").keyup(function () {
        validateStandNumber();
});
function validateStandNumber() {
		let textValue = $("#standnumber").val();
		if (textValue.length == "") {
			$("#standnumbercheck").show();
			standnumberError = false;
			return false;
		} else if (textValue.length < 5) {
			$("#standnumbercheck").show();
			$("#standnumbercheck").html("**invalid address");
			standnumberError = false;
			return false;
		} else {
            const specialChars = /[`!@#$%^&*()_\-=\[\]{};':"\\|,.<>?~\/]/;
            charscheck         =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#standnumbercheck").show();
                $("#standnumbercheck").html("**remove special chars");
                standnumberError = false;
                return false;
            }else{
                standnumberError = true;
                $("#standnumbercheck").hide();
            }
		}
}
// add comple and submit
$("#btn-val-compile").click(function () {
    validateDRC();validateStandNumber();validateFairValue();
    validateForcedSaleEstimate();validateGRC();validateLandValue();
   validateMarketValue();validateRentalValue();validateDepreciationValue();
    validateReportDocument();validateReportSchedule();
    try {
        if(drcError==true && standnumberError==true &&
            fairvalueError==true && forcedsalestimateError==true && depreciationvalueError==true &&
            grcError==true && landvalueError==true && marketvalueError==true && rentalvalueError==true 
        && reportdocumentError==true && reportscheduleError==true )
            { return true; }
        else{ return false; }
    } catch (err) {
        alert(err.message);
        return false;
    }
});
// add quality check 
$("#btn-val-quality").click(function () {
    validateReportDocument();
    try {
        if(reportdocumentError==true )
            { return true; }
        else{ return false; }
    } catch (err) {
        alert(err.message);
        return false;
    }
});