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


    function addToCart($product)
    {
        $cartItem = array(
            'thumbnail' => $this->thumbnail,
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            

        );


        $_SESSION['cart'][] = $cartItem;

    }



}

$url = "https://mockend.up.railway.app/api/products";
$response = file_get_contents($url);
//json_decode() è una funzione usata per decodificare una stringa JSON in un array associativo
$products_data = json_decode($response, true);
$products = [];



echo "<script>";
echo "function addToCart(product){";
echo "var cart = [];";
echo "var cartFromSS = sessionStorage.getItem('cart') || [];"; //prendiamo l'array dal sessionStorage
echo "if(cartFromSS.length > 0){"; //se è già popolato
echo "cart = JSON.parse(cartFromSS);"; //il parse lo trasforma in un array
echo "const foundIndex = cart.findIndex(p => p.id === product.id);"; //cerca l'indice del prodotto
echo "if(foundIndex > -1){"; //se lo trova
echo "cart[foundIndex].quantity++;"; //aumenta la quantità
echo "} else {";
echo "cart.push(product);"; //altrimenti lo aggiunge soltanto
echo "}";
echo "} else {";
echo "cart.push(product);"; //altrimenti lo aggiunge soltanto
echo "}";
echo "sessionStorage.setItem('cart', JSON.stringify(cart));"; //alla fine salva l'array nel sessionStorage
echo "addToSessionCart(cart);"; //richiamiamo il metodo che aggiunge il prodotto al carrello
echo "}";
echo "function addToSessionCart(cart){";
echo "var http = new XMLHttpRequest();"; //questo metodo crea un nuovo oggetto XMLHttpRequest
echo "http.onreadystatechange = function(){"; //se la richiesta è stata completata
echo "if(this.readyState == 4 && this.status == 200){"; //e la risposta è stata ricevuta
echo "console.log('prodotto aggiunto al carrello');"; //stampa a console
echo "};";
echo "http.open('GET', 'cart.php?cart=' + JSON.stringify(cart), true);"; //prepara la richiesta GET che invia l'array al file cart.php
echo "http.send();"; //e la invia
echo "}";
echo "</script>";


foreach ($products_data as $product_data) {

    $product = new Product(
        $product_data["thumbnail"],
        $product_data["title"],
        $product_data["description"],
        $product_data["price"],
        $product_data["id"],

    );

    $products[] = $product;
}

echo "<div class='wrapper'";
foreach ($products as $product) {
    $product = new Product($thumbnail, $title, $description, $price, $id);
    echo "<div class='card'>";
    echo "<img src=" . $product->thumbnail . "/>";
    echo "<h2>" . $product->title . "</h2>";
    echo "<p>" . $product->description . "</p>";
    echo "<p>" . $product->price . "</p>";
    echo "<button onclick='. $product->addToCart($product) .'>Add to cart</button>"; //il json_encode trasforma l'array in una stringa JSON

    echo "</div>";

}
echo "</div>";





?>