<?php
if (!isset($_COOKIE['user'])) {
    header('Location: login.php');
}
require_once('utils/db_conn.php');
require_once('classes/Product.php');
require_once('classes/Cart.php');
require_once('classes/User.php');
$user = User::load();

$cart = new Cart($db, $user->id);
$cartProducts = $cart->listProductsInCart();
$products = array();
foreach ($cartProducts as $item) {
    array_push($products,new Product($item['id'], $item['name'], $item['description'], $item['price'], $item['imgUrl']));
}
?>



<html>
    <head>
        <link rel="stylesheet" href="site.css" >
    </head>
    <body>
        <header class="flex-row background-primary align-center" style="width: calc(100% - 20px); padding: 10px;">
            <div><a href="index.php" style="color: white; text-decoration: none; margin-right:10px;" >Products</a></div>
            <div><a href="checkout.php" style="color: white; text-decoration: none; margin-right:10px;">Checkout</a></div>


            <!-- Logout Click -->
            <span style="color: white; text-decoration: none; margin-right:10px;" onclick="document.cookie='user=; expires='+new Date()+';';location.href='/Group7_Plantes/login.php'">Logout</span>

        </header>
        <?php
        if (count($products) == 0) {echo '<div class="text-center">Cart is Empty</div>';
        }
        ?>
        <div class="flex-row" style="flex-wrap: wrap; gap: 10px; padding: 10px;">
            <?php include('utils/product_list.php'); ?>
        </div>
         <script src="utils/button-interaction.js"></script>
    </body>
</html>