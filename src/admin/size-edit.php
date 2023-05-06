<?php
session_start();
ob_start();
if(isset($_SESSION["user"]) &&  ($_SESSION["user"]["role"] == 1)) {
    include("./database.php");
    include("./header.php");
    include("./menu.php");
    include("./footer.php");
    include("./class/product-class.php");

?>

<?php
    $Product = new Product;
    if(isset($_GET["size_id"])) {
        $size_id = $_GET["size_id"];
    }
    $get_size = $Product->get_size_by_size_id($size_id)->fetch_assoc();

    //update
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_size = $_POST["product_size"];
        $check_size_is_already = $Product->check_size_is_already($product_size);
        if($check_size_is_already) {
            echo "<script>alert('Size sản phẩm đã có danh sách!')</script>";
        } else {
            $Product->update_size($size_id, $product_size);
            header("location: size-list.php");
        }
       
    }
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Sửa kho hàng</h2>
            <form action="" method="POST">
                <div class=" form-group mt-4">
                <label for="product_size" class="h6">Kích cỡ sản phẩm:</label>
                    <input type="text" class="form-control" id="product_size" name="product_size"
                        value="<?php echo $get_size['product_size']?>"
                        placeholder="Nhập kích cỡ sản phẩm" 
                        required
                        onchange="
                            if(this.value == 0) this.value = 1
                        "
                        onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                       
                    >
                </div>
                <button type="submit" class="btn btn-dark mt-3">Sửa</button>
            </form>
        </div>
    </main>
</div>
</div>
<?php 
    } else {
        include("./404.php");
    }
?>