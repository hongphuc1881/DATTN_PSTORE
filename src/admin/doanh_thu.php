<?php
session_start();
ob_start();
if (isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
    include("./database.php");
    include("./header.php");
    include("./menu.php");
    include("./footer.php");
    include("./class/product-class.php");
    include("./class/order-class.php");
    

    $Product = new Product;
    $Order = new Order;
    if(isset($_GET["year"])) {
        $year = $_GET["year"];
    } else {
        $year =  date("Y");
    }
    $select_product_in_storage = $Product->select_product_in_storage();
    $calculate_total_price_per_month = $Order->calculate_total_price_per_month($year);
    if(!$calculate_total_price_per_month) {
        header("location: index.php");
    }
    $monthArray = [];
    $totalPriceArray = [];
    while($row = $calculate_total_price_per_month->fetch_assoc()) {
        $monthArray[] = $row["month"];
        $totalPriceArray[] = $row["total_price"];
    }

   
    //var_dump($monthArray);
    //var_dump($calculate_total_price_per_month->fetch_assoc());exit();
?>
    <!--<link href="css/styles.css" rel="stylesheet" />-->
    <!--<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>-->

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Thống kê doanh thu</h1>
                <a class="d-inline-block bg-info text-white text-decoration-none px-3 py-2 rounded-2" href="?year=2022">2022</a>
                <a class="d-inline-block bg-info text-white text-decoration-none px-3 py-2 rounded-2" href="?year=2023">2023</a>
               
                <div class="mb-5">
                    <canvas id="myChart"></canvas>
                </div>

                    

                <table class="table" style="font-size: 12px">
                    <thead style="position: sticky; top: 55px; background-color: #000; color: #fff;">
                        <tr>
                            <th scope="col" style="width: 5%">#</th>
                            <th scope="col" style="width: 40%">Tên sản phẩm</th>
                            <th scope="col" style="width: 10%">Giá nhập</th>
                            <th scope="col" style="width: 10%">Giá bán</th>
                            <th scope="col" style="width: 5%">SL nhập</th>
                            <th scope="col" style="width: 5%">SL bán</th>
                            <th scope="col" style="width: 5%">SL tồn</th>
                            <th scope="col" style="width: 10%">TT nhập</th>
                            <th scope="col" style="width: 10%">TT bán</th>
                            <th scope="col" style="width: 10%">Lợi nhuận</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        while ($result = $select_product_in_storage->fetch_assoc()) {
                            $select_product_in_order_by_product_id = $Product->select_product_in_order_by_product_id($result["product_id"]);

                            $i++;
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $result["product_name"] ?></td>

                                <td class="gia_nhap"><?php echo $formatted_number = number_format($result["product_cost"], 0, ',', '.') ?></td>
                                <td class="gia_ban"><?php echo $formatted_number = number_format($result["product_price_new"], 0, ',', '.') ?></td>
                                <td class="sl_nhap"><?php echo $result["product_price_new"] ?></td>
                                <?php
                                if ($select_product_in_order_by_product_id) {
                                    $rs = $select_product_in_order_by_product_id->fetch_assoc();
                                ?>
                                    <td class="sl_ban"><?php echo $rs["total_sell_quantity"] ?></td>
                                <?php
                                } else {
                                ?>
                                    <td class="sl_ban"><?php echo 0 ?></td>
                                <?php
                                }
                                ?>
                                <td class="sl_ton"><?php echo $result["total_quantity"] ?></td>
                                <td class="tt_nhap"></td>
                                <td class="tt_ban"></td>
                                <td class="doanh_thu"></td>
                                
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
               
            </div>
        </main>
    </div>
    

<?php
    include("./footer.php");
} else {
    include("./404.php");
}
?>

<script>
    var sl_nhap = document.querySelectorAll(".sl_nhap");

    sl_nhap.forEach(item => {
        var parentElement = item.parentElement
        var sl_ban = parentElement.querySelector('.sl_ban')
        var sl_ton = parentElement.querySelector('.sl_ton')
        var gia_nhap = parentElement.querySelector('.gia_nhap').innerText
        var gia_ban = parentElement.querySelector('.gia_ban').innerText
        var tt_nhap = parentElement.querySelector(".tt_nhap");
        var tt_ban = parentElement.querySelector(".tt_ban");
        var doanh_thu = parentElement.querySelector(".doanh_thu");

        gia_nhap = gia_nhap.replaceAll(".","")
        gia_ban = gia_ban.replaceAll(".","")
        item.innerText = +sl_ban.innerText + +sl_ton.innerText;
        
        tt_nhap.innerText = (gia_nhap * item.innerText).toLocaleString('vi-VN')
        tt_ban.innerText = (gia_ban * sl_ban.innerText).toLocaleString('vi-VN')

        tt_nhap = tt_nhap.innerText.replaceAll(".","")
        tt_ban = tt_ban.innerText.replaceAll(".","")
        doanh_thu.innerText = (tt_ban-tt_nhap).toLocaleString('vi-VN');
    })

   
   
</script>

<script src="
https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js
"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart');
    const monthArray = <?= json_encode($monthArray); ?>;
    const totalPriceArray = <?= json_encode($totalPriceArray); ?>;
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [...monthArray],
            datasets: [{
                label: 'doanh thu',
                data: [...totalPriceArray],
                borderWidth: 1,
                barPercentage: 0.2,
            }]
        },
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
        }
    });
</script>