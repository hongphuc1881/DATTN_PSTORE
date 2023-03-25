<?php 
    include("./header.php");
    //var_dump($_SESSION['cart']);

?>
<?php 
    if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
        $cart = $_SESSION["cart"];
        
?>
<?php 
    if(isset($_POST["update_cart"])) {
        $product_quantity = $_POST["product_quantity"];
        
        $count = count($cart);
        foreach ($cart as $key => $item) {
            for($i = 0; $i < $count ; $i++) {
                $item[5] = (int)$product_quantity[$i];
                $cart[$i][5] = $item[5];
            }
        }
        $_SESSION["cart"] = $cart;
      
    } else if(isset($_POST["order_click"])) {
        echo "submit cart";

    }
?>
            <div class="app-container">
                <div class="container pt-5">
                    <form action="cart.php?action=submit" method="POST">
                        <table>
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Thông tin sản phẩm</td>
                                    <td>Đơn giá</td>
                                    <td>Số lượng</td>
                                    <td>Thành tiền</td>
                                    <td>Xoá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <!--$product = array($product_id, $product_name, $product_img_main, $product_size, $price, $quantity);-->

                                <?php 
                                $total_price = 0;
                                    foreach ($cart as $product_item) {
                                    $thanh_tien = $product_item[4] * $product_item[5];
                                    $total_price += $thanh_tien;
                                ?>
                                    <tr class="product-data">
                                        <td><img src="./admin/uploads/<?php echo $product_item[2]?>" alt="product" /></td>
                                        <td>
                                            <p class="text-uppercase"><?php echo $product_item[1]?></p>
                                            <span class="text-danger">(<?php echo $product_item[3]?>)</span>
                                        </td>
                                        <td><span><?php echo   $formatted_number = number_format( $product_item[4], 0, ',', '.');?></span>đ</td>
                                        <td>
                                            <div class="change-quantity">
                                                <!--<button class="updateQty increaseQty" onclick="
                                                var result = this.nextSibling;
                                                var qtyItem<?php echo $product_item[0]; ?> = result.value; 
                                                if( !isNaN( qtyItem<?php echo $product_item[0]; ?> ) && qtyItem<?php echo $product_item[0]; ?> > 1 ) 
                                                    result.value--;
                                                return false;"
                                                >-</button><input
                                                    type="text"
                                                    min="0"
                                                    value=<?php echo $product_item[5]?>
                                                    maxlength="5"
                                                    class="quantity"
                                                    onchange="if(this.value == 0) this.value = 1"
                                                    onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                                                /><button class="updateQty decreaseQty" onclick="
                                                var result = this.previousSibling; 
                                                var qtyItem<?php echo $product_item[0]; ?> = result.value; 
                                                if( !isNaN( qtyItem<?php echo $product_item[0]; ?> )) 
                                                    result.value++;
                                            return false;"
                                                >+</button>-->
                                                <input type="hidden" value="<?php echo $product_item[0]; ?>" name="product_id">
                                                <button class="updateQty decreaseQty">-</button>
                                                <input
                                                    type="text"
                                                    min="1"
                                                    name="product_quantity[]";
                                                    value=<?php echo $product_item[5]?>
                                                    maxlength="3"
                                                    class="quantity"
                                                    onchange="
                                                        if(this.value == 0) this.value = 1
                                                    "
                                                    onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                                                /><button class="updateQty increaseQty ">+</button>
                                            </div>
                                        </td>
                                        <td><span class="price"><?php echo   $formatted_number = number_format( $thanh_tien, 0, ',', '.');?></span>đ</td>
                                        <td>
                                            <a href="delete-product-cart.php?product_id=<?php echo $product_item[0]?>&product_size=<?php echo $product_item[3];?>" class="text-dark">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                ?>
                                <tr>
                                    <td class="text-end" colspan="6">
                                        <button type="submit" name="update_cart" class="rounded bg-black text-white p-2 ">cập nhật</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="total-price">Tổng tiền: <span><?php echo   $formatted_number = number_format( $total_price, 0, ',', '.');?></span>đ</div>
                        <div class="d-flex justify-content-end gap-3">
                            <a  href="./index.php"class="btn-buy">Tiếp tục mua hàng</a>
                            <a  href="./checkout.php" class="btn-order">Tiến hành thanh toán</a>
                            <!--<button class="btn-order" type="submit" name="order_click">
                                Tiến hành đặt hàng
                            </button>-->
                        </div>
                    </form>
                </div>
            </div>

<?php 
    } 
    else if(empty($_SESSION["cart"])){
        var_dump(empty($_SESSION["cart"]))
?>
    <div class="d-flex justify-content-center py-5">
        <img src="../assets/img/empty-cart.webp" alt="" style="max-width: 50%">
    </div>
<?php 

}
?>
<?php 
    include("./footer.php");
?>
<script>
    $(document).ready(function() {

        $(".decreaseQty").click(function(e){
            e.preventDefault();
            
             var qty = $(this).closest(".product-data").find(".quantity").val();
     
             var value = parseInt(qty);
             value = isNaN(value) ? 0 : value;
             if(value > 1) {
                 value--;
                 $(this).closest(".product-data").find(".quantity").val(value);
             }
             console.log($(this).closest(".product-data").find(".quantity").val());
        }) 

        $(".increaseQty").click(function(e){
            e.preventDefault();
             var qty = $(this).closest(".product-data").find(".quantity").val();
     
             var value = parseInt(qty);
             value = isNaN(value) ? 0 : value;
             if(value < 999) {
                 value++;
                 $(this).closest(".product-data").find(".quantity").val(value);
             }
             console.log( $(this).closest(".product-data").find(".quantity").val());
        }) 
    })
</script>