function ajaxOrder(action, id, page) {
    let value = -1
    if(action == 'accept') {
        value = 2
    }
    else if(action == 'reject') {
        value = 0
    }
    else if(action == 'delete') {
        if(confirmAction() == false) return
    }
    $.ajax({
        url: DOMAIN + '/admin/processOrder/id=' + id,
        type: 'POST',
        data: {value: value},
        success: function(data) {
            console.log(data)
            loadOrder(page);
        }
    })
}


function loadOrder(page) {
    $.ajax({
        url: DOMAIN + '/admin/order/getAjax/page=' + page,
        type: 'POST',
        success: function(data) {
            data = JSON.parse(data);
            let index = (page - 1) * limit + 1
            let html = ``
            for(item of data) {
                html += `<tr id="tr-${index}">
                <td class="width-50px td-center">${index}</td>
                <td class="width-200px" id="item-${index}">${item["user_email"]}</td>
                <td class="width-100px">${item["phone_number"]}</td>
                <td class="width-200px">${item["address"]}</td>
                <td class="td-shorter td-center">${item["id"]}</td>
                <td class="width-100px td-right">${item["order_date"]}</td>
                <td class="td-right">${item["total_money"]}</td>
                <td class="width-100px text-center" id="btn-edit-${index}">`
                if(item["status"] == 0) {
                    html += `<div class="color-white bg-error btn-radius" onclick="ajaxOrder('accept' , ${item["id"]}, ${page})">
                        Đã hủy
                    </div>
                </td>`
                html += `<td class="width-100px text-center" id="btn-edit-${index}">
                        <div class="color-white bg-error btn-radius" onclick="ajaxOrder('delete' , ${item["id"]}, ${page})">
                            Xóa đơn
                        </div>
                    </td>
                </tr>`
                }
                else if(item["status"] == 1) {
                    html += `<div class="color-white bg-yellow btn-radius" onclick="ajaxOrder('accept' , ${item["id"]}, ${page})">
                            Chờ duyệt
                        </div>
                    </td>`
                    html += `<td class="width-100px text-center" id="btn-edit-${index}">
                        <div class="color-white bg-yellow btn-radius" onclick="ajaxOrder('reject' , ${item["id"]}, ${page})">
                            Hủy đơn
                        </div>
                    </td>
                </tr>`
                }
                else if(item["status"] == 2) {
                    html += `<div class="color-white bg-green btn-radius">
                            Đã duyệt
                        </div>
                    </td>`
                    html += `<td class="width-100px text-center" id="btn-edit-${index}">
                        <div class="color-white bg-yellow btn-radius" onclick="ajaxOrder('reject' , ${item["id"]}, ${page})">
                            Hủy đơn
                        </div>
                    </td>
                </tr>`
                }
                index++
            }
            $('#list-order').html(html)
        }
    })
}



// info/myorder
function showOrderDetail(id, title, quantity, total, phone, address, orderDate, note, status) {
    
    let msgStatus = ''
    if(status == 0) {
        msgStatus = 'Đã hủy'
    } else if(status == 2) {
        msgStatus = 'Đã duyệt - Đang giao hàng'
    } else msgStatus = 'Đang chờ duyệt'

    $('#order-code').html(id);
    $('#order-title').html(title);
    $('#order-quantity').html(quantity);
    $('#order-sum').html(total+' VND');
    $('#order-phone').html(phone);
    $('#order-date').html(orderDate);
    $('#order-status').html(msgStatus);
    $('#order-addr').html(address);
    $('#order-note').html(note);
    
    if(status != 0) {
        let html = `<span class="btnCancelOrder" onclick="ajaxInfoOrder('cancel', ${id}, ${status})">Hủy đơn hàng</span> <br>
        <i style="color:red">(Bạn không thể hoàn tác sau khi hủy, hãy cân nhắc!)</i>`
    
        $('#btnCancelOrder').html(html);
    } else {
        $('#btnCancelOrder').html('');
    }
    

}

function ajaxInfoOrder(action, id, status) {
    if(action == 'cancel') {
        if(!confirmAction()) {
            return
        }
        $.ajax({
            url: DOMAIN + '/info/processMyOrder/cancel/id=' + id,
            type: 'POST',
            success: function(data) {
                if(JSON.parse(data)) {
                    $('#order-status').html('Đã hủy')
                    $('#btnCancelOrder').html('')
                    let oldBorderLeft = ''
                    let newBorderLeft = 'border-left-danger'
                    if(status == 1 ) {
                        oldBorderLeft = 'border-left-warning'
                    }
                    else if(status == 2) {
                        oldBorderLeft = 'border-left-success'
                    }
                    $('#order-item-'+id).removeClass(oldBorderLeft).addClass(newBorderLeft)
                }
                else {
                    alert("Đã xảy ra lỗi, vui lòng thử lại sau!")
                }
            }
        })
    }
    else if(action == 'close') {

    }
}


function editQuantity(action, price) {
    if(action == 'reset') {
        $('#quantity-sum').html(1)
        $('#money-sum').html(price+' VND')
        return false
    }
    let s = $('#quantity-sum').html()
    s = parseInt(s)
    if(action == 'down') {
        if(s > 1) {
            s -= 1
            let newprice = s * price
            $('#quantity-sum').html(s)
            $('#money-sum').html(newprice + ' VND')
        }
    } else if(action == 'up') {
        s += 1
        let newprice = s * price
        $('#quantity-sum').html(s)
        $('#money-sum').html(newprice + ' VND')
    } else if(action == 'downx5') {
        if(s > 1) {
            s -= 5
            s = s < 1 ? 1 : s
            let newprice = s * price
            $('#quantity-sum').html(s)
            $('#money-sum').html(newprice + ' VND')
        }
    } else if(action == 'upx5') {
        s += 5
        let newprice = s * price
        $('#quantity-sum').html(s)
        $('#money-sum').html(newprice + ' VND')
    }
}

function processOrder(id, price, isLogin) {
    if(!isLogin) {
        if(confirm('Bạn có muốn đăng nhập để tiếp tục thao tác?')) {
            window.location.replace(DOMAIN + '/login')
        }
        return
    }
    let phone_number = $('#phone_number').val()
    let address = $('#address').val()
    if(phone_number == '') {
        $('#error-phone').html('Thiếu số điện thoại!')
        return
    } else if(address == '') {
        $('#error-phone').html('Thiếu địa chỉ nhận hàng!')
        return
    }
    let s = $('#quantity-sum').html()
    s = parseInt(s)
    price = s * price
    let note = $('#note').val()
    $.ajax({
        url: DOMAIN + '/home/processOrder/product_id=' + id,
        type: 'POST',
        data: {phone_number, address, quantity: s, total_money: price, note},
        success: function(data) {
            if(JSON.parse(data)) {
                alert('Đặt hàng thành công, đơn hàng đang chờ được duyệt!')
                actionModel('close')
            } else {
                alert('Đã xảy ra lỗi!')
            }
        }
    })
}

function actionModel(action) {
    if(action == 'close') {
        $('#modelForm').addClass('d-none')
    } else if(action == 'open') {
        $('#modelForm').removeClass('d-none')
    }
}