

$('#add-banking-item').on('click', function() {
	var CurrencyID		=	$('#CurrencyID').val();
	var AccountName		=	$('#AccountName').val();
	var BankName		=	$('#BankName').val();
	var Branch			=	$('#Branch').val();
	var AccountNumber	=	$('#AccountNumber').val();
	var Currency 		=	'';
	var count = $('#landlordbanking tr').length - 1;
	
	if(AccountName!="" && BankName !="" && AccountNumber!=""){
		try {
		if (CurrencyID == 1){Currency = "ZWL"}else if (CurrencyID == 2){Currency = "USD"}
		if(Branch ==''){
			Branch = 'n/a';
		}
		$('#landlordbanking tbody').append('<tr class="child"><td>'+count+'</td><td> <input name="CurrencyID[]" type="hidden" value='+CurrencyID+' readonly/><input name="Currency" class="form-control" value='+Currency+' readonly/></td><td><input name="AccountName[]" class="form-control" value='+AccountName+' readonly /></td><td><input name="BankName[]" class="form-control" value='+BankName+' readonly /></td><td> <input name="Branch[]" class="form-control " value='+Branch+' readonly/></td><td><input name="AccountNumber[]" class="form-control " value='+AccountNumber+' readonly /></td><td><button style="text-align: right;" class="btn btn-danger" type="button" value="Delete" onclick="deleteRow(this)">Delete</button></td></tr>');
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
var count = 2,
limits = 10;


