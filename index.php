<?php
    if (!isset($_COOKIE['user'])) {
        header('Location: login.php');
        exit;
    }

    require_once('utils/db_conn.php');
    require_once('classes/Product.php');
    require_once('classes/Cart.php');
    require_once('classes/User.php');
    $user = User::load();

    $products = [];

    $searchQuery = isset($_GET['q']) ? $_GET['q'] : '';

    $products = Product::list($searchQuery);

    $cart = new Cart($db, $user->id);
    $cartProducts = $cart->listProductsInCart();
?>

<html>
    <head>
        <link rel="stylesheet" href="site.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #B5C4B6;
                margin: 0;
                padding: 0;
            }

            .flex-row {
                display: flex;
                justify-content: center;
                align-items: flex-start;
                flex-wrap: wrap;
                gap: 20px;
                padding: 20px;
            }

            .product-card {
                width: 300px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                transition: transform 0.3s ease;
            }

            .product-card:hover {
                transform: translateY(-5px);
            }

            .product-image {
                width: 100%;
                height: 200px;
                object-fit: cover;
            }

            .product-details {
                padding: 20px;
            }

            .product-title {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .product-price {
                font-size: 18px;
                color: #333;
                margin-bottom: 10px;
            }

            .product-description {
                font-size: 16px;
                color: #666;
                margin-bottom: 10px;
            }

            .text-center {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php include('utils/search.php'); ?>

        <?php if (count($products) == 0): ?>
            <div class="text-center">No Results</div>
        <?php endif; ?>

        <div class="flex-row">
            <?php include('utils/product_list.php'); ?>
        </div>

        <script src="utils/button-interaction.js"></script>
    </body>
</html>
