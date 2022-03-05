<style>
    td {
        height: 50px;
    }
</style> 
<div class="block-manage">

    <div class="man-header">
        <h2 class="man-heading">Chi tiết đơn hàng</h2>
    </div>
    <div class="mygrid man-body">
        <i>Thời gian giao hàng dự kiến từ 5 đến 7 ngày</i>
        <div class="myrow">
            <div class="mycol myl-5 mym-5 myc-12">
                <ul class="order-list">
                <?php
                $data["listOrder"] = json_decode($data["listOrder"], true);
                $output = '';
                $status = 'border-left-warning';
                foreach($data["listOrder"] as $item) {
                    if($item["status"] == 0) {
                        $status = 'border-left-danger';
                    } else if($item["status"] == 2) {
                        $status = 'border-left-success';
                    } else {
                        $status = 'border-left-warning';
                    }

                    $output = $output.'<li class="order-item '.$status.'" id="order-item-'.$item["id"].'" onclick="showOrderDetail(`'.$item["id"].'`, `'.$item["product_title"].'`, `'.$item["quantity"].'`, `'.$item["total_money"].'`, `'.$item["phone_number"].'`, `'.$item["address"].'`, `'.$item["order_date"].'`, `'.$item["note"].'`, '.$item["status"].')">
                    <input type="radio" name="radio-myorder" class="radio-myorder" id="radio-myorder-'.$item["id"].'">';
                    $output = $output.'<label for="radio-myorder-'.$item["id"].'" class="lable-myorder d-flex">
                        <div class="item-head">
                            <h6 class="item-title">'.$item["product_title"].'</h6>
                        </div>
                        <div class="item-foo">
                            <p class="item-num">x'.$item["quantity"].'</p>
                            <p class="item-num">'.$item["total_money"].'VND</p>
                        </div>';
                    $output = $output.'</label></li>';
                }
                echo $output;
                ?>
                </ul>
            </div>
            <div class="mycol myl-7 mym-7 myc-12">
                <div class="item-detail item-border-dot" id="item-detail">
                    <div class="box-header">
                        <h6 class="box-heading">Chi tiết đơn hàng</h6>
                    </div>
                    <div class="box-body">
                        <div class="box-body-main">
                            <div class="main-box-body-line">
                                <div class="line-lable">Mã đơn hàng:</div>
                                <div class="line-value" id="order-code">#</div>
                            </div>
                            <div class="main-box-body-line">
                                <div class="line-lable">Tên sản phẩm:</div>
                                <div class="line-value" id="order-title">#</div>
                            </div>
                            <div class="main-box-body-line">
                                <div class="line-lable">Số lượng:</div>
                                <div class="line-value" id="order-quantity">#</div>
                            </div>
                            <div class="main-box-body-line">
                                <div class="line-lable">Tổng tiền:</div>
                                <div class="line-value" id="order-sum">#</div>
                            </div>
                            <div class="main-box-body-line">
                                <div class="line-lable">Số điện thoại:</div>
                                <div class="line-value" id="order-phone">#</div>
                            </div>
                            <div class="main-box-body-line">
                                <div class="line-lable">Địa chỉ:</div>
                                <div class="line-value" id="order-addr">#</div>
                            </div>
                            <div class="main-box-body-line">
                                <div class="line-lable">Ngày đặt hàng:</div>
                                <div class="line-value" id="order-date">#</div>
                            </div>
                            <div class="main-box-body-line">
                                <div class="line-lable">Trạng thái:</div>
                                <div class="line-value" id="order-status">#</div>
                            </div>
                        </div>
                        <div class="box-body-sub">
                            <div class="sub-box-body-line">
                                <div class="line-lable">Ghi chú:</div>
                                <div class="line-value" id="order-note"></div>
                            </div>
                            <div class="sub-box-body-line" id="btnCancelOrder" style="text-align: right;">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>