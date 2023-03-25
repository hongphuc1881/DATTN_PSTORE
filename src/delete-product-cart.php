<?php 
session_start();
ob_start();
    // xóa sản phẩm khỏi giỏ hàng
    if (isset($_GET["product_id"]) && isset($_GET["product_size"])) {
        $product_id = $_GET["product_id"];
        $product_size = $_GET["product_size"];
        foreach ($_SESSION["cart"] as $key => $item) {
            if ($item[0] == $product_id && $item[3] == $product_size) {
                unset($_SESSION["cart"][$key]); // xoá phần tử
                $_SESSION["cart"] = array_values($_SESSION["cart"]); // làm mới chỉ số key của mảng
                break;
            }
        }
        echo "<script>alert('Sản phẩm đã được xoá khỏi giỏ hàng')</script>";
        header("location: cart.php");
    }
?>