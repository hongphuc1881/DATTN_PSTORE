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
    $show_brand = $Brand->show_brand();

     // phan trang
    // 1.tong so ban ghi
    $total_brand = $show_brand->num_rows;
    // 2. thiet lap so ban ghi tren 1 trang
    $limit = 7;
    // 3. tinh so trang 
    $page = ceil($total_brand/$limit);
    // 4. lay trang hien tai
    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1 ;

    //5. start
    $start = ($current_page - 1) * $limit;
    //6: query
    $brand_pagination = $Brand->brand_pagination($limit, $start);
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Danh sách loại sản phẩm</h2>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col" style="width: 10%">#</th>
                    <th scope="col" style="width: 20%">Danh mục</th>
                    <th scope="col" style="width: 55%">Loại sản phẩm</th>
                    <th scope="col" style="width: 15%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($brand_pagination) {
                            $i = 0;
                            while($result = $brand_pagination->fetch_assoc()) { 
                                $i++; 
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["category_name"] ?></td>
                        <td><?php echo $result["brand_name"] ?></td>
                        <td>
                        <a href="brand-edit.php?brand_id=<?php echo $result['brand_id'] ?>" class="btn btn-dark">Sửa</a>
                       
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#<?php echo $result["brand_name"]?>">Xoá</a>
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
                                    Bạn có chắc chắn muốn xoá <strong><?php echo $result["brand_name"];?></strong>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                     <a href="brand-lock.php?brand_id=<?php echo $result['brand_id'] ?>" class="btn btn-danger">Xoá</a>
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
                                <a class="page-link" href="brand-list.php?page=<?php  echo $current_page -1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php 
                            for ($i=1; $i <= $page ; $i++) { 
                        ?>
                                <li class="page-item <?php echo $i == $current_page ? "active": ""?>"><a class="page-link" href="brand-list.php?page=<?php echo $i ?>"><?php echo  $i ?></a></li>
                        <?php 
                                }   
                        ?>
                        
                        <?php
                            if($current_page + 1 <= $page) {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="brand-list.php?page=<?php echo $current_page + 1;?>" aria-label="Next">
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

