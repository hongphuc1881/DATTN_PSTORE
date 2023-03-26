<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] != 3) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/product-class.php");
?>

<?php 
    $Product = new Product;
    $show_product = $Product->show_product();

    
    // phan trang
    // 1.tong so ban ghi
    $total_product = $show_product->num_rows;
    // 2. thiet lap so ban ghi tren 1 trang
    $limit = 4;
    // 3. tinh so trang 
    $page = ceil($total_product/$limit);
    // 4. lay trang hien tai
    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1 ;

    //5. start
    $start = ($current_page - 1) * $limit;
    //6: query
    $product_pagination = $Product->product_pagination($limit, $start);
   
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Danh sách loại sản phẩm</h2>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col" style="max-width: 5%">#</th>
                    <th scope="col" style="max-width: 10%">Danh mục</th>
                    <th scope="col" style="max-width: 20%">Loại sản phẩm</th>
                    <th scope="col" style="max-width: 45%">Tên sản phẩm</th>
                    <th scope="col" style="max-width: 5%">Giá gốc</th>
                    <th scope="col" style="max-width: 5%">Giá mới</th>
                    <th scope="col" style="max-width: 5%">Ảnh</th>
                    <th scope="col" style="max-width: 20%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody style="text-transform: lowercase" >
                    <?php
                        if($product_pagination) {
                            $i = 0;
                            while($result = $product_pagination->fetch_assoc()) { 
                                $i++; 
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["category_name"] ?></td>
                        <td><?php echo $result["brand_name"] ?></td>
                        <td><?php echo $result["product_name"] ?></td>
                        <td><?php echo   $formatted_number = number_format( $result["product_price_old"], 0, ',', '.');?>đ</td>
                        <td><?php echo   $formatted_number = number_format( $result["product_price_new"], 0, ',', '.');?>đ</td>
                        <td>
                            <img src="<?php echo "./uploads/".$result["product_img_main"] ?>" alt="product_img" style="max-width: 100px">
                        </td>
                        <td>
                        <a href="product-edit.php?product_id=<?php echo $result['product_id'] ?>" class="btn btn-dark">Sửa</a>
                        <a href="product-lock.php?product_id=<?php echo $result['product_id'] ?>" class="btn btn-danger">Xoá</a>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                     ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php 
                            if($current_page - 1 > 0) {
                         ?>
                            <li class="page-item">
                                <a class="page-link" href="product-list.php?page=<?php  echo $current_page -1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php 
                            for ($i=1; $i <= $page ; $i++) { 
                        ?>
                                <li class="page-item <?php echo $i == $current_page ? "active": ""?>"><a class="page-link" href="product-list.php?page=<?php echo $i ?>"><?php echo  $i ?></a></li>
                        <?php 
                                }   
                        ?>
                        
                        <?php
                            if($current_page + 1 <= $page) {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="product-list.php?page=<?php echo $current_page + 1;?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </main>
</div>
</div>
<script>
    var tr = document.querySelectorAll("tbody tr");
    tr.forEach(item => {
        item.style.lineHeight = "100px";
    })
</script>

<?php 
    } else {
        include("./404.php");
    }
?>