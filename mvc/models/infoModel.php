<?php

class infoModel extends db {
    use tool;

    public function getListRole($id = null) {
        $sql = "SELECT * FROM role";
        if($id) {
            $sql .= " WHERE id = '$id'";
            return $this->excuteResult($sql, true);
        }
        return $this->excuteResult($sql);

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

    public function getListOrder($user_id, $id = null) {
        $sql = "SELECT orders.*, product.title as product_title, product.price as product_price
        FROM orders LEFT JOIN product ON orders.product_id = product.id WHERE orders.user_id = '$user_id'";
        if($id != null) {
            $sql = $sql. " AND orders.id = ".$id;
            return $this->excuteResult($sql, true);
        }
        return $this->excuteResult($sql);
    }

}

?>