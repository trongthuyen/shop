<div class="modelForm d-none" id="modelForm">
    <div class="modelForm-form" id="modelForm-form">
        <div class="container bg-pink-light">
            <div class="panel">
                <div class="panel-heading">
                    <h2 class="text-center">Thông tin đơn hàng</h2>
                    <p class="panel-subheading">
                        <span class="btn-span" onclick="actionModel('close')">Đóng</span>
                    </p>
                </div>
                <div class="panel-body">
                    <form method="POST">
                        <div class="form-item">
                            <label class="form-item-lable" for="phone_number">Số điện thoại *:</label>
                            <input required="true" type="text" name="phone_number" class="form-item-input" id="phone_number">
                            <span id="error-phone"></span>
                        </div>
                        <div class="form-item">
                            <label class="form-item-lable" for="address">Địa chỉ nhận hàng *:</label>
                            <input required="true" type="text" name="address" class="form-item-input" id="address">
                            <span id="error-address"></span>
                        </div>
                        <div class="form-item">
                            <div class="quantity-edit">
                                <span>Số lượng:</span>
                                <div>
                                    <div class="btn-adjust bg-orange-light" id="resetQuantity" <?php echo 'onclick="editQuantity(`reset`, '.$product_price.')"' ?>>Reset</div>
                                    <div class="btn-adjust bg-orange-light" id="btndownx5" <?php echo 'onclick="editQuantity(`downx5`, '.$product_price.')"' ?>>-5</div>
                                    <div class="btn-adjust bg-orange-light" id="btndown" <?php echo 'onclick="editQuantity(`down`, '.$product_price.')"' ?>>-</div>
                                    <p class="quantity-item" id="quantity-sum">1</p>
                                    <div class="btn-adjust bg-orange-light" id="btnup" <?php echo 'onclick="editQuantity(`up`, '.$product_price.')"' ?>>+</div>
                                    <div class="btn-adjust bg-orange-light" id="btnupx5" <?php echo 'onclick="editQuantity(`upx5`, '.$product_price.')"' ?>>+5</div>
                                </div>
                            </div>
                            <div>
                                <p id="money-sum"><?=$product_price?> VND</p>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="note">Ghi chú:</label>
                            <textarea name="note" id="note" class="form-item-input" cols="40" rows="5"></textarea>
                        </div>
                        <button type="button" class="btn-adjust bg-orange-light width-100" id="btnOrder" name="btnOrder" <?php echo 'onclick="processOrder('.$product_id.', '.$product_price.', '.$isLogin.')"' ?>>Thanh toán</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>