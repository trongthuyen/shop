# Xây dựng bố cục folder/file

> Bố cục folder/file mô hình MVC
0. shop
    index.php (file chính)
    htaccess (file cấu hình URL)
    > file export sql
    - database
        technology_shop.sql
    > các file phân tích đề tài
    - guilder
        analist.md
        design_db.md
        frame_web.md
    > mô hình MVC
    - mvc
        access.php (là cầu nối giữa index.php với các file khác)
        htaccess
        > chứa các file chứa hàm tiện ích hay sử dụng, kết nối database,...
        - core
        > controllers chứa các file thuộc về controller để tương tác giữa model và view
        - controllers
            admin.php
            home.php
            info.php
            login.php
            register.php
        > models chứa các file tương tác dữ liệu từ database
        - models
            > model lấy/xử lý dữ liệu và trả về dạng json
        > views chứa mã HTML5, CSS3, JAVASCRIPT để render ra website cho người
        - views
            > các file trang chính
            admin.php
            home.php
            info.php
            login.php
            > assets chứa các file nhúng link css, js và mã css, js
            - assets
                main_css.php
                main_js.php
                - css
                - js
                - icon for web
                - thumbnail
            > blocks chứa các thành phần cố định của trang web như header, navbar, sidebar, footer
            - blocks
            > components chứa các thành phần nhỏ như toast, phân trang, form
            - components
            > pages chứa mã html phần thân web
            - pages