<header class="flex-row background-primary" style="width: calc(100% - 20px); padding: 10px;">
    <div class="flex-row align-center">
        <div><a href="cart.php" style="color: white; text-decoration: none; margin-right:10px; margin-left:50px;">Cart</a></div>
        <div><a href="checkout.php" style="color: white; text-decoration: none; margin-right:10px;">Checkout</a></div>
        <span style="color: white; text-decoration: none; margin-right:10px;" onclick="document.cookie='user=; expires='+new Date()+';';location.href='/Group7_Plants/login.php'">Logout</span>
    </div>
    </div>
    <div class="flex-row">
        <form action="" class="flex-row">
            <input type="search" name="q" class="input-primary" value="<?=isset($_GET['q']) ? $_GET['q'] : ''?>" style="width: 200px; padding: 5px; margin-right: 5px;">
            <input type="submit" value="Search" class="btn-primary" style="padding: 4px 10px;">
        </form>
        
</header>