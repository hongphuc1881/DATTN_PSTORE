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
            $sql = "INSERT INTO tbl_user(username, password, fullname, email, role, status) VALUE('$username', '$password', '$fullname', '$email',3,1)";
            $result = $this->db->insert($sql);
            return $result;
        }
        public function update_password($user_id, $new_password) {
            $sql = "UPDATE tbl_user SET password = '$new_password' WHERE user_id = '$user_id'";
            $result = $this->db->select($sql);
            return $result;
        }
        public function check_username($username) {
            $sql = "SELECT * FROM tbl_user WHERE username = '$username'";
            $result = $this->db->select($sql);
            return $result;
        }
        public function check_user_valid($username) {
            $sql = "SELECT * FROM tbl_user WHERE username = '$username' AND status = 1";
            $result = $this->db->select($sql);
            return $result;
        }

        public function check_email($email) {
            $sql = "SELECT * FROM tbl_user WHERE email = '$email'";
            $result = $this->db->select($sql);
            return $result;
        }

        public function show_user(){
            $sql = "SELECT tbl_user.* , tbl_role.role_name FROM tbl_user INNER JOIN tbl_role ON tbl_user.role = tbl_role.role_id WHERE status = 1 ORDER BY tbl_user.role";
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
            $sql = "SELECT tbl_user.* , tbl_role.role_name FROM tbl_user INNER JOIN tbl_role ON tbl_user.role = tbl_role.role_id WHERE status = 1 AND NOT tbl_user.role = 1 ORDER BY role  LIMIT $start, $limit";
            $result = $this->db->select($sql);
            return $result;
        }

        public function lock_user($user_id) {
            $sql = "UPDATE tbl_user 
            SET  status =  0
            WHERE user_id = '$user_id'";
            $result = $this->db->select($sql);
            return $result;
        }
        public function unlock_user($user_id) {
            $sql = "UPDATE tbl_user 
            SET  status =  1
            WHERE user_id = '$user_id'";
            $result = $this->db->select($sql);
            return $result;
        }
        public function delete_user($user_id) {
            $sql = "DELETE FROM tbl_user WHERE user_id = '$user_id'";
            $result = $this->db->delete($sql);
            return $result;
        }
        public function show_user_lock() {
            $sql = "SELECT tbl_user.* , tbl_role.role_name FROM tbl_user INNER JOIN tbl_role ON tbl_user.role = tbl_role.role_id WHERE status = 0 ORDER BY role ";
            $result = $this->db->select($sql);
            return $result;
        }
    }

?>