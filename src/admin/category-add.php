<?php
session_start();
if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
    include("./header.php");
    include("./menu.php");
    include("./footer.php");
    include("./class/category-class.php");

?>

<?php
    $Category = new Category;
    if($_SERVER["REQUEST_METHOD"] == "POST" ) {
        if(isset($_POST["category_name"])) {
            $category_name = $_POST["category_name"];
            $Category->insert_category($category_name);
            echo "<script>window.location.href = 'category-list.php' </script>";
        }
    }
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Thêm danh mục</h2>
            <form action="" method="POST">
                <div class=" form-group mt-4">
                    <input type="text" class="form-control" id="category_name" name="category_name"
                        placeholder="Nhập danh mục muốn thêm" required>
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