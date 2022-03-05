<?php

class order extends db {
    use tool;

    public function processOrder($id, $value) {
        if($value == -1) {
            $sql = "DELETE FROM orders WHERE id = '$id'";
            return $this->excute($sql);
        }
        $sql = "UPDATE orders SET status = '$value' WHERE id = '$id'";
        return $this->excute($sql);
    }
    public function deleteOrder($ref, $id) {
        if($ref == 'user') {
            $sql = "DELETE FROM orders WHERE user_id = '$id'";
        } else if($ref == 'product') {
            $sql = "DELETE FROM orders WHERE product_id = '$id'";
        }
        return $this->excute($sql);
    }
}

?>