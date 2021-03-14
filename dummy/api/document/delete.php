<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../Database.php';
include_once '../../models/document.php';

$methodType = strtolower($_SERVER['REQUEST_METHOD']);

$database = Database::getInstance();
$db = $database->getConnection();
$document = new Document($db);

if($methodType != 'delete') {
    http_response_code(501);
    echo json_encode(array("message" => "Request method not supported."));
    return;
} else {

    $document = new Document($db);

    $document->id = isset($_GET['id']) ? $_GET['id'] : die();
    if(!empty($document->id)){
        $result = $document->delete();
        if($result == "Deleted"){
            http_response_code(200);
            echo json_encode(array("message" => "Document is deleted."));
            return;
        } else if ($result == "Not Found") {
            http_response_code(404);
            echo json_encode(array("message" => "Document does not exist."));
            return;
        }
        else{
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete document."));
            return;
        }
    }
    else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to delete document. Data is incomplete."));
        return;
    }
}
?>