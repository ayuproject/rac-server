<?php
    require_once("../config/const.php");
    require_once('../vendor/autoload.php');

    use \Firebase\JWT\JWT;

    $key = KEY_TOKEN;

    $app_id =  $_POST["app_id"];

    if ($app_id !== APP_ID) {
        header('HTTP/1.0 401 Unauthorized');
        return;
    }

    $c_time = time();
    $nbf = $c_time + 10;
    $token = array(
        "iat" => $c_time
    );

    $jwt = JWT::encode($token, $key, 'HS256');
    //$decoded = JWT::decode($jwt, $key, array('HS256'));
    header('Content-type: application/json');
    echo json_encode([
        'result' => 1,
        'msg' => 'OK',
        'jwt' => $jwt
    ]);
?>