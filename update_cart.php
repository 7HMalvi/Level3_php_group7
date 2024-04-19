<?php
    $request = json_decode(file_get_contents('php://input'), true);
    if (isset($request['productid'])) {
        if (!isset($_COOKIE['user'])) {
            header('Location: login.php');
        }
        require_once('utils/db_conn.php');
        require_once('classes/Cart.php');
        require_once('classes/User.php');
        require_once('utils/utils.php');
        $user = User::load();

        $pid = $request['productid'];

        $c = new Cart($db, $user->id);
        if ($c->containsProduct($pid)) {
            $c->removeProductFromCart($pid);
            echo 'Add to Cart';
        } else {
            $c->addProductToCart($pid);
            echo 'Remove';
        }
    }
?>