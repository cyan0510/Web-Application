<?php
class Product{
	private $DB_SERVER='localhost';
	private $DB_USERNAME='root';
	private $DB_PASSWORD='';
	private $DB_DATABASE='gbp_db';
	private $conn;
	public function __construct(){
		$this->conn = new PDO("mysql:host=".$this->DB_SERVER.";dbname=".$this->DB_DATABASE,$this->DB_USERNAME,$this->DB_PASSWORD);
		
	}
	
public function new_product_type($tname){

	$data = [
		[$tname,'1'],
	];
	$stmt = $this->conn->prepare("INSERT INTO prod_type (type_name, type_status) VALUES (?,?)");
	try {
		$this->conn->beginTransaction();
		foreach ($data as $row)
		{
			$stmt->execute($row);
		}
		$id= $this->conn->lastInsertId();
		$this->conn->commit();
		
	}catch (Exception $e){
		$this->conn->rollback();
		throw $e;
	}

	return $id;

	}

	public function new_product($pname,$desc,$price,$type){
	
		$data = [
			[$pname, $desc, $price, $type],
		];
		$stmt = $this->conn->prepare("INSERT INTO products(name, description, price, type_id) VALUES (?,?,?,?)");
		try {
			$this->conn->beginTransaction();
			foreach ($data as $row)
			{
				$stmt->execute($row);
			}
			$id= $this->conn->lastInsertId();
			$this->conn->commit();
			
		}catch (Exception $e){
			$this->conn->rollback();
			throw $e;
		}
	
		return $id;
	
		}


	public function list_product_type(){
		$sql="SELECT * FROM prod_type";
		$q = $this->conn->query($sql) or die("failed!");
		while($r = $q->fetch(PDO::FETCH_ASSOC)){
		$data[]=$r;
		}
		if(empty($data)){
		   return false;
		}else{
			return $data;	
		}
	}

	public function list_product(){
		$sql="SELECT * FROM products";
		$q = $this->conn->query($sql) or die("failed!");
		while($r = $q->fetch(PDO::FETCH_ASSOC)){
		$data[]=$r;
		}
		if(empty($data)){
		   return false;
		}else{
			return $data;	
		}
	}

	public function list_types(){
		$sql="SELECT * FROM prod_type";
		$q = $this->conn->query($sql) or die("failed!");
		while($r = $q->fetch(PDO::FETCH_ASSOC)){
		$data[]=$r;
		}
		if(empty($data)){
		   return false;
		}else{
			return $data;	
		}
	}

	public function update_product($pname,$desc, $ptype, $id){

		$sql = "UPDATE products SET name=:name,description=:description,type_id=:type_id WHERE product_ID=:product_ID";

		$q = $this->conn->prepare($sql);
		$q->execute(array(':name'=>$pname, ':description'=>$desc,':type_id'=>$ptype,':product_ID'=>$id));
		return true;
	}

	function get_prod_name($id){
		$sql="SELECT name FROM products WHERE product_ID = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$name = $q->fetchColumn();
		return $name;
	}

	function get_prod_desc($id){
		$sql="SELECT description FROM products WHERE product_ID = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$description = $q->fetchColumn();
		return $description;
	}

	function get_prod_type($id){
		$sql="SELECT type_id FROM products WHERE product_ID = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$type_id = $q->fetchColumn();
		return $type_id;
	}

	function get_type_name($id){
		$sql="SELECT type_name FROM prod_type WHERE type_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$type_name = $q->fetchColumn();
		return $type_name;
	}

	function get_price($id){
		$sql="SELECT price FROM products WHERE product_ID = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$price = $q->fetchColumn();
		return $price;
	}
	
	
}