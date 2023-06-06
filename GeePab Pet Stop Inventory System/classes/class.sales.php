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

    public function list_sales_search($keyword) {
        $q = $this->conn->prepare('SELECT * FROM `sale_list` WHERE `client_name` LIKE ?');
        $q->bindValue(1, "%$keyword%", PDO::PARAM_STR);
        $q->execute();
    
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $r;
        }
        if (empty($data)) {
            return false;
        } else {
            return $data;
        }
    }

	public function get_client_name($client_name) {
		$sql = "SELECT client_name FROM sale_list WHERE client_name = :client_name";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':client_name', $client_name);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
		if ($result && isset($result['client_name'])) {
			$client_name = $result['client_name'];
			return $client_name;
		} else {
			return "";
		}
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
	

	public function getProductPrice($product_ID) {    
		$sql = "SELECT price FROM products WHERE product_ID = :product_ID";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':product_ID', $product_ID);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
	
		if ($result && isset($result['price'])) {
			$price = $result['price'];
			return $price;
		} else {
			// Return a default value or handle the error accordingly
			return 0;
		}
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
		$stmt->bindParam(':client_name', $client_name);
		$stmt->bindParam(':product_ID', $product_ID);
		$stmt->bindParam(':amount', $amount);
		$stmt->bindParam(':id', $id);
		$success = $stmt->execute();
	
		return $success;
	}
	
	
	public function getSaleById($id) {
		$sql = "SELECT * FROM sale_list WHERE id = :id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	
		$sale = $stmt->fetch(PDO::FETCH_ASSOC);
	
		return $sale ?: false;
	}
	
		
}

