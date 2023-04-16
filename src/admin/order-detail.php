<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] != 3) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/order-class.php");
        include("./class/product-class.php");
?>

<?php 
    if($_GET["order_id"]) {
        $order_id = $_GET["order_id"];
        $Order = new Order;
        $Product = new Product;
        $get_order_by_order_id = $Order->get_order_by_order_id($order_id);
        $get_order_detail = $Order->get_order_detail($order_id);

        if($get_order_by_order_id) {
            $result1 = $get_order_by_order_id->fetch_assoc();
        }
        if($result1["status"] == 2) {
            $Product->subtract_product_quantity($order_id);
        }
        var_dump($result1["status"]);
    }
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Chi tiết đơn hàng</h2>
            <div class="row">
                <div class="col-lg-6">
                <p>Tên khách hàng:<strong> <?php echo $result1["fullname"];?></strong> </p>
                <p>Email:<strong> <?php echo $result1["email"];?></strong> </p>
                <p>Điện thoại:<strong> <?php echo $result1["phone"];?></strong> </p>
                <p>Ghi chú:<strong> <?php echo $result1["note"];?></strong> </p>
            </div>
            <div class="col-lg-6">
                <p>Điạ chỉ:<strong> <?php echo $result1["address"];?></strong> </p>
            <p>Ngày đặt hàng:<strong> <?php echo $result1["order_date"];?></strong> </p>
            <p>Trạng thái đơn hàng:
                <strong> 
                    <?php 
                        if($result1["status"] == 1) {
                            ?>
                        <td class="text-info"><?php echo "Đang chờ xử lý";?></td>
                    <?php
                        } else if($result1["status"] == 2){
                    ?>
                            <td class="text-success"><?php echo "Đã giao hàng";?></td>
                    <?php
                        }
                        else if($result1["status"] == 3){
                    ?>
                            <td class="text-danger"><?php echo "Đã huỷ đơn";?></td>
                    <?php 
                        }
                    ?>
                </strong> </p>
                <?php 
                        if($result1["status"] == 1) {
                ?>
                    <select name="" class="form-select" id="xulydonhang">
                        <option id="<?php echo $result1["order_id"]?>" value="#">--Chọn phương thức xử lý--</option>
                        <option id="<?php echo $result1["order_id"]?>" value="2">Xác nhận đơn hàng</option>
                        <option id="<?php echo $result1["order_id"]?>" value="3">Huỷ đơn hàng</option>
                    </select>
                    <a class="btn btn-dark mt-3" href="#" onclick="window.location.reload(true);">Xác nhận</a>
                <?php
                    } 
                ?>
            </div>
            </div>
        
            <table class="table mt-5">
                <thead>
                    <tr>
                    <th scope="col" style="width: 5%">#</th>
                    <th scope="col" style="width: 30%">Tên sản phẩm</th>
                    <th scope="col" style="width: 5%">hình ảnh</th>
                    <th scope="col" style="width: 10%">Số lượng</th>
                    <th scope="col" style="width: 10%">Đơn giá</th>
                    <th scope="col" style="width: 10%">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($get_order_detail) {
                            $i = 0;
                            $total_price = 0;
                            while($result = $get_order_detail->fetch_assoc()) { 
                                $thanh_tien = $result["price"]  * $result["quantity"];
                                $total_price += $thanh_tien;
                                $i++; 
                            $get_product = $Product->get_product($result["product_id"])->fetch_assoc();

                    ?>
                    <tr style="line-height: 100px;">

                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $get_product["product_name"]?></td>
                        <td>
                            <img style="width: 100px;" src="./uploads/<?php echo $get_product["product_img_main"] ?>" alt="">
                        </td>
                        <td><?php echo $result["quantity"] ?></td>
                        <td><?php echo   $formatted_number = number_format( $result["price"], 0, ',', '.');?>đ</td>
                        <td><?php echo   $formatted_number = number_format( $thanh_tien, 0, ',', '.');?>đ</td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-end">Tổng tiền:<strong> <?php echo   $formatted_number = number_format( $total_price, 0, ',', '.');?>đ</strong></td>
                    </tr>
                </tfoot>
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

<script>
    $('#xulydonhang').change(function () {
        const value = $(this).val();
        const order_id = $(this).find(':selected').attr('id');
        
        if(value == '#') {
            alert("Vui lòng chọn phương thức thanh toán");
        }else {
            $.ajax({
                method: 'POST',
                url:'order-confirmation-ajax.php',
                data: {value: value, order_id: order_id},
                success: function(){
                    //location.reload();
                }
            })
        }
    })
</script>