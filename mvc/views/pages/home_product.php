<div class="mygrid padding-0-12">
    <div class="myrow">
        <h2 class="mycol l-12 m-12 c-12 page-title">
            <?php
            if($data["category"] != "") {
                echo json_decode($data["category"], true)["name"];
            } else {
                // echo 'Toàn bộ sản phẩm';
            }
            ?>
        </h2>
    </div>
    <div class="myrow">
    <?php
    $listProduct = json_decode($data["listProduct"], true);
    $output = '';
    foreach($listProduct as $item) {
        $product_id = $item["id"];
        $product_price = $item["price"];
        $output .= '<div class="mycol myl-2-4 mym-3 myc-6 margin-bot-16px">
            <div class="box-item bg-orange-light">
                <div class="item-header bg-light">
                    <img src="'.$item["thumbnail"].'" class="item-img">
                </div>
                <div class="item-body">
                    <h6 class="item-title">'.$item["title"].'</h6>
                    <p class="item-content">'.$item["price"].' VND</p>
                </div>
                <div class="box-item-more bg-dark-opacity">
                    <div class="bg-item-more">
                        <div class="item-info">
                            <h6 class="item-title">'.$item["title"].'</h6>
                            <p class="item-content">Danh mục: '.$item["category_name"].'</p>
                            <p class="item-content">Giá: '.$item["price"].' VND</p>
                        </div>
                        <div class="item-action">
                            <a href="'.$links["productDetail"].$item["id"].'">
                                <button class="btn-product btn-bg">Xem chi tiết</button>
                            </a>
                            <span>
                                <button type="button" class="btn-product btn-bg">Mua</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
    echo $output;
    ?>
    </div>

    <div class="myrow">
        <div class="mycol myl-12 mym-12 myc-12">
            <div class="item-center">
            <?php
            require_once "./mvc/views/components/pagination.php";
            ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once './mvc/views/components/formOrder.php';
?>