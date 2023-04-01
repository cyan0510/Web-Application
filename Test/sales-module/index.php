<?php
require_once 'classes\class.sales.php';

// Create a new Sales instance
$sales = new Sales();

// Handle form submissions
if (isset($_POST['create_order'])) {
    $client_name = $_POST['client_name'];
    $amount = $_POST['amount'];
    $product_id = $_POST['product'];
    $quantity = $_POST['quantity'];
    $result = $sales->createOrder($client_name, $amount, $product_id, $quantity);
    if ($result) {
        header('Location: index.php');
        exit();
    } else {
        $error = "Failed to create order.";
    }
}

// Get product list and sale list
$product_list = $sales->getProductList();
$sales_list = $sales->getSalesList();

// Get the sales list
$sales_list = $sales->getSalesList();

// Get the product list
$product_list = $sales->getProductList();

// Get the customer list
$customer_list = $sales->getCustomerList();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales App</title>
</head>
<body>

    <h2>Create Order</h2>
<form method="POST">
    <label for="client_name">Client Name:</label>
    <input type="text" name="client_name" id="client_name" required><br>

    <label for="amount">Amount:</label>
    <input type="number" name="amount" id="amount" required><br>

    <label for="product">Product:</label>
    <select name="product" id="product" required>
        <?php foreach ($product_list as $product): ?>
            <option value="<?= $product['product_ID'] ?>"><?= $product['name'] ?> - <?= $product['description'] ?></option>
        <?php endforeach; ?>
    </select><br>

    <button type="submit" name="create_order">Create Order</button>
</form> 