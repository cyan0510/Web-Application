<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    include_once 'classes/class.sales.php';

    $product = new Product();
    $sales = new Sales();

    // Get total count of products
    $products = $product->list_product();
    $totalProducts = count($products);

    // Get product type list
    $types = $product->list_product_type();

    $typeCount = [];
    $totalTypes = 0;

    foreach ($types as $type) {
        $typeId = $type['type_id'];
        $typeCount[$typeId] = 0;
    }

    foreach ($products as $product) {
        $typeId = $product['type_id'];
        $typeCount[$typeId]++;
    }

    $totalTypes = count($typeCount);

    // Get total count of orders
    $orders = $sales->getSalesList();
    $totalOrders = count($orders);

    // Calculate total price of all sales
    $totalPrice = 0;
    foreach ($orders as $order) {
        $totalPrice += $order['price'] * $order['amount'];
    }
    ?>

    <h2>Amount of Products: <?php echo $totalProducts; ?></h2>
    <h2>Amount of Product Types: <?php echo $totalTypes; ?></h2>
    <h2>Amount of Orders: <?php echo $totalOrders; ?></h2>
    <h2>Total Price of Sales: ₱<?php echo $totalPrice; ?></h2>