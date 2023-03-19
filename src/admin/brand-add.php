<?php 
    session_start();
?>
<?php
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/brand-class.php");
?>

<?php
  $Brand = new Brand;
  if($_SERVER['REQUEST_METHOD']  == "POST") {
    $category_id = $_POST['category_id'];
    $brand_name = $_POST['brand_name'];
    $insert_brand = $Brand->insert_brand($category_id, $brand_name);
  }
  
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Thêm loại sản phẩm</h2>
            <form action="" method="POST">
                <select name="category_id" id=""  class="form-select">
                    <option value="#">--Chọn danh mục--</option>
                    <?php 
                        $show_category = $Brand->show_category();
                        if($show_category) {
                            while($rs = $show_category->fetch_assoc()) {
                    ?>
                        <option value="<?php  echo $rs["category_id"] ?>"><?php echo $rs["category_name"] ?></option>
                    <?php 
                         }
                        }
                    ?>
                </select>
                <div class=" form-group mt-4">
                    <input type="text" class="form-control" id="brand_name" name="brand_name"
                        placeholder="Nhập loại sản phẩm muốn thêm" required>
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