<?php 
    session_start();
    include("./admin/class/brand-class.php");
?>
<?php 
    $Brand = new Brand;
    $show_category = $Brand->show_category();
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>PStore</title>
        <link rel="stylesheet" href="../assets/font/fontawesome-free-6.3.0-web/css/all.min.css" />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
            crossorigin="anonymous"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="../assets/lib/owlcarousel/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="../assets/lib/owlcarousel/assets/owl.theme.default.css" />
        <link rel="stylesheet" href="../assets/css/header.css" />
        <link rel="stylesheet" href="../assets/css/footer.css" />
        <link rel="stylesheet" href="../assets/css/responsive.css" />
        <link rel="stylesheet" href="../assets/css/globalStyle.css" />
        <link rel="stylesheet" href="../assets/css/product-detail.css" />
        <link rel="stylesheet" href="../assets/css/validator.css" />
        <link rel="stylesheet" href="../assets/css/cart.css" />
        <link rel="stylesheet" href="../assets/css/checkout.css" />
        <link rel="stylesheet" href="../assets/css/login.css">
        <link rel="stylesheet" href="../assets/css/index.css" />
    </head>
    <body>
        <div id="app">
            <!-- header -->
            <header>
                <div class="header-top d-flex align-items-center">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-2 col-2">
                                <div class="logo">
                                    <a href="./index.php">
                                        <img src="../assets/img/logo.png" alt="" />
                                    </a>
                                </div>
                            </div>
                            <div
                                class="col-lg-7 col-md-6 d-none d-lg-flex d-md-flex justify-content-lg-end justify-content-md-center"
                            >
                                <div class="header-search">
                                    <input type="text" placeholder="Tìm kiếm" />
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-9 d-flex justify-content-end gap-4">
                                <div class="user">
                                    <!--<div><i class="fa-solid fa-user"></i> Tài khoản</div>-->
                                    <div class="dropdown">
                                        <button
                                            class="border-0 bg-white"
                                            type="button"
                                            id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            <i class="fa-solid fa-user"></i> <?php echo isset($_SESSION["user"]) ? $_SESSION["user"]["username"] : "Tài khoản" ;?>
                                        </button>
                                        <?php if(isset($_SESSION["user"])){
                                            if($_SESSION["user"]["role"] == 1) {
                                        ?>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="./admin/index.php">Trang admin</a></li>
                                                <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                                            </ul>
                                        <?php  
                                            } else {
                                        ?> 
                                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="account.php">Thông tin tài khoản</a></li>
                                                <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                                            </ul>
                                        <?php
                                            }
                                        } else {

                                        ?>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="register.php">Đăng ký</a></li>
                                                <li><a class="dropdown-item" href="login.php">Đăng nhập</a></li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                 
                                </div>
                                <div class="cart">
                                    <a href="./cart.html">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        Giỏ hàng (<span>0</span>)
                                    </a>
                                </div>
                            </div>
                            <div class="d-lg-none d-md-none col-1 d-flex justify-content-end h2">
                                <label for="menu-mobile">
                                    <i class="fa-solid fa-bars"></i>
                                </label>
                                <input type="checkbox" id="menu-mobile" hidden />
                                <ul class="menu-mobile">
                                    <label for="menu-mobile"><i class="fa-solid fa-xmark"></i></label>
                                    <li class="mt-5"><a href="">ALL</a></li>
                                    <li><a href="">NIKE</a></li>
                                    <li><a href="">ADIDAS</a></li>
                                    <li><a href="">VANS</a></li>
                                    <li><a href="">CONVERSE</a></li>
                                </ul>
                                <label for="menu-mobile" class="overlay"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="header-navbar d-none d-lg-block d-md-block">
                    <div class="container">
                        <ul class="menu">
                            <li><a href="./index.php">home</a></li>
                            <li><a href="">all</a></li>
                            <?php 
                                while($result = $show_category->fetch_assoc()) {
                            ?>
                                <li>
                                    <a href="index.php?category_id=<?php  echo $result["category_id"];?>"><?php echo $result["category_name"] ?></a>
                                <ul>
                                    <?php 
                                        $show_group_brand = $Brand->show_group_brand($result["category_id"]);
                                        while( $rs = $show_group_brand->fetch_assoc()) {
                                    ?>
                                        <li><a href=""><?php echo $rs["brand_name"] ?></a></li>
                                    <?php 
                                        }
                                    ?>
                                  
                                </ul>
                            </li>
                            <?php 
                                }
                            ?>

                            
                            
                        </ul>
                    </div>
                </nav>
            </header>