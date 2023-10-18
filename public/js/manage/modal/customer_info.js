// Supplier information
$(document).ready(function(){	

	$('#cusInfo').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var cus_id = button.data('whatever');
		var modal = $(this);
		
		$.ajax({

				type : 'GET',
				url  : 'modal/customer-info.php',
				data : 'cus_id='+cus_id,				
				success :  function (response) {																		
				$('.modal-body').html(response);					
				}			
		})
	})

});