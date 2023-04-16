<?php
    session_start();
    ob_start();
    if(isset($_SESSION["user"]) && ($_SESSION["user"]["role"] == 1 || $_SESSION["user"]["role"] == 3)) {
        include("./database.php");
        include("./class/order-class.php");
    
        $Order = new Order;
        
        if(!isset($_GET["order_id"]) || $_GET["order_id"] == NULL) {
            echo "<script>window.location.href = 'order-list.php'</script>";
        } else {
            $order_id = $_GET["order_id"];
        }
    
        $cancel_order = $Order->cancel_order($order_id);
        if($_SESSION["user"]["role"] == 1) {
            echo "<script>window.location.href = 'order-list.php' </script>";
        }
        else if($_SESSION["user"]["role"] == 3) {
            //header("location:javascript://history.go(-1)");
            header("location: ".$_SERVER['HTTP_REFERER']);
        }
    } else {
        include("./404.php");
    }
?>
