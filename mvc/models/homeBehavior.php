<?php

class homeBehavior extends db {
    use tool;

    public function processOrder($user_id, $product_id, $quantity, $phone_number, $address, $note, $total_money) {
        $order_date = date('Y-m-d H:m:s');
        $sql = "INSERT INTO orders (user_id, product_id, quantity, phone_number, address, note, order_date, status, total_money)
        VALUES ('$user_id','$product_id','$quantity','$phone_number','$address','$note','$order_date', 1,'$total_money')";
        return $this->excute($sql);
    }
    public function addFeedback($user_id, $product_id, $content) {
        $created_at = $updated_at = date('Y-m-d H:m:s');
        $sql = "INSERT INTO feedback (user_id, product_id, content, created_at, updated_at, is_seen, marked)
        VALUES ('$user_id','$product_id','$content','$created_at','$updated_at',0,0)";
        return $this->excute($sql);
    }
    public function editFeedback($id, $content) {
        $updated_at = date('Y-m-d H:m:s');
        $sql = "UPDATE feedback SET content = '$content', updated_at = '$updated_at' WHERE id = '$id'";
        return $this->excute($sql);
    }
    public function deleteFeedback($id) {
        $sql = "DELETE FROM feedback WHERE id = '$id'";
        return $this->excute($sql);
    }
}

?>