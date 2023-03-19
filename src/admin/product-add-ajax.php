<?php 
    include("./database.php");
    include("./class/product-class.php");
    $Product = new Product;
    $category_id = $_GET["category_id"];
?>

<?php 
    $show_brand_ajax = $Product->show_brand_ajax($category_id);
    if($show_brand_ajax) {
        while($result = $show_brand_ajax->fetch_assoc()){
?>
    <option value="<?php echo $result["brand_id"] ?>"><?php echo $result["brand_name"]?></option>
<?php 
        }
    }
?>