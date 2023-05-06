<?php 
    include("./header.php");
    $Product = new Product;
    //echo "<pre>";
    //var_dump($_SESSION['cart']);
    //echo "</pre>";

?>
<?php 
    if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
        $cart = $_SESSION["cart"];
   
?>
<?php 
    //if(isset($_POST["update_cart"])) {
    //    $product_quantity = $_POST["product_quantity"];
        
    //    $count = count($cart);
    //    foreach ($cart as $key => $item) {
    //        for($i = 0; $i < $count ; $i++) {
    //            $item[5] = (int)$product_quantity[$i];
    //            $cart[$i][5] = $item[5];
    //        }
    //    }
    //    $_SESSION["cart"] = $cart;
      
    //} else if(isset($_POST["order_click"])) {
    //    echo "submit cart";

    //}
?>
            <div class="app-container">
                <div class="container pt-5">
                    <form action="" method="POST">
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
                                    $get_product_size = $Product->get_product_size_by_size_id($product_item[3])->fetch_assoc();
                                    $max_quantity = $Product->select_productId_sizeId($product_item[0], $product_item[3])->fetch_assoc();
                                ?>
                                    <tr class="product-data">
                                        <td><img src="./admin/uploads/<?php echo $product_item[2]?>" alt="product" /></td>
                                        <td>
                                            <p class="text-uppercase"><?php echo $product_item[1]?></p>
                                            <span class="text-danger">(<?php echo $get_product_size["product_size"];?>)</span>
                                        </td>
                                        <td><span class="price"><?php echo   $formatted_number = number_format( $product_item[4], 0, ',', '.');?></span>đ</td>
                                        <td>
                                            <div class="change-quantity">
                                                
                                                <input type="hidden" value="<?php echo $product_item[3]; ?>" name="size_id" class="size_id">
                                                <input type="hidden" value="<?php echo $product_item[0]; ?>" name="product_id" class="product_id">
                                                <button class="updateQty decreaseQty">-</button>
                                                <input
                                                    type="text"
                                                    min="1"
                                                    name="product_quantity[]";
                                                    value=<?php echo $product_item[5]?>
                                                    maxlength="2"
                                                    max= "<?php echo $max_quantity["quantity"]?>"
                                                    class="quantity"
                                                    onchange="
                                                        if(this.value == 0) this.value = 1
                                                    "
                                                    onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                                                /><button class="updateQty increaseQty ">+</button>
                                            </div>
                                        </td>
                                        <td><span class="thanhtien"><?php echo   $formatted_number = number_format( $thanh_tien, 0, ',', '.');?></span>đ</td>
                                        <td>
                                            <a href="delete-product-cart.php?product_id=<?php echo $product_item[0]?>&product_size=<?php echo $product_item[3];?>" class="text-dark">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                ?>
                                <!--<tr>
                                    <td class="text-end" colspan="6">
                                        <button type="submit" name="update_cart" class="rounded bg-black text-white p-2 ">cập nhật</button>
                                    </td>
                                </tr>-->
                            </tbody>
                        </table>
                        <div class="total-price">Tổng tiền: <span><?php echo   $formatted_number = number_format( $total_price, 0, ',', '.');?></span>đ</div>
                        <div class="d-flex justify-content-end gap-3">
                            <a  href="./index.php"class="btn-buy">Tiếp tục mua hàng</a>
                            <a  href="./checkout.php" class="btn-order">Tiến hành thanh toán</a>
                        </div>
                    </form>
                </div>
            </div>

<?php 
    } 
    else if(empty($_SESSION["cart"])){
        var_dump(empty($_SESSION["cart"]))
?>
    <div class="d-flex justify-content-center" style="padding-top: 150px">
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
            var thanhtienAll = document.querySelectorAll(".thanhtien")
            
            var qty = $(this).closest(".product-data").find(".quantity").val();
            var product_id = $(this).closest(".product-data").find(".product_id").val();
            var size_id = $(this).closest(".product-data").find(".size_id").val();
            var price = $(this).closest(".product-data").find(".price").text();
            var thanhtien = $(this).closest(".product-data").find(".thanhtien").text();
            var total_price = 0;
            price = price.replaceAll(".", "");
            
            var value = parseInt(qty);
            value = isNaN(value) ? 0 : value;
            
            if(value > 1) {
                value--;
                $(this).closest(".product-data").find(".quantity").val(value);
                qty = value
            }
            thanhtien = price * qty;
            $(this).closest(".product-data").find(".thanhtien").text(thanhtien.toLocaleString('vi-VN'));
           
           thanhtienAll.forEach(item => {
                var a = +item.innerText.replaceAll(".", "")
                total_price += a;
           })
        //   console.log(total_price, thanhtien);
            $(".total-price span").text(total_price.toLocaleString('vi-VN'));

            $.ajax({
                method: "POST",
                url:"cart-ajax.php",
            data: {
                product_id: product_id,
                size_id: size_id,
                qty: qty,
            },
            success: function(data) {
            }
            
        })
        
        //console.log("price: ",price);
        //console.log("thanh tien ",thanhtien);
        //console.log("quantity",$(this).closest(".product-data").find(".quantity").val());
        //console.log(thanhtien.toLocaleString('vi-VN', {style: 'currency', currency: 'VND'})); 
        //console.log(product_id);
        //console.log(size_id);
        }) 

        $(".increaseQty").click(function(e){
            e.preventDefault();
            var thanhtienAll = document.querySelectorAll(".thanhtien");
            var qty = $(this).closest(".product-data").find(".quantity").val();
            var product_id = $(this).closest(".product-data").find(".product_id").val();
            var size_id = $(this).closest(".product-data").find(".size_id").val();
            var price = $(this).closest(".product-data").find(".price").text();
            var thanhtien = $(this).closest(".product-data").find(".thanhtien").text();
            var total_price = 0;

            var maxQuantity = $(this).closest(".product-data").find(".quantity").attr("max");
            price = price.replaceAll(".", "");
            var value = parseInt(qty);
            value = isNaN(value) ? 0 : value;
            if(value < maxQuantity) {
                value++;
                $(this).closest(".product-data").find(".quantity").val(value);
                //console.log(  $(this).closest(".product-data").find(".quantity").val(value));
                qty = value
            }
            thanhtien = price * qty;
            
            
            $(this).closest(".product-data").find(".thanhtien").text(thanhtien.toLocaleString('vi-VN'));
            thanhtienAll.forEach(item => {
                var a = +item.innerText.replaceAll(".", "")
                total_price += a;
                console.log(a, qty, total_price);
            })
            //console.log(total_price, thanhtien);
            $(".total-price span").text(total_price.toLocaleString('vi-VN'));

             $.ajax({
                method: "POST",
                url:"cart-ajax.php",
                data: {
                    product_id: product_id,
                    size_id: size_id,
                    qty: qty,
                },
                success: function(data) {
                    //location.reload();
                }
                
            })
            //console.log("price: ",price);
            //console.log("thanh tien ",thanhtien);
            //console.log("quantity",$(this).closest(".product-data").find(".quantity").val());
            //console.log(thanhtien.toLocaleString('vi-VN', {style: 'currency', currency: 'VND'})); 
            //console.log(product_id);
            //console.log(size_id);
           
        }) 
         
       
        $(".quantity").on('change',function(event) {
            event.preventDefault();
            var qty = $(this).closest(".product-data").find(".quantity").val();
            var product_id = $(this).closest(".product-data").find(".product_id").val();
            var size_id = $(this).closest(".product-data").find(".size_id").val();
            
            var maxQuantity = $(this).closest(".product-data").find(".quantity").attr("max");
            var value = parseInt(qty);
             value = isNaN(value) ? 0 : value;
             if(value > maxQuantity) {
                value = parseInt(maxQuantity);
                $(this).closest(".product-data").find(".quantity").val(value);
                qty = value
             }
            

            $.ajax({
                method: "POST",
                url:"cart-ajax.php",
                data: {
                    product_id: product_id,
                    size_id: size_id,
                    qty: qty,
                },
                success: function(data) {
                    location.reload();
                }
            })
            return false;
        })
    })
</script>