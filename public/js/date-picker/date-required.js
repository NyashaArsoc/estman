   function validatDate() {
    var x = document.forms["propDetails"]["AvailableOn"].value;
    if (x == "") {
      alert("Please select date when property is available");
      return false;
    }
  }
   