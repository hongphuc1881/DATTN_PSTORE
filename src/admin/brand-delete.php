<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./class/brand-class.php");
        $Brand = new Brand;
        $brand_id = $_GET["brand_id"];
        $Brand->delete_brand($brand_id);
        header('Location: brand-list.php');
    } else {
        include("./404.php");
    }
?>