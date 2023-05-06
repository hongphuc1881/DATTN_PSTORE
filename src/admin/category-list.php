<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/category-class.php");
?>

<?php 
    $Category = new Category;
    $show_category = $Category->show_category();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Danh sách danh mục</h2>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col" style="width: 10%">#</th>
                    <th scope="col" style="width: 10%">ID</th>
                    <th scope="col" style="width: 65%">Danh mục</th>
                    <th scope="col" style="width: 15%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($show_category) {
                            $i = 0;
                            while($result = $show_category->fetch_assoc()) { 
                                $i++; 
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["category_id"] ?></td>
                        <td><?php echo $result["category_name"] ?></td>
                        <td>
                        <a href="category-edit.php?category_id=<?php echo $result['category_id'] ?>" class="btn btn-dark">Sửa</a>
                        <!--<a href="category-lock.php?category_id=<?php echo $result['category_id'] ?>" class="btn btn-danger">Xoá</a>-->
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#<?php echo $result["category_name"]?>">Xoá</a>
                        </td>
                        <!-- Modal -->
                        <div class="modal fade" id="<?php echo $result["category_name"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Xoá danh mục</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn xoá <strong><?php echo $result["category_name"];?></strong>
                                    <p class="text-danger">Việc này sẽ làm mất hết dữ liệu trong hệ thống và không thể khôi phục lại</p>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                     <a href="category-lock.php?category_id=<?php echo $result['category_id'] ?>" class="btn btn-danger">Xoá</a>

                                    <!--<button type="button" class="btn btn-primary">Xoá</button>-->
                                </div>
                                </div>
                            </div>
                        </div>
                    </tr>
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