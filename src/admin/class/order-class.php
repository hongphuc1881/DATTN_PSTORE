
<?php
    class Order {
        private $db;
        public function __construct() {
            $this -> db = new Database();
        }
        public function insert_order($user_id, $fullname ,$email ,$phone ,$address ,$note ,$cart) {
          

            $sql = "INSERT INTO tbl_order (user_id, fullname, email, phone, address, note, order_date, status) 
            VALUES ( '$user_id', '$fullname', '$email', '$phone', '$address', '$note', NOW(), 1)";
            $result = $this->db->insert($sql);

            //echo date('d/m/y', 1680015322);

            if($result) {
                $sql = "SELECT * FROM tbl_order ORDER BY order_id DESC LIMIT 1";
                $result = $this->db->select($sql)->fetch_assoc();
                $order_id = $result["order_id"];
                foreach ($cart as $item) {
                    $product_id = $item[0];
                    $size_id = $item[3];
                    $quantity = $item[5];
                    $price = $item[4];
                    $sql = "INSERT INTO tbl_order_detail (order_id, product_id, size_id, quantity, price) 
                    VALUES ('$order_id', '$product_id','$size_id', '$quantity', '$price')";
                    $result = $this->db->insert($sql);
                }
            }
            return $result;

            
        }

        public function get_order_by_user_id($user_id) {
            $sql = "SELECT * FROM tbl_order WHERE user_id = '$user_id' ORDER BY order_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
      
        public function show_order() {
            $sql = "SELECT * FROM tbl_order ORDER BY order_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
        public function get_order_by_order_id($order_id) {
            $sql = "SELECT * FROM tbl_order WHERE order_id = '$order_id'";
            $result = $this->db->select($sql);
            return $result;
        }

        public function get_order_detail($order_id){
            $sql = "SELECT * FROM tbl_order_detail WHERE order_id = '$order_id'";
            $result = $this->db->select($sql);
            return $result;
        }
      
        public function show_order_pagination($limit, $start) {
            $sql = "SELECT * FROM tbl_order ORDER BY order_id DESC LIMIT $start,$limit";
            $result = $this->db->select($sql);
            return $result;
        }
        public function cancel_order($order_id){
            $sql = "UPDATE tbl_order SET status = 3 WHERE order_id = '$order_id'";
            $result = $this->db->update($sql);
            return $result;
        }
        public function order_confirmation($value, $order_id) {
            $sql = "UPDATE tbl_order SET status = '$value' WHERE order_id = '$order_id'";
            $result = $this->db->update($sql);
            return $result;
        }
        
        public function show_order_success() {
            $sql = "SELECT * FROM tbl_order WHERE status = 2 ORDER BY order_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_order_cancel() {
            $sql = "SELECT * FROM tbl_order WHERE status = 3 ORDER BY order_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_order_pending() {
            $sql = "SELECT * FROM tbl_order WHERE status = 1 ORDER BY order_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_order_success_pagination($limit, $start) {
            $sql = "SELECT * FROM tbl_order WHERE status = 2 ORDER BY order_id DESC LIMIT $start,$limit";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_order_cancel_pagination($limit, $start) {
            $sql = "SELECT * FROM tbl_order WHERE status = 3 ORDER BY order_id DESC LIMIT $start,$limit";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_order_pending_pagination($limit, $start) {
            $sql = "SELECT * FROM tbl_order WHERE status = 1 ORDER BY order_id DESC LIMIT $start,$limit";
            $result = $this->db->select($sql);
            return $result;
        }

        
    }
?>