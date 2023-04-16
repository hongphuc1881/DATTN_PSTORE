
<?php 
    include("./header.php");
    
    if(isset($_SESSION["user"])) {
    $user_id = $_SESSION["user"]["user_id"];
    echo $user_id;
    $Order = new Order;
    $get_order_by_user_id = $Order->get_order_by_user_id($user_id);
    
?>
        <div class="app-container">
            <div class="container">
                <h2 class="pt-5 text-uppercase">thông tin tài khoản</h2>
                <p class="fw-bold">xin chào, <?php echo $_SESSION["user"]["fullname"] ?>!</p>

                <?php 
                    if($get_order_by_user_id) {
                    $i = 0;
                   
                ?>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col" style="width: 10%">#</th>
                        <th scope="col" style="width: 10%">Ngày</th>
                        <th scope="col" style="width: 35%">Địa chỉ</th>
                        <th scope="col" style="width: 15%">Giá trị đơn hàng</th>
                        <th scope="col" style="width: 15%">Trạng thái</th>
                        <th scope="col" style="width: 15%">Tuỳ chọn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($result = $get_order_by_user_id->fetch_assoc()) {
                        ?>
                        
                        <tr>
                            
                           <td><?php echo $result["order_id"]?></td>
                           <td><?php echo $result["order_date"]?></td>
                           <td><?php echo $result["address"]?></td>
                           <td>
                                <?php
                                    $get_order_detail = $Order->get_order_detail($result["order_id"]);
                                    if($get_order_detail) {
                                        $total = 0;
                                        while($rs = $get_order_detail->fetch_assoc()) {
                                            $total += $rs["price"] * $rs["quantity"];
                                        }
                                        echo   $formatted_number = number_format( $total,0, ',', '.');
                                    }
                                
                                ?> đ
                           </td>
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
                                <?php 
                                    if($result["status"] == 1) {
                                ?>
                                <a href="#" data-toggle="modal" data-target="#<?php echo $result["order_id"]?>" class="btn btn-danger" style="font-size: 16px;">Huỷ đơn hàng</a>
                                <?php 
                                    }
                                ?>
                            </td>
                             <!-- Modal -->
                         <div  class="modal fade" id="<?php echo $result["order_id"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Huỷ đơn hàng</h3>
                                    <button type="button" class="close btn btn-close" data-dismiss="modal" aria-label="Close">
                                        
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn có chắc chắn muốn huỷ đơn hàng mã <strong><?php echo $result["order_id"];?></strong></p>
                                    <p>Hãy cân nhắc trước khi huỷ đơn hàng này!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary h3" data-dismiss="modal"  style="font-size: 16px;">Huỷ</button>
                                    <a href="./admin./order-cancel.php?order_id=<?php echo $result["order_id"]?>" class="btn btn-danger" style="font-size: 16px;">Xác nhận</a>
                                </div>
                                </div>
                            </div>
                        </div>
                        </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                </table>
                <?php 
                    } else {
                ?>  
                    <p>Không có đơn hàng nào.</p>
                <?php
                    }  
                ?>
            </div>
        </div>
<?php
    include("./footer.php");
    } else {
        include("./admin/404.php");
    }
?>
