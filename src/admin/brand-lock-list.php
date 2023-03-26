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
                        <a href="brand-delete.php?brand_id=<?php echo $result['brand_id'] ?>" class="btn btn-danger">Xoá vĩnh viễn</a>
                        </td>
                    </tr>
                    <!-- Modal -->
                    
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