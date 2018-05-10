<?php
	require_once("../config/database.php");
	require_once("../config/const.php");

	$data_result = array("result" => 0,
					  "msg" => "",
					  "angkot" => array());

	$q = "";
	if (!isset($_GET["q"])) {
		$data_result["msg"] = "bad parameter";
		echo json_encode($data_result);
		return;
	}
	$q = "%".$_GET["q"]."%";

	$stmt = $conn->prepare("
				SELECT 
					ta.id AS taid,
					ta.nama AS tanama,
					tt.id AS ttid,
					tt.nama AS ttnama,
					tt.latlng AS ttlocation
				FROM 
					tb_tempat AS tt
				LEFT JOIN
					tb_angkot_tempat AS tat
				ON
					tt.id=tat.id_tempat 
				LEFT JOIN
					tb_angkot AS ta
				ON
					tat.id_angkot=ta.id
				WHERE 
					tt.nama LIKE :nama_tempat;
			");
	$stmt->bindParam(':nama_tempat', $q, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	//kondisi jika data tidak ada
	$num = 0;
	foreach ($result as $data) {
		$data_result["angkot"][$num]["id"] = $data["taid"];
		$data_result["angkot"][$num]["nama"] = $data["tanama"];
		$data_result["angkot"][$num]["tempat"]["id"] = $data["ttid"];
		$data_result["angkot"][$num]["tempat"]["nama"] = $data["ttnama"];
		$data_result["angkot"][$num]["tempat"]["location"] = $data["ttlocation"];
		$data_result["result"] = ++$num; 
	}
	echo json_encode($data_result);
	//printf("<pre>%s</pre>", json_encode($data_result, JSON_PRETTY_PRINT));
?>