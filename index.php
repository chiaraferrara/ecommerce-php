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
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST['product_data'])) {
        $productData = json_decode($_POST['product_data']);
        $quantityToAdd = $_POST['quantity']; // la quantità inviata dal form
        $product->addToCart($productData, $quantityToAdd);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }


    ?>

    </hr>

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
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="event.preventDefault();">
                    <input type="hidden" name="product_data" value='<?php echo json_encode($productItem); ?>' />
                    <button class="addToCartButton" type="submit" name="button">Aggiungi al carrello</button>
                </form>
            </div>
        <?php } ?>
    </div>


    <script>

        function addToSessionCart(cart) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log("Carrello aggiornato");
                    console.log(cart)
                }
            };
            xmlhttp.open("GET", "cart.php?cart=" + JSON.stringify(cart), true);
            xmlhttp.send();
        }


        document.addEventListener("DOMContentLoaded", function () {
            var buttons = document.querySelectorAll(".addToCartButton");

            buttons.forEach(function (button) {
                button.addEventListener("click", function () {
                    var productDataInput = this.closest('.card').querySelector("input[name='product_data']"); //seleziono l'elemento dal DOM con querySelector
                    var productData = productDataInput.value;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            alert(productData + " aggiunto");

                            var cart = [...<?php echo json_encode($_SESSION['cart']); ?>, JSON.parse(productData)];
                            addToSessionCart(cart);
                        }
                    };
                    xhr.send("product_data=" + encodeURIComponent(productData));
                });
            });
        });
    </script>

</body>

</html>