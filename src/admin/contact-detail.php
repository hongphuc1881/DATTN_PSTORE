<?php
    ob_start();
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] != 3) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/user-class.php");
?>

<?php 
    if($_GET["contact_id"]) {
        $contact_id = $_GET["contact_id"];
      
        $User = new User;
        $get_contact_by_id = $User->get_contact_by_id($contact_id);
        if($get_contact_by_id) {
            $result = $get_contact_by_id->fetch_assoc();
        }
    }
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Chi tiết liên hệ</h2>
            <p>Tên khách hàng:<strong> <?php echo $result["username"];?></strong> </p>
            <p>Email:<strong> <?php echo $result["email"];?></strong> </p>
            <p>Điện thoại:<strong> <?php echo $result["phone"];?></strong> </p>
            <p>Nội dung liên hệ:<strong> <?php echo $result["content"];?></strong> </p>
           
            <a class="btn btn-dark" target="_blank" href="mailto:<?php echo $result["email"]; ?>">Phản hồi</a>
           
        </div>
    </main>
</div>

</div>
<?php 
        error_reporting(E_ERROR | E_PARSE);
        $a = $User->update_status_contact($contact_id);

    } else {
        include("./404.php");
    }
?>
