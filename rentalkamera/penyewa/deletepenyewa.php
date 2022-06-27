<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../connection.php';
header("Content-Type: application/json; charset=UTF-8");

$idpenyewa = $_POST['idpenyewa'];

if(trim($idpenyewa)!== ''){
        
        $sql = "DELETE FROM `penyewa` WHERE `id` = '$idpenyewa'";
        $execute = mysqli_query($dbConnection, $sql);
        if($execute){
            $response['status'] = 'sukses'; 
            $response['message'] = 'Sukses menghapus penyewa';
        } else {
        $response['status'] = 'failed';
        $response['message'] = 'Gagal menghapus penyewa';    
        }
        
    } else {
        $response['status'] = 'failed';
        $response['message'] = 'Gagal menghapus penyewa, karna id kosong';
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;