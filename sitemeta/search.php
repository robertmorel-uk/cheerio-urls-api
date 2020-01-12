<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/cryptoUrl.php';
 
// instantiate database and cryptoUrl object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$cryptoUrl = new CryptoUrl($db);
 
// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
 
// query cryptoUrls
$stmt = $cryptoUrl->search($keywords);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // cryptoUrls array
    $cryptoUrls_arr=array();
    $cryptoUrls_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $cryptoUrl_item = array(
            "urlID" =>  $urlID,
            "urlTitle" => $urlTitle,
            "urlLink" => $urlLink,
            "urlDescription" => $urlDescription,
            "urlSource" => $urlSource,
            "urlDate" => $urlDate
        );
 
        array_push($cryptoUrls_arr["records"], $cryptoUrl_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show cryptoUrls data
    echo json_encode($cryptoUrls_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no cryptoUrls found
    echo json_encode(
        array("message" => "No cryptoUrls found.")
    );
}
?>