<?php
class User {
    public $email;
    public $name;
    public $password;
    public $id;

    function __construct($email, $name, $password, $id) {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->id = $id;
    }

    function set_cookie() {
        setcookie("user",$this->id, time() + (24 * 3600));
    }

    function save() {
        global $db;

        $sql = "INSERT INTO users (email, name, password) VALUES (:email, :name, :password)";
        $stmt = $db->pdo->prepare($sql);

        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    function update() {
        global $db;

        $sql = "UPDATE users SET name = :name, password = :password, email = :email WHERE id = :id";
        $stmt = $db->pdo->prepare($sql);

        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    function delete() {
        global $db;

        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $db->pdo->prepare($sql);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function findByEmail($email) {
        global $db;

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->pdo->prepare($sql);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $obj = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($obj) {
                return new User($obj['email'], $obj['name'],$obj['password'], $obj['id']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return null;
        }
    }

    function fetchDetails() {
        global $db;

        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $db->pdo->prepare($sql);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $obj = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($obj) {
                $this->email = $obj['email'];
                $this->name = $obj['name'];
                $this->password = $obj['password'];
            }
        } catch (PDOException $e) {
        }
    }

    static function load() {
        $d = $_COOKIE['user'];
        return new User('','','',$d);
    }
}
