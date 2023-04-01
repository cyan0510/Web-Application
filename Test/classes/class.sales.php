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
	
	public function createOrder($client_name, $amount){
		$sql = "INSERT INTO sale_list (id, client_name, amount) VALUES (:id, :client_name, :amount)";
		$stmt = $this->conn->prepare($sql);
		$id = $this->getNextSaleId();
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':client_name', $client_name);
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
		$sql = "SELECT * FROM sale_list, products";
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
}