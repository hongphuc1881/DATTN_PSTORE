
<?php
    class Category {
        private $db;
        public function __construct() {
            $this -> db = new Database();
        }
        public function insert_category($category_name) {
            //$sql = "INSERT INTO tbl_category(category_name) VALUES('$category_name')";
            $sql = "INSERT INTO tbl_category (category_name, status) SELECT '$category_name', 1
            FROM dual 
            WHERE NOT EXISTS (SELECT category_name FROM tbl_category WHERE category_name = '$category_name')";
            $result = $this->db->insert($sql);
            return $result;
        }
        public function show_category() {
            $sql = "SELECT * FROM tbl_category WHERE status = 1 ORDER BY category_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_category_lock() {
            $sql = "SELECT * FROM tbl_category WHERE status = 0 ORDER BY category_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
        public function get_category($category_id) {
            $sql = "SELECT * FROM tbl_category WHERE category_id = $category_id";
            $result = $this->db->select($sql);
            return $result;
        }

        public function update_category($category_id, $category_name) {
            //$sql = "UPDATE tbl_category SET category_name = '$category_name' WHERE category_id = '$category_id'";
            $sql = "UPDATE tbl_category
            SET category_name = '$category_name'
            WHERE category_id = '$category_id' 
            AND NOT EXISTS (SELECT * FROM tbl_category WHERE category_name = '$category_name' AND category_id != '$category_id')";
            $result = $this->db->update($sql);
            return $result;
        }
        public function delete_category($category_id) {
            $sql = "DELETE FROM tbl_category WHERE category_id = '$category_id'";
            $result = $this->db->delete($sql);
            return $result;
        }
        public function lock_category($category_id) {
            $sql = "UPDATE tbl_category 
            SET  status =  0
            WHERE category_id = '$category_id'";
            $result = $this->db->update($sql);
            return $result;
        }
        public function unlock_category($category_id) {
            $sql = "UPDATE tbl_category 
            SET  status =  1
            WHERE category_id = '$category_id'";
            $result = $this->db->update($sql);
            return $result;
        }

    }
?>