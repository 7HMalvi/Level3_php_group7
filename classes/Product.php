<?php

class Product
 {
    public $id;
    public $name;
    public $description;
    public $price;
    public $imgUrl;

    public function __construct($id, $name, $description, $price, $imgUrl) 
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->imgUrl = $imgUrl;
    }

    public static function list($searchQuery)
     {
        global $db;
        try {
            $query = "SELECT * FROM products WHERE name LIKE :searchQuery OR description LIKE :searchQuery2";
            $stmt = $db->pdo->prepare($query);

            $param = "%$searchQuery%";
            $stmt->bindParam(':searchQuery', $param, PDO::PARAM_STR);
            $stmt->bindParam(':searchQuery2', $param, PDO::PARAM_STR);
            $stmt->execute();
            $products = array();
        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
             {
                $product = new Product($row['id'], $row['name'], $row['description'], $row['price'], $row['imgUrl']);
                $products[] = $product;
            }
            return $products;
        } catch (PDOException $e) 
        {
            die("Query failed: " . $e->getMessage());
        }
    }
}