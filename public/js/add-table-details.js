$("#accountnamecheck").hide();
let accountnameError = true;
$("#AccountName").keyup(function () {
    validateAccountName();
});
function validateAccountName() {
    let textValue = $("#AccountName").val();
    if (textValue.length == "") {
        $("#accountnamecheck").show();
        accountnameError = false;
        return false;
    } else if (textValue.length < 3) {
        $("#accountnamecheck").show();
        $("#accountnamecheck").html("**invalid account name");
        accountnameError = false;
        return false;
    } else {
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>?~0-9]/;
            charscheck =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#accountnamecheck").show();
                $("#accountnamecheck").html("**follow the required format abc wzy");
                accountnameError = false;
                return false;
            }else{
                accountnameError = true;
                $("#accountnamecheck").hide();
            }
    }
}
 //valid currency
 $("#currencycheck").hide();
 let currencyError = true;
 $("#Currency").keyup(function () {
     validateCurrency();
 });
 function validateCurrency() {
     let textValue = $("#Currency").val();
     if (textValue.length == "") {
         $("#currencycheck").show();
         currencyError = false;
         return false;
     } else {
         currencyError = true;
         $("#currencycheck").hide();
     }
 }
  //valid bankname
  $("#banknamecheck").hide();
  let banknameError = true;
  $("#BankName").keyup(function () {
      validateBankName();
  });
  function validateBankName() {
     let textValue = $("#BankName").val();
     if (textValue.length == "") {
         $("#banknamecheck").show();
         banknameError = false;
         return false;
     } else if (textValue.length < 2) {
         $("#banknamecheck").show();
         $("#banknamecheck").html("**invalid account name");
         banknameError = false;
         return false;
     } else {
         const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>?~\/s\0-9]/;
             charscheck =  specialChars.test(textValue);
             if (charscheck == true){
                  $("#banknamecheck").show();
                 $("#banknamecheck").html("**follow the required format");
                 banknameError = false;
                 return false;
             }else{
                 banknameError = true;
                 $("#banknamecheck").hide();
             }
     }
 }
     //valid account number
     $("#accountnumbercheck").hide();
     let accountnumberError = true;
     $("#AccountNumber").keyup(function () {
         validateAccountNumber();
     });
     function validateAccountNumber() { 
		let textValue = $("#AccountNumber").val();
		if (textValue.length == "") {
			$("#accountnumbercheck").show();
			accountnumberError = false;
			return false;
		} else if (textValue.length < 5) {
			$("#accountnumbercheck").show();
			$("#accountnumbercheck").html("**invalid account number");
			accountnumberError = false;
			return false;
		} else {
            const specialChars = /[`!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?~a-z/\s/A-Z]/;
            charscheck         =  specialChars.test(textValue);
            if (charscheck == true){
                 $("#accountnumbercheck").show();
                $("#accountnumbercheck").html("**follow the required format 063701000123");
                accountnumberError = false;
                return false;
            }else{
                accountnumberError = true;
                $("#accountnumbercheck").hide();
            }
		}
	}
    
//valid lease item currency
$("#leaseitemcurrencycheck").hide();
let leaseitemcurrencyError = true;
$("#LeaseItemCurrencyID").keyup(function () {
    validateLeaseItemCurrency();
});
function validateLeaseItemCurrency() {
   let textValue = $("#LeaseItemCurrencyID").val();
   if (textValue.length == "") {
       $("#leaseitemcurrencycheck").show();
       leaseitemcurrencyError = false;
       return false;
   } else {
        leaseitemcurrencyError = true;
       $("#leaseitemcurrencycheck").hide();
   }
}
//valid lease item bal bd
$("#leaseitembdamountcheck").hide();
let leaseitembdamountError = true;
$("#LeaseItemBDamount").keyup(function() {
   validateLeaseItemBDamount();
});

function validateLeaseItemBDamount(){
    let textValue         = $("#LeaseItemBDamount").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#leaseitembdamountcheck").show();
           $("#leaseitembdamountcheck").html("**digits only or (13.5)");
           leaseitembdamountError = false;
           return false;
       }else{
        leaseitembdamountError = true;
           $("#leaseitembdamountcheck").hide();
       }
    }else {
        leaseitembdamountError = true;
       $("#leaseitembdamountcheck").hide();
   }
}
//valid lease item rate cost
$("#leaseitemratecostcheck").hide();
let leaseitemratecostError = true;
$("#LeaseItemRatesCost").keyup(function() {
   validateLeaseItemRatesCost();
});

function validateLeaseItemRatesCost(){
    let textValue         = $("#LeaseItemRatesCost").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#leaseitemratecostcheck").show();
           $("#leaseitemratecostcheck").html("**digits only or (13.5)");
           leaseitemratecostError = false;
           return false;
       }else{
        leaseitemratecostError = true;
           $("#leaseitemratecostcheck").hide();
       }
    }
}
//valid lease item operation cost
$("#leaseitemoperationcostcheck").hide();
let leaseitemoperationcostError = true;
$("#LeaseItemOperationalCost").keyup(function() {
   validateLeaseItemOperationalCost();
});

function validateLeaseItemOperationalCost(){
    let textValue         = $("#LeaseItemOperationalCost").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#leaseitemoperationcostcheck").show();
           $("#leaseitemoperationcostcheck").html("**digits only or (13.5)");
           leaseitemoperationcostError = false;
           return false;
       }else{
        leaseitemoperationcostError = true;
           $("#leaseitemoperationcostcheck").hide();
       }
    }
}
//valid lease item deposit
$("#leaseitemdepositcheck").hide();
let leaseitemdepositcheckError = true;
$("#LeaseItemDepositPaid").keyup(function() {
   validateLeaseItemDepositPaid();
});

function validateLeaseItemDepositPaid(){
    let textValue         = $("#LeaseItemDepositPaid").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#leaseitemdepositcheck").show();
           $("#leaseitemdepositcheck").html("**digits only or (13.5)");
           leaseitemdepositcheckError = false;
           return false;
       }else{
        leaseitemdepositcheckError = true;
           $("#leaseitemdepositcheck").hide();
       }
    }
}
//valid lease item admin
$("#leaseitemadminpaidcheck").hide();
let leaseitemadmincheckError = true;
$("#LeaseItemAdminPaid").keyup(function() {
   validateLeaseItemAdminPaid();
});
function validateLeaseItemAdminPaid(){
    let textValue         = $("#LeaseItemAdminPaid").val();
    if(textValue!=''){
        const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~a-z/\s/A-Z]/;
        charscheck =  specialChars.test(textValue);
        if (charscheck == true){
            $("#leaseitemadminpaidcheck").show();
           $("#leaseitemadminpaidcheck").html("**digits only or (13.5)");
           leaseitemadmincheckError = false;
           return false;
       }else{
        leaseitemadmincheckError = true;
           $("#leaseitemadminpaidcheck").hide();
       }
    }
}
$('#add-banking-item').on('click', function() {
	var CurrencyID		=	$('#Currency').val();
	var AccountName		=	$('#AccountName').val();
	var BankName		=	$('#BankName').val();
	var Branch			=	$('#Branch').val();
	var AccountNumber	=	$('#AccountNumber').val();
	var count = $('#landlordbanking tr').length - 1;
	
	if(AccountName!="" && BankName !="" && AccountNumber!=""){
       /* validateAccountNumber();
        validateBankName();
        validateAccountName();
        validateCurrency();*/
		try {
		if(Branch ==''){
			Branch = 'n/a';
		}
		$('#landlordbanking tbody').append('<tr class="child"><td>'+count+'</td><td><input name="Currency[]" class="form-control" value='+CurrencyID+' readonly/></td><td><input name="AccountName[]" class="form-control" value='+AccountName+' readonly /></td><td><input name="BankName[]" class="form-control" value='+BankName+' readonly /></td><td> <input name="Branch[]" class="form-control " value='+Branch+' readonly/></td><td><input name="AccountNumber[]" class="form-control " value='+AccountNumber+' readonly /></td><td><button style="text-align: right;" class="btn btn-danger" type="button" value="Delete" onclick="deleteRow(this)">Delete</button></td></tr>');
		$('#AccountName').val('');  $('#BankName').val('');   $('#Branch').val(''); $('#AccountNumber').val(''); 
		}
		catch(err) {
			alert(err.message);
		  }
	}
});

	

function deleteRow(t) {
    var a = $("#landlordbanking > tbody > tr").length;
    if (1 == a) alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e);
    }
}
$('#add-lease-item').on('click', function() {
	var CurrencyID				=	$('#LeaseItemCurrencyID').val();
	var BalanceBD				=	$('#LeaseItemBDamount').val();
	var RatesCost				=	$('#LeaseItemRatesCost').val();
	var OperationalCost			=	$('#LeaseItemOperationalCost').val();
	var DepositPaid				=	$('#LeaseItemDepositPaid').val();
    var AdminPaid				=	$('#LeaseItemAdminPaid').val();
	var Currency 				=	'';
	var count = $('#leaseitems tr').length - 1;
	
	if(CurrencyID!=""){
		validateLeaseItemCurrency();
		validateLeaseItemBDamount();
		validateLeaseItemRatesCost();
		validateLeaseItemOperationalCost();
		validateLeaseItemDepositPaid();
        validateLeaseItemAdminPaid();
		try {
			if(leaseitemcurrencyError == true && leaseitembdamountError==true && leaseitemratecostError==true
				&& leaseitemoperationcostError==true && leaseitemdepositcheckError==true && leaseitemadmincheckError==true) {
		if (CurrencyID == 1){Currency = "ZWL"}else if (CurrencyID == 2){Currency = "USD"}
		if(BalanceBD ==''){BalanceBD = 0;}
		if(RatesCost ==''){RatesCost = 0;}
		if(OperationalCost ==''){OperationalCost = 0;}
		if(DepositPaid ==''){DepositPaid = 0;}
        if(AdminPaid ==''){AdminPaid = 0;}
		$('#leaseitems tbody').append('<tr class="child"><td>'+count+'</td><td> <input name="LeaseItemCurrencyID[]" type="hidden" value='+CurrencyID+' readonly/><input name="Currency" class="form-control" value='+Currency+' readonly/></td><td><input name="LeaseItemBDamount[]" class="form-control" value='+BalanceBD+' readonly /></td><td><input name="LeaseItemRatesCost[]" class="form-control" value='+RatesCost+' readonly /></td><td> <input name="LeaseItemOperationalCost[]" class="form-control " value='+OperationalCost+' readonly/></td><td><input name="LeaseItemDepositPaid[]" class="form-control " value='+DepositPaid+' readonly /></td><td><input name="LeaseItemAdminPaid[]" class="form-control " value='+AdminPaid+' readonly/></td><td><button style="text-align: right;" class="btn btn-danger" type="button" value="Delete" onclick="deleteLeaseRow(this)">Delete</button></td></tr>');
		$('#LeaseItemBDamount').val('');  $('#LeaseItemRatesCost').val('');   $('#LeaseItemOperationalCost').val(''); $('#LeaseItemDepositPaid').val(''); $('#LeaseItemAdminPaid').val(''); 
				//valid
				return true;
			}else{
				//failed
				return false;
			}
			}
		catch(err) {
			alert(err.message);
		  }
	}
});
function deleteLeaseRow(t) {
    var a = $("#leaseitems > tbody > tr").length;
    if (1 == a) alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e);
    }
}
var count = 2,
limits = 10;



