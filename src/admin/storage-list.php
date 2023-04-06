<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/product-class.php");
?>

<?php 
    $Product = new Product;
    $storage_show_product = $Product->storage_show_product();
     // phan trang
    // 1.tong so ban ghi
    $total_product = $storage_show_product->num_rows;
    // 2. thiet lap so ban ghi tren 1 trang
    $limit = 20;
    // 3. tinh so trang 
    $page = ceil($total_product/$limit);
    // 4. lay trang hien tai
    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1 ;

    //5. start
    $start = ($current_page - 1) * $limit;
    //6: query
    $storage_show_product_pagination = $Product->storage_show_product_pagination($start, $limit);
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Danh sách kho hàng</h2>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col" style="width: 10%">#</th>
                    <th scope="col" style="width: 45%">Tên sản phẩm</th>
                    <th scope="col" style="width: 10%">Kích cỡ</th>
                    <th scope="col" style="width: 10%">Số lượng</th>
                    <th scope="col" style="width: 15%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        if($storage_show_product_pagination) {
                            $i = 0;
                            while($result = $storage_show_product_pagination->fetch_assoc()) { 
                                $i++; 
                                
                               
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["product_name"] ?></td>
                        <td><?php echo $result["product_size"] ?></td>
                        <td><?php echo $result["quantity"] ?></td>
                        <td>
                        <a href="storage-edit.php?product_id=<?php echo $result['product_id'] ?>&size_id=<?php echo $result["size_id"]?>" class="btn btn-dark">Sửa</a>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#<?php echo $result["product_id"].''.$result["size_id"]?>">Xoá</a>
                                
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="<?php echo $result["product_id"].''.$result["size_id"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Xoá danh mục</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn xoá <strong><?php echo $result["product_name"];?></strong> với kích thước <strong><?php echo $result["product_size"];?></strong>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                     <a href="storage-delete.php?product_id=<?php echo $result['product_id'] ?>&size_id=<?php echo $result["size_id"]?>" class="btn btn-danger">Xoá</a>

                                </div>
                                </div>
                            </div>
                        </div>
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
                                <a class="page-link" href="storage-list.php?page=<?php  echo $current_page -1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php 
                            for ($i=1; $i <= $page ; $i++) { 
                        ?>
                                <li class="page-item <?php echo $i == $current_page ? "active": ""?>"><a class="page-link" href="storage-list.php?page=<?php echo $i ?>"><?php echo  $i ?></a></li>
                        <?php 
                                }   
                        ?>
                        
                        <?php
                            if($current_page + 1 <= $page) {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="storage-list.php?page=<?php echo $current_page + 1;?>" aria-label="Next">
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