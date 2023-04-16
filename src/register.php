<?php 
    include("./header.php");
?>
<?php 
    $User = new User;
    $error = [];
    if(isset($_POST["username"])) {
        $username = trim($_POST['username']);
        $password =trim( $_POST['password']);
        $password_confirm = trim($_POST['password_confirm']);
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $check_username = $User->check_username($username);
        $check_email = $User->check_email($email);
       
        if($check_username) {
            $error["username"] = "Vui lòng chọn tên đăng nhập khác";
        } else {
            if($check_email) {
                $error["email"] = "Email này đã được sử dụng";
            } elseif($email == "") {
                $error["email"] = "Vui lòng nhập email khác";
            }
            elseif(strlen($username) < 6 || $username == "") {
                $error["username"] = "Vui lòng nhập từ 6 ký tự trở lên";
            }
            elseif(strlen($password) < 6 || $password == "" ) {
                $error["password"] = "Vui lòng nhập từ 6 ký tự trở lên";
            } elseif($password != $password_confirm) {
                $error["password_confirm"] = "Mật khẩu chưa khớp";
            } elseif($fullname == "" ){
                $error["fullname"] = "Vui lòng nhập tên";
            } else {
                $User->register();
                echo "<script>window.location.href = 'login.php'</script>";
            }
        }
        
    }
?>
        <div class="app-container">
            <div class="container">
                <div class="login-form">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <h2 class="pt-5">Đăng ký tài khoản</h2>
                            <p class="text-danger text-center"><?php echo !empty($error) ? "Đăng ký thất bại" : "" ?></p>
                            <form action="" method="POST">
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
                                    <span class="form-message text-danger"><?php echo isset($error["username"]) ? $error["username"]: "" ?></span>
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
                                    <span class="form-message text-danger"><?php echo isset($error["password"]) ? $error["password"]: "" ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Nhập lại mật khẩu</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password-confirm"
                                        name="password_confirm"
                                        placeholder="Vui lòng nhập lại mật khẩu..."
                                        required
                                    />
                                    <span class="form-message text-danger"><?php echo isset($error["password_confirm"]) ? $error["password_confirm"]: "" ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Họ và tên</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="fullname"
                                        name="fullname"
                                        placeholder="Vui lòng nhập họ tên..."
                                        required
                                    />
                                    <span class="form-message text-danger"><?php echo isset($error["fullname"]) ? $error["fullname"]: "" ?></span>

                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        aria-describedby="emailHelp"
                                        placeholder="Vui lòng nhập email..."
                                        required
                                    />
                                    <span class="form-message text-danger"><?php echo isset($error["email"]) ? $error["email"]: "" ?></span>
                                </div>
                                <button type="submit" class="btn btn-dark w-100">Đăng ký</button>
                            </form>
                            <div class="mt-2">Nếu đã có tài khoản <a href="./login.php">Đăng nhập</a> tại đây!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

      
<?php 
    include("./footer.php");
?>
