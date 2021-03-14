<?php

include_once '../../Database.php';
include_once '../../models/document.php';

$database = Database::getInstance();
$db = $database->getConnection();

$document = new Document($db);

$stmt = $document->read();
$count = $stmt->rowCount();

if($count > 0) {
    $document_arr=array();
    $document_arr["data"]=array();

    while ($row = $stmt->fetch()) {
        $documentObj=array(
            "id" => $row['id'],
            "category_id" => $row['category_id'],
            "name" => $row['name'],
            "created_at" => $row['created_at'],
            "updated_at" => $row['updated_at']
        );
        array_push($document_arr["data"], $documentObj);
    }

    http_response_code(200);
    echo json_encode($document_arr);

} else {
    http_response_code(200);
    echo json_encode(
        array("message" => "No category found.")
    );
}
?>
