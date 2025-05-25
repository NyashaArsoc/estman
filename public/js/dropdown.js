function CreationTypeOption(select) {
   if (select.value == 1) {
      document.getElementById('GroupCreation').style.display = "block";
      document.getElementById('UserCreation').style.display = "none";
   }
   else if (select.value == 2) {
      document.getElementById('UserCreation').style.display = "block";
      document.getElementById('GroupCreation').style.display = "none";
   } else {
      document.getElementById('GroupCreation').style.display = "none";
      document.getElementById('UserCreation').style.display = "none";
   }
}

function optionlandlordtype(select) {

   if (select.value == 1) { // individual 
      document.getElementById('individualgroup').style.display = "block";
      document.getElementById('corporategroup').style.display = "none";
   }
   else if (select.value == "") { // nothing/default 
      document.getElementById('individualgroup').style.display = "none";
      document.getElementById('corporategroup').style.display = "none";
   }
   else { // corporate 
      document.getElementById('individualgroup').style.display = "none";
      document.getElementById('corporategroup').style.display = "block";
   }
}

function optiontenanttype(select) {
   if (select.value == 1) { // individual 
      document.getElementById('individualgroup').style.display = "block";
      document.getElementById('keengroup').style.display = "block";
      document.getElementById('corporategroup').style.display = "none";
      document.getElementById('companycontactgroup').style.display = "none";
   } else if (select.value == "") { // empty clienttype
      document.getElementById('individualgroup').style.display = "none";
      document.getElementById('keengroup').style.display = "none";
      document.getElementById('corporategroup').style.display = "none";
      document.getElementById('companycontactgroup').style.display = "none";
   } else {

      document.getElementById('corporategroup').style.display = "block";
      document.getElementById('keengroup').style.display = "none";
      document.getElementById('individualgroup').style.display = "none";
      document.getElementById('companycontactgroup').style.display = "block";
   }
}


function optionpropertytype(select) {
   if (select.value == 1) {// residential
      document.getElementById('residential').style.display = "block";
      document.getElementById('commercial').style.display = "none";
      document.getElementById('CommercialBottom').style.display = "none";
      document.getElementById('residentialbottom').style.display = "block";

   }
   else {
      document.getElementById('commercial').style.display = "block";
      document.getElementById('residential').style.display = "none";
      document.getElementById('CommercialBottom').style.display = "block";
      document.getElementById('residentialbottom').style.display = "none";

   }
}
function optionclienttype(select) {

   if (select.value == 1) { // individual 
      document.getElementById('individualgroup').style.display = "block";
      document.getElementById('corporategroup').style.display = "none";
      document.getElementById('companycontactgroup').style.display = "none";
   }
   else if (select.value == "") { // nothing/default 
      document.getElementById('individualgroup').style.display = "none";
      document.getElementById('corporategroup').style.display = "none";
      document.getElementById('companycontactgroup').style.display = "none";
   }
   else { // corporate 
      document.getElementById('individualgroup').style.display = "none";
      document.getElementById('corporategroup').style.display = "block";
      document.getElementById('companycontactgroup').style.display = "block";
   }
}

