<?php
	require_once("config/const.php");
    require_once("config/database.php");
    
    function deleteTableFrom($stmt, $id_angkot) {
        try {
            $stmt->bindParam(":id_angkot", $id_angkot);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (PDOException $e) {
            return "$e";
        }
        return "";
    }

    function createMultipleInsertSQL($id_angkot, $table_name, $col_name, $val, $conn) {
        $sql = "
            INSERT INTO
                ". $table_name ."(
                    id_angkot,
                    ". $col_name ."
                )
            VALUES ";
        for ($i = 0; $i < sizeof($val); ++$i) {
            $sql .= $i === 0 ? "" : ",";
            $sql .= "($id_angkot, :val$i)";
        }
        $sql .= ";";
        $stmt = $conn->prepare($sql);
        for ($i = 0; $i < sizeof($val); ++$i) {
            $stmt->bindParam(":val$i", $val[$i]);
        }

        return $stmt;
    }

	$aksi = $_POST["aksi"];
	$id = $_POST["id"];
	$nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
	$tarif = isset($_POST["tarif"]) ? $_POST["tarif"] : "";
	$rute = isset($_POST["rute"]) ? $_POST["rute"] : array();
	$id_jalan = isset($_POST["id_jalan"]) ? $_POST["id_jalan"] : array();
    $id_tempat = isset($_POST["id_tempat"]) ? $_POST["id_tempat"] : array();
    $satu_jalur = isset($_POST["satu_jalur"]) ? $_POST["satu_jalur"] : 0;
    $pesan = "";

    $stmt_angkot = null;
    $stmt_rute = null;
    $stmt_jalan = null;
    $stmt_tempat = null;
    
	if ($aksi === "edit") {
        $pesan = "diubah";
        $del_rute = deleteTableFrom(
            $conn->prepare("
                DELETE FROM
                    tb_angkot_rute
                WHERE 
                    id_angkot=:id_angkot
            "),
            $id
        );
        $del_jalan = deleteTableFrom(
            $conn->prepare("
                DELETE FROM
                    tb_angkot_jalan
                WHERE 
                    id_angkot=:id_angkot
            "),
            $id
        );
        $del_tempat = deleteTableFrom(
            $conn->prepare("
                DELETE FROM
                    tb_angkot_tempat
                WHERE 
                    id_angkot=:id_angkot
            "),
            $id
        );
        if ($del_rute !== "" || $del_jalan !== "" || $del_tempat !== "") {
            echo "$del_rute---$del_jalan---$del_tempat";
            return;
        }
        try {
            $stmt_angkot = $conn->prepare("
                UPDATE
                    tb_angkot
                    SET
                    nama=:nama,
                    harga=:tarif,
                    satu_jalur=:satu_jalur
                    WHERE 
                    id=:id;
                );"
            );
            $stmt_angkot->bindParam(":id", $id);
            $stmt_angkot->bindParam(":nama", $nama);
            $stmt_angkot->bindParam(":tarif", $tarif);
            $stmt_angkot->bindParam(":satu_jalur", $satu_jalur);
            $stmt_angkot->execute();
            $stmt_angkot->closeCursor();
            $stmt_rute = createMultipleInsertSQL(
                $id, 
                "tb_angkot_rute", 
                "latlng", 
                $rute, 
                $conn
            );
            $stmt_rute->execute();
            $stmt_rute->closeCursor();
            $stmt_jalan = createMultipleInsertSQL(
                $id, 
                "tb_angkot_jalan", 
                "id_jalan", 
                $id_jalan,
                $conn
            );
            $stmt_jalan->execute();
            $stmt_jalan->closeCursor();
            $stmt_tempat = createMultipleInsertSQL(
                $id,
                "tb_angkot_tempat", 
                "id_tempat", 
                $id_tempat,
                $conn
            );
            $stmt_tempat->execute();
            $stmt_tempat->closeCursor();
            echo "Data berhasil di $pesan";
        } catch (PDOException $e) {
            echo "$e";
        }
	} else if ($aksi === "tambah") {
		$pesan = "ditambah";
		$stmt_angkot = $conn->prepare("
					INSERT INTO 
						tb_angkot (
							nama,
                            harga,
                            satu_jalur
						)
					VALUES (
						:nama,
                        :tarif,
                        :satu_jalur
					);"
		);
		$stmt_angkot->bindParam(":nama", $nama);
        $stmt_angkot->bindParam(":tarif", $tarif);
        $stmt_angkot->bindParam(":satu_jalur", $satu_jalur);
        try {
            $stmt_angkot->execute();
            $id = $conn->lastInsertId();
            $stmt_angkot->closeCursor();
            $stmt_rute = createMultipleInsertSQL(
                $id, 
                "tb_angkot_rute", 
                "latlng", 
                $rute, 
                $conn
            );
            $stmt_jalan = createMultipleInsertSQL(
                $id, 
                "tb_angkot_jalan", 
                "id_jalan", 
                $id_jalan,
                $conn
            );
            $stmt_tempat = createMultipleInsertSQL(
                $id,
                "tb_angkot_tempat", 
                "id_tempat", 
                $id_tempat,
                $conn
            );
            $stmt_rute->execute();
            $stmt_rute->closeCursor();
            $stmt_jalan->execute();
            $stmt_jalan->closeCursor();
            $stmt_tempat->execute();
            $stmt_tempat->closeCursor();
            echo "Data berhasil di $pesan";
        } catch (PDOException $e) {
            echo "$e";
        }
	} else if ($aksi === "hapus") {
		$pesan = "dihapus";
		$stmt_angkot = $conn->prepare("
					DELETE FROM
						tb_angkot
					WHERE
						id=:id;"
		);
        $stmt_angkot->bindParam(":id", $id);
        $stmt_rute = $conn->prepare("
					DELETE FROM
						tb_angkot_rute
					WHERE
						id_angkot=:id;"
		);
        $stmt_rute->bindParam(":id", $id);
        $stmt_jalan = $conn->prepare("
					DELETE FROM
						tb_angkot_jalan
					WHERE
						id_angkot=:id;"
		);
        $stmt_jalan->bindParam(":id", $id);
        $stmt_tempat = $conn->prepare("
					DELETE FROM
						tb_angkot_tempat
					WHERE
						id_angkot=:id;"
		);
        $stmt_tempat->bindParam(":id", $id);
        try {
            $stmt_angkot->execute();
            $stmt_angkot->closeCursor();
            $stmt_rute->execute();
            $stmt_rute->closeCursor();
            $stmt_jalan->execute();
            $stmt_jalan->closeCursor();
            $stmt_tempat->execute();
            $stmt_tempat->closeCursor();
            echo "Data berhasil di $pesan";
        } catch (PDOException $e) {
            echo "$e";
        }
	}
?>