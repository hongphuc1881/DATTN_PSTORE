<?php 
    class User {
        private $db;
        public function __construct(){
            $this->db = new Database;
        }
       
        public function register() {
            $username = trim($_POST["username"]);
            $password = md5(trim( $_POST["password"]));
            $fullname =  trim( $_POST["fullname"]);
            $email = trim($_POST["email"]);
            $sql = "INSERT INTO tbl_user(username, password, fullname, email, role) VALUE('$username', '$password', '$fullname', '$email',2)";
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

        public function show_user(){
            $sql = "SELECT tbl_user.* , tbl_role.role_name FROM tbl_user INNER JOIN tbl_role ON tbl_user.role = tbl_role.role_id ORDER BY tbl_user.role";
            $result = $this->db->select($sql);
            return $result;
        }
        public function get_user($user_id){
            $sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_role(){
            $sql = "SELECT * FROM tbl_role";
            $result = $this->db->select($sql);
            return $result;
        }

        public function set_admin($user_id, $role_id) {
            $sql = "UPDATE tbl_user SET role = '$role_id' WHERE user_id = '$user_id' ";
            $result = $this->db->update($sql);
            return $result;
        }
        public function user_pagination($limit, $start) {
            $sql = "SELECT tbl_user.* , tbl_role.role_name FROM tbl_user INNER JOIN tbl_role ON tbl_user.role = tbl_role.role_id ORDER BY role  LIMIT $start, $limit";
            $result = $this->db->select($sql);
            return $result;
        }
    }

?>