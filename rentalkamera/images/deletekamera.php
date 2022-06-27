<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../connection.php';
header("Content-Type: application/json; charset=UTF-8");

$idkamera = $_POST['idkamera'];

if(trim($idkamera)!= '') {

    $sql = "DELETE FROM `kamera` WHERE `id` = '$idkamera'";
    $execute = mysqli_query($dbConnection, $sql);
    if($execute) {
        $response['status'] = 'sukses'; 
        $response['message'] = 'Sukses menghapus kamera';
    } else {
    $response['status'] = 'failed';
    $response['message'] = 'Gagal menghapus kamera';    
    }

} else {
    $response['status'] = 'failed';
    $response['message'] = 'Gagal menghapus kamera, karna id kosong';
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;