<?php
    session_start();
    if(!isset($_SESSION['login_id'])){
      session_destroy();
      echo "<script type='text/javascript'>window.location='login.php';</script>";
      exit();
    }
	require_once("config/const.php");
	require_once("config/database.php");


	$aksi = "";
	$id = -1;
	$nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
    $pass = isset($_POST["password"]) ? $_POST["password"] : "";
    
    if ($_SESSION['login_level'] == 1) {
        $aksi = $_POST["aksi"];
        $id = $_POST["id"];
        $nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
        $pass = isset($_POST["pass"]) ? $_POST["pass"] : "";
    } else {
        $aksi = "edit";
        $id = $_SESSION['login_id'];
        if ($nama === "" || $pass === "") {
            echo "<script type='text/javascript'>window.alert('Invalid Input');</script>";
            echo "<script type='text/javascript'>window.location='edit-user.php';</script>";
            exit();
        }
    }





	$pesan = "";

	$stmt = null;

	if ($aksi === "edit") {
		$pesan = "diubah";
		$stmt = $conn->prepare("
					UPDATE  
						tb_users 
					SET 
                        user_name=:nama,
                        password=:pass
					WHERE 
						id=:id;
					);"
		);
		$stmt->bindParam(":id", $id);
        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":pass", $pass);
	} else if ($aksi === "tambah") {
        $pesan = "ditambah";

		$stmt = $conn->prepare("
					INSERT INTO 
                        tb_users (
							user_name,
							password,
							lv
						)
					VALUES (
						:nama,
						:pass,
						2
					);"
		);
		$stmt->bindParam(":nama", $nama);
		$stmt->bindParam(":pass", $pass);
	} else if ($aksi === "hapus") {
		$pesan = "dihapus";
		$stmt = $conn->prepare("
					DELETE FROM
						tb_users
					WHERE
                        id=:id;
                    AND 
                        lv<>1"
		);
		$stmt->bindParam(":id", $id);
	}
	try {
        $stmt->execute();
        if ($aksi === "edit" && $_SESSION['login_level'] !== 1) {
            $_SESSION['login_user'] = $nama;
            $_SESSION['login_pass'] = $pass;
        }
        if ($_SESSION['login_level'] === 1) {
            if ($aksi === "edit" && $_SESSION['login_id'] === $id) {
                $_SESSION['login_user'] = $nama;
                $_SESSION['login_pass'] = $pass;
            }
        }
		echo "Data berhasil di $pesan";
	} catch (PDOException $e) {
		echo "$e";
	}
?>