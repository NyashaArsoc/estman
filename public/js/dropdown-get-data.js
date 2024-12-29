// get landlord on add banks
function getLandlord() {
    var textValue = $("#BankLandlordClientType").val();
        
	$.ajax({          
        	type: "GET",
        	url: "/single-landlord"+'/'+textValue,
        	success: function(data){
        		$("#LandlordName").html(data);
        	}
	});
}
// get tenant details on recepting
function getTenantDetails() {
    var textValue = $("#PropertyAddressDesc").val();
	$.ajax({          
        	type: "GET",
        	url: "/single-tenant/details"+'/'+textValue,
        	success: function(data){
        		$("#tenantdetailsform").html(data);
        	}
	});
}
// get tenant details on recepting
function getRemittanceLandlordDetails() {
    var textValue = $("#PropertyAddressDesc").val();
	$.ajax({          
        	type: "GET",
        	url: "/single-landlord/remit"+'/'+textValue,
        	success: function(data){
        		$("#propertydetailsform").html(data);
        	}
	});
}
// get creditor balance
function getCreditorBalance() {
    var textValue = $("#CreditorCode").val();
	var anothertextValue = document.querySelector('#PropertyAddressDesc').value;;//$("#").val();
	$.ajax({          
        	type: "GET",
        	url: "/single-creditor/bal"+'/'+textValue+'/'+anothertextValue,
        	success: function(data){
        		$("#creditorbalance").html(data);
        	}
	});
}
// get val active clients
function getvalclient() {
    var textValue = $("#clienttype").val();
	$.ajax({          
        	type: "GET",
        	url: "/val/"+textValue+"/client/type", 
        	success: function(data){
        		$("#propertyclientname").html(data);
        	}
	});
}
// get val client contact person 
function getvalclientcontact() {
    var textValue = $("#propertyclientname").val();
	$.ajax({          
        	type: "GET",
        	url: "/val/"+textValue+"/client/contact", 
        	success: function(data){
        		$("#clientcontactname").html(data);
        	}
	});
}
// get landlord on add property by client type
function getpropmanlandlordlist() {
    var textValue = $("#clienttype").val();
	$.ajax({          
        	type: "GET",
        	url: "/prop/landlord/single/type"+'/'+textValue,
        	success: function(data){
        		$("#landlordlist").html(data);
        	}
	});
}
// get tenant on add lease by client type
function getpropmantenantlist() {
    var textValue = $("#clienttype").val();
	$.ajax({          
        	type: "GET",
        	url: "/prop/tenant/single/type/"+textValue,
        	success: function(data){
        		$("#tenantlist").html(data);
        	}
	});
}
// get property list on add lease by propertytype
function getoptionpropmanpropertylist() {
    var textValue = $("#propertytype").val();
	$.ajax({          
        	type: "GET",
        	url: "/prop/property/single/type/"+textValue,
        	success: function(data){
        		$("#propertyaddress").html(data);
        	}
	});
	if(textValue==1){// residential
		document.getElementById('residential').style.display = "block";
		document.getElementById('commercial').style.display = "none";   
		document.getElementById('commercialbottom').style.display = "none";   
	   } 
	   else{
		document.getElementById('commercial').style.display = "block";
		document.getElementById('commercialbottom').style.display = "block";
		document.getElementById('residential').style.display = "none";   
	   }	
}
// get landlord on add lease by property address
function getpropmanlandlordlistbyproperty() {
    var textValue = $("#propertyaddress").val();
	$.ajax({          
        	type: "GET",
        	url: "/prop/landlord/contact/propertyaddress/"+textValue,
        	success: function(data){
        		$("#landlordlist").html(data);
        	}
	});
}
//get tenant details on receipting by leaseID 
function getpropmantenantbyleaseid() {
    var textValue = $("#leasenumber").val();
	$.ajax({          
        	type: "GET",
        	url: "/prop/tenant/single/details/"+textValue,
        	success: function(data){
        		$("#tenantdetailsform").html(data);
        	}
	});
}