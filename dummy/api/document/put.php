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

$data = json_decode(file_get_contents("php://input"));
$document = new Document($db);

if($methodType != 'put') {
    http_response_code(501);
    echo json_encode(array("message" => "Request method not supported."));
    return;
} else {

    $document = new Document($db);

    if(
        !(empty($data->id) ||
        empty($data->category_id) ||
        empty($data->name))
    ) {

        $document->id=$data->id;
        $document->category_id=$data->category_id;
        $document->name=$data->name;

        if($document->update()){
            http_response_code(200);
            echo json_encode(array("message" => "Document is updated."));
            return;
        }

        else{
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update document."));
            return;
        }
    }
    else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to update document. Data is incomplete."));
        return;
    }
}
?>