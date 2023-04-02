<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/brand-class.php");
?>

<?php 
    $Brand = new Brand;
    $show_brand_lock = $Brand->show_brand_lock();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Danh sách loại sản phẩm đã xoá</h2>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col" style="width: 10%">#</th>
                    <th scope="col" style="width: 10%">ID</th>
                    <th scope="col" style="width: 25%">Danh mục</th>
                    <th scope="col" style="width: 25%">Tên loại sản phẩm</th>
                    <th scope="col" style="width: 35%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($show_brand_lock) {
                            $i = 0;
                            while($result = $show_brand_lock->fetch_assoc()) { 
                                $i++; 
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["category_id"] ?></td>
                        <td><?php echo $result["category_name"] ?></td>
                        <td><?php echo $result["brand_name"] ?></td>
                        <td>
                        <a href="brand-lock-edit.php?brand_id=<?php echo $result['brand_id'] ?>" class="btn btn-dark">Khôi phục</a>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#<?php echo $result["brand_name"]?>">Xoá vĩnh viễn</a>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="<?php echo $result["brand_name"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Xoá loại sản phẩm</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn xoá vĩnh viễn <strong><?php echo $result["brand_name"];?></strong>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                    <a href="brand-delete.php?brand_id=<?php echo $result['brand_id'] ?>" class="btn btn-danger">Xoá</a>
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