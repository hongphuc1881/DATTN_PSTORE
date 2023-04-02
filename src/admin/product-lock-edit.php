<?php
session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./class/product-class.php");
    
        $Product = new Product;
        if(!isset($_GET["product_id"]) || $_GET["product_id"] == NULL) {
            echo "<script>window.location.href = 'product-list.php'</script>";
        } else {
            $product_id = $_GET["product_id"];
        }
    
        $unlock_product = $Product->unlock_product($product_id);
        echo "<script>window.location.href = 'product-list.php' </script>";
    } else {
        include("./404.php");
    }
?>

