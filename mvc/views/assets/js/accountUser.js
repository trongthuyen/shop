function ajaxUser(action, id, page) {
    if(action == 'delete') {
        if(confirmAction() == false) {
            return
        }
        $.ajax({
            url: DOMAIN + '/admin/processUser/del/id=' + id,
            type: 'POST',
            success: function(data) {
                data = JSON.parse(data)
                console.log(data)
                if(data) {
                    loadUser(page)
                }
                else {
                    alert('Có lỗi xảy ra, vui lòng kiểm tra feedback, đơn hàng hoặc quyền tài khoản!')
                }
            }
        })
    }
}

function loadUser(page) {
    $.ajax({
        url: DOMAIN + '/admin/user/getAjax/page=' + page,
        type: 'POST',
        success: function(data) {
            data = JSON.parse(data)
            let index = (page-1) * limit + 1;
            let html = ''
            for(item of data) {
                html += `<tr>
                    <td class="td-center">${index}</td>
                    <td class="td-normal">${item["fullname"]}</td>
                    <td>${item["email"]}</td>
                    <td class="td-normal text-right">${item["phone_number"]}</td>
                    <td class="td-shorter text-center">${item["role_name"]}</td>
                    <td class="td-shorter text-center">
                    <a href="${DOMAIN}/admin/user/edit/id=${item["id"]}">
                        <button type="button" class="btn btn-outline-warning">
                            <i class="fas fa-pen-nib"></i>
                        </button>
                    </a>
                    </td>
                    <td class="td-shorter text-center">
                        <button type="button" class="btn btn-outline-danger" onclick="ajaxUser('delete', ${item["id"]}, ${page})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`
                index++
            }
            $('#list-user').html(html)
        }
    })
}

function ajaxInfo(action) {
    if(!confirmAction()) {
        return false;
    }
    if(action === 'logout') {
        let gotoHome = confirm('Trở lại trang chủ?')
        if(gotoHome == true) {
            $.ajax({
                url: DOMAIN + '/info/logout',
                type: 'POST',
                success: function(data) {
                    if(JSON.parse(data)) {
                        window.location.replace(DOMAIN + '/home');
                    }
                    else {
                        alert('Đăng xuất thất bại!')
                    }
                }
            })
        }
        else {
            // $('#logout').href(DOMAIN + '/login')
            window.location.replace(DOMAIN + '/login');
        }
    }

    else if(action === 'update') {
        if(!validateForm()) {
            return false;
        }
        let fullname = $('#usr').val()
        let email = $('#email').val()
        let phone_num = $('#phone_num').val()
        let addr = $('#addr').val()
        let pwd = $('#pwd').val()
        let oldPwd = $('#old-pwd').val()
        $.ajax({
            url: DOMAIN + '/info/updateInfo',
            type: 'POST',
            data: {fullname, email, phone_num, addr, pwd, oldPwd},
            success: function (data) {
                console.log(data)
                if(JSON.parse(data)) {
                    alert('Cập nhật thành công!')
                    window.location.reload();
                }
                else {
                    alert('Cập nhật thất bại, thông tin không hợp lệ!')
                }
            }
        })
    }

    else if(action === 'del-account') {
        $.ajax({
            url: DOMAIN + '/info/delAccount',
            type: 'POST',
            success: function(data) {
                if(JSON.parse(data)) {
                    let gotoHome = confirm('Trở lại trang chủ?')
                    if(gotoHome == true) {
                        window.location.replace(DOMAIN + '/home');
                    }
                    else {
                        window.location.replace(DOMAIN + '/login');
                    }
                }
                else {
                    alert('Không thể xóa tài khoản này, vui lòng kiểm tra quyền!')
                }
            }
        })
    }

    return true
}