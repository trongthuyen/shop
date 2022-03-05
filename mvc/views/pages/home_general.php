<div class="container-home" id="container-home">
    <div class="container-banner" id="container-banner">
        <h1 class="container-title">AIRBNB - NIỀM TỰ HÀO CÔNG NGHỆ</h1>
        <div class="container-service">
            <div class="service-item">
                <a href="<?=$links["product"]?>" class="service-item-link">
                    <i class="fas fa-store service-icon"></i>
                    <p class="service-name">Mua hàng</p>
                </a>
            </div>
            <div class="service-item">
                <a href="#" class="service-item-link">
                    <i class="fas fa-hand-sparkles service-icon"></i>
                    <p class="service-name">Dùng thử</p>
                </a>
            </div>
            <div class="service-item">
                <a href="#" class="service-item-link">
                    <i class="fas fa-toolbox service-icon"></i>
                    <p class="service-name">Bảo dưỡng</p>
                </a>
            </div>
        </div>
    </div>
    <div class="container-body" id="container-about">
        <h3 class="container-title">
            Giới thiệu
        </h3>
        <p class="container-content">
            Airbnb là công ty chuyên về công nghệ uy tín,
            chất lượng hàng đầu bởi cái tên thương hiệu Airbnb
            đã được nhiều khách hàng tin tưởng sử dụng làm mạng viễn thông
            của mình. Airbnb bày bán đa dạng các sản phẩm công nghệ
            thông tin, điện tử, linh kiện điện thoại, Laptop của các thương
            hiệu hàng đầu Thế Giới. Đội ngũ nhân viên tư vấn nhiệt tình,
            có nhiều kinh nghiệm trong lĩnh vực sẽ giúp khách hàng tìm được
            cho mình sản phẩm công nghệ phù hợp nhất với giá cả phải chăng
            và nhiều chương trình hậu mãi, khuyến mãi đi kèm. Đặc biệt hơn,
            Airbnb luôn có chính sách bảo hành tốt và giao hàng
            tận nhà miễn phí cho khách hàng.
        </p>
    </div>
    <div class="container-body" id="container-history">
        <h3 class="container-title">
            Lịch sử thành lập công ty Airbnb
        </h3>
        <p class="container-content">
            Airbnb là công ty công nghệ được thành lập từ đầu năm 2000 với quá trình phát triển
            trải qua nhiều biến động thị trường, và cũng đã đạt được nhiều thành tựu đáng kể.
            Được thành lập từ năm 2000, ban đầu chỉ là một cơ sở doanh nghiệp nhỏ,
            nhờ biết nắm bắt thị trường và nhu cầu người dùng, Airbnb đã từng bước mở rộng đầu tư và quy mô,
            chú trọng rất nhiều đến việc nâng cấp, cải tiến kỹ thuật công nghệ...
        </p>
    </div>
    <div class="container-body" id="container-outstanding">
        <h3 class="container-title">Sản phẩm mới</h3>
        <a href="<?=$links["product"]?>" class="viewmore">Đến cửa hàng</a>
        <div class="mygrid margin-top-36px">
            <div class="myrow">
            <?php
            $listProduct = json_decode($data["listProduct"], true);
            $output = '';
            $index = 0;
            foreach($listProduct as $item) {
                $product_id = $item["id"];
                $product_price = $item["price"];
                $output .= '<div class="mycol myl-3 mym-3 myc-6 margin-bot-16px">
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
                if(++$index >= 4) break;
            }
            echo $output;
            
            ?>
            </div>
        </div>
    </div>
    <div class="container-body" id="container-contact">
        <h3 class="container-title">Liên hệ</h3>
        <div class="mygrid padding-0-80 margin-top-28px">
            <div class="myrow">
                <div class="mycol myl-4 mym-4 myc-12 text-center">
                    <h4 class="foo-title">Liên hệ trực tiếp</h4>
                    <div class="social-foo">
                        <a href="tel:+84353472233" class="color-black">
                            <i class="fas fa-phone-volume contact-icon"></i>
                            Hotline: +84353472233
                        </a>
                    </div>
                    <div class="social-foo">
                        <a href="mailto:trongthuyen2606@gmail.com" class="color-black">
                            <i class="far fa-envelope contact-icon"></i>
                            Email: trongthuyen2606@gmail.com
                        </a>
                    </div>
                </div>
                <div class="mycol myl-4 mym-4 myc-12 text-center">
                    <div class="oursocial">
                        <h4 class="foo-title">Liên hệ qua Fanpages</h4>
                        <div class="foo-item">
                            <a href="<?=$socialMedia["facebook"]?>" target="_blank" class="color-black">
                            <i class="fab fa-facebook-square contact-icon"></i> Fanpage
                            </a>
                        </div>
                        <div class="foo-item">
                            <a href="<?=$socialMedia["instagram"]?>" target="_blank" class="color-black">
                            <i class="fab fa-instagram contact-icon"></i> Instagram
                            </a>
                        </div>
                        <div class="foo-item">
                            <a href="<?=$socialMedia["twitter"]?>" target="_blank" class="color-black">
                            <i class="fab fa-twitter contact-icon"></i> Twitter
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mycol myl-4 mym-4 myc-12 text-center">
                    <div class="branches">
                        <h4 class="foo-title">Các chi nhánh</h4>
                        <p class="foo-item"><b>Đại học Bách khoa TPHCM cơ sở Dĩ An - Bình Dương <br> (Trụ sở chính)</b></p>    
                        <p class="foo-item">Quận 10</p>    
                        <p class="foo-item">Thành phố Thủ Đức</p>    
                        <p class="foo-item">Quận 9</p>    
                        <p class="foo-item">Đà Lạt</p>    
                        <p class="foo-item">Quận Cam</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>