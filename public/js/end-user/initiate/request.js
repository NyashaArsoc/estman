 $(document).ready(function(){
                $('#payment_form').on('submit', function(e){
                    //Stop the form from submitting itself to the server.
                    e.preventDefault();
                    var cell = $('#Cell').val();
					var AmountToPay = $('#AmountToPay').val();
                    $.ajax({
                        type: "POST",
                        url: 'check/examples/send-request.php',
                        data: {cell: cell,AmountToPay: AmountToPay}
                    });
                });
            });