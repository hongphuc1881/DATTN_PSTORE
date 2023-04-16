<?php
    class Product {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function show_category() {
            $sql = "SELECT * FROM tbl_category WHERE status = 1 ";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_brand() {
            $sql = "SELECT tbl_brand.*, tbl_category.category_name FROM tbl_brand
            INNER JOIN tbl_category ON tbl_brand.category_id = tbl_category.category_id
            ORDER BY tbl_brand.category_id  DESC";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_brand_ajax($category_id) {
            $sql = "SELECT * FROM tbl_brand WHERE category_id = '$category_id' AND status = 1";
            $result = $this->db->select($sql);
            return $result;
        }

        public function insert_product() {
            $product_name = trim($_POST["product_name"]);
        
            $category_id = $_POST["category_id"];
            $brand_id = $_POST["brand_id"];
            $product_cost = $_POST["product_cost"];
            $product_price_old = trim($_POST["product_price_old"]);
            $product_price_new = trim($_POST["product_price_new"]);
            $product_description =trim( $_POST["product_description"]);
            $product_img_main = $_FILES["product_img_main"]["name"];
            $is_hot = $_POST["is_hot"];
            
            move_uploaded_file($_FILES['product_img_main']['tmp_name'], "uploads/".$_FILES['product_img_main']['name']);
            $count = count($_FILES["product_img_description"]["name"]) ;
       
            for($i = 0; $i < $count; $i++) {
                move_uploaded_file($_FILES['product_img_description']['tmp_name'][$i], "uploads/".$_FILES['product_img_description']['name'][$i]);
            }
        
            $sql =" INSERT INTO tbl_product (product_name, category_id, brand_id, product_cost, product_price_old, product_price_new, product_description, product_img_main, is_hot, status)
            SELECT * FROM (SELECT '$product_name', '$category_id', '$brand_id', '$product_cost','$product_price_old' as product_price_old, '$product_price_new' as product_price_new, '$product_description', '$product_img_main', '$is_hot', '1' AS product_status) AS tmp
            WHERE NOT EXISTS (
                SELECT product_name FROM tbl_product WHERE product_name = '$product_name'
            ) LIMIT 1;";
            
            $result = $this->db->insert($sql);
            //them anh mo ta 
            if($result) {
                $sql = "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 1";
                $result = $this->db->select($sql)->fetch_assoc();
                $product_id = $result["product_id"];
                $file_name = $_FILES["product_img_description"]["name"];
                foreach ($file_name as $key => $value) {
                    $sql = "INSERT INTO tbl_product_img_description(product_id, product_img_description) VALUES('$product_id','$value')";
                    $result = $this->db->insert($sql);
                }
            }

            //size san pham
            //if($result) {
            //    $sql = "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 1";
            //    $result = $this->db->select($sql)->fetch_assoc();
            //    $product_id = $result["product_id"];
            //    $size_id = $_POST['size_id'];
            //    foreach ($size_id as $value) {
            //        $sql = "INSERT INTO tbl_storage(product_id, size_id) VALUES('$product_id','$value')";
            //        $result = $this->db->insert($sql);
            //    }
            //}

            return $result;
        }

        public function show_product() {
            $sql = "SELECT tbl_product.*, tbl_category.category_name , tbl_brand.brand_name
            FROM tbl_brand INNER JOIN tbl_category ON tbl_brand.category_id = tbl_category.category_id
                            INNER JOIN tbl_product ON tbl_brand.brand_id = tbl_product.brand_id 
            WHERE tbl_product.status = 1
            ORDER BY tbl_brand.category_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
         //filter
            // size
         public function show_product_filter_by_size($size_id, $key = "", $value = "", $isSale = false ) {
            if(!empty($key) && !empty($value)) {
                $sql = "SELECT tbl_product.*, tbl_storage.*
                FROM tbl_product INNER JOIN tbl_storage ON tbl_product.product_id = tbl_storage.product_id
                WHERE tbl_product.status = 1 AND tbl_product.$key = $value AND tbl_storage.size_id IN ('$size_id');
                ";
            } else if($isSale == true) {
                $sql = "SELECT tbl_product.*, tbl_storage.*
                FROM tbl_product INNER JOIN tbl_storage ON tbl_product.product_id = tbl_storage.product_id
                WHERE tbl_product.status = 1 AND  tbl_product.product_price_new < tbl_product.product_price_old AND tbl_storage.size_id IN ('$size_id');
                ";
            }
           else {
                $sql = "SELECT tbl_product.*, tbl_storage.*
                FROM tbl_product INNER JOIN tbl_storage ON tbl_product.product_id = tbl_storage.product_id
                WHERE tbl_product.status = 1 AND tbl_storage.size_id IN ('$size_id');
                ";
           }
            $result = $this->db->select($sql);
            return $result;
        }
           
        // price
           public function show_product_filter_by_price($field, $sort) {
        
            $sql = "SELECT tbl_product.*, tbl_storage.*
            FROM tbl_product INNER JOIN tbl_storage ON tbl_product.product_id = tbl_storage.product_id
            WHERE tbl_product.status = 1;
            ORDER BY tbl_product.$field $sort";
            $result = $this->db->select($sql);
            return $result;
        }
        //public function get_size($product_id) {
        //    $sql = "SELECT product_id, GROUP_CONCAT(size_id) AS sizes
        //    FROM tbl_storage
        //    WHERE product_id = '$product_id'
        //    GROUP BY product_id";
        //    $result = $this->db->select($sql);
        //    return $result;
        //}
        public function get_size($product_id) {
            $sql = "SELECT tbl_storage.product_id as product_id, GROUP_CONCAT(tbl_storage.size_id) AS sizes_id,
            GROUP_CONCAT(tbl_size.product_size ) AS product_sizes
            FROM tbl_storage INNER JOIN tbl_size
            ON tbl_storage.size_id = tbl_size.size_id
            WHERE tbl_storage.product_id = '$product_id' AND tbl_storage.quantity > 0
            GROUP BY tbl_storage.product_id";
            $result = $this->db->select($sql);
            return $result;
        }
        
        public function show_size() {
            $sql = "SELECT * FROM tbl_size";
            $result = $this->db->select($sql);
            return $result;
        }

        public function get_product($product_id) {
            $sql = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
            $result = $this->db->select($sql);
            return $result;
        }

        public function update_product($product_id) {
            $product_name = trim($_POST["product_name"]);
            $category_id = $_POST["category_id"];
            $brand_id = $_POST["brand_id"];
            $product_price_old = intval($_POST["product_price_old"]);
            $product_price_new = intval($_POST["product_price_new"]);
            $product_description =trim( $_POST["product_description"]);
            $product_img_main = $_FILES["product_img_main"]["name"];
            $is_hot = $_POST["is_hot"];
            move_uploaded_file($_FILES['product_img_main']['tmp_name'], "uploads/".$_FILES['product_img_main']['name']);

            $sql = "UPDATE tbl_product SET product_name = '$product_name',category_id = '$category_id' , brand_id = '$brand_id', 
            product_price_old = '$product_price_old',  product_price_new = '$product_price_new', product_description =' $product_description',
            product_img_main = '$product_img_main', is_hot = '$is_hot'
            WHERE product_id = '$product_id'";

            $result = $this->db->update($sql);

            //them anh mo ta 
            if($result) {
                $file_name = $_FILES["product_img_description"]["name"];
                $sql = "DELETE FROM tbl_product_img_description WHERE product_id = '$product_id'";
                $result = $this->db->delete($sql);
              
                foreach ($file_name as $key => $value) {
                    $sql = "INSERT INTO tbl_product_img_description(product_id, product_img_description) VALUES('$product_id','$value')";
                    $result = $this->db->insert($sql);
                }

            }

            //size san pham
            //if($result) {
            //    $size_id = $_POST['size_id'];
            //    $sql = "DELETE FROM tbl_storage WHERE product_id = '$product_id'";
            //    $result = $this->db->delete($sql);
            //    foreach ($size_id as $value) {
            //        $sql = "INSERT INTO tbl_storage(product_id, size_id) VALUES('$product_id','$value')";
            //        $result = $this->db->insert($sql);
            //    }
            //}
            return $result;
        }

       

        public function select_productId_sizeId($product_id, $size_id) {
            $sql = "SELECT * FROM `tbl_storage` WHERE product_id= '$product_id' AND size_id = '$size_id'";
            $result = $this->db->select($sql);
            return $result;
        }

        // quản lý kho hàng: start
       
        public function storage_show_product($product_id) {
            $sql = "SELECT tbl_product.product_name, tbl_storage.*, tbl_size.product_size
            FROM tbl_storage INNER JOIN tbl_product ON tbl_product.product_id = tbl_storage.product_id
                                 INNER JOIN tbl_size ON tbl_storage.size_id = tbl_size.size_id
            WHERE tbl_product.status = 1  and tbl_product.product_id = '$product_id'
            ORDER BY tbl_product.product_id DESC
            ";
            $result = $this->db->select($sql);
            return $result;
        }
        public function storage_show_product_pagination($start, $limit) {
            $sql = "SELECT tbl_product.product_name, tbl_storage.*, tbl_size.product_size
            FROM tbl_storage INNER JOIN tbl_product ON tbl_product.product_id = tbl_storage.product_id
                                 INNER JOIN tbl_size ON tbl_storage.size_id = tbl_size.size_id
            WHERE tbl_product.status = 1  
            ORDER BY tbl_product.product_id DESC LIMIT $start, $limit
            ";
            $result = $this->db->select($sql);
            return $result;
        }

        public function storage_update($product_id, $size_id, $quantity) {
            $sql = "UPDATE `tbl_storage` SET quantity = '$quantity' WHERE product_id = '$product_id' AND  size_id='$size_id'";
            $result = $this->db->update($sql);
            return $result;
        }
        public function insert_storage($product_id, $size_id, $quantity) {
            $sql = "INSERT INTO tbl_storage(product_id, size_id, quantity) VALUES('$product_id','$size_id', '$quantity')";
            $result = $this->db->insert($sql);
            return $result;
        }
        public function storage_delete($product_id, $size_id) {
            $sql = "DELETE FROM tbl_storage WHERE product_id = '$product_id' AND size_id =' $size_id'";
            $result = $this->db->delete($sql);
            return $result;
        }

        public function total_quantity_of_product_id($product_id) {
            $sql = "SELECT SUM(quantity) AS total_quantity FROM tbl_storage WHERE product_id = '$product_id'";
            $result = $this->db->select($sql);
            return $result;
        }

        //quản lý kho hàng : end
        public function product_pagination($limit, $start, $field = "", $sort = "") {
            if(!empty($field) && !empty($sort)) {
                $sql = "SELECT tbl_product.* , tbl_brand.brand_name, tbl_category.category_name FROM tbl_product
                INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id
                INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
                WHERE tbl_product.status = 1
                ORDER BY tbl_product.$field $sort LIMIT $start,$limit";     
            } else {
                $sql = "SELECT tbl_product.* , tbl_brand.brand_name, tbl_category.category_name FROM tbl_product
                INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id
                INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
                WHERE tbl_product.status = 1
                ORDER BY category_id DESC LIMIT $start,$limit";
            }
            $result = $this->db->select($sql);
            return $result;
        }
        public function product_category_pagination($category_id, $limit, $start, $field = "", $sort = "") {
            if(!empty($field) && !empty($sort)) {
                $sql = "SELECT * FROM tbl_product WHERE category_id = '$category_id' AND status = 1 
                ORDER BY tbl_product.$field $sort LIMIT $start,$limit";     
            } else {
                $sql = "SELECT * FROM tbl_product WHERE category_id = '$category_id' AND status = 1 
                ORDER BY product_id DESC LIMIT $start,$limit";
            }
            $result = $this->db->select($sql);
            return $result;
        }
        public function product_new_pagination($limit, $start,  $field = "", $sort = "") {
            if(!empty($field) && !empty($sort))  {
                $sql = "SELECT tbl_product.* , tbl_brand.brand_name, tbl_category.category_name FROM tbl_product
                INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id
                INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
                AND tbl_product.status = 1
                ORDER BY $field $sort LIMIT $start,$limit";
            } else {
                $sql = "SELECT tbl_product.* , tbl_brand.brand_name, tbl_category.category_name FROM tbl_product
                INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id
                INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
                AND tbl_product.status = 1
                ORDER BY product_id DESC LIMIT $start,$limit";
            }
            $result = $this->db->select($sql);
            return $result;
        }
        public function product_sale_pagination($limit, $start,  $field = "", $sort = "") {
            if(!empty($field) && !empty($sort)) {
                $sql = "SELECT * FROM tbl_product WHERE product_price_new < product_price_old AND status = 1 ORDER BY $field $sort LIMIT $start,$limit";
            } else {
                $sql = "SELECT * FROM tbl_product WHERE product_price_new < product_price_old AND status = 1 ORDER BY product_id DESC LIMIT $start,$limit";
            }
           
            $result = $this->db->select($sql);
            return $result;
        }
        public function product_hot_pagination($limit, $start, $field = "", $sort = "") {
            if(!empty($field) && !empty($sort)) {
                $sql = "SELECT * FROM tbl_product WHERE is_hot = 1 AND status = 1 ORDER BY $field $sort LIMIT $start,$limit";     
            } else {
                $sql = "SELECT * FROM tbl_product WHERE is_hot = 1 AND status = 1 ORDER BY product_id DESC LIMIT $start,$limit";
            }
           
            $result = $this->db->select($sql);
            return $result;
        }

        public function delete_product($product_id) {
            $sql = "DELETE FROM tbl_product WHERE product_id = '$product_id'";
            $result = $this->db->delete($sql);
            return $result;
        }

        public function show_product_hot($limit = 9999) {
            $sql = " SELECT * FROM tbl_product WHERE is_hot = 1 AND status = 1 ORDER BY product_id DESC LIMIT $limit";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_product_sale($limit = 9999) {
            $sql = " SELECT * FROM tbl_product WHERE product_price_new < product_price_old AND status = 1 ORDER BY product_id DESC LIMIT $limit";
            $result = $this->db->select($sql);
            return $result;
        }

        public function show_product_new($limit = 9999)
        {
            $sql = "SELECT tbl_product.*, tbl_category.category_name , tbl_brand.brand_name
            FROM tbl_brand INNER JOIN tbl_category ON tbl_brand.category_id = tbl_category.category_id
                            INNER JOIN tbl_product ON tbl_brand.brand_id = tbl_product.brand_id 
            WHERE tbl_product.status = 1
            ORDER BY product_id DESC LIMIT $limit";
            $result = $this->db->select($sql);
            return $result;
        }       

        public function get_product_img_description($product_id) {
            $sql = " SELECT * FROM tbl_product_img_description WHERE product_id = '$product_id'";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_product_by_category($category_id) {
            $sql = " SELECT * FROM tbl_product WHERE category_id = '$category_id' AND status = 1";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_product_by_brand($brand_id) {
            $sql = " SELECT * FROM tbl_product WHERE brand_id = '$brand_id' AND status = 1";
            $result = $this->db->select($sql);
            return $result;
        }
        public function get_product_size_by_size_id($size_id) {
            $sql = " SELECT * FROM tbl_size WHERE size_id = '$size_id'";
            $result = $this->db->select($sql);
            return $result;
        }
        public function search_product($search) {
            $sql = " SELECT * FROM tbl_product WHERE product_name LIKE '%$search%'";
            $result = $this->db->select($sql);
            return $result;
        }
        public function search_product_with_pagination($search, $start, $limit) {
            
            $sql = " SELECT tbl_product.* , tbl_brand.brand_name, tbl_category.category_name FROM tbl_product
            INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id
            INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
            WHERE tbl_product.status = 1 AND product_name LIKE '%$search%'
            ORDER BY category_id DESC LIMIT $start,$limit";
            $result = $this->db->select($sql);
            return $result;
        }
        public function show_product_lock() {
            $sql = "SELECT tbl_product.*, tbl_category.category_name , tbl_brand.brand_name
            FROM tbl_brand INNER JOIN tbl_category ON tbl_brand.category_id = tbl_category.category_id
                            INNER JOIN tbl_product ON tbl_brand.brand_id = tbl_product.brand_id 
            WHERE tbl_product.status = 0
            ORDER BY tbl_brand.category_id DESC";
            $result = $this->db->select($sql);
            return $result;
        }
        public function product_lock_pagination($limit, $start) {
            $sql = "SELECT tbl_product.* , tbl_brand.brand_name, tbl_category.category_name FROM tbl_product
            INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id
            INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
            WHERE tbl_product.status = 0
            ORDER BY category_id DESC LIMIT $start,$limit";
            $result = $this->db->select($sql);
            return $result;
        }
        public function lock_product($product_id) {
            $sql = "UPDATE tbl_product 
            SET  status =  0
            WHERE product_id = '$product_id'";
            $result = $this->db->update($sql);
            return $result;
        }
        public function unlock_product($product_id) {
            $sql = "UPDATE tbl_product 
            SET  status =  1
            WHERE product_id = '$product_id'";
            $result = $this->db->update($sql);
            return $result;
        }

        //trừ số lượng sản phẩm trong kho sau khi đặt hàng thành công
        public function subtract_product_quantity($order_id) {
            $sql = "UPDATE tbl_storage 
            JOIN tbl_order_detail ON tbl_storage.product_id = tbl_order_detail.product_id 
            AND tbl_storage.size_id = tbl_order_detail.size_id 
            JOIN tbl_order ON tbl_order.order_id = tbl_order_detail.order_id
            SET tbl_storage.quantity = tbl_storage.quantity - tbl_order_detail.quantity 
            WHERE tbl_order.order_id = '$order_id' AND tbl_order.status = 2 AND tbl_storage.quantity >=  tbl_order_detail.quantity ";
            $result = $this->db->update($sql);
            return $result;
        }
       
    }

?>