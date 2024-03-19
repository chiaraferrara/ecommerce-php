<?php

class Product
{

    public $thumbnail;

    public $title;
    public $description;
    public $price;
    public $id;


    public function __construct($thumbnail, $title, $description, $price, $id)
    {
        $this->thumbnail = $thumbnail;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->id = $id;

    }


    // function addToCart($product)
    // {
    //     $cartItem = array(
    //         'thumbnail' => $this->thumbnail,
    //         'id' => $this->id,
    //         'title' => $this->title,
    //         'description' => $this->description,
    //         'price' => $this->price,


    //     );

    //     if(!isset($_SESSION)) {
    //        session_start();
    //     }
    //     //se non esiste cart lo inizializza come array
    //     if(!isset($_SESSION['cart'])) {
    //         $_SESSION['cart'] = [];
    //     }

    //     //aggiunge l'elemento al cart
    //     $foundIndex = array_search($product->id, array_column($_SESSION['cart'], 'id'));
    //     if ($foundIndex === false) {
    //         $_SESSION['cart'][] = $cartItem;
    //         echo "<script>console.log('Prodotto aggiunto al carrello: " . $product->title . "');</script>";
    //     } else {
    //         echo "<script>console.log('Il prodotto è già nel carrello: " . $product->title . "');</script>";
    //     }
    // }



}

$url = "https://mockend.up.railway.app/api/products";
$response = file_get_contents($url);
//json_decode() è una funzione usata per decodificare una stringa JSON in un array associativo
$products_data = json_decode($response, true);
$products = [];



echo "<script>";
echo "function addToCart(product){";
echo "var cart = [];";
echo "var cartFromSS = sessionStorage.getItem('cart') || [];";
echo "if(cartFromSS.length > 0){";
echo "cart = JSON.parse(cartFromSS);";
echo "const foundIndex = cart.findIndex(p => p.id === product.id);";
echo "if(foundIndex > -1){";
echo "cart[foundIndex].quantity++;";
echo "} else {";
echo "product.quantity = 1;";
echo "cart.push(product);";
echo "}";
echo "} else {";
echo "cart.push(product);";
echo "}";
echo "sessionStorage.setItem('cart', JSON.stringify(cart));";
echo "addToSessionCart(cart);";
echo "}";
//XMLHTTPREQUEST è un oggetto che permette di inviare richieste HTTP asincrone
echo 'function addToSessionCart(cart) {';
echo '    var xmlhttp = new XMLHttpRequest();';
echo '    xmlhttp.onreadystatechange = function() {';
echo '        if (this.readyState == 4 && this.status == 200) {';
echo '            console.log("Cart updated successfully");';
echo '        }';
echo '    };';
echo '    xmlhttp.open("GET", "cart.php?cart=" + JSON.stringify(cart), true);';
echo '    xmlhttp.send();';
echo '}';
echo '</script>';
?>

<div class='wrapper'>
    <?php
    foreach ($products_data as $product_data) {
        $product = new Product(
            $product_data["thumbnail"],
            $product_data["title"],
            $product_data["description"],
            $product_data["price"],
            $product_data["id"]
        );
        $products[] = $product;
        echo "<div class='card'>";
        echo "<img src=" . $product->thumbnail . "/>";
        echo "<h2>" . $product->title . "</h2>";
        echo "<p>" . $product->description . "</p>";
        echo "<p>" . $product->price . "</p>";
        ?>
        <?php echo "<button onclick='addToCart(". json_encode($product) .")'>Add to cart</button>"; ?>
    </div>
    <?php
    }
    ?>
</div>