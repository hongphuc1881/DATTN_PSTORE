<?php
session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./class/order-class.php");
    
        $Order = new Order;
        if(!isset($_GET["order_id"]) || $_GET["order_id"] == NULL) {
            echo "<script>window.location.href = 'order-list.php'</script>";
        } else {
            $order_id = $_GET["order_id"];
        }
    
        $cancel_order = $Order->cancel_order($order_id);
        echo "<script>window.location.href = 'order-list.php' </script>";
    } else {
        include("./404.php");
    }
?>
