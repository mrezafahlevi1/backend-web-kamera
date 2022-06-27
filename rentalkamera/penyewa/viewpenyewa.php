<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../connection.php';
header("Content-Type: application/json; charset=UTF-8");

$idpenyewa = $_POST['id'];

try{
    if(trim($idpenyewa)!== '') {
        $sql = "SELECT * FROM `penyewa` WHERE id = '$idpenyewa'";
        $execute = mysqli_query($dbConnection, $sql);
        $row = mysqli_fetch_array($execute);
        if($row){
            $response['status'] = 'sukses'; 
            $response['message'] = 'Sukses mengambil data penyewa';
            $response['data'] = $row;
        } 
        }else {
            $response['status'] = 'failed';
            $response['message'] = 'Gagal mengambil data penyewa';
        }
}catch (Exception $e){
    $response['message'] = $e->getMessage(); 
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;