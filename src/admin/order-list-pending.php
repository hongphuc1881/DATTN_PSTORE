<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/order-class.php");
?>

<?php 
    $Order = new Order;
    $show_order_pending = $Order->show_order_pending();
    // phan trang
    // 1.tong so ban ghi
    if($show_order_pending) {
        $total_order = $show_order_pending->num_rows;
        // 2. thiet lap so ban ghi tren 1 trang
        $limit = 6;
        // 3. tinh so trang 
        $page = ceil($total_order/$limit);
        // 4. lay trang hien tai
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1 ;
    
        //5. start
        $start = ($current_page - 1) * $limit;
        //6: query
        $show_order_pending_pagination = $Order->show_order_pending_pagination($limit, $start);
    }
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Danh sách danh mục</h2>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col" style="width: 5%">#</th>
                    <th scope="col" style="width: 5%">ID</th>
                    <th scope="col" style="width: 15%">Khách hàng</th>
                    <th scope="col" style="width: 15%">Số điện thoại</th>
                    <th scope="col" style="width: 15%">Ngày đặt hàng</th>
                    <th scope="col" style="width: 15%">Trạng thái</th>
                    <th scope="col" style="width: 30%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($show_order_pending_pagination) {
                            $i = 0;
                            while($result = $show_order_pending_pagination->fetch_assoc()) { 
                                $i++; 
                    ?>
                    <tr>

                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $result["order_id"] ?></td>
                        <td><?php echo $result["fullname"] ?></td>
                        <td><?php echo $result["phone"] ?></td>
                        <td><?php echo $result["order_date"]?></td>
                        <?php 
                            if($result["status"] == 1) {
                        ?>
                            <td class="text-info"><?php echo "Đang chờ xử lý";?></td>
                        <?php
                             } else if($result["status"] == 2){
                        ?>
                            <td class="text-success"><?php echo "Đã giao hàng";?></td>
                        <?php
                            }
                            else if($result["status"] == 3){
                        ?>
                            <td class="text-danger"><?php echo "Đã huỷ đơn";?></td>
                        <?php 
                            }
                        ?>
                        <td>
                        <a href="./order-detail.php?order_id=<?php echo $result["order_id"]?>" class="btn btn-dark">Chi tiết</a>
                        <?php 
                             if($result["status"] == 1) {
                        ?>
                        <a href="#" data-toggle="modal" data-target="#<?php echo $result["order_id"]?>" class="btn btn-danger">Huỷ đơn hàng</a>
                        <?php 
                             }
                        ?>
                        </td>
                         <!-- Modal -->
                         <div class="modal fade" id="<?php echo $result["order_id"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Huỷ đơn hàng</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn huỷ đơn hàng mã <strong><?php echo $result["order_id"];?></strong> của<strong> <?php echo $result["fullname"];?></strong>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                    <a href="./order-cancel.php?order_id=<?php echo $result["order_id"]?>" class="btn btn-danger">Huỷ đơn hàng</a>

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