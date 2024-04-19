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

if ($_SERVER["REQUEST_METHOD"] != "POST")
    header('Location: index.php');
$addr1 = $_POST['address1'];
$addr2 = $_POST['address2'];
$email = $_POST['contact'];
$name = $_POST['name'];
$cardN = $_POST['card_number'];
$expiry = $_POST['expiry'];
$cvv = $_POST['cvv'];
?>
<html lang="en">
<head>
<title>Invoice</title>
<?php require_once('default_head.php') ?>
<style>
  body {
    font-family: Arial, sans-serif;
  }
  .invoice {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
  }
  .invoice-header {
    text-align: center;
    margin-bottom: 20px;
  }
  .invoice-address {
    margin-bottom: 20px;
  }
  .product-table {
    width: 100%;
    border-collapse: collapse;
  }
  .product-table th, .product-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
  }
  .total {
    text-align: right;
    margin-top: 20px;
  }
</style>
</head>
<body>
  <div class="invoice">
    <div class="invoice-header">
      <h2>Invoice</h2>
    </div>
    <div class="invoice-address">
    <p>Name: <?=$name?></p>
    <p>Address: <?=$addr1?></p>
    <p>Email: <?=$email?></p>
     
    </div>
    <table class="product-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Unit Price</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($cart->cartItems as $product) { ?>
                <tr>
                    <td><?=$product['name']?></td>
                    <td><?=$product['price']?></td>
                </tr>
            <?php } ?>
      </tbody>
    </table>
    <div class="total">
      <p><strong>Total Amount:</strong> $<?=$cart->calculateTotalAmount()?></p>
    </div>
  </div>
  <div class="text-center" style="margin-top: 10px" id="exclude">
  <button class="btn-primary" onclick="onPrintClick()">Print</button>
  </div>
  <script>
    function onPrintClick()
     {
      const el = document.getElementById('exclude');
      el.style.display = 'none';
      window.print();
      el.style.display = 'block';
    }
  </script>
   <script src="utils/button-interaction.js"></script>
</body>
</html>
