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
// get landlord on add property
function getLandlordonProperty() {
    var textValue = $("#PropertyLandlordClientType").val();
        
	$.ajax({          
        	type: "GET",
        	url: "/single-landlord"+'/'+textValue,
        	success: function(data){
        		$("#PropertyLandlordName").html(data);
        	}
	});
}
// get tenant on add lease
function getTenantonLease() {
    var textValue = $("#LeaseTenantClientType").val();
	$.ajax({          
        	type: "GET",
        	url: "/single-tenant"+'/'+textValue,
        	success: function(data){
        		$("#LeaseTenantName").html(data);
        	}
	});
}
// get property on add lease
function getPropertyonLease() {
    var textValue = $("#LeasePropertyType").val();
	$.ajax({          
        	type: "GET",
        	url: "/single-property"+'/'+textValue,
        	success: function(data){
        		$("#LeasePropertyAddress").html(data);
        	}
	});
	if(textValue==1){// residential
		document.getElementById('Residential').style.display = "block";
		document.getElementById('Commercial').style.display = "none";   
		document.getElementById('CommercialBottom').style.display = "none";   
	   } 
	   else{
		document.getElementById('Commercial').style.display = "block";
		document.getElementById('CommercialBottom').style.display = "block";
		document.getElementById('Residential').style.display = "none";   
	   }	
}
// get property balances
function getPropertyBalances() {
    var textValue = $("#LeasePropertyAddress").val();
	$.ajax({          
        	type: "GET",
        	url: "/property-areataken"+'/'+textValue,
        	success: function(data){
        		$("#OccupiedArea").val(data);
        	}
	});
	$.ajax({          
		type: "GET",
		url: "/property-areaavailable"+'/'+textValue,
		success: function(data){
			$("#AvailableLettableArea").val(data);
		}
});

}
