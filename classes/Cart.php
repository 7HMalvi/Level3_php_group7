<?php 
class Cart
 {
    private $db;
    private $userid;
    public $cartItems = [];
    private $totalAmount = 0;

    public function __construct($db, $userid) {
        $this->db = $db->pdo;
        $this->userid = $userid;
    }
    //Adding items to cart.
    public function addProductToCart($productId)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO cart (userid, productid) VALUES (?, ?)");
            $stmt->execute([$this->userid, $productId]);
        } catch (PDOException $e) {
            die('Error adding product to cart: ' . $e->getMessage());
        }
    }

    //Removing items from the cart.
    public function removeProductFromCart($productid) {
        try {
            $stmt = $this->db->prepare("DELETE FROM cart where userid = ? and productid = ?");
            $stmt->execute([$this->userid, $productid]);
        } catch (PDOException $e) {
            die('Error removing product from cart: ' . $e->getMessage());
        }
    }
    

    public function containsProduct($productid)
     {
        try {
            $stmt = $this->db->prepare("SELECT * FROM cart WHERE userid = ? and productid = ?");
            $stmt->execute([$this->userid, $productid]);
            $this->cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return count($this->cartItems)>0;
        } catch (PDOException $e) {
            die('Error fetching cart items: ' . $e->getMessage());
        }
    }
    //Products on UI
    public function listProductsInCart()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM cart left join products on cart.productid = products.id WHERE userid = ?");
            $stmt->execute([$this->userid]);
            $this->cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->cartItems;
        } catch (PDOException $e) {
            die('Error fetching cart items: ' . $e->getMessage());
        }
    }
    //Calculations of total amount 
    public function calculateTotalAmount()
    {
        $this->totalAmount = 0;

        foreach ($this->cartItems as $item) {
            $this->totalAmount += $item['price'];
        }

        return $this->totalAmount;
    }

}
