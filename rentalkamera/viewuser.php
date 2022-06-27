<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST');
// header("Access-Control-Allow-Headers: X-Requested-With");

include_once 'connection.php';
// header("Content-Type: application/json; charset=UTF-8");

try{
    $sql = "SELECT user.iduser,
    user.username,
    user.password
    FROM `user`";
    $execute = mysqli_query($dbConnection, $sql);
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($execute)){
        $F["iduser"] = $ambil->iduser;
        $F["username"] = $ambil->username;
        $F["password"] = $ambil->password;
        
        array_push($response["data"], $F);
    }
}catch (Exception $e) {
    $response['status'] = 'failed';
    $response["message"] = 'Gagal terhubung ke server';
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;