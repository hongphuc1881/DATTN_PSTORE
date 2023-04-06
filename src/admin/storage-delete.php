<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./class/product-class.php");
        $Product = new Product;
        $product_id = $_GET["product_id"];
        $size_id = $_GET["size_id"];
        $Product->storage_delete($product_id, $size_id);
        header('Location: storage-list.php');
    } else {
        include("./404.php");
    }
?>