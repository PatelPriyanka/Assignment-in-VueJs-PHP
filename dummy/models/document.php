<?php
class Document{
    private $conn;
    public $id;
    public $category_id;
    public $name;
    public $create_at;
    public $updated_at;

    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
        $query = "SELECT * FROM test.documents;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function getByCategory() {
        $query = "SELECT * FROM test.documents where category_id = ?;";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->category_id);
        $stmt->execute();
        return $stmt;
    }

    function create(){
        $query = "INSERT INTO `test`.`documents` SET
                    category_id=:category_id, name=:name,created_at=:created_at";
        $stmt = $this->conn->prepare($query);
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->name=htmlspecialchars(strip_tags($this->name));

        $this->create_at = date('Y-m-d H:i:s');;
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":created_at", $this->create_at);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function update(){
        $query = "UPDATE `test`.`documents` 
            SET category_id=:category_id, name=:name where id =:id";
        $stmt = $this->conn->prepare($query);
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function delete(){
        $selectQuery = "SELECT * FROM test.documents where id = ?;";
        $selectStmt = $this->conn->prepare( $selectQuery );
        $selectStmt->bindParam(1, $this->id);
        $selectStmt->execute();
        $documentCount = $selectStmt->rowCount();

        if ($documentCount > 0) {
            $query = "DELETE FROM  `test`.`documents` where id =:id";

            $stmt = $this->conn->prepare($query);

            $this->id=htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":id", $this->id);

            if($stmt->execute()){
                return "Deleted";
            }
        } else {
            return "Not Found";
        }
        return false;
    }
}
?>