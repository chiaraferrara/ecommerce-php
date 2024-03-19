<?php
session_start();

if (isset($_GET['cart'])) {
    $cart = json_decode($_GET['cart'], true);

    $_SESSION['cart'] = $cart;
}


// echo '<script>';
// echo 'var cart = JSON.parse(sessionStorage.getItem("cart") || "[]");';
// echo 'console.log(cart);';
// echo '</script>';


?>

<div class="wrapper">
    <?php
    foreach ($_SESSION['cart'] as $product) {
        echo '<div class="card">';
        echo '<img src="' . $product['image'] . '"/>';
        echo '<h5>' . $product['title'] . '</h5>';
        echo '<p>' . $product['description'] . '</p>';
        echo '<p>' . $product['price'] . '</p>';
        echo '</div>';
    }
    ?>
</div>