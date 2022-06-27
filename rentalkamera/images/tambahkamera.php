<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../connection.php';
header("Content-Type: application/json; charset=UTF-8");

$idjenis = $_POST['jenis'];
$brand = $_POST['brand'];
$harga = $_POST['harga'];
$deskripsi = $_POST['deskripsi'];

$response = [];

try{
    if (trim($idjenis) !='' && trim($brand) !='' && trim($harga) !='' && trim($deskripsi) !='') {

        $target_dir = "kamera/";
        $target_file = $target_dir .rand(999,9999). basename($_FILES ["url_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES ["url_image"]["tmp_name"]);
        if($check !== false){
            if(move_uploaded_file($_FILES ["url_image"]["tmp_name"], $target_file)){
                // Menyambung url
                $ip_server = 'http://127.0.0.1/';
                $folder_root = 'rentalkamera/images/';
                $url = $ip_server.$folder_root.$target_file;

                $sql = "INSERT INTO `kamera`(`id_jeniskamera`, `brand`, `harga`, `deskripsi`, `url_image`) VALUES ('$idjenis', '$brand', '$harga', '$deskripsi', '$url')";
                $execute = mysqli_query($dbConnection, $sql);
                if ($execute){
                    $response["status"] = "sukses";
                    $response["message"] = "Berhasil menambah data kamera";
                } else {
                    $response["status"] = "failed";
                    $response["message"] = "Gagal menambah data pelanggan";
                }
            } else {
                $response["status"] = "failed";
                $response["message"] = "Gagal mengupload file";
            }
        }else{
            $response["status"] = "failed";
            $response["message"] = "Mohon upload image";
        }
    }else{
        $response["status"] = "failed";
        $response["message"] = "Mohon isi semua field";
    }
        
}catch(mysqli_sql_exception $exception){
    $response["status"] = "failed";
    $response["message"] = "Gagal menambah data kamera";
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;
