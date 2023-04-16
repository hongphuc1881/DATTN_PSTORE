<?php 
    ob_start();
    include("./header.php");
    include("../assets/lib/mail/sendMail.php");
?>

<?php 
    $User = new User;
    $error = "";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $check_email = $User->check_email($email);

        if(empty($check_email)) {
            $error = "Email không chính xác";
        } else {
            $result = $check_email->fetch_assoc();
            $random_string = random_string(8);
            $subject = "Forgot password";
            $content = "<p>Mật khẩu mới của bạn đã được đặt lại là</p><strong>$random_string</strong>
            <p>Vui lòng không chia sẻ cho bất kỳ ai.</p>
            ";
            $user_id = $result["user_id"];
            $email = $result["email"];
            $name = $result["username"];
            sendMail($email, $name, $subject, $content);


            $new_password = md5($random_string);
            $User->update_password($user_id, $new_password);
            header("location: login.php");
        }
    }
?>
    <div class="app-container">
        <div class="container">
            <div class="login-form">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <h2 class="pt-5">Quên mật khẩu</h2>
                        <form  action="" method="POST">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Vui lòng nhập email đã đăng ký..."
                                    required
                                />
                                <p class=" text-danger"><?php echo  $error ? $error : "";?></p>

                            </div>
                            <button type="submit" class="btn btn-dark w-100">Lấy lại mật khẩu</button>
                        </form>
                        <div class="mt-3 d-flex justify-content-between">
                            <a class="text-decoration-none" href="./login.php">Đăng nhập</a>
                            <a class="text-decoration-none" href="./register.php">Đăng ký</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    include("./footer.php");
?>