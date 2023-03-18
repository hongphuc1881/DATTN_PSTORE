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
    if(!isset($_GET["category_id"]) || $_GET["category_id"] == NULL) {
        echo "<script>window.location.href = 'category-list.php'</script>";
    } else {
        $category_id = $_GET["category_id"];
    }

    $get_category = $Category->get_category($category_id);
    if($get_category) {
        $result = $get_category->fetch_assoc();
    }
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $category_name = $_POST["category_name"];
        $Category->update_category($category_id, trim($category_name));
        echo "<script>window.location.href = 'category-list.php'</script>";
    }
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Sửa danh mục</h2>
            <form action="" method="POST">
                <div class=" form-group mt-4">
                    <input 
                        type="text" 
                        class="form-control" 
                        d="category_name" 
                        name="category_name"
                        placeholder="Nhập danh mục muốn thêm" 
                        required
                        value="<?php echo $result['category_name'] ?>"
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