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
        $rs1['sizes']=(explode("," ,$rs1["sizes"]));   

        $get_product_img_description = $Product->get_product_img_description($product_id);
       
    }
?>
            <div class="app-container">
                <div class="container pt-5">
                    <!--<nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fa-solid fa-house"></i> Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Vans</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Vans Vault Style 36 Orange</li>
                        </ol>
                    </nav>-->
<!--
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="large-image">
                                <img src="" alt="" />
                            </div>
                            <div class="list-image-detail">
                                <div class="owl-carousel">
                                    <div class="item">
                                        <img src="../assets/img/vans.webp" alt="" />
                                    </div>
                                    <div class="item">
                                        <img src="../assets/img/vans2.webp" alt="" />
                                    </div>
                                    <div class="item">
                                        <img src="../assets/img/vans3.webp" alt="" />
                                    </div>
                                    <div class="item">
                                        <img src="../assets/img/vans4.webp" alt="" />
                                    </div>
                                    <div class="item">
                                        <img src="../assets/img/vans5.webp" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="product-info">
                                <div class="product-title">vans vault style 36 orange</div>
                                <div class="price">
                                    <div class="new-price">832.000đ</div>
                                    <div class="old-price">1.040.000đ</div>
                                </div>
                                <div class="product-description">
                                    <p>- Chất lượng Rep 1:1</p>
                                    <p>
                                        - Đối với chân thon gọn nên đi lùi 1 size , chân bè ngang nên đi lùi 0,5 size so
                                        với size chuẩn
                                    </p>
                                    <p>- Vận chuyển toàn quốc [ Kiểm Tra Hàng Trước Khi Thanh Toán ]</p>
                                    <p>- 100% Ảnh chụp trực tiếp tại PStore</p>
                                    <p>- Bảo Hành Trọn Đời Sản Phẩm</p>
                                    <p>- Đổi Trả 7 Ngày Không Kể Lí Do</p>
                                    <p>- Liên Hệ : 0967.585.135</p>
                                </div>
                                <div class="product-size">
                                    <p>Kích Thước:</p>
                                    <ul>
                                        <li>
                                            <input type="radio" name="product-size" id="product-size-36" />
                                            <label for="product-size-36">36</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="product-size" id="product-size-37" />
                                            <label for="product-size-37">37</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="product-size" id="product-size-38" />
                                            <label for="product-size-38">38</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="product-size" id="product-size-39" />
                                            <label for="product-size-39">39</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="product-size" id="product-size-40" />
                                            <label for="product-size-40">40</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="product-size" id="product-size-41" />
                                            <label for="product-size-41">41</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="product-size" id="product-size-42" />
                                            <label for="product-size-42">42</label>
                                        </li>
                                    </ul>
                                </div>
                                <a href="./cart.html" class="btn btn-dark add-to-cart">Thêm vào giỏ hàng</a>
                            </div>
                        </div>
                    </div>
                    -->
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
                                <div class="product-size">
                                    <p>Kích Thước:</p>
                                    <ul>
                                        <?php
                                            foreach($rs1["sizes"] as $value) {
                                        ?>
                                                <li>
                                                    <input type="radio" name="product-size" value="<?php echo $value?>"   id="product-size-<?php echo $value?>" />
                                                    <label for="product-size-<?php echo $value?>"><?php echo $value ?></label>
                                                </li>
                                        <?php 
                                            }
                                        ?>
                                       
                                    </ul>
                                </div>
                                <a href="./cart.html" class="btn btn-dark add-to-cart">Thêm vào giỏ hàng</a><br>
                                            
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