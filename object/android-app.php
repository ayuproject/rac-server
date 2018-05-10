<?php 
require_once("config/database.php");
class appAndroid extends DbConn {

	public function __construct($id = null) {
		if ($id == NULL) 
			$this->data["id"] = $id;
		else
			$this->data["id"] = NULL;
		$this->connect();
	}

	//get data
	private $columns = array("id",
							 "name",
							 "desc",
							 "src_app",
							 "src_pdf",
							 "src_ico");
	private $data = array();

	public function getData($id) {
		$query = 

"SELECT 
	*
FROM 
	tb_app
WHERE
	id=:id_app";

		try{
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(":id_app", $id);
			$stmt->execute();
			$datas = $stmt->fetchAll();
			foreach ($datas as $data) {
				$this->data["id"] = $data["id"];
				$this->data["name"] = $data["name"];
				$this->data["desc"] = $data["description"];
				$this->data["src_app"] = $data["src_app"];
				$this->data["src_pdf"] = $data["src_pdf"];
				$this->data["src_ico"] = $data["src_ico"];
			}
			return true;
		} catch (PDOException $e) {
			echo "$e <br>";
			return false;
		}
	}

	public function __set($key, $value) {
		if(in_array($key, $this->columns)) {
			$this->data[$key] = $value;
		}
	}

	public function __get($key)
	{
		if(in_array($key, $this->columns)) {
			return $this->data[$key];
		} else {
			return $this->{$key};
		}
	}

	public function save() {
		$stmt = NULL;
		if ($this->data['id'] == NULL) {
			$stmt = $this->conn->prepare("
					INSERT INTO 
						tb_app 
					VALUES(
						NULL,
						:name,
						:descrip,
						:src_app,
						:src_pdf,
						:src_ico
					);");

		}
		else {
			$stmt = $this->conn->prepare("
					UPDATE  
						tb_app 
					SET name=:name,
						description=:descrip,
						src_app=:src_app,
						src_pdf=:src_pdf,
						src_ico=:src_ico 
					WHERE 
						id=:id;
					);");
			$stmt->bindParam(":id", $this->data['id']);
		}
		
		try {
			$stmt->bindParam(":id", $this->data['name']);
			$stmt->bindParam(":id", $this->data['desc']);
			$stmt->bindParam(":id", $this->data['src_app']);
			$stmt->bindParam(":id", $this->data['src_pdf']);
			$stmt->bindParam(":id", $this->data['src_ico']);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo "$e <br>";
			return false;
		}
	}
}
?>