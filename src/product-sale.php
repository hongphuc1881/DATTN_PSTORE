<?php
    include("./header.php");
?>
<?php 
    $Product = new Product;
    $show_product_sale = $Product->show_product_sale();
    
    
    $show_size = $Product->show_size();
   
    // phan trang
    // 1.tong so ban ghi
    $total_product = $show_product_sale->num_rows;
    // 2. thiet lap so ban ghi tren 1 trang
    $limit = 12;
    // 3. tinh so trang 
    $page = ceil($total_product/$limit);
    // 4. lay trang hien tai
    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1 ;
    //5. start
    $start = ($current_page - 1) * $limit;
    //6: query

    //sort
    $field = isset($_GET["field"]) ? $_GET["field"] : "";
    $sort = isset($_GET["sort"]) ? $_GET["sort"] : "";
    
    if(!empty($field) && !empty($sort)) {
        $product_sale_pagination = $Product->product_sale_pagination($limit, $start, $field, $sort);
    } else {
        $product_sale_pagination = $Product->product_sale_pagination($limit, $start);
    }
  

?>
            <div class="app-container">
                <div class="container pt-5">
                  
                    <div class="row">
                        <div class="col-lg-3">
                        <div class="filter-product-list">
                                <form action="" method="GET" >
                                        <div class="row align-items-md-center">
                                            <div class="col-12 col-lg-12 col-md-8 filter-product-item d-none d-lg-block d-sm-block d-md-block">
                                                <div class="filter-product-item-title d-flex justify-content-between pb-4 pb-md-3">
                                                    <div class="">Theo size giày</div>
                                                    <div>
                                                        <button class="btn btn-dark" style="font-size: 16px;" type="submit">Tìm giày ngay</button>
                                                    </div>
                                                </div>
                                                <ul class="row gx-0 filter-ul">
                                                    <?php 
                                                        if($show_size) {
                                                            while($rs = $show_size->fetch_assoc()) {   
                                                                $checked = [];
                                                                if(isset($_GET["sizes"]))   {
                                                                    $checked = $_GET["sizes"];
                                                                }   
                                                    ?>
                                                        <li class="col-lg-6 col">
                                                            <input type="checkbox" id="filter-<?php echo $rs["product_size"] ?>" name="sizes[]" value="<?php echo $rs["size_id"]?>" <?php if(in_array($rs["size_id"],$checked)) {echo "checked";}?>/>
                                                            <label for="filter-<?php echo $rs["product_size"] ?>"><?php echo $rs["product_size"] ?></label>
                                                        </li>
                                                    <?php 
                                                    }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="col-12 col-lg-12 col-md-4 filter-product-item">
                                                <div class="filter-product-item-title pb-md-4">Sắp xếp</div>
                                                <select name="sort" id="" class="w-100"
                                                    onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
                                                >
                                                    <option value="#">--Sắp xếp--</option>
                                                    <option value="?field=product_price_new&sort=asc">Giá từ thấp đến cao</option>
                                                    <option value="?field=product_price_new&sort=desc">Giá từ cao đến thấp</option>
                                                    <option value="?field=product_name&sort=asc">Tên A - Z</option>
                                                    <option value="?field=product_name&sort=desc">Tên Z - A</option>
                                                    <option value="?field=product_id&sort=asc">Cũ nhất</option>
                                                    <option value="?field=product_id&sort=desc">Mới nhất</option>
                                                </select>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-9 col-12">
                            <div class="list-product">
                                <div class="row">
                                    <!-- size -->
                                    <?php 
                                    if(isset($_GET["sizes"])) {
                                        $sizes_checked = $_GET["sizes"] ;
                                        $size_id = implode(",", $sizes_checked);
                                        $show_product_filter = $Product->show_product_filter_by_size($size_id, "", "", true);
                                        if($show_product_filter) {
                                            while($result = $show_product_filter->fetch_assoc()) {
                                    ?>
                                         <div class="col-lg-4 col-md-4 col-6">
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
                                        <div class="text-center">
                                            <img src="../assets/img/no-result.png" class="w-25"/>
                                            <h2 >Không có sản phẩm nào</h2>
                                        </div>
                                    <?php
                                        }
                                    }else {

                                
                                    if($product_sale_pagination) {
                                        while($result = $product_sale_pagination->fetch_assoc()) {
                                    ?>
                                        <div class="col-lg-4 col-md-4 col-6">
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
                                        }
                                    ?>
                                    
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center mt-5">
                                <?php 
                                    if(isset($_GET["sizes"])) {
                                    //   
                                    }
                                    else {
                                ?>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php 
                                                if($current_page - 1 > 0) {
                                            ?>
                                                <li class="page-item">
                                                   
                                                    <?php
                                                        if(isset($_GET["field"]) && isset($_GET["sort"])) {
                                                    ?>
                                                        <a class="page-link" href="product-sale.php?page=<?php echo $current_page - 1;?>&field=<?php echo $_GET["field"]?>&sort=<?php echo $_GET["sort"]?>" aria-label="Next">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    <?php 
                                                        } else {
                                                    ?>
                                                         <a class="page-link" href="product-sale.php?page=<?php  echo $current_page -1; ?>" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                    <?php 
                                                        }
                                                    ?>
                                                </li>
                                            <?php } ?>
                                            <?php 
                                                for ($i=1; $i <= $page ; $i++) { 
                                            ?>
                                                <li class="page-item <?php echo $i == $current_page ? "active": ""?>">
                                                    <?php
                                                        if(isset($_GET["field"]) && isset($_GET["sort"])) {
                                                    ?>
                                                        <a class="page-link" href="product-sale.php?page=<?php echo $i ?>&field=<?php echo $_GET["field"]?>&sort=<?php echo $_GET["sort"]?>"><?php echo  $i ?></a>
                                                    <?php 
                                                        } else {
                                                    ?>
                                                        <a class="page-link" href="product-sale.php?page=<?php echo $i ?>"><?php echo  $i ?></a>
                                                    <?php 
                                                        }
                                                    ?>
                                                </li>
                                            <?php 
                                                    }   
                                            ?>
                                            
                                            <?php
                                                if($current_page + 1 <= $page) {
                                            ?>
                                                <li class="page-item">
                                                    <?php
                                                        if(isset($_GET["field"]) && isset($_GET["sort"])) {
                                                    ?>
                                                        <a class="page-link" href="product-sale.php?page=<?php echo $current_page + 1;?>&field=<?php echo $_GET["field"]?>&sort=<?php echo $_GET["sort"]?>" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    <?php 
                                                        } else {
                                                    ?>
                                                        <a class="page-link" href="product-sale.php?page=<?php echo $current_page + 1;?>" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    <?php 
                                                        }
                                                    ?>
                                                </li>
                                            <?php } ?>

                                        </ul>
                                    </nav>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php 
    include("./footer.php");
?>