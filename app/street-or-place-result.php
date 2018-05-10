<?php
	require_once("../config/database.php");
	require_once("../config/const.php");

	$data_result = array("result" => 0,
						"msg" => "",
						"start" => "",
					  	"angkot" => array());

	$street = "";
	$place = "";
	$start = "";
	if (!isset($_GET["street"]) ||
		!isset($_GET["place"]) ||
		!isset($_GET["start"])) {
		$data_result["msg"] = "bad parameters";
		echo json_encode($data_result);
		return;
	}
	$start = $_GET["start"];
	$street = "%".$_GET["street"]."%";
	$place = "%".$_GET["place"]."%";

	$stmt = $conn->prepare("
				SELECT 
				    ta.id AS taid,
				    ta.nama AS tanama,
				    tt.id AS ttid,
				    tt.nama AS ttnama,
				    tt.latlng AS ttlocation,
				    tj.id AS tjid,
				    tj.nama AS tjnama,
				    tj.location AS tjlocation,
				    tj.latlng1 AS tjlatlng1,
				    tj.latlng2 AS tjlatlng2
				FROM
				    tb_angkot AS ta 
				LEFT JOIN
				    tb_angkot_tempat AS tat
				ON
				    ta.id=tat.id_angkot
				LEFT JOIN
				    tb_tempat AS tt
				ON
				    tat.id_tempat=tt.id
				LEFT JOIN
				    tb_angkot_jalan AS taj
				ON
				    ta.id=taj.id_angkot
				LEFT JOIN
				    tb_jalan AS tj
				ON
				    taj.id_jalan=tj.id
				WHERE
				    tt.nama LIKE :nama_tempat
				AND
				    tj.nama LIKE :nama_jalan;

			");
	$stmt->bindParam(':nama_tempat', $place, PDO::PARAM_STR);
	$stmt->bindParam(':nama_jalan', $street, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	//kondisi jika data tidak ada
	$num = 0;
	$data_result["start"] = $start;
	foreach ($result as $data) {
		$data_result["result"] = $num + 1;
		$data_result["angkot"][$num]["id"] = $data["taid"];
		$data_result["angkot"][$num]["nama"] = $data["tanama"];
		$data_result["angkot"][$num]["jalan"]["id"] = $data["tjid"];
		$data_result["angkot"][$num]["jalan"]["nama"] = $data["tjnama"];
		$data_result["angkot"][$num]["jalan"]["location"] = $data["tjlocation"];
		$data_result["angkot"][$num]["jalan"]["latlng1"] = $data["tjlatlng1"];
		$data_result["angkot"][$num]["jalan"]["latlng2"] = $data["tjlatlng2"];
		$data_result["angkot"][$num]["tempat"]["id"] = $data["ttid"];
		$data_result["angkot"][$num]["tempat"]["nama"] = $data["ttnama"];
		$data_result["angkot"][$num]["tempat"]["location"] = $data["ttlocation"];
		$num++;
	}
	echo json_encode($data_result);
	//printf("<pre>%s</pre>", json_encode($data_result, JSON_PRETTY_PRINT));
?>