<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./class/product-class.php");
        $Product = new Product;
        $product_id = $_GET["product_id"];
        $Product->delete_product($product_id);
        header('Location:product-list.php');
    } else {
        include("./404.php");
    }
?>