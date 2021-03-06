<?php
	require_once("../config/database.php");
	require_once("../config/const.php");
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

		$data_result = array("result" => 0,
						"msg" => "",
						"angkot" => array());

		$q = "";
		if (!isset($_POST["q"])) {
			$data_result["msg"] = "bad parameter";
			echo json_encode($data_result);
			return;
		}
		$q = "%".$_POST["q"]."%";

		$stmt = $conn->prepare("
					SELECT 
						ta.id AS taid,
						ta.nama AS tanama,
						tj.id AS tjid,
						tj.nama AS tjnama,
						tj.location AS tjlocation,
						tj.latlng1 AS tjlatlng1,
						tj.latlng2 AS tjlatlng2
					FROM 
						tb_jalan AS tj
					LEFT JOIN
						tb_angkot_jalan AS taj
					ON
						tj.id=taj.id_jalan 
					LEFT JOIN
						tb_angkot AS ta
					ON
						taj.id_angkot=ta.id
					WHERE 
						tj.nama LIKE :nama_jalan;
				");
		$stmt->bindParam(':nama_jalan', $q, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		//kondisi jika data tidak ada
		$num = 0;
		foreach ($result as $data) {
			$data_result["angkot"][$num]["id"] = $data["taid"];
			$data_result["angkot"][$num]["nama"] = $data["tanama"];
			$data_result["angkot"][$num]["jalan"]["id"] = $data["tjid"];
			$data_result["angkot"][$num]["jalan"]["nama"] = $data["tjnama"];
			$data_result["angkot"][$num]["jalan"]["location"] = $data["tjlocation"];
			$data_result["angkot"][$num]["jalan"]["latlng1"] = $data["tjlatlng1"];
			$data_result["angkot"][$num]["jalan"]["latlng2"] = $data["tjlatlng2"];
			$data_result["result"] = ++$num; 
		}
		echo json_encode($data_result);
		//printf("<pre>%s</pre>", json_encode($data_result, JSON_PRETTY_PRINT));
	} catch (Exception $e) {
		header('HTTP/1.0 401 Unauthorized');
	}
?>