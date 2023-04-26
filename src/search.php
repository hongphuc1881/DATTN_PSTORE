<?php
ob_start();
    include("./header.php");
?>

<?php 
    $Product = new Product;
    if(isset($_GET["search"]) && $_GET["search"] != "" ) {
        $search = $_GET["search"];
        $search_product = $Product->search_product($search);
    } else {
        header("location: index.php");
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
           
                <div class="list-product">
                    <div class="row">
                        <?php 
                            if($search_product) {
                                while($result = $search_product->fetch_assoc()) {

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
                            } else {
                           
                        ?>
                            <div class="d-flex justify-content-center flex-column align-items-center">
                                <div class="d-flex justify-content-center"><img src="../assets/img/no-result.png" alt="" style="max-width: 60%;"></div>
                                <h2>Không tìm thấy kết quả nào</h2>
                                <h3>Hãy sử dụng các từ khoá chung chung hơn</h3>
                            </div>
                        <?php
                            }
                        ?>
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
<?php 
    include("./footer.php");
?>