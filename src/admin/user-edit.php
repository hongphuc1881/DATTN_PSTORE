<?php
    session_start();
    if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == 1) {
        include("./database.php");
        include("./header.php");
        include("./menu.php");
        include("./footer.php");
        include("./class/user-class.php"); 
?>

<?php
    $User = new User;
    //$Brand = new Brand;
    if(!isset($_GET["user_id"]) || $_GET["user_id"] == NULL) {
        echo "<script>window.location.href = './brand-list.php'</script>";
    }else {
        $user_id = $_GET["user_id"];
    }
    $get_user = $User->get_user($user_id);
    if($get_user) {
        $result = $get_user->fetch_assoc();
    }
    

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $role_id = $_POST["role_id"];
        $User->set_admin($user_id, $role_id);
        echo "<script>window.location.href = 'user-list.php'</script>";
    }

?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-4">
            <h2>Sửa thông tin người dùng</h2>
            <form action="" method="POST">
                <select name="role_id" id=""  class="form-select" required>
                    <?php 
                        $show_role = $User->show_role();
                        if($show_role) {
                            while($rs = $show_role->fetch_assoc()) {
                    ?>
                        <option <?php if($result["role"] == $rs["role_id"]){echo "SELECTED";}?> value="<?php  echo $rs["role_id"] ?>"><?php echo $rs["role_name"] ?></option>
                    <?php 
                         }
                        }
                    ?>
                </select>
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