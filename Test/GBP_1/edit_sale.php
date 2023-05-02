<?php
include_once 'classes/class.sales.php';

$sales = new Sales();

// Check if the form has been submitted
if(isset($_POST['update_sale'])) {
    $id = $_POST['id'];
    $client_name = $_POST['client_name'];
    $product_ID = $_POST['product_ID'];
    $amount = $_POST['amount'];

    $result = $sales->updateSale($id, $client_name, $product_ID, $amount);
    if($result){
        header('location: edit_sale.php');
    }
}

// Retrieve the sale by ID
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $sales->getSalesList($id);
} else {
    // Redirect to the main page if no sale ID is provided
    header('location: sales_list.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Sale</title>
</head>
<body>
    <h2>Edit Sale</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label>Client Name:</label>
        <input type="text" name="client_name" value="<?php echo $row['client_name']; ?>"><br><br>
        <label>Product:</label>
        <select name="product_ID">
            <?php
                $product_list = $sales->getProducts();
                foreach ($product_list as $product) {
                    $selected = ($row['product_ID'] == $product['id']) ? 'selected' : '';
                    echo '<option value="'.$product['id'].'" '.$selected.'>'.$product['name'].'</option>';
                }
            ?>
        </select><br><br>
        <label>Amount:</label>
        <input type="number" name="amount" value="<?php echo $row['amount']; ?>"><br><br>
        <input type="submit" name="update_sale" value="Update">
    </form>
</body>
</html>