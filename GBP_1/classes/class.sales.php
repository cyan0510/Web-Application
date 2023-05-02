<?php
class Sales{
	private $DB_SERVER='localhost';
	private $DB_USERNAME='root';
	private $DB_PASSWORD='';
	private $DB_DATABASE='gbp_db';
	private $conn;
	public function __construct(){
		$this->conn = new PDO("mysql:host=".$this->DB_SERVER.";dbname=".$this->DB_DATABASE,$this->DB_USERNAME,$this->DB_PASSWORD);
		
	}
	
	public function createOrder($client_name, $product_ID, $amount){
		$sql = "INSERT INTO sale_list (id, client_name, product_ID, amount) VALUES (:id, :client_name, :product_ID, :amount)";
		$stmt = $this->conn->prepare($sql);
		$id = $this->getNextSaleId();
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':client_name', $client_name);
		$stmt->bindParam(':product_ID', $product_ID);
		$stmt->bindParam(':amount', $amount);
		$stmt->execute();
	
		return $stmt->rowCount();
	}
	
	public function getNextSaleId() {
		$sql = "SELECT MAX(id) FROM sale_list";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$maxId = $stmt->fetchColumn();
	
		if ($maxId < 101) {
			return 101;
		} else {
			return $maxId + 1;
		}
	}
	
	private function getProductPrice($product_id){
		$sql = "SELECT price FROM products WHERE id = :product_id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':product_id', $product_id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$price = $result['price'];
	
		return $price;
	}

    public function getSalesList(){
        $sql = "SELECT sale_list.id, sale_list.client_name, products.name, sale_list.amount, products.price
		FROM sale_list
		JOIN products ON sale_list.product_ID = products.product_ID
		GROUP BY sale_list.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

	public function getProductList(){
		$sql = "SELECT * FROM products";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCustomerList(){
		$sql = "SELECT * FROM sale_list";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
	
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getProducts(){
		$sql = "SELECT name, price FROM products";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function updateSale($id, $client_name, $product_ID, $amount) {
    	$sql = "UPDATE sale_list SET client_name = :client_name, product_ID = :product_ID, amount = :amount WHERE id = :id";
    	$stmt = $this->conn->prepare($sql);
    	$stmt->bindParam(':id', $id);
    	$stmt->bindParam(':client_name', $client_name);
    	$stmt->bindParam(':product_ID', $product_ID);
    	$stmt->bindParam(':amount', $amount);
    	$stmt->execute();

    return $stmt->rowCount();
	}
}