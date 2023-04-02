<?php 
    include("./database.php");
    include("./class/order-class.php");
    $Order = new Order;
    $value = $_POST["value"];
    $order_id = $_POST["order_id"];

    $order_confirmation = $Order->order_confirmation($value, $order_id);
?>

