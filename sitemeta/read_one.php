<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/cryptoUrl.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare cryptoUrl object
$cryptoUrl = new CryptoUrl($db);
 
// set ID property of record to read
$cryptoUrl->urlID = isset($_GET['urlID']) ? $_GET['urlID'] : die();
 
// read the details of cryptoUrl to be edited
$cryptoUrl->readOne();
 
if($cryptoUrl->urlID!=null){
    // create array
    $cryptoUrl_arr = array(
        "urlID" =>  $cryptoUrl->urlID,
        "urlTitle" => $cryptoUrl->urlTitle,
        "urlLink" => $cryptoUrl->urlLink,
        "urlDescription" => $cryptoUrl->urlDescription,
        "urlSource" => $cryptoUrl->urlSource,
        "urlDate" => $cryptoUrl->urlDate
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($cryptoUrl_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user cryptoUrl does not exist
    echo json_encode(array("message" => "cryptoUrl does not exist."));
}
?>