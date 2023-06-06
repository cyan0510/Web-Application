<span id="search-result">
<h3>Product Details</h3>
<div id="subcontent">
    <table id="data-list">
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Description</th>
        <th>Type</th>
        <th>Price</th>
      </tr>
<?php
$count = 1;
if($product->list_product() != false){
foreach($product->list_product() as $value){
   extract($value);
  
?>
      <tr>
        <td><?php echo $count;?></td>
        <td><a href="index.php?page=settings&subpage=products&action=profile&id=<?php echo $product_ID;?>"><?php echo $name;?></a></td>
        <td><?php echo $description;?></td>
        <td><?php echo $product->get_type_name($product->get_prod_type($product_ID));?></td>
        <td><?php echo $product->get_price($product_ID);?></td>
      </tr>
      <tr>
<?php
 $count++;
}
}else{
  echo "No Record Found.";
}
?>
    </table>
</div>