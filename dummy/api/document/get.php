<?php

include_once '../../Database.php';
include_once '../../models/document.php';

$database = Database::getInstance();
$db = $database->getConnection();

$methodType = strtolower($_SERVER['REQUEST_METHOD']);

$document = new Document($db);

$document->category_id = isset($_GET['id']) ? $_GET['id'] : die();

if($methodType != 'get') {
    http_response_code(501);
    echo json_encode(array("message" => "Request method not supported."));
    return;
} else {
    $stmt = $document->getByCategory();;
    $count = $stmt->rowCount();

    if($count > 0) {
        $document_arr=array();
        $document_arr["data"]=array();

        while ($row = $stmt->fetch()) {
            $product_item=array(
                "id" => $row['id'],
                "category_id" => $row['category_id'],
                "name" => $row['name'],
                "created_at" => $row['created_at'],
                "updated_at" => $row['updated_at']
            );
            array_push($document_arr["data"], $product_item);
        }

        http_response_code(200);
        echo json_encode($document_arr);

    } else {
        http_response_code(200);
        echo json_encode(
            array("message" => "No category found.")
        );
    }
}
?>
