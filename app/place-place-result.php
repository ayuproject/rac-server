<?php
	require_once("../config/database.php");
	require_once("../config/const.php");

	$data_result = array("result" => 0,
						"msg" => "",
					  	"angkot" => array());

	$place1 = "";
	$place2 = "";
	if (!isset($_GET["place1"]) ||
		!isset($_GET["place2"])) {
		$data_result["msg"] = "bad parameters";
		echo json_encode($data_result);
		return;
	}
	$place1 = "%".$_GET["place1"]."%";
	$place2 = "%".$_GET["place2"]."%";

	$stmt = $conn->prepare("
				SELECT 
				    ta.id AS taid,
				    ta.nama AS tanama,
				    tt.id AS ttid1,
				    tt.nama AS ttnama1,
				    tt.latlng AS ttlatlng1,
				    tt1.id AS ttid2,
				    tt1.nama AS ttnama2,
				    tt1.latlng AS ttlatlng2
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
				INNER JOIN
				    tb_angkot_tempat AS tat1
				ON
				    ta.id=tat1.id_angkot
				INNER JOIN
				    tb_tempat AS tt1
				ON
				    tat1.id_tempat=tt1.id
				AND
				    tt1.nama LIKE :nama_tempat2
				WHERE
				    tt.nama  LIKE :nama_tempat1;

			");
	$stmt->bindParam(':nama_tempat1', $place1, PDO::PARAM_STR);
	$stmt->bindParam(':nama_tempat2', $place2, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	//kondisi jika data tidak ada
	$num = 0;
	foreach ($result as $data) {
		$data_result["result"] = $num + 1;
		$data_result["angkot"][$num]["id"] = $data["taid"];
		$data_result["angkot"][$num]["nama"] = $data["tanama"];
		$data_result["angkot"][$num]["tempat1"]["id"] = $data["ttid1"];
		$data_result["angkot"][$num]["tempat1"]["nama"] = $data["ttnama1"];
		$data_result["angkot"][$num]["tempat1"]["location"] = $data["ttlatlng1"];
		$data_result["angkot"][$num]["tempat2"]["id"] = $data["ttid2"];
		$data_result["angkot"][$num]["tempat2"]["nama"] = $data["ttnama2"];
		$data_result["angkot"][$num]["tempat2"]["location"] = $data["ttlatlng2"];
		$num++;
	}
	echo json_encode($data_result);
	//printf("<pre>%s</pre>", json_encode($data_result, JSON_PRETTY_PRINT));
?>