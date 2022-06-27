<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../connection.php';
header("Content-Type: application/json; charset=UTF-8");

$nama = $_POST['nama'];
$jeniskelamin = $_POST['jeniskelamin'];
$nik = $_POST['nik'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];

$response = [];
try{
    if(trim($nama) !='' && trim($jeniskelamin) !='' && trim($nik) !='' && trim($no_hp) !='' && trim($alamat) !=''){

        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["url_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["url_image"]["tmp_name"]);
        if($check !== false) {
            // move file img to server folder
            if(move_uploaded_file($_FILES["url_image"]["tmp_name"], $target_file)){
                // Menyambung url
                $ip_server = 'http://127.0.0.1/';
                $folder_root = 'rentalkamera/penyewa/';
                $url = $ip_server.$folder_root.$target_file;

                $sql = "INSERT INTO `penyewa`(`nama`, `jeniskelamin`, `nik`, `no_hp`, `alamat`, `url_image`) VALUES ('$nama','$jeniskelamin','$nik','$no_hp','$alamat', '$url')";
                $execute = mysqli_query($dbConnection, $sql);
                if ($execute){
                    $response["status"] = "sukses";
                    $response["message"] = "Berhasil menambah data penyewa";
                } else {
                    $response["status"] = "failed";
                    $response["message"] = "Gagal menambah data penyewa";
                    $response["data"] = $row;
                }

            } else {
                    $response["status"] = "failed";
                    $response["message"] = "Gagal mengupload file";
            }

        }
        else {
                    $response["status"] = "failed";
                    $response["message"] = "Mohon upload image";
        }
    }else{
        $response["status"] = "failed";
        $response["message"] = "Mohon isi semua field";
    }
}catch (mysqli_sql_exception $exception){
    $response["status"] = "failed";
    $response["message"] = "Gagal terhubung ke server";
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;