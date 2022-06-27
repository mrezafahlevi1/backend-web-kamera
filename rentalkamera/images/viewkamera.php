<?php  
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../connection.php';
header("Content-Type: application/json; charset=UTF-8");

try{
    $sql = "SELECT kamera.id,
    jenis_kamera.nama_kamera AS jenis_kamera,
    kamera.brand,
    kamera.harga,
    kamera.deskripsi,
    kamera.status,
    kamera.url_image
    FROM `kamera` INNER JOIN jenis_kamera ON kamera.id_jeniskamera = jenis_kamera.id";
    $execute = mysqli_query($dbConnection, $sql);

    $response["status"] = "sukses";
    $response["message"] = "Menampilkan data";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($execute)){
        $F["id"] = $ambil->id;
        $F["jenis_kamera"] = $ambil->jenis_kamera;
        $F["brand"] = $ambil->brand;
        $F["harga"] = $ambil->harga;
        $F["deskripsi"] = $ambil->deskripsi;
        $F["url_image"] = $ambil->url_image;
        $F["status"] = $ambil->status;
        
        array_push($response["data"], $F);
    }
}catch (Exception $e) {
    $response['status'] = 'failed';
    $response["message"] = 'Gagal terhubung ke server';
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;