<?php
    session_start();
     if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] != 3) {
     include("../database.php");
     include("./class/product-class.php");
     include("./class/order-class.php");
    define("_SYSTEM_TTFONTS", "../fonts");
    require('../../assets/lib/tfpdf/tfpdf.php');

    function convert_number_to_words($number) {
        $hyphen      = ' ';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'âm ';
        $decimal     = ' phẩy ';
        $dictionary  = array(
        0                   => 'Không',
        1                   => 'Một',
        2                   => 'Hai',
        3                   => 'Ba',
        4                   => 'Bốn',
        5                   => 'Năm',
        6                   => 'Sáu',
        7                   => 'Bảy',
        8                   => 'Tám',
        9                   => 'Chín',
        10                  => 'Mười',
        11                  => 'Mười một',
        12                  => 'Mười hai',
        13                  => 'Mười ba',
        14                  => 'Mười bốn',
        15                  => 'Mười năm',
        16                  => 'Mười sáu',
        17                  => 'Mười bảy',
        18                  => 'Mười tám',
        19                  => 'Mười chín',
        20                  => 'Hai mươi',
        30                  => 'Ba mươi',
        40                  => 'Bốn mươi',
        50                  => 'Năm mươi',
        60                  => 'Sáu mươi',
        70                  => 'Bảy mươi',
        80                  => 'Tám mươi',
        90                  => 'Chín mươi',
        100                 => 'trăm',
        1000                => 'nghìn',
        1000000             => 'triệu',
        1000000000          => 'tỷ',
        1000000000000       => 'nghìn tỷ',
        1000000000000000    => 'ngàn triệu triệu',
        1000000000000000000 => 'tỷ tỷ'
        );
        
        if (!is_numeric($number)) {
        
        return false;
        
        }
        
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        
        // overflow
        
        trigger_error(
        
        'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
        
        E_USER_WARNING
        
        );
        
        return false;
        
        }
        
        if ($number < 0) {
        
        return $negative . convert_number_to_words(abs($number));
        
        }
        
        $string = $fraction = null;
        
        if (strpos($number, '.') !== false) {
        
        list($number, $fraction) = explode('.', $number);
        
        }
        
        switch (true) {
        
        case $number < 21:
        
        $string = $dictionary[$number];
        
        break;
        
        case $number < 100:
        
        $tens   = ((int) ($number / 10)) * 10;
        
        $units  = $number % 10;
        
        $string = $dictionary[$tens];
        
        if ($units) {
        
        $string .= $hyphen . $dictionary[$units];
        
        }
        
        break;
        
        case $number < 1000:
        
        $hundreds  = $number / 100;
        
        $remainder = $number % 100;
        
        $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
        
        if ($remainder) {
        
        $string .= $conjunction . convert_number_to_words($remainder);
        
        }
        
        break;
        
        default:
        
        $baseUnit = pow(1000, floor(log($number, 1000)));
        
        $numBaseUnits = (int) ($number / $baseUnit);
        
        $remainder = $number % $baseUnit;
        
        $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
        
        if ($remainder) {
        
        $string .= $remainder < 100 ? $conjunction : $separator;
        
        $string .= convert_number_to_words($remainder);
        
        }
        
        break;
        
        }
        
        
        
        if (null !== $fraction && is_numeric($fraction)) {
        
        $string .= $decimal;
        
        $words = array();
        
        foreach (str_split((string) $fraction) as $number) {
        
        $words[] = $dictionary[$number];
        
        }
        
        $string .= implode(' ', $words);
        
        }
        
        return $string;
        
        }

    


    if($_GET["order_id"]) {
        $order_id = $_GET["order_id"];
        $Order = new Order;
        $Product = new Product;
        $get_order_by_order_id = $Order->get_order_by_order_id($order_id);
        $get_order_detail = $Order->get_order_detail($order_id);

        if($get_order_by_order_id) {
            $result = $get_order_by_order_id->fetch_assoc();
        }
    }



    $pdf = new tFPDF();
    $pdf->AddPage("0");

    // Add a Unicode font (uses UTF-8)
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $pdf->SetFont('DejaVu','',14);

    //// Load a UTF-8 string from a file and print it
    //$txt = 'HelloWorld.txt ô kê';
    //$pdf->Write(0,$txt);

    $pdf->Write(8,'HOÁ ĐƠN BÁN HÀNG');
	$pdf->Ln(10);
    $pdf->Write(8,'Tên khách hàng: '.$result["fullname"]);
	$pdf->Ln(10);
    $pdf->Write(8,'Mã đơn hàng: '.$result["order_id"]);
	$pdf->Ln(10);
    $pdf->SetFillColor(255,255,255);
	$width_cell=array(10,120,30,30,30,40);
    $pdf->Cell($width_cell[0],10,'STT',1,0,'C',true);
	$pdf->Cell($width_cell[1],10,'Tên sản phẩm',1,0,'C',true);
	$pdf->Cell($width_cell[2],10,'Size',1,0,'C',true); 
	$pdf->Cell($width_cell[3],10,'Số lượng',1,0,'C',true); 
	$pdf->Cell($width_cell[4],10,'Đơn Giá',1,0,'C',true);
	$pdf->Cell($width_cell[5],10,'Thành tiền',1,0,'C',true);
    $pdf->Ln(10);
	$fill=false;
	$i = 0;
    $total_price = 0;
	while($row = $get_order_detail->fetch_assoc() ){
        $get_product = $Product->get_product($row["product_id"])->fetch_assoc();
        $thanh_tien = $row["price"]  * $row["quantity"];
        $total_price += $thanh_tien;
		$i++;
        $size_id = $row["size_id"];
        $show_size = $Product->get_product_size_by_size_id($size_id)->fetch_assoc();

        $pdf->Cell($width_cell[0],10,$i,1,0,'C',$fill);
        $pdf->Cell($width_cell[1],10,strtoupper($get_product["product_name"]),1,0,'C',$fill);
        $pdf->Cell($width_cell[2],10,$show_size["product_size"],1,0,'C',$fill);
        $pdf->Cell($width_cell[3],10,$row['quantity'],1,0,'C',$fill);
        $pdf->Cell($width_cell[4],10,number_format( $row["price"], 0, ',', '.'),1,0,'C',$fill);
        $pdf->Cell($width_cell[5],10,number_format($thanh_tien, 0, ',', '.'),1,0,'C',$fill);
        $fill = !$fill;
        $pdf->Ln(10);

	}
   
  
	$pdf->Cell(220,10,'Tổng cộng',1,0,'R',true);
	$pdf->Cell(40,10,number_format($total_price, 0, ',', '.'),1,0,'C',true); 
    $pdf->Ln(15);
	

   
    $word = convert_number_to_words($total_price);
    $pdf->Write(10, ucwords($word.' Đồng Chẵn.'));
	$pdf->Ln(10);
	$pdf->Write(10,'Cảm ơn quý khách đã đặt hàng tại PStore.');
	$pdf->Ln(10);
	$pdf->Write(10,'Chúng tôi rất hân hạnh được phục vụ quý khách.');
	$pdf->Ln(10);
    


    
        
   

   
    $pdf->Output();

} else {
    include("./404.php");
}
?>