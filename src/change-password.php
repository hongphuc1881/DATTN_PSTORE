<?php 
ob_start();
    include("./header.php");
?>
<?php 
    $User = new User;
    $error = [];
    
    if(isset($_POST["change"])) {
        $user_id = $_SESSION["user"]["user_id"];
        $password = $_SESSION["user"]["password"];
        $password_old = md5(trim($_POST['password_old']));
        $password_new = md5(trim( $_POST['password_new']));
        $password_new_confirm = md5(trim($_POST['password_new_confirm']));
    
       
        if(strlen($password_old) < 6 || $password_old == "") {
            $error["password_old"] = "Vui lòng nhập từ 6 ký tự trở lên";
        } elseif($password != $password_old) {
            $error["password_old"] = "Mật khẩu cũ chưa khớp";
        }
        elseif(strlen($password_new) < 6 || $password_new == "" ) {
            $error["password_new"] = "Vui lòng nhập từ 6 ký tự trở lên";
        } elseif(strlen($password_new_confirm) < 6 || $password_new_confirm == "" ) {
            $error["password_new_confirm"] = "Vui lòng nhập từ 6 ký tự trở lên";
        } 
        elseif($password_new != $password_new_confirm) {
            $error["password_new_confirm"] = "Mật khẩu chưa khớp";
        } else {
            $User->update_password($user_id, $password_new);
            header("location: index.php ");
        }
        
    } 
?>
        <div class="app-container">
            <div class="container">
                <div class="login-form">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <h2 class="pt-5">Đổi mật khẩu</h2>
                            <form action="" method="POST">
                            <div class="form-group">
                                    <label for="password_old">Mật khẩu cũ</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password_old"
                                        name="password_old"
                                        placeholder="Vui lòng nhập mật khẩu cũ..."
                                        required
                                    />
                                    <span class="form-message text-danger"><?php echo isset($error["password_old"]) ? $error["password_old"]: "" ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="password_new">Mật khẩu mới</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password_new"
                                        name="password_new"
                                        placeholder="Vui lòng nhập mật khẩu mới..."
                                        required
                                    />
                                    <span class="form-message text-danger"><?php echo isset($error["password_new"]) ? $error["password_new"]: "" ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="password_new-confirm">Nhập lại mật khẩu mới</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password_new-confirm"
                                        name="password_new_confirm"
                                        placeholder="Vui lòng nhập lại mật khẩu mới..."
                                        required
                                    />
                                    <span class="form-message text-danger"><?php echo isset($error["password_new_confirm"]) ? $error["password_new_confirm"]: "" ?></span>
                                </div>
                                
                                <button type="submit" name="change" value="change" class="btn btn-dark w-100">Đổi mật khẩu</button>
                            </form>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

      
<?php 
    include("./footer.php");
?>
