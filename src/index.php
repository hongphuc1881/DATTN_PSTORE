<?php 
    include("./header.php");
?>
<?php 
    $Product = new Product;
    $limit = 12;
    $limit_hot = 12;
    $show_product_hot = $Product->show_product_hot($limit_hot);
    $show_product_new = $Product->show_product_new($limit);
    $show_product_sale = $Product->show_product_sale($limit);
?>

<div class="app-container">
    <section id="banner"></section>
    <section id="feature-products">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="feature-product__title"><a href="./product-hot.php">Sản phẩm nổi bật</a></h2>
                </div>
                <?php 
                    if($show_product_hot) {
                        while($result = $show_product_hot->fetch_assoc()) {
                ?>
                 <div class="col-lg-3 col-md-4 col-6">
                 <div class="product-item">
                        <a href="product-detail.php?product_id=<?php echo $result['product_id']?>">
                            <div class="product-item__img">
                                <img src="<?php echo './admin/uploads/'.$result["product_img_main"] ?>" alt="" />
                            </div>
                            <div class="product-item__name"><?php echo $result["product_name"] ?></div>
                            <div class="product-item__price">
                                <?php if($result["product_price_new"] < $result["product_price_old"]) {

                                ?>
                                    <div class="product-item__price--new"><span><?php echo $formatted_number = number_format( $result["product_price_new"], 0, ',', '.'); ?></span>đ</div>
                                    <div class="product-item__price--old"><span><?php echo   $formatted_number = number_format( $result["product_price_old"], 0, ',', '.');?></span>đ</div>
                                <?php
                                    } else {

                                        
                                ?>
                                    <div class="product-item__price--new"><span><?php echo $formatted_number = number_format( $result["product_price_new"], 0, ',', '.'); ?></span>đ</div>
                                <?php 
                                } 
                                ?>
                            </div>
                            <?php 
                                if( $result["product_price_new"] < $result["product_price_old"]) {
                            ?>
                                <div class="product-item--sale-flash">-<?php  echo round((1 - $result["product_price_new"] / $result["product_price_old"]) * 100, 3); ?>%</div>
                            <?php  } ?>
                        </a>
                    </div>
                </div>
                <?php 
                
                        }
                    }
                ?>
            </div>
        </div>
    </section>

    <section id="sale-products">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="sale-product__title"><a href="./product-sale.php">Sản phẩm sales</a></h2>
                </div>
                <?php 
                    if($show_product_sale) {
                        while($result = $show_product_sale->fetch_assoc()) {
                ?>
                 <div class="col-lg-3 col-md-4 col-6">
                    <div class="product-item">
                        <a href="product-detail.php?product_id=<?php echo $result['product_id']?>">
                            <div class="product-item__img">
                                <img src="<?php echo './admin/uploads/'.$result["product_img_main"] ?>" alt="" />
                            </div>
                            <div class="product-item__name"><?php echo $result["product_name"] ?></div>
                            <div class="product-item__price">
                                <?php if($result["product_price_new"] < $result["product_price_old"]) {

                                ?>
                                    <div class="product-item__price--new"><span><?php echo $formatted_number = number_format( $result["product_price_new"], 0, ',', '.'); ?></span>đ</div>
                                    <div class="product-item__price--old"><span><?php echo   $formatted_number = number_format( $result["product_price_old"], 0, ',', '.');?></span>đ</div>
                                <?php
                                    } else {

                                        
                                ?>
                                    <div class="product-item__price--new"><span><?php echo $formatted_number = number_format( $result["product_price_new"], 0, ',', '.'); ?></span>đ</div>
                                <?php 
                                } 
                                ?>
                            </div>
                            <?php 
                                if( $result["product_price_new"] < $result["product_price_old"]) {
                            ?>
                                <div class="product-item--sale-flash">-<?php  echo round((1 - $result["product_price_new"] / $result["product_price_old"]) * 100, 0); ?>%</div>
                            <?php  } ?>
                        </a>
                    </div>
                </div>
                <?php 
                
                        }
                    }
                ?>
            </div>
        </div>
    </section>
   
</div>

<?php
    include("./footer.php");
?>
