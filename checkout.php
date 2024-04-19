<?php
if (!isset($_COOKIE['user'])) {
    header('Location: login.php');
}
require_once('utils/db_conn.php');
require_once('classes/Cart.php');
require_once('classes/User.php');
$user = User::load();
$user->fetchDetails();
$cart = new Cart($db, $user->id);
$cart->listProductsInCart();

$addr1 = '';
$addr2 = '';
$email = '';
$name = '';
$cardN = '';
$expiry = '';
$cvv = '';
$error = '';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $addr1 = $_POST['address1'];
    $addr2 = $_POST['address2'];
    $email = $_POST['contact'];
    $name = $_POST['name'];
    $cardN = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    if (empty($addr1)) {
        $error = 'Address line 1 is Required..!';
    }else if (empty($name)) {
        $error = 'Name is Required..!';
    }else if (empty($cardN)) {
        $error = 'Card Number is Required..!';
    } else if (strlen($cardN) != 16) {
        $error = 'Card number is Invalid..!';
    } else if (empty($expiry)) {
        $error = 'Card expiry date is Required..!';
    } else if (empty($cvv)) {
        $error = 'CVV is Required..!';
    } else if (strlen($cvv) != 3) {
        $error = 'CVV is Invalid';
    } else {
        $success = true;
    }
}
?>
<html>
    <head>
        <?php require_once('default_head.php') ?>
        <style>
            .header {
                background-color: #4CAF50; 
                color: white;
                padding: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .header a {
                color: white;
                text-decoration: none;
                margin-right: 10px;
            }

            .header span {
                color: white;
                text-decoration: none;
                margin-right: 10px;
                cursor: pointer;
            }

            .card {
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 30px;
                max-width: 600px;
                margin: 50px auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            td, th {
                padding: 10px 0;
                text-align: left;
            }

            input[type="text"],
            input[type="number"] {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
            }

            .btn-primary {
                background-color: #4CAF50; 
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            .btn-primary:hover {
                background-color: #45a049; 
            }

            .error-message {
                color: #f44336; 
                font-size: 14px;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <header class="header">
            <div><a href="index.php">Products</a></div>
            <div><a href="cart.php">Cart</a></div>
            <span onclick="document.cookie='user=; expires='+new Date()+';';location.href='/Group7_Plants/login.php'">Logout</span>
        </header>

        <div class="card">
            <div style="text-align: end">Total : $<?=$cart->calculateTotalAmount()?></div>
            <form action="checkout.php" method="post">
                <table>
                    <tr>
                        <th>Contact*</th>
                    </tr>
                    <tr>
                        <td>Email* </td>
                        <td><input type="text" name="contact" value="<?=$user->email?>"></td>
                    </tr>
                    <tr>
                        <td>Name </td>
                        <td><input type="text" name="name" value="<?=$user->name?>"></td>
                    </tr>
                    <tr>
                        <th>Shipping Address</th>
                    </tr>
                    <tr>
                        <td>Address Line 1*</td>
                        <td><input name="address1" value="<?=$addr1?>"/></td>
                    </tr>
                    <tr>
                        <td>Address Line 2</td>
                        <td><input name="address2" value="<?=$addr2?>"/></td>
                    </tr>
                    <tr>
                        <th>Card Details*</th>
                    </tr>
                    <tr>
                        <td>Card Number* </td>
                        <td><input name="card_number" type="number" value="<?=$cardN?>"/></td>
                    </tr>
                    <tr>
                        <td>Expiry date* </td>
                        <td><input name="expiry" type="text" value="<?=$expiry?>"/></td>
                    </tr>
                    <tr>
                        <td>CVV*</td>
                        <td><input name="cvv" type="text" value="<?=$cvv?>"/></td>
                    </tr>
                </table>
                <div class="error-message">
                    <?php if($error) { echo $error; } ?>
                </div>
                <input class="btn-primary" type="submit" value="Checkout">
            </form>
        </div>
        <?php
        if($success) {
        echo '<form id="myForm" action="invoice.php" method="post">';
        foreach ($_POST as $a => $b) {
            echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
        }
        ?>
</form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>
 <script src="utils/button-interaction.js"></script>
<?php } ?>
    </body>
</html>