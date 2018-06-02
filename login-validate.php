<?php
    require_once('config/database.php');    
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
        $_SESSION['login_id'] = $stmt->fetchColumn();
        $_SESSION['login_user'] = $stmt->fetchColumn(1);
        $_SESSION['login_pass'] = $stmt->fetchColumn(2);
        $_SESSION['login_level'] = $stmt->fetchColumn(3);
    } else {
        echo "<script type='text/javascript'>window.alert('Username atau Password salah');</script>";
        echo "<script type='text/javascript'>window.location='login.php';</script>";
        exit();
    }

?>