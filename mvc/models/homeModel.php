<?php

class homeModel extends db {
    use tool;
    


    public function getListRole($id = null) {
        $sql = "SELECT * FROM role";
        if($id) {
            $sql .= " WHERE id = ".$id;
            return $this->excuteResult($sql, true);
        }
        return $this->excuteResult($sql);

    }
    public function getUserToken() {
        if(isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        $token = $this->get_COOKIE('token');
        $sql = "SELECT * FROM token WHERE token = '$token'";
        $item = $this->excuteResult($sql, true);
        if($item != "null") {
            $userId = json_decode($item, true)['user_id'];
            $sql = "SELECT * FROM user WHERE id = '$userId'";
            $item = $this->excuteResult($sql, true);
            if($item != "null") {
                $_SESSION['user'] = $item;
                return $item;
            }
        }
        return "null";
    }

    public function getListCategory($id = null) {
        $sql = "SELECT * FROM category WHERE is_deleted = 0";
        if($id != null) {
            $sql = $sql." AND id = '$id'";
            return $this->excuteResult($sql, true);
        }
        $sql = $sql." ORDER BY name ASC LIMIT 10";
        return $this->excuteResult($sql);
    }
    public function getListProduct($offset = 0, $category_id = null) {

        $sql = "SELECT product.*, category.name as category_name FROM product LEFT JOIN category ON product.category_id = category.id WHERE product.is_deleted = 0";

        if($category_id != null) {
            $sql .= " AND product.category_id = ".$category_id;
        }
        $sql .= " LIMIT ".$offset.", ".limit;
        return $this->excuteResult($sql);
    }
    
    public function getProduct($id = null) {
        $sql = "SELECT product.*, category.name as category_name FROM product LEFT JOIN category ON product.category_id = category.id WHERE product.id = '$id' AND product.is_deleted = 0";
        return $this->excuteResult($sql, true);
    }

    public function getListFeedback($product_id, $is_full = false) {
        $sql = "SELECT feedback.*, user.fullname as user_name FROM feedback LEFT JOIN user ON user_id = user.id
        WHERE feedback.product_id = ".$product_id." ORDER BY feedback.created_at DESC";
        if($is_full) {
            return $this->excuteResult($sql);
        }
        $sql .= " LIMIT 100";
        return $this->excuteResult($sql);
    }

    public function getCountPage($table, $category_id = null) {
        $sql = "SELECT * FROM ".$table." WHERE is_deleted = 0";
        if($category_id != null) {
            $sql .= " AND category_id = ".$category_id;
        }
        return ceil(count($this->excuteResult($sql, false, false)) / limit);
    }
    public function getListUser($id = null) {
        $sql = "SELECT user.*, role.name as role_name FROM user LEFT JOIN role
        ON user.role_id = role.id WHERE user.is_deleted = 0";
        if($id != null) {
            $sql = $sql." AND user.id = '$id'";
            return $this->excuteResult($sql, true);
        }
        return $this->excuteResult($sql);
    }

    public function getListData($tableName, $keyword) {
        $sql = '';
        switch ($tableName) {
            case 'user':
                $sql = "SELECT user.*, role.name as role_name FROM user LEFT JOIN role
                ON user.role_id = role.id WHERE user.is_deleted = 0 AND
                (user.fullname LIKE '$keyword' OR user.email LIKE '$keyword' OR user.phone_number LIKE '$keyword' OR role.name LIKE '$keyword')";
                break;
            case 'category':
                $sql = "SELECT * FROM category WHERE is_deleted = 0 AND name LIKE '$keyword'
                ORDER BY name ASC";
                break;
            case 'product':
                $sql = "SELECT product.*, category.name as category_name FROM product LEFT JOIN category
                ON product.category_id = category.id WHERE product.is_deleted = 0 AND (product.title LIKE '$keyword' OR product.price LIKE '$keyword' OR category.name LIKE '$keyword')
                ORDER BY category.name ASC";
                break;
            case 'orders':
                $sql = "SELECT orders.*, user.email as user_email FROM orders LEFT JOIN user ON user_id = user.id
                WHERE user.fullname LIKE '$keyword' OR user.email LIKE '$keyword' OR orders.phone_number LIKE '$keyword'
                ORDER BY orders.order_date DESC";
                break;
            case 'feedback':
                $sql = "SELECT feedback.*, user.fullname as user_name, user.email as user_email FROM feedback LEFT JOIN user
                ON feedback.user_id = user.id
                WHERE user.fullname LIKE '$keyword' OR user.email LIKE '$keyword' OR feedback.content LIKE '$keyword'
                ORDER BY feedback.created_at DESC";
                break;
            default: return;
        }
        return $this->excuteResult($sql);
    }





}

?>