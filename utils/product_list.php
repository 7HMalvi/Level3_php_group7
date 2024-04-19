<?php
    require_once('utils/utils.php');
    foreach ($products as $product) {
?>


<div style="display: flex; flex-direction:column; padding:50px; width: 300px;">
    <img src="<?=$product->imgUrl?>">
    <div><b><?=$product->name?></b></div>
    <div class="flex-1"><?=$product->description?></div>
    <div class="flex-row align-center justify-space-between">
        <b>$<?=$product->price?></b>
        <button class="btn-primary" onclick="addRemoveProduct('<?=$product->id?>', this)"><?php 
        if (containsId($cartProducts, $product->id)) 
        {
            echo 'Remove';
        } else 
         {
            echo 'Add to Cart';
        }?>
        </button>
    </div>
</div>
<?php
}
?>




<script>
    function addRemoveProduct(id, btn) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                const response = xhr.responseText;
                btn.innerText = response;
            }
        }
        xhr.withCredentials = true;
        xhr.open('POST', '/Group7_Plants/update_cart.php');
        xhr.send(JSON.stringify({productid:id}));
        btn.innerHTML = '<div class="loader"></div>';
    }
</script>