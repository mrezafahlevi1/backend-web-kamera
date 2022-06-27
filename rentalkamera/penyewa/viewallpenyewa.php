<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../connection.php';
header("Content-Type: application/json; charset=UTF-8");

try{
    $sql = "SELECT * FROM `penyewa`";
    $execute = mysqli_query($dbConnection, $sql);
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($execute)){
        $F["id"] = $ambil->id;
        $F["nama"] = $ambil->nama;
        $F["jeniskelamin"] = $ambil->jeniskelamin;
        $F["nik"] = $ambil->nik;
        $F["no_hp"] = $ambil->no_hp;

        array_push($response["data"], $F);
    }
}catch (Exception $e){
    $response["status"] = "failed";
    $response["message"] = $e->getMessage();
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;