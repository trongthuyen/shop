function ajaxSeenFeedback(id, value, page) {
    value = value == 1 ? 0 : 1;
    $.ajax({
        url: DOMAIN + "/admin/processFeedback/seen/id=" + id,
        type: "POST",
        data: {value: value},
        success: function(data) {
            console.log(data)
            loadFeedback(page);
        }
    })
}

function ajaxMarkingFeedback(id, value, page) {
    value = value == 1 ? 0 : 1;
    $.ajax({
        url: DOMAIN + "/admin/processFeedback/marked/id=" + id,
        type: "POST",
        data: {value: value},
        success: function(data) {
            console.log(data)
            loadFeedback(page);
        }
    })

}

function loadFeedback(page) {
    $.ajax({
        url: DOMAIN + "/admin/feedback/getAjax/page=" + page,
        type: "POST",
        success: function(list) {
            list = JSON.parse(list)
            console.log(list)
            let index = (page - 1) * limit + 1
            let html = ``
            for(item of list) {
                if(item["is_seen"] == 1) {
                    html += `<tr id="tr-${item}">
                        <td class="td-shorter td-center">${index}</td>
                        <td id="item-${item}">${item["user_name"]}</td>
                        <td class="width-400px">${item["content"]}</td>
                        <td class="width-100px td-right">${item["updated_at"]}</td>
                        <td class="width-100px text-center" id="btn-edit-${item}">
                            <div class="color-white bg-green btn-radius" onclick="ajaxSeenFeedback(${item["id"]}, ${item["is_seen"]}, ${page})">
                                Đã xem
                            </div>
                        </td>`
                    if(item["marked"] == 1) {
                        html += `<td class="td-shorter text-center">
                            <div class="btn-radius btn-yellow" onclick="ajaxMarkingFeedback(${item["id"]}, ${item["marked"]}, ${page})">
                                <i class="fas fa-star"></i>
                            </div>
                        </td>
                    </tr>`
                    }
                    else if(item["marked"] == 0) {
                        html += `<td class="td-shorter text-center">
                            <div class="btn-radius btn-yellow" onclick="ajaxMarkingFeedback(${item["id"]}, ${item["marked"]}, ${page})">
                                <i class="far fa-star"></i>
                            </div>
                        </td>
                    </tr>`
                    }
                }
                else if(item["is_seen"] == 0) {
                    html += `<tr class="bg-gray" id="tr-${item}">
                        <td class="td-shorter td-center">${index}</td>
                        <td id="item-${item}">${item["user_name"]}</td>
                        <td class="width-400px">${item["content"]}</td>
                        <td class="width-100px td-right">${item["updated_at"]}</td>
                        <td class="width-100px text-center" id="btn-edit-${item}">
                            <div class="color-white btn-radius bg-error" onclick="ajaxSeenFeedback(${item["id"]}, ${item["is_seen"]}, ${page})">
                                Chưa xem
                            </div>
                        </td>`
                    if(item["marked"] == 1) {
                        html += `<td class="td-shorter text-center">
                            <div class="btn-radius btn-yellow" onclick="ajaxMarkingFeedback(${item["id"]}, ${item["marked"]}, ${page})">
                                <i class="fas fa-star"></i>
                            </div>
                        </td>
                    </tr>`
                    }
                    else if(item["marked"] == 0) {
                        html += `<td class="td-shorter text-center">
                            <div class="btn-radius btn-yellow" onclick="ajaxMarkingFeedback(${item["id"]}, ${item["marked"]}, ${page})">
                                <i class="far fa-star"></i>
                            </div>
                        </td>
                    </tr>`
                    }
                }
                index++

            }
            document.querySelector('#list-feedback').innerHTML = html
        }
    })

}


function addFeedback(product_id, isLogin, user_id) {
    if(!isLogin) {
        if(confirm('Bạn có muốn đăng nhập để tiếp tục thao tác?')) {
            window.location.replace(DOMAIN + '/login')
        }
        return
    }
    let content = $('#content').val()
    if(content == '') {
        return
    } else {
        $.ajax({
            url: DOMAIN + '/home/processFeedback/add/product_id=' + product_id,
            type: 'POST',
            data: {content},
            success: function(data) {
                if(JSON.parse(data)) {
                    $('#content').val('')
                    loadFeedbacHome(product_id, isLogin, user_id, false)
                }
            }
        })
    }
}
function editFeedback(id, product_id, isLogin, user_id) {
    if(!isLogin) {
        if(confirm('Bạn có muốn đăng nhập để tiếp tục thao tác?')) {
            window.location.replace(DOMAIN + '/login')
        }
        return
    }
    let content = $('#edit-input-'+id).val()
    if(content == '') {
        return
    } else {
        $.ajax({
            url: DOMAIN + '/home/processFeedback/edit/id=' + id,
            type: 'POST',
            data: {content},
            success: function(data) {
                if(JSON.parse(data)) {
                    $('#form-edit-'+id).toggleClass('d-none')
                    $('#feedback-content-'+id).html(content)
                    loadFeedbacHome(product_id, isLogin, user_id, false)
                }
            }
        })
    }
}
function deleteFeedback(id, product_id, isLogin, user_id) {
    if(!isLogin) {
        if(confirm('Bạn có muốn đăng nhập để tiếp tục thao tác?')) {
            window.location.replace(DOMAIN + '/login')
        }
        return
    }
    if(!confirmAction()) {
        return
    }
    $.ajax({
        url: DOMAIN + '/home/processFeedback/delete/id=' + id,
        type: 'POST',
        success: function(data) {
            if(JSON.parse(data)) {
                loadFeedbacHome(product_id, isLogin, user_id, false)
            }
        }
    })
}

function loadFeedbacHome(product_id, isLogin, user_id, viewFeedback = false) {
    let action = viewFeedback ? '/viewFeedback' : '/viewFeedbackPart'
    $.ajax({
        url: DOMAIN + '/home/productDetail/id=' + product_id + action,
        type: 'POST',
        success: function(data) {
            data = JSON.parse(data)
            let html = ''
            for(item of data) {
                html += `<li class="feedback-item">
                <b class="feedback-name">${item["user_name"]}</b>
                <i class="feedback-content">: (${item["created_at"]})</i>
                <p class="feedback-content" id="feedback-content-${item["id"]}">${item["content"]}</p>`
                if(user_id == item["user_id"]) {
                    html += `<span class="feedback-action" onclick="actionEditor(${item['id']})">Sửa</span>
                    <span class="feedback-action">Xóa</span>`
                }
                html += `<form action="" class="form-edit d-none" id="form-edit-${item['id']}">
                <input type="text" checked name="edit-input" id="edit-input-${item['id']}" class="edit-input search-item width-200px" value="${item['content']}">
                <span class="feedback-action" onclick="editFeedback(${item["id"]}, ${product_id}, ${isLogin}, ${user_id})">Lưu</a>
            </form>
        </li>`
            }
            $('#feedback-list').html(html)
        }
    })
}

function actionEditor(id) {
    console.log(id)
    $('#form-edit-'+id).toggleClass('d-none')
}