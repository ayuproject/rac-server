<?php
	session_start();

    if (!isset($_SESSION['login_id'])) {
		session_destroy();
        header('HTTP/1.0 401 Unauthorized');
        return;
    }
	require_once("config/database.php");
	require_once("config/const.php");
	$data_result = array();
	$stmt_jalan = $conn->prepare("
			SELECT
				id,
				nama,
				latlng,
				place_id
			FROM
				tb_tempat;

		");

	$stmt_jalan->execute();
	$result_jalan = $stmt_jalan->fetchAll();
	$c_jalan = 0;
	foreach ($result_jalan as $data_jalan) {
		$data_result["tempat"][$c_jalan]["id"] = $data_jalan["id"];
		$data_result["tempat"][$c_jalan]["nama"] = $data_jalan["nama"];
		$data_result["tempat"][$c_jalan]["location"] = $data_jalan["latlng"];
		$data_result["tempat"][$c_jalan]["place_id"] = $data_jalan["place_id"];
		$c_jalan++;
	}

	echo json_encode($data_result);
?>