<?php

	function getStreet($id_angkot, $conn) {
		$data_result = array();
		$stmt_jalan = $conn->prepare("
				SELECT
					tj.id,
					tj.nama,
					tj.location,
					tj.latlng1,
					tj.latlng2
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
		foreach ($result_jalan as $data_jalan) {
			$data_result[$c_jalan]["id"] = $data_jalan["id"];
			$data_result[$c_jalan]["nama"] = $data_jalan["nama"];
			$data_result[$c_jalan]["location"] = $data_jalan["location"];
			$data_result[$c_jalan]["latlng1"] = $data_jalan["latlng1"];
			$data_result[$c_jalan]["latlng2"] = $data_jalan["latlng2"];
			$c_jalan++;
		}
		return $data_result;
	}

	function getPlace($id_angkot, $conn){
		$data_result = array();
		$stmt_tempat = $conn->prepare("
				SELECT
					tt.id,
					tt.nama,
					tt.latlng
				FROM
					tb_angkot_tempat AS tat
				LEFT JOIN
					tb_tempat AS tt
				ON
					tat.id_tempat=tt.id
				WHERE
					tat.id_angkot=".$id_angkot."

			");
		$stmt_tempat->execute();
		$result_tempat = $stmt_tempat->fetchAll();
		$c_tempat = 0;
		foreach ($result_tempat as $data_tempat) {
			$data_result[$c_tempat]["id"] = $data_tempat["id"];
			$data_result[$c_tempat]["nama"] = $data_tempat["nama"];
			$data_result[$c_tempat]["latlng"] = $data_tempat["latlng"];
			++$c_tempat;
		}
		return $data_result;
	}

?>