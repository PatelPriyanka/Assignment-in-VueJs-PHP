<?php
class Category{
    private $conn;
    private $table_name = "category";

    public $id;
    public $category;
    public $create_at;
    public $updated_at;

    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
        $query = "SELECT * FROM test.categories;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>