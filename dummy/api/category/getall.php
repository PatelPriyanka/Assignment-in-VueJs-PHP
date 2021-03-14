<?php

include_once '../../Database.php';
include_once '../../models/category.php';

$database = Database::getInstance();
$db = $database->getConnection();

$category = new Category($db);

$stmt = $category->read();
$count = $stmt->rowCount();

if($count > 0) {
    $category_arr=array();
    $category_arr["data"]=array();

    while ($row = $stmt->fetch()) {
        extract($row);

        $categoryObj=array(
            "id" => $row['id'],
            "name" => $row['category'],
            "created_at" => $row['create_at'],
            "updated_at" => $row['updated_at']
        );
        array_push($category_arr["data"], $categoryObj);
    }

    http_response_code(200);
    echo json_encode($category_arr);

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No category found.")
    );
}


?>
