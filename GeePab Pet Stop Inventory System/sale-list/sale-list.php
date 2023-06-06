<?php
require_once 'classes/class.sales.php';

$sales = new Sales();
$sales_list = $sales->getSalesList();
?>
<span id="search-result">
<div>
    <h1>Sales List</h1>
    <table id="data-list">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Product Name</th>
                <th>Amount</th>
                <th>Price Amount</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_amount = 0;
            if (!empty($sales_list)) {
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
                        <td><a href="index.php?page=sales&action=modify&id=<?= $sale['id'] ?>">Edit</a></td>
                    </tr>
            <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>
</div>
