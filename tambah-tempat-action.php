<?php
	require_once("config/const.php");
	require_once("config/database.php");

	$aksi = $_POST["aksi"];
	$id_tempat = $_POST["id_tempat"];
	$nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
	$location = isset($_POST["location"]) ? $_POST["location"] : "";
	$place_id = isset($_POST["placeid"]) ? $_POST["placeid"] : "";
	$pesan = "";

	$stmt = null;

	if ($aksi === "edit") {
		$pesan = "diubah";
		$stmt = $conn->prepare("
					UPDATE  
						tb_tempat 
					SET 
						nama=:nama
					WHERE 
						id=:id;
					);"
		);
		$stmt->bindParam(":id", $id_tempat);
		$stmt->bindParam(":nama", $nama);
	} else if ($aksi === "tambah") {
		$pesan = "ditambah";
		$stmt = $conn->prepare("
					INSERT INTO 
						tb_tempat (
							nama,
							latlng,
							place_id
						)
					VALUES (
						:nama,
						:location,
						:placeid
					);"
		);
		$stmt->bindParam(":nama", $nama);
		$stmt->bindParam(":location", $location);
		$stmt->bindParam(":placeid", $place_id);
	} else if ($aksi === "hapus") {
		$pesan = "dihapus";
		$stmt = $conn->prepare("
					DELETE FROM
						tb_tempat
					WHERE
						id=:id;"
		);
		$stmt->bindParam(":id", $id_tempat);
	}
	try {
		$stmt->execute();
		echo "Data berhasil di $pesan";
	} catch (PDOException $e) {
		echo "$e";
	}
?>