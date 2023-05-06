<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] != 3) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/user-class.php");
?>

<?php 
    $User = new User;
    $show_contact = $User->show_contact();
    // phan trang
    // 1.tong so ban ghi
    if($show_contact) {
        $total_order = $show_contact->num_rows;
        // 2. thiet lap so ban ghi tren 1 trang
        $limit = 10;
        // 3. tinh so trang 
        $page = ceil($total_order/$limit);
        // 4. lay trang hien tai
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1 ;
    
        //5. start
        $start = ($current_page - 1) * $limit;
        //6: query
        $show_contact_pagination = $User->show_contact_pagination($limit, $start);
    }
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Danh sách danh mục</h2>
            <table class="table">
                <thead >
                    <tr>
                    <th scope="col" style="width: 5%">#</th>
                    <th scope="col" style="width: 15%">Tên khách hàng</th>
                    <th scope="col" style="width: 15%">Email</th>
                    <th scope="col" style="width: 15%">Số điện thoại</th>
                    <th scope="col" style="width: 15%">Trạng thái</th>
                    <th scope="col" style="width: 30%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($show_contact_pagination) {
                            $i = 0;
                            while($result = $show_contact_pagination->fetch_assoc()) { 
                                $i++; 
                    ?>
                    <tr>

                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["username"] ?></td>
                        <td><?php echo $result["email"] ?></td>
                        <td><?php echo $result["phone"] ?></td>
                        <?php 
                            if($result["status"] == 0) {
                        ?>
                            <td class="text-danger"><?php echo "chưa đọc";?></td>
                        <?php
                             } else if($result["status"] == 1){
                        ?>
                            <td class="text-success"><?php echo "Đã đọc";?></td>
                        <?php
                            }
                            
                        ?>
                        <td>
                        <a href="./contact-detail.php?contact_id=<?php echo $result["contact_id"]?>" class="btn btn-dark">Xem chi tiết</a>
                        <a href="#" data-toggle="modal" data-target="#<?php echo $result["contact_id"]?>" class="btn btn-danger">Xoá</a>
                        </td>
                         <!-- Modal -->
                         <div class="modal fade" id="<?php echo $result["contact_id"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Huỷ đơn hàng</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn xoá liên hệ của <strong> <?php echo $result["username"];?></strong>.
                                    <p class="text-danger">Việc làm này sẽ không thể khôi phục lại</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                    <a href="./contact-delete.php?contact_id=<?php echo $result["contact_id"]?>" class="btn btn-danger">Xác nhận</a>

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
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php 
                            if($current_page - 1 > 0) {
                         ?>
                            <li class="page-item">
                                <a class="page-link" href="order-list.php?page=<?php  echo $current_page -1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php 
                            for ($i=1; $i <= $page ; $i++) { 
                        ?>
                                <li class="page-item <?php echo $i == $current_page ? "active": ""?>"><a class="page-link" href="order-list.php?page=<?php echo $i ?>"><?php echo  $i ?></a></li>
                        <?php 
                                }   
                        ?>
                        
                        <?php
                            if($current_page + 1 <= $page) {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="order-list.php?page=<?php echo $current_page + 1;?>" aria-label="Next">
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