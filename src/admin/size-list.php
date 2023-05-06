<?php
    ob_start();
    session_start();
    if(isset($_SESSION["user"]) && ($_SESSION["user"]["role"] == 1)) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/product-class.php");
?>

<?php 
    $Product = new Product;
    $show_size = $Product->show_size();
    if(!$show_size ) {
        header("location: index.php");
    }


    
    if($_SERVER["REQUEST_METHOD"] == "POST" ) {
        $product_size = $_POST['product_size'];
        $check_size_is_already = $Product->check_size_is_already($product_size);
        if($check_size_is_already) {
            echo "<script>alert('Sản phẩm đã có trong kho!')</script>";
        } else {
            $insert_size = $Product->insert_size($product_size);
            header("location: size-list.php");
        }
    }
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
         
                <h2>Quản lý kích cỡ</h2>
                <div class="row">
                    <div class="col-6">
                        <form action="" method="POST">
                            <div class=" form-group ">
                            <label for="product_size" class="h6">kích cỡ:</label>
                                <input type="text" class="form-control" id="product_size" name="product_size"
                                    placeholder="Nhập kích cỡ"
                                    onchange="
                                        if(this.value == 0) this.value = 1
                                    "
                                    onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-dark">Thêm</button>
                        </form>
                    </div>
                    <div class="col-6">
                       <strong> Danh sách kích cỡ</strong>
                       <table class="table">
                            <thead>
                                <tr>
                                <th scope="col" style="width: 10%">#</th>
                                <th scope="col" style="width: 10%">Kích cỡ</th>
                                <th scope="col" style="width: 15%">Tuỳ chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                        if($show_size) {
                            $i = 0;
                            while($result = $show_size->fetch_assoc()) { 
                                $i++; 
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["product_size"] ?></td>
                        <td>
                        <a href="size-edit.php?size_id=<?php echo $result['size_id'] ?>" class="btn btn-dark">Sửa</a>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#<?php echo $result["product_size"]?>">Xoá</a>
                        </td>
                    </tr>
                     <!-- Modal -->
                     <div class="modal fade" id="<?php echo $result["product_size"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Xoá kích cỡ sản phẩm</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn xoá kích cỡ <strong><?php echo $result["product_size"];?></strong>
                                    <p class="text-danger">Việc này sẽ làm mất hết dữ liệu trong hệ thống và không thể khôi phục lại</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                    <a href="size-delete.php?size_id=<?php echo $result['size_id'] ?>" class="btn btn-danger">Xoá</a>
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