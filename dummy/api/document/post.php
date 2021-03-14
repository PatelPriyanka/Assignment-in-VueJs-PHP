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

if($methodType != 'post') {
    http_response_code(501);
    echo json_encode(array("message" => "Request method not supported."));
    return;
} else {

    $document = new Document($db);

    if(
        !empty($_POST['categoryId']) &&
        !empty($_POST['name'])
    ) {
        $document->category_id = $_POST['categoryId'];
        $document->name = $_POST['name'];

        if($document->create()){
            http_response_code(201);
            echo json_encode(array("message" => "Document is created."));
            return;
        }

        else{
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create document."));
            return;
        }
    }
    else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
        return;
    }
}
?>