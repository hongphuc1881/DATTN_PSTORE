<?php 
    include("./header.php");
?>
<?php
    $Product = new Product;
    
    if($_GET["product_id"]) {
        $product_id = $_GET["product_id"];
        $get_product = $Product->get_product($product_id)->fetch_assoc();
        $get_size = $Product->get_size($product_id);
        if($get_size) {
            $rs1 = $get_size->fetch_assoc();
        }
        $rs1['product_sizes']=(explode("," ,$rs1["product_sizes"]));   // vd: 36,37,38
        $rs1['sizes_id']=(explode("," ,$rs1["sizes_id"]));   // vd: 1,2,3

        $get_product_img_description = $Product->get_product_img_description($product_id);
       
    }
   
?>
            <div class="app-container">
                <div class="container pt-5">

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="large-image">
                                <img src="./admin/uploads/<?php  echo $get_product["product_img_main"]?>" alt="" />
                            </div>
                            <div class="list-image-detail">
                                <div class="owl-carousel">
                                    <?php 
                                        while($result = $get_product_img_description->fetch_assoc()) {
                                    ?>
                                     <div class="item">
                                        <img src="./admin/uploads/<?php echo $result['product_img_description']; ?>" alt="" />
                                    </div>
                                    <?php 
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="product-info">
                                <div class="product-title"><?php echo $get_product["product_name"];?></div>
                                <div class="price">
                                    <?php 
                                        if( $get_product["product_price_new"] <  $get_product["product_price_old"]){
                                    ?>
                                        <div class="new-price"><span><?php echo   $formatted_number = number_format( $get_product["product_price_new"], 0, ',', '.');?></span>đ</div>
                                        <div class="old-price"><span><?php echo   $formatted_number = number_format( $get_product["product_price_old"], 0, ',', '.');?></span>đ</div>
                                    <?php } else {?>
                                        <div class="new-price"><span><?php echo   $formatted_number = number_format( $get_product["product_price_new"], 0, ',', '.');?></span>đ</div>
                                    <?php } ?>
                                </div>
                                <div class="product-description">
                                    <?php echo $get_product["product_description"];?>
                                </div>
                               <form action="add-to-cart.php" method="POST">
                                    <div class="product-size">
                                        <p>Kích Thước:</p>
                                        <ul>
                                            <?php
                                                $count =count($rs1["product_sizes"]);  
                                                for($i = 0 ; $i < $count; $i++) {
                                            ?>
                                                    <li>
                                                        <input type="radio" name="product_size" value="<?php echo $rs1["sizes_id"][$i];?>"  id="product-size-<?php echo $rs1["product_sizes"][$i]?>" checked/>
                                                        <label for="product-size-<?php echo $rs1["product_sizes"][$i]?>"><?php echo $rs1["product_sizes"][$i] ?></label>
                                                    </li>
                                            <?php 
                                                    
                                                } 
                                            ?>
                                           
                                        </ul>
                                    </div>
                                    <input type="hidden" name="product_id" value="<?php echo $product_id ;?>">
                                    <input type="hidden" name="product_img_main" value="<?php echo $get_product["product_img_main"] ;?>">
                                    <input type="hidden" name="product_name" value="<?php echo $get_product["product_name"] ;?>">
                                    <input type="hidden" name="price" value="<?php echo $get_product["product_price_new"] ;?>">
                                    <!--<a href="./cart.php?product_id=<?php echo $product_id;?>" class="btn btn-dark add-to-cart">Thêm vào giỏ hàng</a><br>-->
                                    <button type="submit" class="add-to-cart" name="add_to_cart">them vao gio hang</button>    
                               </form>
                            </div>
                        </div>
                    </div>
              
                </div>
            </div>
<?php 
    include("./footer.php");
?>
<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel();
    });
</script>
<script>
    var img = document.querySelectorAll(".item img");
    var largeImage = document.querySelector(".large-image img");
    //largeImage.src = img[0].src;
    img.forEach((item) => {
        item.onclick = function (e) {
            largeImage.src = this.src;
        };
    });
</script>