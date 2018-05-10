<?php
	require_once("../config/database.php");
	require_once("../config/const.php");

	$data_result = array("result" => 0,
						"msg" => "",
					  	"angkot" => array());

	$q = "";
	$sql_ = ";";
	if (isset($_GET["q"])) {
		$q = "%".$_GET["q"]."%";
		$sql_ = "WHERE nama LIKE :nama;";
	}

	$stmt = $conn->prepare("
				SELECT 
					id,
					nama,
					harga
				FROM 
					tb_angkot
				".$sql_."
			");
	if ($q !== '')
		$stmt->bindParam(':nama', $q, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	//kondisi jika data tidak ada
	$num = 0;
	foreach ($result as $data) {
		$id_angkot = $data["id"];
		$data_result["angkot"][$num]["id"] = $id_angkot;
		$data_result["angkot"][$num]["nama"] = $data["nama"];
		$stmt_jalan = $conn->prepare("
				SELECT
					tj.nama
				FROM
					tb_angkot_jalan AS taj
				LEFT JOIN
					tb_jalan AS tj
				ON
					taj.id_jalan=tj.id
				WHERE
					taj.id_angkot=".$id_angkot."

			");
		$stmt_jalan->execute();
		$result_jalan = $stmt_jalan->fetchAll();
		$c_jalan = 0;
		$s_jalan = "";
		$data_result["angkot"][$num]["alljalan"] = $s_jalan;
		foreach ($result_jalan as $data_jalan) {
			if ($c_jalan == 0) 
				$s_jalan = $data_jalan["nama"];
			else 
				$s_jalan .= " -- ".$data_jalan["nama"];
			$c_jalan++;
		}
		$data_result["angkot"][$num]["alljalan"] = $s_jalan;
		$data_result["result"] = ++$num;
	}
	echo json_encode($data_result);
	//printf("<pre>%s</pre>", $json);
?>