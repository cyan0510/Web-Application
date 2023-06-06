<?php
require_once '../classes/class.sales.php';

$sales = new Sales();

$q = $_GET["q"];
$count = 1;
$hint = '<h3>Search Result(s)</h3><table id="data-list">
<tr>
<th>ID</th>
<th>Client Name</th>
<th>Product Name</th>
<th>Amount</th>
<th>Price Amount</th>
<th>Total Price</th>
<th>Actions</th>
</tr>';

$data = $sales->list_sales_search($q);

if ($data !== false) {
    foreach ($data as $value) {
        $client_name = $sales->get_client_name($value['client_name']);
        $product_price = $sales->getProductPrice($value['product_ID']);

        $hint .= '
       <tr>
        <td>'.$count.'</td>
        <td>'.$client_name.'</td>
        <td>'.$value['product_ID'].'</td>
        <td>'.$value['amount'].'</td>
        <td>'.$product_price.'</td>
        <td>'.$value['amount'] * $product_price.'</td>
        <td><a href="index.php?page=sales&action=modify&id='.$value['id'].'">Edit</a></td>
        </tr>';

        $count++;
    }
}

$hint .= '</table>';

echo $hint === '<h3>Search Result(s)</h3><table id="data-list">
<tr>
<th>ID</th>
<th>Client Name</th>
<th>Product Name</th>
<th>Amount</th>
<th>Price Amount</th>
<th>Total Price</th>
<th>Actions</th>
</tr></table>' ? "No result(s)" : $hint;
?>
