<?php
session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./class/category-class.php");
    
        $Category = new Category;
        if(!isset($_GET["category_id"]) || $_GET["category_id"] == NULL) {
            echo "<script>window.location.href = 'category-list.php'</script>";
        } else {
            $category_id = $_GET["category_id"];
        }
    
        $lock_category = $Category->unlock_category($category_id);
        echo "<script>window.location.href = 'category-list.php' </script>";
    } else {
        include("./404.php");
    }
?>

