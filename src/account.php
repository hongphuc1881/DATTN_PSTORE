
<?php 
    include("./header.php");
    if(isset($_SESSION["user"])) {
?>
        <div class="app-container">
            <div class="container">
                <h2 class="pt-5 text-uppercase">thông tin tài khoản</h2>
                <p class="fw-bold">xin chào, <?php echo $_SESSION["user"]["fullname"] ?> !   </p>
            </div>
        </div>
<?php
    include("./footer.php");
    } else {
        include("./admin/404.php");
    }
?>
