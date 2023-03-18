<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {

        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/product-class.php");
?>

<?php
    $Product = new Product;
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        ///var_dump($_FILES, $_POST);
        $Product->insert_product($_POST, $_FILES);
    }
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Thêm sản phẩm</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class=" form-group mt-3">
                    <label for="product_name" class="h6">Tên sản phẩm:</label>
                    <input type="text" class="form-control" id="product_name" name="product_name"
                        placeholder="Nhập tên sản phẩm" required>
                </div>
                <div class=" form-group mt-3">
                    <label for="category_id" class="h6">Tên danh mục:</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">--Chọn danh mục--</option>
                        <?php
                            $show_category = $Product->show_category();

                            if($show_category) {
                                while($result = $show_category->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $result["category_id"] ?>"><?php echo $result["category_name"]?></option>
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
                <input name="product_size[]" type="checkbox" value="36" id="size-36">
                <label class="form-check-label" for="size-36">
                    36
                </label> &nbsp;
                <input name="product_size[]" type="checkbox" value="37" id="size-37">
                <label class="form-check-label" for="size-37">
                    37
                </label> &nbsp;
                <input name="product_size[]" type="checkbox" value="38" id="size-38">
                <label class="form-check-label" for="size-38">
                    38
                </label> &nbsp;
                <input name="product_size[]" type="checkbox" value="39" id="size-39">
                <label class="form-check-label" for="size-39">
                    39
                </label> &nbsp;
                 <input name="product_size[]" type="checkbox" value="40" id="size-40">
                <label class="form-check-label" for="size-40">
                    40
                </label> &nbsp;
                <input name="product_size[]" type="checkbox" value="41" id="size-41">
                <label class="form-check-label" for="size-41">
                    41
                </label> &nbsp;
                <input name="product_size[]" type="checkbox" value="42" id="size-42">
                <label class="form-check-label" for="size-42">
                    42
                </label> &nbsp;
                </div>
                <div class=" form-group mt-3">
                    <label for="product_price_old" class="h6">Giá sản phẩm:</label>
                    <input type="text" class="form-control" id="product_price_old" name="product_price_old"
                        placeholder="Nhập giá sản phẩm" required>
                </div>
                <div class=" form-group mt-3">
                    <label for="product_price_new" class="h6">Giá khuyến mãi:</label>
                    <input type="text" class="form-control" id="product_price_new" name="product_price_new"
                        placeholder="Nhập giá khuyến mãi" required>
                </div>
                <div class="form-group mt-3">
                    <label for="product_description" class="h6">Mô tả sản phẩm:</label>
                    <textarea class="form-control" id="product_description" name="product_description" rows="5"></textarea>
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
                <button type="submit" class="btn btn-dark mt-3">Thêm</button>
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