<?php 
    session_start();
    ob_start();

    $product_quantity = $_POST["qty"];
    $product_id = $_POST["product_id"];
    $size_id = $_POST["size_id"];
    $cart =  $_SESSION["cart"] ;
    
    $count = count($cart);
    foreach ($cart as $key => $item) {
        for($i = 0; $i < $count ; $i++) {
            if($cart[$i][0] == $product_id && $cart[$i][3] == $size_id) {
                $cart[$i][5] = (int)$product_quantity;
                
            }
        }
    }
   
    $_SESSION["cart"] = $cart;
?>
