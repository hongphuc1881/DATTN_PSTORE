<?php
session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./class/brand-class.php");
    
        $Brand = new Brand;
        if(!isset($_GET["brand_id"]) || $_GET["brand_id"] == NULL) {
            echo "<script>window.location.href = 'brand-list.php'</script>";
        } else {
            $brand_id = $_GET["brand_id"];
        }
    
        $unlock_brand = $Brand->unlock_brand($brand_id);
        echo "<script>window.location.href = 'brand-list.php' </script>";
    } else {
        include("./404.php");
    }
?>

