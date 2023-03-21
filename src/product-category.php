<?php
    include("./header.php");
?>
<?php 
    $Product = new Product;
    if(!isset($_GET["category_id"]) || $_GET["category_id"] == NULL) {
        echo "<script>window.location.href =' index.php'</script>";
    }else {
        $category_id = $_GET["category_id"];
        $show_product_by_category = $Product->show_product_by_category($category_id);
    }
    
?>

            <div class="app-container">
                <div class="container pt-5">
                    <!--<nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fa-solid fa-house"></i> Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Adidas</li>
                        </ol>
                    </nav>-->

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="filter-product-list">
                                <div class="filter-product-item">
                                    <div class="filter-product-item-title">Theo size giày</div>
                                    <ul class="row gx-0 filter-ul">
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-36" />
                                            <label for="filter-36">36</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-37" />
                                            <label for="filter-37">37</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-38" />
                                            <label for="filter-38">38</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-39" />
                                            <label for="filter-39">39</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-40" />
                                            <label for="filter-40">40</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-41" />
                                            <label for="filter-41">41</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-42" />
                                            <label for="filter-42">42</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="filter-product-item">
                                    <div class="filter-product-item-title">Theo loại</div>
                                    <ul class="row gx-0 filter-ul">
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-air-force-1" />
                                            <label for="filter-air-force-1">Air Force 1</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-air-max" />
                                            <label for="filter-air-max">Air max</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="filter-product-item">
                                    <div class="filter-product-item-title">Sale</div>
                                    <ul class="row gx-0 filter-ul">
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-giam-10%" />
                                            <label for="filter-giam-10%">Giảm 10%</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-giam-20%" />
                                            <label for="filter-giam-20%">Giảm 20%</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-giam-30%" />
                                            <label for="filter-giam-30%">Giảm 30%</label>
                                        </li>
                                        <li class="col-6">
                                            <input type="checkbox" id="filter-giam-40%" />
                                            <label for="filter-giam-40%">Giảm 40%</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="list-product">
                                <div class="row">
                                    <!-- category -->
                                    <?php 
                                    if($show_product_by_category) {
                                        while($result = $show_product_by_category->fetch_assoc()) {

                                     
                                    ?>
                                        <div class="col-lg-4">
                                        <div class="product-item">
                                        <a href="product-detail.php?product_id=<?php echo $result['product_id']?>">
                                            <div class="product-item__img">
                                                <img src="<?php echo './admin/uploads/'.$result["product_img_main"] ?>" alt="" />
                                            </div>
                                            <div class="product-item__name"><?php echo $result["product_name"] ?></div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span><?php echo 
                                                    $formatted_number = number_format( $result["product_price_new"], 0, ',', '.');
                                            ?></span>đ</div>
                                                <div class="product-item__price--old"><span><?php echo   $formatted_number = number_format( $result["product_price_old"], 0, ',', '.');?></span>đ</div>
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

                                    <!--<div class="col-lg-4">
                                        <div class="product-item">
                                            <div class="product-item__img">
                                                <img src="../assets/img/pd1.webp" alt="" />
                                            </div>
                                            <div class="product-item__name">Yeezy slides 'bone' 2022</div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span>720.000</span>đ</div>
                                                <div class="product-item__price--old"><span>900.000</span>đ</div>
                                            </div>
                                            <div class="product-item--sale-flash">-20%</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="product-item">
                                            <div class="product-item__img">
                                                <img src="../assets/img/pd1.webp" alt="" />
                                            </div>
                                            <div class="product-item__name">Yeezy slides 'bone' 2022</div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span>720.000</span>đ</div>
                                                <div class="product-item__price--old"><span>900.000</span>đ</div>
                                            </div>
                                            <div class="product-item--sale-flash">-20%</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="product-item">
                                            <div class="product-item__img">
                                                <img src="../assets/img/pd1.webp" alt="" />
                                            </div>
                                            <div class="product-item__name">Yeezy slides 'bone' 2022</div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span>720.000</span>đ</div>
                                                <div class="product-item__price--old"><span>900.000</span>đ</div>
                                            </div>
                                            <div class="product-item--sale-flash">-20%</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="product-item">
                                            <div class="product-item__img">
                                                <img src="../assets/img/pd1.webp" alt="" />
                                            </div>
                                            <div class="product-item__name">Yeezy slides 'bone' 2022</div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span>720.000</span>đ</div>
                                                <div class="product-item__price--old"><span>900.000</span>đ</div>
                                            </div>
                                            <div class="product-item--sale-flash">-20%</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="product-item">
                                            <div class="product-item__img">
                                                <img src="../assets/img/pd1.webp" alt="" />
                                            </div>
                                            <div class="product-item__name">Yeezy slides 'bone' 2022</div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span>720.000</span>đ</div>
                                                <div class="product-item__price--old"><span>900.000</span>đ</div>
                                            </div>
                                            <div class="product-item--sale-flash">-20%</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="product-item">
                                            <div class="product-item__img">
                                                <img src="../assets/img/pd1.webp" alt="" />
                                            </div>
                                            <div class="product-item__name">Yeezy slides 'bone' 2022</div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span>720.000</span>đ</div>
                                                <div class="product-item__price--old"><span>900.000</span>đ</div>
                                            </div>
                                            <div class="product-item--sale-flash">-20%</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="product-item">
                                            <div class="product-item__img">
                                                <img src="../assets/img/pd1.webp" alt="" />
                                            </div>
                                            <div class="product-item__name">Yeezy slides 'bone' 2022</div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span>720.000</span>đ</div>
                                                <div class="product-item__price--old"><span>900.000</span>đ</div>
                                            </div>
                                            <div class="product-item--sale-flash">-20%</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="product-item">
                                            <div class="product-item__img">
                                                <img src="../assets/img/pd1.webp" alt="" />
                                            </div>
                                            <div class="product-item__name">Yeezy slides 'bone' 2022</div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span>720.000</span>đ</div>
                                                <div class="product-item__price--old"><span>900.000</span>đ</div>
                                            </div>
                                            <div class="product-item--sale-flash">-20%</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="product-item">
                                            <div class="product-item__img">
                                                <img src="../assets/img/pd1.webp" alt="" />
                                            </div>
                                            <div class="product-item__name">Yeezy slides 'bone' 2022</div>
                                            <div class="product-item__price">
                                                <div class="product-item__price--new"><span>720.000</span>đ</div>
                                                <div class="product-item__price--old"><span>900.000</span>đ</div>
                                            </div>
                                            <div class="product-item--sale-flash">-20%</div>
                                        </div>
                                    </div>
                                -->
                                </div>
                            </div>
                            <!--<div class="d-flex justify-content-center mt-5">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item"><a class="page-link" href="#">8</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
<?php 
    include("./footer.php");
?>