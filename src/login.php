<?php 
    ob_start();
    include("./header.php");
?>

<?php 
    $User = new User;
    $error = "";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $username = trim($_POST["username"]);
        $password = md5(trim($_POST["password"]));
        $check_username = $User->check_username($username);
        $check_user_valid = $User->check_user_valid($username);
        if($check_username && $check_user_valid) {
            $result = $check_username->fetch_assoc();
          
            if($result["password"] != $password) {
                $error= "Tên đăng nhập hoặc mật khẩu không chính xác";
            } else {
                // tạo session user
                $_SESSION["user"] = $result;

                if($_SESSION["user"]["role"] == 1) {
                    echo "<script>window.location.href = 'admin/index.php'</script>";
                } else {
                    echo "<script>window.location.href = 'index.php'</script>";
                }

                // chuyển hướng đến trang checkout.php
                if(isset($_GET["action"])) {
                    $action = $_GET["action"];
                    header("location: ".$action.".php");
                }
            }
        } else {
            $error= "Tên đăng nhập hoặc mật khẩu không chính xác";
        }
    }
?>
    <div class="app-container">
        <div class="container">
            <div class="login-form">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <h2 class="pt-5">Đăng nhập tài khoản</h2>
                        <p class="text-center text-danger"><?php echo  $error ? $error : "";?></p>
                        <form  action="" method="POST">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập</label>
                                <input
                                    type="username"
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    placeholder="Vui lòng nhập tên đăng nhập..."
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Vui lòng nhập mật khẩu..."
                                    required
                                />
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                        </form>
                        <div class="mt-2">Nếu chưa có tài khoản <a href="./register.php">Đăng ký</a> tại đây!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    include("./footer.php");
?>