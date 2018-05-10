<?php
	require_once("config/database.php");
	require_once("config/const.php");
	$data_result = array();
	$stmt_jalan = $conn->prepare("
			SELECT
				id,
				nama,
				location,
				latlng1,
				latlng2,
				place_id
			FROM
				tb_jalan;
		");

	$stmt_jalan->execute();
	$result_jalan = $stmt_jalan->fetchAll();
	$c_jalan = 0;
	foreach ($result_jalan as $data_jalan) {
		$data_result["jalan"][$c_jalan]["id"] = $data_jalan["id"];
		$data_result["jalan"][$c_jalan]["nama"] = $data_jalan["nama"];
		$data_result["jalan"][$c_jalan]["location"] = $data_jalan["location"];
		$data_result["jalan"][$c_jalan]["latlng1"] = $data_jalan["latlng1"];
		$data_result["jalan"][$c_jalan]["latlng2"] = $data_jalan["latlng2"];
		$data_result["jalan"][$c_jalan]["place_id"] = $data_jalan["place_id"];
		$c_jalan++;
	}

	echo json_encode($data_result);
?>