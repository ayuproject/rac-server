<?php
	require_once("../config/database.php");
	require_once("../config/const.php");

	$data_result = array("result" => 0,
						"msg" => "",
					  	"angkot" => array());

	$street1 = "";
	$street2 = "";
	if (!isset($_GET["street1"]) ||
		!isset($_GET["street2"])) {
		$data_result["msg"] = "bad parameters";
		echo json_encode($data_result);
		return;
	}
	$street1 = "%".$_GET["street1"]."%";
	$street2 = "%".$_GET["street2"]."%";

	$stmt = $conn->prepare("
				SELECT 
				    ta.id AS taid,
				    ta.nama AS tanama,
				    tj.id AS tjid1,
				    tj.nama AS tjnama1,
				    tj.location AS tjlocation1,
				    tj.latlng1 AS tjlatlng11,
				    tj.latlng2 AS tjlatlng21,
				    tj1.id AS tjid2,
				    tj1.nama AS tjnama2,
				    tj1.location AS tjlocation2,
				    tj1.latlng1 AS tjlatlng12,
				    tj1.latlng2 AS tjlatlng22
				FROM
				    tb_angkot AS ta 
				LEFT JOIN
				    tb_angkot_jalan AS taj
				ON
				    ta.id=taj.id_angkot
				LEFT JOIN
				    tb_jalan AS tj
				ON
				    taj.id_jalan=tj.id
				INNER JOIN
				    tb_angkot_jalan AS taj1
				ON
				    ta.id=taj1.id_angkot
				INNER JOIN
				    tb_jalan AS tj1
				ON
				    taj1.id_jalan=tj1.id
				AND
				    tj1.nama LIKE :nama_jalan2
				WHERE
				    tj.nama  LIKE :nama_jalan1;

			");
	$stmt->bindParam(':nama_jalan1', $street1, PDO::PARAM_STR);
	$stmt->bindParam(':nama_jalan2', $street2, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	//kondisi jika data tidak ada
	$num = 0;
	foreach ($result as $data) {
		$data_result["result"] = $num + 1;
		$data_result["angkot"][$num]["id"] = $data["taid"];
		$data_result["angkot"][$num]["nama"] = $data["tanama"];
		$data_result["angkot"][$num]["jalan1"]["id"] = $data["tjid1"];
		$data_result["angkot"][$num]["jalan1"]["nama"] = $data["tjnama1"];
		$data_result["angkot"][$num]["jalan1"]["location"] = $data["tjlocation1"];
		$data_result["angkot"][$num]["jalan1"]["latlng1"] = $data["tjlatlng11"];
		$data_result["angkot"][$num]["jalan1"]["latlng2"] = $data["tjlatlng21"];
		$data_result["angkot"][$num]["jalan2"]["id"] = $data["tjid2"];
		$data_result["angkot"][$num]["jalan2"]["nama"] = $data["tjnama2"];
		$data_result["angkot"][$num]["jalan2"]["location"] = $data["tjlocation2"];
		$data_result["angkot"][$num]["jalan2"]["latlng1"] = $data["tjlatlng12"];
		$data_result["angkot"][$num]["jalan2"]["latlng2"] = $data["tjlatlng22"];
		$num++;
	}
	echo json_encode($data_result);
	//printf("<pre>%s</pre>", json_encode($data_result, JSON_PRETTY_PRINT));
?>