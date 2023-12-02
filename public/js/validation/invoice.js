$(document).ready(function () { 
//valid rent
    $("#proitemrentcheck").hide();
let prorentalError = true;
$("#Rental").keyup(function () {
    validateProRental();
});
function validateProRental() {
    let textValue = $("#Rental").val();
    let RatesValue = $("#RatesLevies").val();
    let OperationValue = $("#OperationCosts").val();
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#proitemrentcheck").show();
                $("#proitemrentcheck").html("**digits only or (3.5)");
                prorentalError = false;
                return false;
            }else{
                let TotalBilled              = (parseFloat(textValue) +
                parseFloat(RatesValue) + parseFloat(OperationValue));
                prorentalError = true;
                $("#proitemtotalbilledcheck").show();
                $("#proitemtotalbilledcheck").html(TotalBilled);
                $("#proitemrentcheck").hide();
            }
}
//valid rates
    $("#proitemratecostcheck").hide();
let proratescostsError = true;
$("#RatesLevies").keyup(function () {
    validateProRates();
});
function validateProRates() {
    let textValue = $("#RatesLevies").val();
    let RentValue = $("#Rental").val();
    let OperationValue = $("#OperationCosts").val();
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#proitemratecostcheck").show();
                $("#proitemratecostcheck").html("**digits only or (3.5)");
                prorentalError = false;
                return false;
            }else{
                let TotalBilled              = (parseFloat(textValue) +
                parseFloat(RentValue) + parseFloat(OperationValue));
                prorentalError = true;
                $("#proitemtotalbilledcheck").show();
                $("#proitemtotalbilledcheck").html(TotalBilled);
                $("#proitemratecostcheck").hide();
            }
}
//valid rates
$("#proitemoperationcostcheck").hide();
let prooperationcostsError = true;
$("#OperationCosts").keyup(function () {
    validateProOperation();
});
function validateProOperation() {
    let textValue = $("#OperationCosts").val();
    let RentValue = $("#Rental").val();
    let RatesValue = $("#RatesLevies").val();
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|<>\/?~a-z/\s/A-Z]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#proitemoperationcostcheck").show();
                $("#proitemoperationcostcheck").html("**digits only or (3.5)");
                prooperationcostsError = false;
                return false;
            }else{
                let TotalBilled              = (parseFloat(textValue) +
                parseFloat(RentValue) + parseFloat(RatesValue));
                prooperationcostsError = true;
                $("#proitemtotalbilledcheck").show();
                $("#proitemtotalbilledcheck").html(TotalBilled);
                $("#proitemoperationcostcheck").hide();
            }
}
$("#btn-edit-pro").click(function () {
    try {
        validateProOperation();validateProRates();validateProRental();
        if(prooperationcostsError==true && proratescostsError==true && prorentalError==true){
            return true;
        }else{
            return false;
        }
    }catch (err) {
        alert(err.message);
        return false;
    }
});
});