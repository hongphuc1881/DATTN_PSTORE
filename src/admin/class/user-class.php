<?php 
    include("database.php");
?>

    <?php 
    class User {
        private $db;
        public function __construct(){
            $this->db = new Database;
        }

        public function login($user_name, $password) {
            $sql = "SELECT * FROM tbl_user WHERE username = '$user_name' AND password = '$password' LIMIT 1";
            $result = $this->db->select($sql);
            if($result) {
                $value = $result->fetch_assoc();
                //Session::set("login", true);
                //Session::set("login", true);
                header("Location: index.php");
            } else {
                $message = "Tên đăng nhập hoặc mật khẩu không chính xác";
                return $message;
            }
        }

       
        public function register() {
            $username = trim($_POST["username"]);
            $password = md5(trim( $_POST["password"]));
            $fullname =  trim( $_POST["fullname"]);
            $email = trim($_POST["email"]);
            $sql = "INSERT INTO tbl_user(username, password, fullname, email) VALUE('$username', '$password', '$fullname', '$email')";
            $result = $this->db->insert($sql);
            return $result;
        }

        public function check_username($username) {
            $sql = "SELECT * FROM tbl_user WHERE username = '$username'";
            $result = $this->db->select($sql);
            return $result;
        }

        public function check_email($email) {
            $sql = "SELECT * FROM tbl_user WHERE email = '$email'";
            $result = $this->db->select($sql);
            return $result;
        }
    }

?>