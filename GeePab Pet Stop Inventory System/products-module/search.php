<?php
include_once '../classes/class.product.php';
$product = new Product();

// get the q parameter from URL
$q = $_GET["q"];
$count = 1;
$hint=' <h3>Search Result(s)</h3><table id="data-list">
<tr>
<th>#</th>
<th>Name</th>
<th>Description</th>
<th>Type</th>
<th>Price</th>
</tr>';
$data = $product->list_product_search($q);
if ($data != false) {
    foreach ($data as $value) {
        extract($value);

        $type_name = $product->get_type_name($type_id); // Get the type name using type_id

        $hint .= '
       <tr>
        <td>'.$count.'</td>
        <td><a href="index.php?page=settings&subpage=products&action=profile&id='.$product_ID.'">'.$name.'</a></td>
        <td>'.$description.'</td>
        <td>'.$type_name.'</td>
        <td>'.$price.'</td>
        </tr>';
        $count++;
    }
}
$hint .= '</table>';

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "No result(s)" : $hint;
?>
