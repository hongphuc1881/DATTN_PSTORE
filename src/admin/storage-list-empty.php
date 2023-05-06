<?php
    session_start();
    if(isset($_SESSION["user"]) && ($_SESSION["user"]["role"] == 1 || $_SESSION["user"]["role"] == 2)) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/product-class.php");
?>

<?php 
    //sua tai
    $Product = new Product;
    $show_product = $Product->storage_show_product_empty_quantity();

    
    // phan trang
    // 1.tong so ban ghi
    $total_product = $show_product->num_rows;
    // 2. thiet lap so ban ghi tren 1 trang
    $limit = 10;
    // 3. tinh so trang 
    $page = ceil($total_product/$limit);
    // 4. lay trang hien tai
    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1 ;

    //5. start
    $start = ($current_page - 1) * $limit;
    //6: query
    $storage_empty_quantity_pagination = $Product->storage_empty_quantity_pagination($limit, $start);
    
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Danh sách kho hàng trống</h2>
            <table class="table">
                <thead  style="position: sticky; top: 55px; background-color: #000; color: #fff;">
                    <tr>
                    <th scope="col" style="width: 10%">#</th>
                    <th scope="col" style="width: 45%">Tên sản phẩm</th>
                    <th scope="col" style="width: 15%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        if($storage_empty_quantity_pagination) {
                            $i = 0;
                            while($result = $storage_empty_quantity_pagination->fetch_assoc()) { 
                                $i++; 
                              
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td style=" text-transform: uppercase;"><?php echo $result["product_name"] ?></td>
                        <td>
                            <a href="./storage-add.php?product_id=<?php echo $result['product_id']?>" class="btn btn-dark">Thêm</a>
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
                                <a class="page-link" href="storage-list-empty.php?page=<?php  echo $current_page -1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php 
                            for ($i=1; $i <= $page ; $i++) { 
                        ?>
                                <li class="page-item <?php echo $i == $current_page ? "active": ""?>"><a class="page-link" href="storage-list-empty.php?page=<?php echo $i ?>"><?php echo  $i ?></a></li>
                        <?php 
                                }   
                        ?>
                        
                        <?php
                            if($current_page + 1 <= $page) {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="storage-list-empty.php?page=<?php echo $current_page + 1;?>" aria-label="Next">
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
<?php 
    } else {
        include("./404.php");
    }
?>