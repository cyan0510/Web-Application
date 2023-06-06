<?php
require_once 'classes/class.sales.php';

// Create an instance of the Sales class
$sales = new Sales();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $client_name = $_POST['client_name'];
    $product_ID = $_POST['product_ID'];
    $amount = $_POST['amount'];

    // Update the sale
    $rowCount = $sales->updateSale($id, $client_name, $product_ID, $amount);

    if ($rowCount > 0) {
        // Sale updated successfully
        header('Location: index.php?page=sales');
        exit();
    } else {
        // Failed to update sale
        echo "Failed to update sale.";
    }
}

// Get the sale ID from the query string
$id = $_GET['id'];

// Fetch the sale details by ID
$sale = $sales->getSaleById($id);

// Check if the sale exists
if ($sale) {
    // Extract the sale details
    $client_name = $sale['client_name'];
    $product_ID = $sale['product_ID'];
    $amount = $sale['amount'];
} else {
    // Sale not found
    echo "Sale not found.";
}
?>

<h3>Edit Sale</h3>
<br/>
<div id="form-block">
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <label for="client_name">Client Name</label>
        <input type="text" id="client_name" class="input" name="client_name" value="<?php echo $client_name; ?>" placeholder="Client name.." required>
        
        <label for="product_ID">Product</label>
        <select id="product_ID" name="product_ID" required>
            <?php
            $products = $sales->getProductList();
            foreach ($products as $product) {
                $productID = $product['product_ID'];
                $productName = $product['name'];
                ?>
                <option value="<?php echo $productID; ?>" <?php if ($productID == $product_ID) { echo "selected"; } ?>><?php echo $productName; ?></option>
                <?php
            }
            ?>
        </select>
        
        <label for="amount">Amount</label>
        <input type="number" id="amount" class="input" name="amount" value="<?php echo $amount; ?>" placeholder="Amount.." required>

        <div id="button-block">
            <input type="submit" value="Update">
        </div>
    </form>
</div>
