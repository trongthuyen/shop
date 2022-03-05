<?php

class adminModel extends db {
    use tool;

    public function getListRole($id = null) {
        $sql = "SELECT * FROM role";
        if($id) {
            $sql .= " WHERE id = '$id'";
            return $this->excuteResult($sql, true);
        }
        return $this->excuteResult($sql);

    }

    public function getListUser($offset = 0, $id = null) {
        $sql = "SELECT user.*, role.name as role_name FROM user LEFT JOIN role
        ON user.role_id = role.id WHERE user.is_deleted = 0";
        if($id != null) {
            $sql = $sql." AND user.id = ".$id;
            return $this->excuteResult($sql, true);
        }
        $sql = $sql." LIMIT ".$offset.", ".limit;
        return $this->excuteResult($sql);
    }

    public function getListCategory($offset = 0, $id = null) {
        $sql = "SELECT * FROM category WHERE is_deleted = 0";
        if($id != null) {
            $sql = $sql." AND id = '$id'";
            return $this->excuteResult($sql, true);
        }
        $sql = $sql." ORDER BY name ASC LIMIT ".$offset.", ".limit;
        return $this->excuteResult($sql);
    }

    public function getListProduct($offset = 0, $id = null) {
        $sql = "SELECT product.*, category.name as category_name FROM product LEFT JOIN category
        ON product.category_id = category.id WHERE product.is_deleted = 0";
        if($id != null) {
            $sql = $sql." AND product.id = '$id'";
            return $this->excuteResult($sql, true);
        }
        $sql = $sql." ORDER BY category.name ASC LIMIT ".$offset.", ".limit;
        return $this->excuteResult($sql);
    }

    public function getListFeedback($offset = 0, $id = null) {
        $sql = "SELECT feedback.*, user.fullname as user_name, user.email as user_email FROM feedback LEFT JOIN user
        ON feedback.user_id = user.id";
        if($id != null) {
            $sql = $sql." WHERE feedback.id = '$id'";
        }
        $sql = $sql." ORDER BY feedback.created_at DESC LIMIT ".$offset.", ".limit;
        return $this->excuteResult($sql);
    }
    
    public function getListOrder($offset = 0, $id = null) {
        $sql = "SELECT orders.*, user.email as user_email FROM orders LEFT JOIN user ON user_id = user.id";
        if($id != null) {
            $sql .= " WHERE orders.id = '$id'";
            return $this->excuteResult($sql, true);
        }
        $sql .= " ORDER BY orders.order_date DESC LIMIT ".$offset.", ".limit;
        return $this->excuteResult($sql);
    }

    public function getCountPage($tableName, $is_deleted = true) {
        $sql = "SELECT * FROM ".$tableName;
        if(!$is_deleted) {
            $sql .= " WHERE is_deleted = 0";
        }
        return ceil(count($this->excuteResult($sql, false, false)) / limit);
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