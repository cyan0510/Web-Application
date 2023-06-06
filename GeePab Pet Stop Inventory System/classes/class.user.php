<?php
class User{
	private $DB_SERVER='localhost';
	private $DB_USERNAME='root';
	private $DB_PASSWORD='';
	private $DB_DATABASE='gbp_db';
	private $conn;
	public function __construct(){
		$this->conn = new PDO("mysql:host=".$this->DB_SERVER.";dbname=".$this->DB_DATABASE,$this->DB_USERNAME,$this->DB_PASSWORD);
		
	}
	
	public function new_user($email,$password,$lastname,$firstname, $access){
		// Check if email already exists in database
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE user_email = ?");
		$stmt->execute([$email]);
		$result = $stmt->fetchColumn();
		if ($result > 0) {
			// Email already exists, return false
			return false;
		}
	
		$data = [
			[$lastname,$firstname,$email,$password,'1', $access],
		];
		$stmt = $this->conn->prepare("INSERT INTO users (user_lastname, user_firstname, user_email, user_password, user_status, user_access) VALUES (?,?,?,?,?,?)");
		try {
			$this->conn->beginTransaction();
			foreach ($data as $row)
			{
				$stmt->execute($row);
			}
			$this->conn->commit();
		}catch (Exception $e){
			$this->conn->rollback();
			throw $e;
		}
	
		return true;
	}

	public function list_users_search($keyword) {
		$q = $this->conn->prepare('SELECT * FROM `users` WHERE `user_lastname` LIKE ? OR `user_firstname` LIKE ?');
		$q->bindValue(1, "%$keyword%", PDO::PARAM_STR);
		$q->bindValue(2, "%$keyword%", PDO::PARAM_STR);
		$q->execute();
	
		$data = array();
	
		while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $r;
		}
	
		if (empty($data)) {
			return false;
		} else {
			return $data;	
		}
	}

	public function update_user($lastname,$firstname, $access, $id){

		$sql = "UPDATE users SET user_firstname=:user_firstname,user_lastname=:user_lastname,user_access=:user_access WHERE user_id=:user_id";

		$q = $this->conn->prepare($sql);
		$q->execute(array(':user_firstname'=>$firstname, ':user_lastname'=>$lastname,':user_access'=>$access,':user_id'=>$id));
		return true;
	}

	public function change_user_status($id,$status){

		$sql = "UPDATE users SET user_status=:user_status WHERE user_id=:user_id";

		$q = $this->conn->prepare($sql);
		$q->execute(array(':user_status'=>$status,':user_id'=>$id));
		return true;
	}

	public function change_email($id,$email){

		$sql = "UPDATE users SET user_email=:user_email WHERE user_id=:user_id";

		$q = $this->conn->prepare($sql);
		$q->execute(array(':user_email'=>$email,':user_id'=>$id));
		return true;
	}

	public function change_password($id,$password){

		$sql = "UPDATE users SET user_password=:user_password WHERE user_id=:user_id";

		$q = $this->conn->prepare($sql);
		$q->execute(array(':user_password'=>$password,':user_id'=>$id));
		return true;
	}
	
	public function list_users(){
		$access = $this->get_user_access($this->get_user_id($_SESSION['user_email']));
	
		if ($access == "Manager") {
			$sql = "SELECT * FROM users";
		} else {
			$sql = "SELECT * FROM users WHERE user_id = :user_id";
		}
	
		$q = $this->conn->prepare($sql);
	
		if ($access != "Manager") {
			$q->execute(['user_id' => $this->get_user_id($_SESSION['user_email'])]);
		} else {
			$q->execute();
		}
	
		while($r = $q->fetch(PDO::FETCH_ASSOC)){
			$data[] = $r;
		}
	
		if(empty($data)){
			return false;
		} else {
			return $data;
		}
	}

	function get_user_id($email){
		$sql="SELECT user_id FROM users WHERE user_email = :email";	
		$q = $this->conn->prepare($sql);
		$q->execute(['email' => $email]);
		$user_id = $q->fetchColumn();
		return $user_id;
	}
	function get_user_email($id){
		$sql="SELECT user_email FROM users WHERE user_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$user_email = $q->fetchColumn();
		return $user_email;
	}
	function get_user_firstname($id){
		$sql="SELECT user_firstname FROM users WHERE user_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$user_firstname = $q->fetchColumn();
		return $user_firstname;
	}
	function get_user_lastname($id){
		$sql="SELECT user_lastname FROM users WHERE user_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$user_lastname = $q->fetchColumn();
		return $user_lastname;
	}
	function get_user_access($id){
		$sql="SELECT user_access FROM users WHERE user_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$user_access = $q->fetchColumn();
		return $user_access;
		
	}
	function get_user_status($id){
		$sql="SELECT user_status FROM users WHERE user_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['id' => $id]);
		$user_status = $q->fetchColumn();
		return $user_status;
	}
	function get_session(){
		if(isset($_SESSION['login']) && $_SESSION['login'] == true){
			return true;
		}else{
			return false;
		}
	}
    public function check_login($email, $password){
        $sql = "SELECT * FROM users WHERE user_email = :user_email AND user_password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(':user_email' => $email, ':password' => $password));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            if($user['user_status'] == 0){
                return false; // user is deactivated
            } else {
				$_SESSION['login']=true;
				$_SESSION['user_email']=$email;
				return true;
            }
        } else {
            return false; // user does not exist
        }
    }
}