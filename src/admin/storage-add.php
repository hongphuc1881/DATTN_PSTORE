<?php
session_start();
ob_start();
if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
    include("./database.php");
    include("./header.php");
    include("./menu.php");
    include("./footer.php");
    include("./class/product-class.php");

?>

<?php
    $Product = new Product;
    if($_SERVER["REQUEST_METHOD"] == "POST" ) {
        $product_id = $_POST['product_id'];
        $size_id = $_POST['size_id'];
        $quantity = $_POST['quantity'];
        $select_productId_sizeId = $Product->select_productId_sizeId($product_id, $size_id);
        //var_dump($select_productId_sizeId);exit();
        if(!$select_productId_sizeId) {
            $insert_storage = $Product->insert_storage($product_id, $size_id, $quantity);
            header("location: storage-list.php");
        } else {
            echo "<script>alert('Sản phẩm đã có trong kho')</script>";
        }
    }
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Thêm kho hàng</h2>
            <form action="" method="POST">
                <div class="form-group mt-4">
                     <label for="product_name" class="h6">Tên sản phẩm:</label>
                    <select name="product_id" id="product_name"  class="form-select">
                        <?php 
                            $show_product = $Product->show_product();
                            if($show_product) {
                                while($rs = $show_product->fetch_assoc()) {
                        ?>
                            <option value="<?php  echo $rs["product_id"] ?>"><?php echo $rs["product_name"] ?></option>
                        <?php 
                             }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group mt-4">
                     <label for="product_size" class="h6">Size sản phẩm:</label>
                     <select name="size_id" id="product_size"  class="form-select">
                         <option value="#">--Chọn size sản phẩm--</option>
                         <?php 
                        $show_size = $Product->show_size();
                        if($show_size) {
                            while($rs = $show_size->fetch_assoc()) {
                                ?>
                        <option value="<?php  echo $rs["size_id"] ?>"><?php echo $rs["product_size"] ?></option>
                        <?php 
                         }
                        }
                        ?>
                </select>
            </div>
                <div class=" form-group mt-4">
                <label for="quantity" class="h6">Số lượng sản phẩm:</label>
                    <input type="text" class="form-control" id="quantity" name="quantity"
                        placeholder="Nhập số lượng sản phẩm"
                        onchange="
                            if(this.value == 0) this.value = 1
                        "
                        onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                        required>
                </div>
                <button type="submit" class="btn btn-dark mt-3">Thêm</button>
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