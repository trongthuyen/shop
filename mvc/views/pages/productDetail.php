<?php
$product = json_decode($data["product"], true);
$product_price = $product["price"];
$product_id = $product["id"];
$listFeedback = json_decode($data["listFeedback"], true);
?>

<div class="mygrid padding-40-80">
    <div class="myrow">
        <div class="mycol myl-6 mym-6 myc-12">
            <div class="product-img">
                <img src="<?=$product["thumbnail"]?>" class="width-100">
            </div>
        </div>
        <div class="mycol myl-6 mym-6 myc-12">
            <div class="product-info">
                <h3 class="product-title"><?=$product["title"]?></h3>
                <p class="product-content">Nhóm: <?=$product["category_name"]?></p>
                <p class="product-content">Giá: <?=$product["price"]?> VND</p>
            </div>
            <div class="product-buying">
                <button type="button" id="btn-buying" class="btn-buying" onclick="actionModel('open')">Đặt hàng</button>
            </div>
        </div>
    </div>
    <div class="myrow margin-top-50px">
        <div class="mycol myl-12 mym-12 myc-12">
            <div class="product-description">
                <h2 class="product-title">Mô tả sản phẩm</h2>
                <p class="product-content"><?=$product["description"]?></p>
            </div>
        </div>
    </div>
    <div class="myrow padding-top-20px">
        <div class="mycol myl-12 mym-12 myc-12">
            <h3 class="product-title">Đánh giá sản phẩm</h3>
            <div class="form-feedback">
                <label for="content" class="acc-info"><?php if(isset($account["fullname"])) echo $account["fullname"]; else echo "Username: "; ?>:</label>
                <form method="POST" class="form-input" id="feedback">
                    <input type="text" name="content" id="content" class="search-item" placeholder="Viết đánh giá của bạn...">
                    <button type="button" name="btn-search" class="btn-adjust bg-dark" <?php echo 'onclick="addFeedback('.$product_id.', '.$isLogin.', '.$user_id.')"' ?>>
                    <i class="far fa-paper-plane"></i>
                    </button>
                </form>
            </div>
            <div id="feedback-area">
                <ul class="feedback-list" id="feedback-list">
                    <?php
                    $output = '';
                    foreach($listFeedback as $item) {
                        $feedback_id = $item["id"];
                        $output .= '<li class="feedback-item">
                        <b class="feedback-name">'.$item["user_name"].'</b>
                        <i class="feedback-content">: ('.$item["created_at"].')</i>
                        <p class="feedback-content" id="feedback-content-'.$feedback_id.'">'.$item["content"].'</p>';
                        if(isset($account["id"])) {
                            if($account["id"] == $item["user_id"]) {
                                $output .= '<span class="feedback-action" onclick="actionEditor('.$feedback_id.')">Sửa</span>
                                <span class="feedback-action" onclick="deleteFeedback('.$feedback_id.', '.$product_id.', '.$isLogin.', '.$user_id.')">Xóa</span>';
                            }
                        }
                        $output .= '<form class="form-edit d-none" id="form-edit-'.$feedback_id.'">
                            <input type="text" name="edit-input" id="edit-input-'.$feedback_id.'" class="edit-input search-item width-200px" value="'.$item["content"].'">
                            <span class="feedback-action" onclick="editFeedback('.$feedback_id.', '.$product_id.', '.$isLogin.', '.$user_id.')">Lưu</a>
                        </form>
                    </li>';
                    }
                    echo $output;
                    ?>
                    
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
require_once './mvc/views/components/formOrder.php';
?>