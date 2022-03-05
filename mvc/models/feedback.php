<?php

class feedback extends db {
    use tool;
    public function processFeedback($action, $id, $value) {
        if($action == 'seen') {
            $sql = "UPDATE feedback SET is_seen = '$value' WHERE id = '$id'";
        }
        else if($action == 'marked') {
            $sql = "UPDATE feedback SET marked = '$value' WHERE id = '$id'";
        }
        return $this->excute($sql);
    }
    public function deleteFeedback($ref, $id) {
        if($ref == 'user') {
            $sql = "DELETE FROM feedback WHERE user_id = '$id'";
        } else if($ref == 'product') {
            $sql = "DELETE FROM feedback WHERE product_id = '$id'";
        }
        return $this->excute($sql);
    }

}

?>