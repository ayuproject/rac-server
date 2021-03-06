<?php
	require_once("../config/database.php");
	require_once("../config/const.php");
	require_once("get-location.php");
	require_once('../vendor/autoload.php');

	use \Firebase\JWT\JWT;

	
	try {
		/*
		* decode the jwt using the key from config
		*/
		
		$jwt = "";
		foreach (getallheaders() as $name => $value) {
			if ($name === "Authorization") {
				List($jwt) = sscanf($value, 'Bearer %s');
				break;
			}
		}
	
		if ($jwt === "") {
			header('HTTP/1.0 401 Unauthorized');
			return;
		}
		$secretKey = KEY_TOKEN;
		$token = JWT::decode($jwt, $secretKey, array('HS256'));

		/*
		 * return protected asset
		 */
		
		header('Content-type: application/json');

		$id = 0;

		$data_result = array("result" => 0,
							"msg" => "",
							"angkot" => array());
		if (!isset($_POST["id"])) {
			$data_result["msg"] = "bad parameter";
			echo json_encode($data_result);
			return;
		}
		$id = $_POST["id"];

		$stmt = $conn->prepare("
					SELECT 
						id,
						nama,
						harga,
						satu_jalur
					FROM 
						tb_angkot
					WHERE
						id=:id;
				");
		
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		//kondisi jika data tidak ada
		$num = 0;
		foreach ($result as $data) {
			$id_angkot = $data["id"];
			$data_result["result"] = 1;
			$data_result["angkot"]["id"] = $id_angkot;
			$data_result["angkot"]["nama"] = $data["nama"];
			$data_result["angkot"]["harga"] = $data["harga"];
			$data_result["angkot"]["satu_jalur"] = $data["satu_jalur"] == 1 ? true : false;
			$stmt_rute = $conn->prepare("
					SELECT
						latlng
					FROM
						tb_angkot_rute
					WHERE
						id_angkot=".$id_angkot."

				");
			$stmt_rute->execute();
			$result_rute = $stmt_rute->fetchAll();
			$c_rute = 0;
			$data_result["angkot"]["rute"] = array();
			foreach ($result_rute as $data_rute) {
				$data_result["angkot"]["rute"][$c_rute++] = $data_rute["latlng"];
			}
			$data_result["angkot"]["jalan"] = getStreet($id_angkot, $conn);
			$data_result["angkot"]["tempat"] = getPlace($id_angkot, $conn);
		}

		echo json_encode($data_result);
		//printf("<pre>%s</pre>", json_encode($data_result, JSON_PRETTY_PRINT));
	} catch (Exception $e) {
		header('HTTP/1.0 401 Unauthorized');
	}
?>