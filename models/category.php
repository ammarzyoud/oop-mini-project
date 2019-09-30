<?php

class Category
{
    private $conn;
    private $table_name = "categories";

    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // used to read category name by its ID
    function readName(){

        $query = "SELECT"." "."name"." "."FROM"." ".$this->table_name;

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
    }

    function read()
    {
        $query = "SELECT id, name FROM" . " " . $this->table_name . " " . " ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}

?>