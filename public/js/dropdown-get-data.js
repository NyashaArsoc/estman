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
}
