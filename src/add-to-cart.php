<?php 
    session_start();
    ob_start();
    
    
    if(isset($_POST["add_to_cart"])) {
        // lay thong tin san pham
        $product_id = $_POST["product_id"];
        $product_name = $_POST["product_name"];
        $product_img_main = $_POST["product_img_main"];
        $price = $_POST["price"];
        $quantity = 1;
        $product_size = $_POST["product_size"];

        
        $product = array($product_id, $product_name, $product_img_main, $product_size, $price, $quantity);


        // kiểm tra xem sản phẩm có trong giỏ hàng chưa
        $index = false;
        foreach ($_SESSION["cart"] as $key => $item) {
            if ($item[0] == $product_id && $item[3] == $product_size) {
                $index = $key;
                break;
            }
        }
        if ($index !== false) {
            // nếu sản phẩm đã có trong giỏ hàng, tăng quantity lên 1
            $_SESSION["cart"][$index][5]++;
            echo "<script>alert('Sản phẩm đã có trong giỏ hàng, số lượng được tăng lên')</script>";
            header("location: cart.php");
        } else {
            // nếu sản phẩm chưa có trong giỏ hàng, thêm vào giỏ hàng
            $product[] = 1;
            array_push($_SESSION["cart"], $product);
            echo "<script>alert('Thêm sản phẩm thành công')</script>";
            header("location: cart.php");
        }
                
        //unset($_SESSION["cart"]);
        var_dump($_SESSION['cart']);
    }

?>