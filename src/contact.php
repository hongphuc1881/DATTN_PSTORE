<?php
ob_start();
    include("./header.php");
?>

<?php 
    $User = new User;
    if($_SERVER["REQUEST_METHOD"] == "POST" ) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $content = $_POST['content'];
        $insert_contact = $User->insert_contact($username, $email, $phone, $content);
        //header("location: storage-list.php");
        
    }
?>

<div class="app-container">
    <div class="container pt-5">
       
        <div class="row justify-content-center">
            <div class="mapouter">
                <div class="gmap_canvas">
                <iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=điện máy sĩ thảo Nghĩa hương quốc oai&t=&z=10&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                </iframe>
                </div>
            </div>
            <div class="col-7 mt-4">
            <form action="" method="POST">
                 <div class="mb-3">
                    <label for="name" class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" id="name" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone"  minlength="10"
                                    maxlength="10"
                                    required 
                                    onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label> <br>
                    <textarea name="content" id="content" rows="5" style="width:100%; padding: 12px;" required></textarea>
                </div>
                <button type="submit" class="btn btn-dark btn-contact">Gửi liên hệ</button>
            </form>
            </div>
        </div>
    </div>
</div>
<style>
    .mapouter{position:relative;text-align:right;height:500px;width:1280px;}
    .gmap_canvas {overflow:hidden;background:none!important;height:100%;width:100%;}
    .btn-contact {
        font-size: 1.6rem;
    }
</style>
<?php 
    include("./footer.php");
?>