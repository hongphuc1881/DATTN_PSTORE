<?php
    session_start();
    if(isset($_SESSION["user"]) && ($_SESSION["user"]["role"] == 1 || $_SESSION["user"]["role"] == 2)) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/product-class.php");
?>

<?php 
    //sua tai
    $Product = new Product;
    $show_product = $Product->show_product();

    
    // phan trang
    // 1.tong so ban ghi
    $total_product = $show_product->num_rows;
    // 2. thiet lap so ban ghi tren 1 trang
    $limit = 10;
    // 3. tinh so trang 
    $page = ceil($total_product/$limit);
    // 4. lay trang hien tai
    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1 ;

    //5. start
    $start = ($current_page - 1) * $limit;
    //6: query
    $product_pagination = $Product->product_pagination($limit, $start);

     //sort
     $field = isset($_GET["field"]) ? $_GET["field"] : "";
     $sort = isset($_GET["sort"]) ? $_GET["sort"] : "";
     
     if(!empty($field) && !empty($sort)) {
         $product_pagination = $Product->product_pagination($limit, $start, $field, $sort);
     } else {
         $product_pagination = $Product->product_pagination($limit, $start);
     }
    
?>

<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
          <div  class="d-flex justify-content-between align-items-center">
                <h2>Danh sách kho hàng</h2>
               
          </div>
            <table class="table  table-striped" id="example3">
                <thead  style="position: sticky; top: 55px; background-color: #333; color: #fff;">
                    <tr>
                    <th scope="col" style="width: 10%">#</th>
                    <th scope="col" style="width: 45%">Tên sản phẩm</th>
                    <th scope="col" style="width: 10%">Số lượng</th>
                    <th scope="col" style="width: 15%">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        if($show_product) {
                            $i = 0;
                            while($result = $show_product->fetch_assoc()) { 
                                $i++; 
                                $total_quantity_of_product = $Product->total_quantity_of_product_id($result["product_id"])->fetch_assoc();
                                
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td style=" text-transform: uppercase;"><?php echo $result["product_name"] ?></td>
                        <td><?php echo $total_quantity_of_product["total_quantity"] ?></td>
                        <td>
                        <a href="./storage-detail.php?product_id=<?php echo $result['product_id']?>" class="btn btn-dark">Chi tiết</a>
                        </td>
                    </tr>
                    <?php 
                            }
                        }
                    ?>
                </tbody>
            </table>
            <!--<div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php 
                            if($current_page - 1 > 0) {
                         ?>
                            <li class="page-item">
                                <a class="page-link" href="storage-list.php?page=<?php  echo $current_page -1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php 
                            for ($i=1; $i <= $page ; $i++) { 
                        ?>
                                <li class="page-item <?php echo $i == $current_page ? "active": ""?>"><a class="page-link" href="storage-list.php?page=<?php echo $i ?>"><?php echo  $i ?></a></li>
                        <?php 
                                }   
                        ?>
                        
                        <?php
                            if($current_page + 1 <= $page) {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="storage-list.php?page=<?php echo $current_page + 1;?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
                </nav>
          
            </div>-->
        </div>
    </main>
</div>

</div>
<?php 
    } else {
        include("./404.php");
    }
?>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>
<script>
    $(document).ready(function () {
    $('#example3').DataTable();
});
</script>
