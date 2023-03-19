<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/product-class.php");
?>

<?php
    $Product = new Product;
    if(!isset($_GET["product_id"]) || $_GET["product_id"] == NULL) {
        echo "<script>window.location.href = './brand-list.php'</script>";
    }else {
        $product_id = $_GET["product_id"];
    }
    //$get_brand = $Brand->get_brand($brand_id);
    $get_product = $Product->get_product($product_id);
    
    if($get_product) {
        $result = $get_product->fetch_assoc();
    }
    $get_size = $Product->get_size($product_id);
    
    if($get_size) {
        $rs1 = $get_size -> fetch_assoc();
    }
    // convert string to array
    $rs1['sizes']=(explode("," ,$rs1["sizes"]));


    //sửa
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        //echo "<pre>";
        //var_dump($_POST);
        //var_dump($_FILES);

        //echo "</pre>";
        $Product->update_product($product_id, $_POST, $_FILES);
        echo "<script>window.location.href = 'product-list.php'</script>";
    }

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Sửa sản phẩm</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class=" form-group mt-3">
                    <label for="product_name" class="h6">Tên sản phẩm:</label>
                    <input type="text" class="form-control" id="product_name" name="product_name"
                        placeholder="Nhập tên sản phẩm" value="<?php echo $result["product_name"] ?>" required>
                </div>
                <div class=" form-group mt-3">
                    <label for="category_id" class="h6">Tên danh mục:</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">--Chọn danh mục--</option>
                        <?php 
                        $show_category = $Product->show_category();
                        if($show_category) {
                            while($rs = $show_category->fetch_assoc()) {
                    ?>
                        <option <?php if($result["category_id"] == $rs["category_id"]){echo "SELECTED";}?> value="<?php  echo $rs["category_id"] ?>"><?php echo $rs["category_name"] ?></option>
                    <?php 
                         }
                        }
                    ?>
                    </select>
                </div>
                <div class=" form-group mt-3">
                    <label for="brand_id" class="h6">Tên loại sản phẩm:</label>
                    <select name="brand_id" id="brand_id" class="form-select" required>
                        <option value="">--Chọn loại sản phẩm--</option>
                        <!-- product-add-ajax -->
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label  class="h6">Size sản phẩm:</label><br>
                    <input name="product_size[]" type="checkbox" value="36" id="size-36" <?php echo in_array("36", $rs1['sizes']) ? "checked": "" ?> >
                    <label class="form-check-label" for="size-36">
                        36
                    </label> &nbsp;
                    <input name="product_size[]" type="checkbox" value="37" id="size-37" <?php echo in_array("37", $rs1['sizes']) ? "checked": "" ?>>
                    <label class="form-check-label" for="size-37">
                        37
                    </label> &nbsp;
                    <input name="product_size[]" type="checkbox" value="38" id="size-38" <?php echo in_array("38", $rs1['sizes']) ? "checked": "" ?>>
                    <label class="form-check-label" for="size-38">
                        38
                    </label> &nbsp;
                    <input name="product_size[]" type="checkbox" value="39" id="size-39" <?php echo in_array("39", $rs1['sizes']) ? "checked": "" ?>>
                    <label class="form-check-label" for="size-39">
                        39
                    </label> &nbsp;
                    <input name="product_size[]" type="checkbox" value="40" id="size-40" <?php echo in_array("40", $rs1['sizes']) ? "checked": "" ?>>
                    <label class="form-check-label" for="size-40">
                        40
                    </label> &nbsp;
                    <input name="product_size[]" type="checkbox" value="41" id="size-41" <?php echo in_array("41", $rs1['sizes']) ? "checked": "" ?>>
                    <label class="form-check-label" for="size-41">
                        41
                    </label> &nbsp;
                    <input name="product_size[]" type="checkbox" value="42" id="size-42" <?php echo in_array("42", $rs1['sizes']) ? "checked": "" ?>>
                    <label class="form-check-label" for="size-42">
                        42
                    </label> &nbsp;
                    </div>
                <div class=" form-group mt-3">
                    <label for="product_price_old" class="h6">Giá sản phẩm:</label>
                    <input type="text" class="form-control" id="product_price_old" name="product_price_old" value="<?php echo $result["product_price_old"] ?>"
                        placeholder="Nhập giá sản phẩm" required>
                </div>
                <div class=" form-group mt-3">
                    <label for="product_price_new" class="h6">Giá khuyến mãi:</label>
                    <input type="text" class="form-control" id="product_price_new" name="product_price_new" value="<?php echo $result["product_price_new"] ?>"
                        placeholder="Nhập giá khuyến mãi" required>
                </div>
                <div class="form-group mt-3">
                    <label for="product_description" class="h6">Mô tả sản phẩm:</label>
                    <textarea value="<?php echo $result['product_description']?>" class="form-control" id="product_description" name="product_description" rows="5" ></textarea>
                </div>
                <div class=" form-group mt-3">
                    <label for="product_img_main" class="h6">Ảnh chính:</label>
                    <input type="file" class="form-control" id="product_img_main" name="product_img_main" accept="image/png, image/jpeg, image/webp" required>
                </div>
                <div class=" form-group mt-3">
                    <label for="product_img_description" class="h6">Ảnh mô tả:</label>
                    <input type="file" class="form-control" id="product_img_description" name="product_img_description[]"  accept="image/png, image/jpeg, image/webp" multiple>
                </div>
                <div class=" form-group mt-3">
                    <label for="is_hot" class="h6">Sản phẩm nổi bật:</label>
                    <select name="is_hot" id="is_hot" class="form-select" required>
                        <option value="0">Không</option>
                        <option value="1">Có</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark mt-3">Sửa</button>
            </form>
        </div>
    </main>
</div>
</div>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor 4
    // instance, using default configuration.
    CKEDITOR.replace( 'product_description' );
</script>
<script>
    //gửi dữ liệu sang file product-add-ajax.php để sử lý mỗi khi chọn danh mục
    // thì loại sản phẩm sẽ thay đổi theo danh mục đó
    $(document).ready(function() {

        $('#category_id').change(function() {
            var category_id = $(this).val();
            $.ajax({
                url: "product-add-ajax.php",
                method: "GET",
                data: {category_id: category_id},
                success: function (data) {
                    $('#brand_id').html(data);
                }
            })
        })
    })
</script>

<?php 
    } else {
        include("./404.php");
    }
?>