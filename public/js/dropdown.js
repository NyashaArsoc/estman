function CreationTypeOption(select){
    if(select.value==1){
     document.getElementById('GroupCreation').style.display = "block";
     document.getElementById('UserCreation').style.display = "none";
    } 
    else if (select.value==2) {
     document.getElementById('UserCreation').style.display = "block";
     document.getElementById('GroupCreation').style.display = "none";
    }else{
     document.getElementById('GroupCreation').style.display = "none";
     document.getElementById('UserCreation').style.display = "none";
    }
 } 

 function LandlordCreationType(select){
   
    if(select.value == 1){ // individual 
     document.getElementById('IndividualGroup').style.display = "block";
     document.getElementById('CorporateGroup').style.display = "none";
     document.getElementById('CorporateGroupContact').style.display = "none";  
    } 
     else if(select.value == ""){ // nothing/default 
      document.getElementById('IndividualGroup').style.display = "none";
      document.getElementById('CorporateGroup').style.display = "none";
      document.getElementById('CorporateGroupContact').style.display = "none";
    }
    else{ // corporate 
    document.getElementById('IndividualGroup').style.display = "none";
     document.getElementById('CorporateGroup').style.display = "block";
     document.getElementById('CorporateGroupContact').style.display = "block";
    }
 } 

 function TenantCreationType(select){
   if(select.value == 1){ // individual 
      document.getElementById('IndividualGroup').style.display = "block";
      document.getElementById('KeenGroup').style.display = "block";
      document.getElementById('CorporateGroup').style.display = "none";
      document.getElementById('CompanyContactGroup').style.display = "none";
   }else if (select.value == ""){ // empty clienttype
      document.getElementById('IndividualGroup').style.display = "none";
      document.getElementById('KeenGroup').style.display = "none";
      document.getElementById('CorporateGroup').style.display = "none";
      document.getElementById('CompanyContactGroup').style.display = "none";
   }else{
    
      document.getElementById('CorporateGroup').style.display = "block";
      document.getElementById('KeenGroup').style.display = "none";
      document.getElementById('IndividualGroup').style.display = "none";
      document.getElementById('CompanyContactGroup').style.display = "block";
   }
 }


function AddPropertyType(select){
   if(select.value==1){// residential
    document.getElementById('Residential').style.display = "block";
    document.getElementById('Commercial').style.display = "none";
    document.getElementById('CommercialBottom').style.display = "none";
    document.getElementById('ResidentialBottom').style.display = "block";
     
   } 
   else{
    document.getElementById('Commercial').style.display = "block";
    document.getElementById('Residential').style.display = "none";
    document.getElementById('CommercialBottom').style.display = "block";
    document.getElementById('ResidentialBottom').style.display = "none"; 
    
   }
} 
function LeasePropertyType(select){
   if(select.value==1){// residential
    document.getElementById('Residential').style.display = "block";
    document.getElementById('Commercial').style.display = "none";    
   } 
   else{
    document.getElementById('Commercial').style.display = "block";
    document.getElementById('Residential').style.display = "none";   
   }
} 

