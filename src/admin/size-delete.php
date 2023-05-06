<?php
    session_start();
    ob_start();
    if(isset($_SESSION["user"]) &&  ($_SESSION["user"]["role"] == 1)) {
        include("./database.php");
        include("./class/product-class.php");
        $Product = new Product;
        $size_id = $_GET["size_id"];
        $Product->delete_size($size_id);
        header('Location: size-list.php');
    } else {
        include("./404.php");
    }
?>