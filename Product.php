<?php

session_start(); //inizializza una sessione php che può essere usata per salvare dati tra le pagine

if (!isset ($_SESSION['cart'])) { //se non esiste la chiave 'cart' nell'array $_SESSION, la inizializza come array vuoto
    $_SESSION['cart'] = [];
}


class Product
{


    public $products = array();
    public $cart = array();



    public function __construct()
    {
        $this->url = "https://mockend.up.railway.app/api/products";
        $response = file_get_contents($this->url);
        //json_decode() è una funzione usata per decodificare una stringa JSON in un array associativo
        $this->data = json_decode($response, true);

        foreach ($this->data as $valore) {
            //utilizzando new Product() si generava un loop infinito perché il costruttore richiamava il costruttore 
            $product = new stdClass(); //questa classe permette di creare oggetti anonimi
            $product->qty = $valore['qty'];
            $product->userId = $valore['userId'];
            $product->title = $valore['title'];
            $product->description = $valore['description'];
            $product->id = $valore['id'];
            $product->price = $valore['price'];
            $product->image = $valore['image'];
            $product->thumbnail = $valore['thumbnail'];
            $this->addProduct($product);
        }
    }


    function addProduct($product)
    {
        $this->products[] = $product;
    }


    function reduceQuantity($id)
    {

        foreach ($this->products as $product) {
            if ($product->id == $id) {
                if ($product->qty > 0) {
                    $product->qty--;
                } else {
                    $this->removeProduct($id);
                }
            }
        }
    }

    function removeProduct($productid)
    {
        foreach ($this->products as $key => $product) {
            if ($product->id == $productid) {
                unset($this->products[$key]); //unset elimina un elemento da un array
            }
        }
    }

    function findProductIndex($id)
    {
        foreach ($this->products as $key => $product) {
            if ($product->id == $id) {
                return $key;
            }
        }
        return false;
    }


    // function addToCart($product, $quantity)
    // {
    //     $prodIndex = $this->findProductIndex($product->id);
    //     if ($prodIndex !== false) {
    //         $this->cart[$prodIndex]['quantity'] += $quantity;
    //     } else {
    //         $this->cart[] = [
    //             'product' => $product,
    //             'quantity' => $quantity
    //         ];
    //         $this->addToSessionCart($this->cart);
    //     }
    // }


    function addToCart($productData)
    {
        $product = json_decode($productData);
        $prodIndex = $this->findProductIndex($product->id);
    
        if ($prodIndex !== false) {

            $this->cart[$prodIndex]['quantity'] += 1;
        } else {

            $this->cart[] = [
                'product' => $product,
                'quantity' => 1
            ];
        }
    
        $this->addToSessionCart($this->cart);
    }

    function addToSessionCart($cart)
    {
        $_SESSION['cart'] = $cart;
    }

    function pay(){
        $this->cart = [];
    }

    function getTotal(){
        $total = 0;
        foreach($this->cart as $cartProduct){
            $total += $cartProduct['product']->price * $cartProduct['quantity'];
        }
        return $total;
    }

    function getCart(){
        return $_SESSION['cart'];
    }

}

