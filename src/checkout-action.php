<?php
    session_start();
    ob_start();
    include("./database.php");
    include("./admin/class/order-class.php");
    $Order = new Order;
    if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
        $cart = $_SESSION["cart"];

        if(isset($_SESSION["user"])) {
            //echo  "<pre>";
            //var_dump($_SESSION["cart"]);
            //var_dump($_SESSION["user"]);
            //var_dump($_SESSION["user"]["user_id"]);
            //var_dump($_POST);
            //echo "</pre>";
            $cart = $_SESSION["cart"];
            $user_id = $_SESSION["user"]["user_id"];
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];
            $note = $_POST["note"];
            //echo date('d-m-y', 1680015322);
            $Order->insert_order($user_id, $fullname, $email, $phone, $address, $note, $cart);
            unset($_SESSION["cart"]);

            header("location: checkout-success.php");
        }  
        else {
            header("location: login.php?action=checkout");
        }
    }   
    else {
        include("./admin/404.php");
    }
?>