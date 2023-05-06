<?php
    session_start();
    ob_start();
    if(isset($_SESSION["user"]) && ($_SESSION["user"]["role"] == 1 || $_SESSION["user"]["role"] == 2)) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/product-class.php");
?>

<?php 
    $Product = new Product;

    if(isset($_GET["product_id"])) {
        $product_id = $_GET["product_id"];
        $storage_show_product = $Product->storage_show_product($product_id);
        if(!$storage_show_product) {
            header("location: ./index.php");
        }
    }
    
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
                    <th scope="col" style="width: 10%">Kích thước</th>
                    <th scope="col" style="width: 10%">Số lượng</th>
                    <th scope="col" style="width: 15%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        if($storage_show_product) {
                            $i = 0;
                            while($result = $storage_show_product->fetch_assoc()) { 
                                $i++; 
                               
                               
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td style=" text-transform: uppercase;"><?php echo $result["product_name"] ?></td>
                        <td><?php echo $result["product_size"]?></td>
                        <td><?php echo $result["quantity"]?></td>
                        <td>
                        <a href="storage-edit.php?product_id=<?php echo $result['product_id'] ?>&size_id=<?php echo $result["size_id"]?>" class="btn btn-dark">Sửa</a>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#<?php echo $result["product_id"].''.$result["size_id"]?>">Xoá</a>
                       
                                
                        </td>
                    </tr>
                    <!--Modal-->
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
                                    <p class="text-danger">Việc này sẽ làm mất hết dữ liệu trong hệ thống và không thể khôi phục lại</p>

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
           
        </div>
    </main>
</div>

</div>
<?php 
    } else {
        include("./404.php");
    }
?>