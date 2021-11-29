<?php
session_start();
include 'vendor/autoload.php';
 
$client = new Google_Client();
$client->setAuthConfig("oauth-credentials.json");
$client->addScope("https://www.googleapis.com/auth/drive");
$service = new Google_Service_Drive($client);
 
// if (isset($_GET['code'])) {
//   $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//   $_SESSION['upload_token'] = $token;
// }
 
if (empty($_SESSION['upload_token'])){
    $authUrl = $client->createAuthUrl();
    header("Location:".$authUrl);
 
} else {
 
    $client->setAccessToken($_SESSION['upload_token']);
    $client->getAccessToken();
 
    // membaca file ID yang akan diunduh
    $fileid = $_GET['id'];
 
    // membaca data file di Google Drive berdasarkan ID
    $file = $service->files->get($fileid);
    // membaca mime type dari file
    $mime = $file->getMimeType();
    // membaca nama file
    $name = $file->getName();
 
    // membuat header file yang akan didownload, sesuai mimenya
    header("Content-Disposition: attachment; filename=".$name);
    header("Content-type: ".$mime);
 
    // membaca content isi file dan menampilkan content
    $content = $service->files->get($fileid, array("alt" => "media"));
 
    while (!$content->getBody()->eof()) {
        echo $content->getBody()->read(2048);
    }
}
 
?>