function displayImg() {
    let thumbnailLink = $('#thumbnail').value;
    if(thumbnailLink) {
        $('#preview-img').src = thumbnailLink;
        return
    }
    $('#preview-img').src = 'https://cdn4.iconfinder.com/data/icons/meBaze-Freebies/512/preview.png';
}


function ajaxProduct(action, id, page) {
    if(action == 'delete') {
        if(confirmAction() == false) {
            return
        }
        $.ajax({
            url: DOMAIN + '/admin/processProduct/del/id=' + id,
            type: 'POST',
            success: function(data) {
                console.log(data)
                    loadProduct(page)
            }
        })
    }
    else if(action == 'get') {
        $.ajax({
            url: DOMAIN + '/admin/product/get/page=' + id,
            type: 'GET',
            success: function(data) {
                data = JSON.parse(data)
                let index = (id - 1) * limit + 1
                let html = ''
                for(item of data) {
                    html += `<tr>
                        <td class="td-center" style="width:36px;">${index}</td>
                        <td class="width-100px td-normal">
                            <img src="${item["thumbnail"]}" alt="Ảnh" class="width-100px">
                        </td>
                        <td>${item["title"]}</td>
                        <td class="width-150px">${item["category_name"]}</td>
                        <td class="width-150px text-right">${item["price"]} VND</td>
                        <td class="td-shorter text-right">${item["discount"]} %</td>
                        <td class="width-100px text-right">${item["updated_at"]}</td>
                        <td class="td-shorter text-center">
                            <a href="${DOMAIN}/admin/product/edit/id=${item["id"]}">
                                <button type="button" class="btn btn-outline-warning">
                                    <i class="fas fa-pen-nib"></i>
                                </button>
                            </a>
                        </td>
                        <td class="td-shorter text-center">
                            <button type="button" class="btn btn-outline-danger" onclick="ajaxProduct('delete', ${item["id"]})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`
                    index++
                }
                $('#list-product').html(html)
            }
        })
    }
}

function loadProduct(page) {
    console.log(1)
    $.ajax({
        url: DOMAIN + `/admin/product/getAjax/page=${page}`,
        type: 'POST',
        success: function(data) {
            data = JSON.parse(data)
            console.log(data)
            let index = (page - 1) * limit + 1;
            let html = ''
            for(item of data) {
                html += `<tr>
                    <td class="td-center" style="width:36px;">${index}</td>
                    <td class="width-100px td-normal">
                        <img src="${item["thumbnail"]}" alt="Ảnh" class="width-100px">
                    </td>
                    <td>${item["title"]}</td>
                    <td class="width-150px">${item["category_name"]}</td>
                    <td class="width-150px text-right">${item["price"]} VND</td>
                    <td class="td-shorter text-right">${item["discount"]} %</td>
                    <td class="width-100px text-right">${item["updated_at"]}</td>
                    <td class="td-shorter text-center">
                        <a href="${DOMAIN}/admin/product/edit/id=${item["id"]}">
                            <button type="button" class="btn btn-outline-warning">
                                <i class="fas fa-pen-nib"></i>
                            </button>
                        </a>
                    </td>
                    <td class="td-shorter text-center">
                        <button type="button" class="btn btn-outline-danger" onclick="ajaxProduct('delete', ${item["id"]}, ${page})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`
                index++
            }
            $('#list-product').html(html)
        }
    })
}