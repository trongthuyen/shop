function editCategory(index, id, name, page) {
    let itemIdx = document.getElementById(`item-${index}`)
    let btnEdit = document.getElementById(`btn-edit-${index}`)

    let html = `<div class="input-group margin-0">
        <div class="full-wide">
            <input type="text" class="form-control non-outline" id="edit-cate" name="edit-cate" value="${name}">
            <button class="btn btn-outline-success" type="button" id="btn-check" onclick="ajaxCategory('edit', ${id}, ${page})">
                <i class="fas fa-check"></i>
            </button>
        </div>
    </div>`
    itemIdx.innerHTML = html

    html = `<button onclick="closeEdit(${index}, ${id}, '${name}', ${page})" class="btn btn-outline-danger">
            <i class="fas fa-times"></i>
        </button>`
    btnEdit.innerHTML = html
}

function closeEdit(index, id, name, page) {
    let itemIdx = document.getElementById(`item-${index}`)
    let btnEdit = document.getElementById(`btn-edit-${index}`)

    let html = `${name}`
    itemIdx.innerHTML = html

    html = `<button onclick="editCategory(${index}, ${id}, '${name}', ${page})" class="btn btn-outline-warning">
            <i class="fas fa-pen-nib"></i>
        </button>`
    btnEdit.innerHTML = html
}


function ajaxCategory(action, id = -1, page = 1) {
    if(action === 'add') {
        let name = $('#category-name').val()
        if(name === '') {
            return
        }
        $.ajax({
            url: DOMAIN + "/admin/processCategory/add",
            type: 'POST',
            data: {name: name},
            success: function(data) {
                data = JSON.parse(data)
                if(data === true) {
                    $("#category-name").val('')
                    loadCategory(page)
                }
                else {
                    alert('Danh mục đã tồn tại!')
                }
            },
        })
    }
    else if(action === 'edit') {
        let name = $('#edit-cate').val()
        if(name === '') {
            return
        }
        $.ajax({
            url: DOMAIN + "/admin/processCategory/edit/id=" + id,
            type: 'POST',
            data: {name: name},
            success: function(data) {
                data = JSON.parse(data)
                if(data === true) {
                    loadCategory(page)
                }
                else {
                    alert('Trùng tên danh mục!')
                }
            }
        })
    }
    else if(action === 'delete') {
        let cf = confirmAction()
        if(cf == false) {
            return
        }
        $.ajax({
            url: DOMAIN + "/admin/processCategory/del/id=" + id,
            type: 'POST',
            success: function(data) {
                data = JSON.parse(data)
                if(data === true) {
                    loadCategory(page)
                }
                else {
                    alert('Xóa thất bại!')
                }
            }
        })
    }
    else if(action == 'get') {
        $.ajax({
            url: DOMAIN + '/admin/category/get/page=' + id,
            success: function(data) {
                data = JSON.parse(data)
                let index = (id - 1) * limit + 1
                let html = ''
                for(item of data) {
                    html += `<tr>
                        <td class="td-shorter td-center">${index}</td>
                        <td id="item-${index}">${item["name"]}</td>
                        <td class="td-shorter text-center" id="btn-edit-${index}">
                            <button onclick="editCategory(${index}, ${item["id"]}, '${item["name"]}', ${page})" class="btn btn-outline-warning">
                                <i class="fas fa-pen-nib"></i>
                            </button>
                        </td>
                        <td class="td-shorter text-center">
                            <button type="button" class="btn btn-outline-danger" onclick="ajaxCategory('delete', ${item["id"]}, ${page})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`
                    index++
                }
                document.querySelector('#list-category').innerHTML = html
            }
        })
    }
}

function loadCategory(page) {
    $.ajax({
        url: DOMAIN + `/admin/category/getAjax/page=${page}`,
        type: 'POST',
        success: function(data) {
            data = JSON.parse(data)
            let index = (page - 1) * limit + 1;
            let html = ''
            for(item of data) {
                html += `<tr>
                    <td class="td-shorter td-center">${index}</td>
                    <td id="item-${index}">${item["name"]}</td>
                    <td class="td-shorter text-center" id="btn-edit-${index}">
                        <button onclick="editCategory(${index}, ${item["id"]}, '${item["name"]}', ${page})" class="btn btn-outline-warning">
                            <i class="fas fa-pen-nib"></i>
                        </button>
                    </td>
                    <td class="td-shorter text-center">
                        <button type="button" class="btn btn-outline-danger" onclick="ajaxCategory('delete', ${item["id"]}, ${page})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`
                index++
            }
            document.querySelector('#list-category').innerHTML = html
        }
    })
}