<?php 

require_once '../autoloader.php';
$cell = false;
$AmountToPay = false;
if(isset($_POST['cell'])){
    $cell = $_POST['cell'];
}
if(isset($_POST['AmountToPay'])){
    $AmountToPay = $_POST['AmountToPay'];
}

$paynow = new Paynow\Payments\Paynow(
    '10240',
    '4300697d-ae59-49cc-8c77-e30c9a46b817',
    'http://example.com/paynw/examples/index.php?paynow-return=true',
    'http://example.com/paynw/examples/callback.php'
);


$payment = $paynow->createPayment('Order 5', 'kudzchitz@gmail.com');


$payment->add('Sadza and Cold Water', $AmountToPay);

// Optionally set a description for the order.
// By default, a description is generated from the items
// added to a payment
$payment->setDescription("Mr Maposa\'s lunch order");


// Initiate a Payment 
$response = $paynow->sendMobile($payment, $cell, 'ecocash');
//$var_dump($response);


?>


<?php if(!$response->success): ?>

    <!-- Something went wrong while initating payment -->
    <h2>An error occured while 
	communicating with Paynow</h2>
    <p><?= $response->error ?></p>

<?php else: ?>

    Maybe write some script that checks if Paynow sent a status update
	 <h2>Status update send waiting for approval</h2>  
    <p><?= $response->instructions() ?></p>

<?php endif; ?>


<?php if(isset($_GET['paynow-return'])): ?>
<script>
    alert('Thank you for your payment!');
</script>
<?php endif; ?>