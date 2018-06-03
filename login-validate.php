<?php
    require_once('config/database.php');
    $nama = $_POST['username'];
    $pass = $_POST['password'];
    $stmt = $conn->prepare("
            SELECT
                id,
                user_name,
                password, 
                lv
            FROM
                tb_users
            WHERE
                user_name=:nama
            AND 
                password=:pass;

        ");
    $stmt->bindParam(":nama", $nama);
    $stmt->bindParam(":pass", $pass);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        session_start();
        $row = $stmt->fetch();
        $_SESSION['login_id'] = $row["id"];
        $_SESSION['login_user'] = $row["user_name"];
        $_SESSION['login_pass'] = $row["password"];
        $_SESSION['login_level'] = $row["lv"];
        echo "<script type='text/javascript'>window.alert('Selamat datang ' + ".$_SESSION['login_user'].");</script>";
        echo "<script type='text/javascript'>window.location='index.php';</script>";
    } else {
        echo "<script type='text/javascript'>window.alert('Username atau Password salah');</script>";
        echo "<script type='text/javascript'>window.location='login.php';</script>";
        exit();
    }

?>