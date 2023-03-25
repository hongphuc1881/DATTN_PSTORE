<?php
    session_start();
    if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
        $cart = $_SESSION["cart"];
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Checkout</title>
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
        <link rel="stylesheet" href="../assets/css/checkout.css" />
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="main">
                        <div class="logo">
                            <a href="./index.php">
                                <img src="../assets/img/logo.png" alt="" />
                            </a>
                        </div>
                        <div class="title">Thông tin giao hàng</div>
                        <form action="" id="checkout-form">
                            <div class="form-group">
                                <label for="fullname">Họ và tên</label>
                                <input type="text" name="fullname" class="form-control" id="fullname" required />
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Số điện thoại</label>
                                <input type="text" 
                                    name="phone_number" 
                                    class="form-control" 
                                    id="phone_number" 
                                    minlength="10"
                                    maxlength="12"
                                    required 
                                    onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                                />
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required />
                            </div>
                             <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" id="address" required />
                            </div>
                            <div class="form-group">
                                <label for="not">Ghi chú</label>
                                <textarea class="form-control" name="not" id="not" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <a href="./cart.php" class="cart">Giỏ hàng</a>
                                <button type="submit">Thanh toán</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <aside class="sidebar">
                        <div class="order-summary">
                            <div class="order-summary__product-list">
                                <?php 
                                    $total_price = 0;
                                    foreach ($cart as $product_item) {
                                    $thanh_tien = $product_item[4] * $product_item[5];
                                    $total_price += $thanh_tien;
                                ?>
                                 <!--$product = array($product_id, $product_name, $product_img_main, $product_size, $price, $quantity);-->

                                <div class="order-summary__product-item">
                                    <div class="product-item-img">
                                        <img src="./admin/uploads/<?php echo $product_item[2]?>" alt="" />
                                        <div class="product-item-quantity"><?php echo $product_item[5]?></div>
                                    </div>

                                    <div class="product-item-name">
                                        <p><?php echo $product_item[1]?></p>
                                        <span class="product-item-size "><?php echo $product_item[3]?></span>
                                    </div>
                                    <div class="product-item-total-price"><span><?php echo   $formatted_number = number_format( $thanh_tien, 0, ',', '.');?></span>đ</div>
                                </div>
                                <?php 
                                    }
                                ?>
                                <!--<div class="order-summary__product-item">
                                    <div class="product-item-img">
                                        <img src="../assets/img/pd1.webp" alt="" />
                                        <div class="product-item-quantity">1</div>
                                    </div>

                                    <div class="product-item-name">
                                        <p>air jordan 1 low 'white university red'</p>
                                        <span class="product-item-size">42</span>
                                    </div>
                                    <div class="product-item-total-price"><span>1.600.000</span>đ</div>
                                </div>

                                <div class="order-summary__product-item">
                                    <div class="product-item-img">
                                        <img src="../assets/img/pd1.webp" alt="" />
                                        <div class="product-item-quantity">1</div>
                                    </div>

                                    <div class="product-item-name">
                                        <p>air jordan 1 low 'white university red'</p>
                                        <span class="product-item-size">42</span>
                                    </div>
                                    <div class="product-item-total-price"><span>1.600.000</span>đ</div>
                                </div>

                                <div class="order-summary__product-item">
                                    <div class="product-item-img">
                                        <img src="../assets/img/pd1.webp" alt="" />
                                        <div class="product-item-quantity">1</div>
                                    </div>

                                    <div class="product-item-name">
                                        <p>air jordan 1 low 'white university red'</p>
                                        <span class="product-item-size">42</span>
                                    </div>
                                    <div class="product-item-total-price"><span>1.600.000</span>đ</div>
                                </div>-->
                            </div>
                            <div class="mt-4">Miễn phí vận chuyển</div>
                            <div class="total">
                                <div>Tổng cộng:</div>
                                <div><span><?php echo   $formatted_number = number_format( $total_price, 0, ',', '.');?></span>đ</div>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-lg-3">
                    <div class="checkout-note mt-5">
                        <h5 class="text-uppercase">Chính sách thanh toán</h5>
                        <div>
                            Quý khách có thể thanh toán giao hàng với 2 hình thức sau:
                            <p>- Thanh toán khi nhận hàng [COD]</p>
                            <p>- Thanh toán thông qua số tài khoản:</p>
                            <p class="text-danger fw-bold">65851278888</p>
                            <p class="text-danger fw-bold">Nguyễn Văn Phúc</p>
                            <p class="text-danger fw-bold">TP Bank Hà Nội</p>
                        </div>
                        <p>
                            <span class="fw-bold"> Lưu ý:</span> khi chuyển khoản quý khách vui lòng điền thông tin
                            trong phần nội dung chuyển khoản
                        </p>
                        <p class="fw-bold">
                            Cảm ơn quý khách hàng đã tin tưởng và cho PStore cơ hội được phục vụ quý khách!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
} else {
    include("./admin/404.php");
}
?>