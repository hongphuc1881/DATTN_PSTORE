
<?php 
    class Brand {
        private $db;
        public function __construct(){
            $this->db = new Database;
        }

        public function show_category() {
            $sql = "SELECT * FROM tbl_category WHERE status = 1 ";
            $result = $this->db->select($sql);
            return $result;
        }

        public function insert_brand($category_id, $brand_name) {
            //$sql = "INSERT INTO tbl_brand (category_id, brand_name) VALUES ('$category_id','$brand_name')";
            $sql = "INSERT INTO tbl_brand (category_id, brand_name, status) 
            SELECT '$category_id', '$brand_name', 1
            FROM dual 
            WHERE NOT EXISTS 
                (SELECT * FROM tbl_brand WHERE category_id = '$category_id' AND brand_name = '$brand_name') 
            AND EXISTS 
                (SELECT * FROM tbl_category WHERE category_id = '$category_id')";
            $result = $this->db->insert($sql);
            return $result;
        }

        public function show_brand() {
            $sql = "SELECT tbl_brand.*, tbl_category.category_name 
            FROM tbl_brand INNER JOIN tbl_category ON tbl_brand.category_id = tbl_category.category_id
            ORDER BY tbl_brand.category_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_group_brand($category_id) {
            $sql = "SELECT * FROM tbl_brand WHERE category_id = '$category_id' AND status = 1";
            $result = $this->db->select($sql);
            return $result;
        }
        public function get_brand($brand_id) {
            $sql = "SELECT * FROM tbl_brand WHERE brand_id = '$brand_id'";
            $result = $this->db->select($sql);
            return $result;
        }

        public function update_brand($category_id, $brand_id,$brand_name) {
            //$sql = "UPDATE tbl_brand SET brand_name = '$brand_name',category_id = '$category_id' WHERE brand_id = '$brand_id'";
            $sql = "UPDATE tbl_brand 
            SET brand_name = '$brand_name', category_id = '$category_id'  
            WHERE brand_id = '$brand_id' 
            AND NOT EXISTS 
                (SELECT * FROM tbl_brand 
                 WHERE brand_name = '$brand_name' AND category_id = '$category_id' AND brand_id != '$brand_id')";
            $result = $this->db->update($sql);
            return $result;
        }
        public function delete_brand($brand_id) {
            $sql = "DELETE FROM tbl_brand WHERE brand_id = '$brand_id'";
            $result = $this->db->delete($sql);
            return $result;
        }

        public function brand_pagination($limit, $start) {
            $sql = "SELECT tbl_brand.* , tbl_category.category_name FROM tbl_brand
            INNER JOIN tbl_category ON tbl_brand.category_id = tbl_category.category_id
            WHERE tbl_brand.status = 1
            ORDER BY category_id DESC LIMIT $start,$limit";
            $result = $this->db->select($sql);
            return $result;
        }
        public function lock_brand($brand_id) {
            $sql = "UPDATE tbl_brand 
            SET  status =  0
            WHERE brand_id = '$brand_id'";
            $result = $this->db->update($sql);
            return $result;
        }
        public function unlock_brand($brand_id) {
            $sql = "UPDATE tbl_brand 
            SET  status =  1
            WHERE brand_id = '$brand_id'";
            $result = $this->db->update($sql);
            return $result;
        }
        public function show_brand_lock() {
            $sql = "SELECT tbl_brand.*, tbl_category.category_name 
            FROM tbl_brand INNER JOIN tbl_category ON tbl_brand.category_id = tbl_category.category_id
            where tbl_brand.status = 0
            ORDER BY tbl_brand.category_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }

    }

?>