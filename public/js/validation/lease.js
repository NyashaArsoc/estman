$(document).ready(function () { 

// btn edit 
$("#btn-edit-lease").click(function () {
    try {
        validateTenantType();validateTenantName(); validatePropertyType();
        validatePropertyAddress(); validateInspection(); validateRentReview();
        validateValidFrom(); validateValidTo();validateRentCurrency();
        validatePropertyDescription();
        if(tenanttypeError==true && tenantnameError==true && propertytypeError==true &&
            propertyaddressError==true && inspectionsError==true && rentreviewError==true &&
            validfromError==true && validtoError==true && rentalcurrencyError==true &&
            propertydescriptionError == true  ){
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

// btn edit 
$("#btn-renew-lease").click(function () {
    try {
        validateValidFrom(); validateValidTo();
        if( validfromError==true && validtoError==true){
                //valid response
                var LeaseFromVal               = $("#LeaseValidFrom").val();
                var LeaseToVal                 = $("#LeaseValidTo").val();
                var Date_LeaseFromVal          = new Date(LeaseFromVal);
                var Date_LeaseToVal            = new Date(LeaseToVal);
                if (Date_LeaseFromVal >= Date_LeaseToVal){
                    $("#validfromcheck").show();
                    $("#validfromcheck").html("**invalid lease period**");
                    return false;
                }else{
                    $("#validfromcheck").hide();
                    return true;
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