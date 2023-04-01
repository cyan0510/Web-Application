<?php
require_once 'classes\class.sales.php';

$sales = new Sales();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$client_name = $_POST['client_name'];
	$product_ID = $_POST['product_ID'];
	$amount = $_POST['amount'];
	$product_price = $sales->getProductPrice($product_ID);
	$amount = $product_price * $amount;
	$sales->createOrder($client_name, $amount, $product_ID, $amount);
}

$sales_list = $sales->getSalesList ();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gee Pab Pet Stop</title>
</head>
<body>
<h1>Sales List</h1>
	<table>
		<thead>
			<tr>
				<th>ID  &nbsp &nbsp &nbsp | </th>
				<th>Client Name &nbsp &nbsp &nbsp |</th>
				<th>Product Name &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp | </th>
				<th>Amount &nbsp &nbsp &nbsp |</th>
				<th>Price Amount &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp |</th>
				<th>Total Price</th>
			</tr>
		</thead>
		<tbody>
		<?php 
$total_amount = 0;
if(!empty($sales_list)) {
    foreach ($sales_list as $sale):
        $subtotal = $sale['amount'] * $sale['price'];
        $total_amount += $subtotal;
?>
        <tr>
            <td><?= $sale['id'] ?></td>
            <td><?= $sale['client_name'] ?></td>
            <td><?= $sale['name'] ?></td>
            <td><?= $sale['amount'] ?></td>
            <td><?= $sale['price'] ?></td>
            <td><?= $subtotal ?></td>
        </tr>
<?php
    endforeach;
}
?>
<tr>
    <td colspan="5" style="text-align:right">Total:</td>
    <td><?= $total_amount ?></td>
</tr>
        </tbody>
	</table>
</body>
</html>