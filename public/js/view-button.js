$(document).ready(function(){  
    $('.view_landlord').click(function(){  
         var LandlordID = $(this).attr("ID");  
         $.ajax({  
              url:"press-view-landlord",  
              method:"post",  
              data:{LandlordID:LandlordID},  
              success:function(data){  
                   $('#LandlordDetail').html(data);  
                   $('#myModalLandlord').modal("show");  
              }  
         });  
    });  
}); 