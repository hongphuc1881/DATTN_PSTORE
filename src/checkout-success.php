<?php 
    include("./header.php");
    if(isset($_SESSION["user"])) {
   
?>
        <div class="app-container">
            <div class="container">
                <div class="row justify-content-center">
                  <div class="col-6 text-center">
                        <div style="font-size: 76px;"><i class="fa-solid fa-circle-check" style="color: #2cf243;"></i></div>
                        <h2 style="color: #2cf243;">Đặt hàng thành công</h2>
                        <p>Cảm ơn <strong><?php echo $_SESSION["user"]["fullname"];?></strong> đã đặt hàng tại PStore</p>
                        <p>Đơn hàng của bạn đã được tiếp nhận và dự kiến giao trong vòng 48h</p>
                  </div>
                </div>
            </div>
        </div>
<?php 
     
     include("./footer.php");
    } else {
        include("./admin/404.php");
    }
?>