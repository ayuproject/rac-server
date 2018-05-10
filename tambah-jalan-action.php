<?php
	require_once("config/const.php");
	require_once("config/database.php");

	$aksi = $_POST["aksi"];
	$id_jalan = $_POST["id_jalan"];
	$nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
	$location = isset($_POST["location"]) ? $_POST["location"] : "";
	$northeast = isset($_POST["northeast"]) ? $_POST["northeast"] : "";
	$southwest = isset($_POST["southwest"]) ? $_POST["southwest"] : "";
	$place_id = isset($_POST["placeid"]) ? $_POST["placeid"] : "";
	$pesan = "";

	$stmt = null;

	if ($aksi === "edit") {
		$pesan = "diubah";
		$stmt = $conn->prepare("
					UPDATE  
						tb_jalan 
					SET 
						nama=:nama
					WHERE 
						id=:id;
					);"
		);
		$stmt->bindParam(":id", $id_jalan);
		$stmt->bindParam(":nama", $nama);
	} else if ($aksi === "tambah") {
		$pesan = "ditambah";
		$stmt = $conn->prepare("
					INSERT INTO 
						tb_jalan (
							nama,
							location,
							latlng1,
							latlng2,
							place_id
						)
					VALUES (
						:nama,
						:location,
						:northeast,
						:southwest,
						:placeid
					);"
		);
		$stmt->bindParam(":nama", $nama);
		$stmt->bindParam(":location", $location);
		$stmt->bindParam(":northeast", $northeast);
		$stmt->bindParam(":southwest", $southwest);
		$stmt->bindParam(":placeid", $place_id);
	} else if ($aksi === "hapus") {
		$pesan = "dihapus";
		$stmt = $conn->prepare("
					DELETE FROM
						tb_jalan
					WHERE
						id=:id;"
		);
		$stmt->bindParam(":id", $id_jalan);
	}
	try {
		$stmt->execute();
		echo "Data berhasil di $pesan";
	} catch (PDOException $e) {
		echo "$e";
	}
?>