<?php 

require_once '../autoloader.php';
$cell = false;
$amount = false;
if(isset($_POST['cell'])){
    $cell = $_POST['cell'];
}
if(isset($_POST['amount'])){
    $amount = $_POST['amount'];
}

$paynow = new Paynow\Payments\Paynow(
    '9945',
    '1a42766b-1fea-48f6-ac39-1484dddfeb62',
    'http://example.com/paynw/examples/index.php?paynow-return=true',
    'http://example.com/paynw/examples/callback.php'
);


$payment = $paynow->createPayment('Order 5', 'kudzchitz@gmail.com');


$payment->add('Sadza and Cold Water', $amount);

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
    <h2>An error occured while communicating with Paynow</h2>
    <p><?= $response->error ?></p>

<?php else: ?>

    <!-- Maybe write some script that checks if Paynow sent a status update
	 <h2>Status update send waiting for approval</h2>  -->
    <p><?//= $response->instructions() ?></p>

<?php endif; ?>


<?php if(isset($_GET['paynow-return'])): ?>
<script>
    alert('Thank you for your payment!');
</script>
<?php endif; ?>