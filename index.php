<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Homepage</h1>

    <?php
    
    include ("Product.php");

    $product = new Product();

    ?>

<div class="wrapper">
        <?php foreach ($product->products as $productItem) { ?>
            <div class="card">
                
                <img src="<?= $productItem->thumbnail ?>">
                <h2>
                    <?= $productItem->title ?>
                </h2>
                <p>
                    <?= $productItem->description ?>
                </p>
                <p>
                    <?= $productItem->price ?>
                </p>
                <button class="addToCartButton" data-id="<?php echo $productItem->id ?>">Add to cart</button>
            </div>
        <?php } ?>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var buttons = document.querySelectorAll(".addToCartButton");

            buttons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var productId = this.getAttribute("data-id");
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true); //richiesta di tipo post...il PHP_SELF restituisce il nome dello script in esecuzione
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //questo invia dati come stringa con chiave valore
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            alert(productId + " aggiunto");
                        }
                    };
                    xhr.send("product_id=" + productId);
                });
            });
        });
    </script>

</body>

</html>