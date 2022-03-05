-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 01, 2021 lúc 07:00 AM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `technology_shop`
--
CREATE DATABASE IF NOT EXISTS `technology_shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `technology_shop`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `is_deleted`) VALUES
(2, 'Laptop', 0),
(4, 'Camera', 0),
(7, 'Phụ kiện', 0),
(9, 'Phone', 0),
(21, 'Cảm biến', 0),
(22, 'An ninh', 0),
(23, 'Desktop', 0),
(32, 'Loa Blutooth', 0),
(33, 'Linh kiện máy tính - laptop', 0),
(34, 'Apple', 0),
(35, 'IC', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `is_seen` int(11) DEFAULT 0,
  `marked` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `total_money` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `phone_number`, `address`, `note`, `order_date`, `status`, `total_money`) VALUES
(29, 102, 2, 6, '0353472233', 'Sài Gòn', 'Nhanh nhanh em nhờ, sắp thi đến nơi rồi', '2021-11-30 03:11:07', 0, 6),
(31, 125, 90, 1, '0353472233', 'Thôn 12 - Cư Knia - Cư Jut - Đắk Nông', 'gkđrh', '2021-12-01 08:12:58', 0, 46990000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(350) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `thumbnail` varchar(500) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `category_id`, `title`, `price`, `discount`, `thumbnail`, `description`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 4, 'Máy ảnh Fujifilm', 40000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/3559d83d6393c2a5458b067dd10d2074/may-anh.jpg', 'Muốn sở hữu một chiếc máy ảnh với mức giá vừa phải nhưng vẫn có đủ những tính năng cũng như đạt chuẩn chất lượng, JShop sẽ là những gì bạn tìm kiếm. JShop được biết đến là cửa hàng chuyên cung cấp các loại máy ảnh cũ, đã qua sử dụng nổi tiếng trong giới yêu máy ảnh. Không chỉ được đánh giá cao bởi chất lượng máy, JShop còn được lựa chọn bởi sản phẩm đa dạng với nhiều dòng máy ảnh được nhiều khách hàng sử dụng. Ngoài máy ảnh cũ, cửa hàng còn cung cấp các loại linh kiện rời như ống kính, phụ kiện chụp như đèn flash, chân máy, giá đỡ…', '2021-10-28 05:18:37', '2021-12-01 06:12:12', 0),
(2, 2, 'Laptop ASUS đời mới nhất', 24000000, 0, 'https://vnreview.vn/image/21/09/36/2109365.jpg?t=1598539261256', 'ASUS Republic of Gamers (ROG) vừa tổ chức sự kiện trực tuyến RISE BEYOND để công bố chiếc laptop gaming 2 màn hình ROG Zephyrus Duo 15 cùng dải sản phẩm laptop chuyên game trang bị CPU Intel Core thế hệ 10 với thiết kế đột phá, mang lại trải nghiệm tối ưu cho game thủ và các nhà sáng tạo nội dung.', '2021-10-28 05:18:37', '2021-12-01 06:12:36', 0),
(12, 9, 'Điện thoại RedMi', 1000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/1706b967cf03fe4938d2d171769abd5b/note-8-x.jpg', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis, sequi a explicabo reprehenderit, vitae recusandae deserunt magni nesciunt quo eveniet dolor sunt officiis modi maxime fuga magnam enim. Impedit, perferendis?', '2021-10-28 19:10:07', '2021-12-01 06:12:58', 0),
(18, 32, 'Tai nghe Blutooth', 12000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/download.jpg', 'Giới thiệu Tai nghe thể thao, chống ồn chủ động Baseus SIMU S15 (Active Noise Reduction, ANC Wireless Sport Earphone)\r\n\r\nChống ồn chủ động (Active Noise Cancelling – ANC) là một công nghệ hiện đại được phát triển bởi hãng âm thanh Bose. Những chiếc headphone sở hữu công nghệ ANC sẽ được trang bị mic để nhận diện được những tạp âm, tiếng ồn từ môi trường bên ngoài. Sau đó, một bộ phận trên tai nghe sẽ chủ động tạo ra những sóng âm ngược pha với những tiếng ồn mic thu được. Hai hỗn hợp sóng âm này gặp nhau, và vì chúng dao động ngược hướng nhau, nên sẽ triệt tiêu lẫn nhau. Kết quả là người dùng sẽ không còn nghe thấy những tạp âm từ môi bên ngoài nữa.', '2021-10-29 18:10:10', '2021-12-01 06:12:35', 0),
(88, 2, 'Laptop gaming xịn xò', 24000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/10050001-laptop-acer-nitro-gaming-ạn-57-74rd-i7-11800h-15-6inch-nh-qd8sv-001-1.jpg', 'Trải nghiệm hình ảnh sắc nét, màu sắc sống động trên màn hình 15.6\'\' FHD\r\nBộ vi xử lý Intel Core i7-11800H giải quyết công việc nhanh chóng, mượt mà\r\nCard đồ họa NVIDIA GeForce RTX 3050 chơi game cực đỉnh lẫn đồ họa sáng tạo\r\nRAM 8GB DDR4 giúp laptop đa nhiệm mượt mà, hạn chế tình trạng giật lag\r\nỔ cứng SSD 512GB giúp khởi động máy nhanh hơn, thoải mái lưu trữ dữ liệu\r\nCông nghệ Acer TrueHarmony mang đến âm thanh to, rõ ràng và sống động', '2021-11-30 03:11:48', '2021-11-30 03:11:32', 0),
(89, 32, 'Tai nghe blutooth Sony', 19000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/kki999.png', 'CX 7.00 BT là chiếc tai nghe in-ear Bluetooth mới nhất mà Sennheiser vừa giới thiệu sau chiếc tai nghe Momentum in-ear Wireless. Tai nghe CX 7.00 BT có thiết kế khá giống với Momentum in-ear Wireless nhưng không có chức năng Vibrate (rung) khi có thông báo hoặc cuộc gọi đến, giá của CX 7.00 BT cũng thấp hơn  Momentum in-ear Wireless. Tai nghe bluetooth Sennheiser CX 7.00 BT giúp bạn thưởng thức trải nghiệm nghe nhạc tuyệt vời ở khắp mọi nơi. Đây là chiếc tai nghe có vòng đeo cổ sang trọng, mang đến chất âm trong trẻo, sạch, chi tiết và tăng cường tiếng bass, đảm bảo truyền tải công nghệ âm thanh đặc trưng của Sennheiser, dẫn đầu về công nghệ không dây với Bluetooth 4.1 và Qualcomm® apt-X™ cho âm thanh Hi-Fi thực sự. Thời gian nghe nhạc liên tục hơn 10h.\r\n\r\nCông nghệ không dây tiên tiến\r\n\r\nTai nghe không dây bluetooth CX 7.00 BT là một trong những thiết bị rất thú vị và phù hợp để đeo lên cổ. Đắm chìm trong âm thanh huyền thoại của Sennheiser nhờ công nghệ Bluetooth apt-X™ của Qualcomm. Thiết kế mạnh mẽ, bắt mắt sẵn sàng thách thức phong cách sống di động. Thưởng thức sự thoải mái với độ vừa vặn hoàn hảo và kết hợp hài hoà với thiết bị di động của bạn. Sự tự do không giới hạn.\r\n\r\n100% chất âm Sennheiser, 0% dây\r\n\r\nÂm thanh trung thực và mạnh mẽ với đáp ứng tiếng bas vượt trội, đây là chiếc tai nghe chất lượng cao với âm thanh đậm chất Sennheiser. Sử dụng hàng loạt công nghệ không dây tiên tiến – Bluetooth 4.1, và Qualcomm® apt-X™ – để đảm bảo bạn có thể thưởng thức âm nhạc một cách trọn vẹn nhất. Bạn sẽ không bỏ lở bất kì 1 chi tiết nào dù là nhỏ nhất.', '2021-11-30 03:11:35', '2021-11-30 03:11:40', 0),
(90, 2, 'Laptop LG Gram 2021 14Z90P-G.AH75A5', 46990000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/5dc113e7f735990906058d11c8b6e946/19495_laptop_lg_gram_2021_14z90p_g_ah75a5.jpg', 'CPU Intel Core i7-1165G7 (12MB, upto 4.70GHz)\r\nRAM 16GB LPDDR4X 4266MHz Onboard\r\nSSD 512GB PCIe NVMe M.2\r\nDisplay 14.0Inch WUXGA 16:10 IPS\r\nVGA Intel Iris Xe Graphics\r\nPin 72WHrs\r\nColor Obsidian Black (Đen)\r\nFinger Print\r\nWeight 999 g\r\nOS Windows 10 Home', '2021-12-01 06:12:19', '2021-12-01 06:12:19', 0),
(91, 2, 'Laptop MSI GP66 Leopard 11UE 643VN', 48000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/5dc113e7f735990906058d11c8b6e946/20813_laptop_msi_gp66_leopard_11ue_643vn_1.jpg', 'CPU Intel Core i7-11800H (24MB, up to 4.60GHz)\r\nChipset Intel HM570\r\nRAM 16GB DDR4 3200MHz (2x8GB)\r\nSSD 1TB NVMe PCIe Gen3x4\r\nVGA NVIDIA GeForce RTX 3060 6GB GDDR6\r\nDisplay 15.6Inch QHD IPS 165Hz\r\nPin 4Cell 65WHrs\r\nColor Core Black (Đen)\r\nPer-Key RGB Backlight Keyboard\r\nWeight 2.38 kg\r\nOS Windows 11 Home', '2021-12-01 06:12:44', '2021-12-01 06:12:44', 0),
(92, 2, 'Laptop MSI Prestige 15 A11SCX 210VN', 43000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/5dc113e7f735990906058d11c8b6e946/18352-msi-prestige-15-a11scx.jpg', 'CPU Intel® Core™ i7-1185G7 (upto 4.80Ghz, 12MB Cache)\r\nChipset Integrated SoC\r\nRAM 32GB (16GB x2) DDR4 3200MHz\r\nSSD 1TB NVMe PCIe Gen4x4\r\nVGA NVIDIA GeForce GTX1650 Max-Q, GDDR6 4GB\r\nDisplay 15.6inch UHD (3840*2160), 4K Thin Bezel, Adobe 100%\r\nPin 4 cell, 82Whr\r\nColor Gray\r\nKeyboard Single backlight KB(White)\r\nWeight 1.6kg\r\nOS Windows 10 Home', '2021-12-01 06:12:29', '2021-12-01 06:12:53', 0),
(93, 2, 'Laptop MSI Pulse GL76 11UEK', 49040000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/5dc113e7f735990906058d11c8b6e946/19630_laptop_msi_pulse_gl76_11uek_1.jpg', 'CPU Intel Core i7-11800H (24MB, up to 4.60GHz)\r\nChipset Intel HM570\r\nRAM 16GB DDR4 3200MHz (2x8GB)\r\nSSD 1TB NVMe PCIe Gen3x4\r\nVGA NVIDIA GeForce RTX 3060 6GB GDDR6\r\nDisplay 17.3Inch QHD IPS 165Hz 100% DCI-P3\r\nPin 3Cell 53.5WHrs\r\nColor Titanium Gray (Xám Titan)\r\nRGB Gaming Keyboard\r\nWeight 2.30 kg\r\nOS Windows 10 Home', '2021-12-01 06:12:13', '2021-12-01 06:12:13', 0),
(94, 33, 'Ram Laptop Kingston 4GB DDR4-2666S19 1Rx16 SODIMM (KVR26S19S6/4)', 630000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/15359-ram-laptop-kingston-4g-d4-2666s19.jpg', 'Hãng sản xuất: Kingston\r\nModel: KVR26S19S6/4\r\nMàu: Xanh lá\r\nKiểu Ram: DDR4\r\nDung lượng: 4GB\r\nTốc độ Buss: 2666Mhz', '2021-12-01 06:12:34', '2021-12-01 06:12:34', 0),
(95, 33, 'Ram Laptop Kingmax GSAF62F 4GB DDR4-2666MHz', 639000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/18188-ram-laptop-kingmax-gsaf62f-4gb-ddr4-2666mhz.jpg', 'Kingmax GSAF62F 4GB DDR4 2666MHz\r\nHãng SX: Kingmax\r\nLoại ram: DDR4\r\nDung lượng: 4GB\r\nBus: 2666MHz\r\nThiết bị SD: laptop\r\nĐiện áp: 1.2V', '2021-12-01 06:12:22', '2021-12-01 06:12:22', 0),
(96, 33, 'Ram PC Kingmax 4GB DDR4 Bus 2666Mhz', 700000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/13864-4gb-ddr4-bus-2666mhz.jpg', 'Xung nhịp: 2666MHz\r\nSố chân: 288 chân\r\nBăng thông: 21,3GB/giây\r\nĐộ trễ CAS: CL=19\r\nĐiện thế (VDD): 1,2V\r\nDung lượng: 4GB', '2021-12-01 06:12:15', '2021-12-01 06:12:15', 0),
(97, 33, 'Ram laptop SK Hynix 4GB DDR4 3200MHz', 630000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/18188-ram-laptop-kingmax-gsaf62f-4gb-ddr4-2666mhz.jpg', 'Hãng sản xuất: SK Hynix\r\nModel: PC4-3200AA-SC0-11 (HMA851S6DJR6N-XN N0)\r\nDung lượng: 4GB\r\nKiểu Ram: DDR4\r\nTốc độ Buss: 3200MHz\r\nĐiện áp: 1,2V\r\nMàu: Xanh lá', '2021-12-01 06:12:06', '2021-12-01 06:12:06', 0),
(98, 34, 'Điện thoại iPhone 12 Pro Max 128GB Gold MGD93VN/A', 29000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/19115_iphone_12_pro_max_128gb_gold.jpg', 'CPU Apple A14 Bionic 6 nhân\r\nRAM 6GB\r\nROM 128GB\r\nDisplay 6.7Inch OLED (1284x2778)\r\nCamera trước 1cam 12MP\r\nCamera sau 3cam 12MP\r\nBattery 3687mAh\r\nColor Gold\r\nWeight 228g\r\nOS iOS 14', '2021-12-01 06:12:40', '2021-12-01 06:12:40', 0),
(99, 34, 'Điện thoại IPHONE 11 PRO MAX GREEN', 29000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/17827-mwhh2vn-a-2.jpg', 'Chipset: Apple A13 Bionic\r\nMàn hình: 6.5-Inch OLED Multi-Touch\r\nĐộ phân giải: 1242x2688pixels\r\nRAM: 4GB\r\nBộ nhớ trong (ROM): 64GB\r\nCamera trước: 12MP\r\nCamera sau: 3 camera 12MP\r\nPIN: 3969 mAh, có sạc nhanh\r\nMàu: GREEN\r\nCân nặng: 226g\r\nHệ điều hành: iOS 13', '2021-12-01 06:12:47', '2021-12-01 06:12:47', 0),
(100, 2, 'Laptop Asus TUF Gaming A15 FA506QM-HN016T', 30000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/278c475469281d8cc9affacf770d5bcc/20537_laptop_asus_tuf_gaming_a15_fa506qm_hn016t_0.jpg', 'CPU AMD Ryzen R7-5800H (16MB, up to 4.40GHz)\r\nRAM 16GB DDR4 3200MHz (2x8GB)\r\nSSD 512GB M.2 NVMe PCIe 3.0\r\nVGA NVIDIA GeForce RTX 3060 6GB GDDR6\r\nDisplay 15.6Inch FHD IPS Anti-glare 144Hz\r\nPin 4Cell Li-ion, 90WHrs, 4S1P\r\nColor Eclipse Gray (Xám)\r\nBacklit Chiclet Keyboard RGB\r\nWeight 2.30 kg\r\nOS Windows 10 Home', '2021-12-01 07:12:51', '2021-12-01 07:12:51', 0),
(101, 32, 'Tai nghe MSI gaming H991 (đỏ)', 20000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/d8ec0c0d1a1a5183713eb8924add6cb2/19354_tai_nghe_gaming_msi_h991_3.jpg', 'Model: H991\r\nHãng sản xuất: MSI\r\nKết nối: jack 3.5mm\r\nMicrophone: Có\r\nTần số : 20 Hz ~ 20 kHz', '2021-12-01 07:12:04', '2021-12-01 07:12:04', 0),
(102, 2, 'Laptop MSI Alpha 15 B5EEK AMD Advantage Edition', 32000000, 0, 'http://localhost/shop/mvc/views/assets/thumbnail/product/278c475469281d8cc9affacf770d5bcc/20754_laptop_msi_alpha_15_b5eek_amd_advantage_edition_0.jpg', 'CPU AMD Ryzen R5-5600H (16MB, up to 4.20GHz)\r\nRAM 8GB DDR4 3200MHz\r\nSSD 512GB NVMe PCIe Gen3x4\r\nVGA AMD Radeon RX 6600M 8GB GDDR6\r\nDisplay 15.6Inch FHD IPS 144Hz 72%NTSC\r\nPin 4Cell 90WHrs\r\nColor Black (Đen)\r\nRGB Gaming Keyboard\r\nWeight 2.35 kg\r\nOS Windows 10 Home', '2021-12-01 07:12:47', '2021-12-01 07:12:47', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(3, 'User'),
(4, 'Admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `token`
--

CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `token` varchar(300) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `token`
--

INSERT INTO `token` (`user_id`, `token`, `created_at`) VALUES
(125, 'f511d0adafcde3a633fb841de863cf24', '2021-12-01 09:12:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `pwd` varchar(300) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `phone_number`, `addr`, `pwd`, `role_id`, `created_at`, `updated_at`, `is_deleted`) VALUES
(102, 'Trọng Thuyên', 'pandorakazira@gmail.com', '0123456789', 'TP HCM', '$2y$10$X27AziG7AfaFeL/NY7k0nOOri.o1pdVQCmCNj2rthxvIB3SUi0CJW', 4, '2021-10-27 17:10:40', '2021-11-30 11:11:17', 0),
(125, 'Nông Trọng Thuyên', 'thuyen.nong26062001@hcmut.edu.vn', '0353472233', 'TP HCM', '$2y$10$boV9s.TXjftqaXgHcHP1UeUMbR38RrdStAMT1/heS.BV0xGlECE72', 4, '2021-12-01 08:12:53', '2021-12-01 09:12:54', 0),
(126, 'username', 'user@gmail.com', '0123456789', 'Hà Nội', '$2y$10$ZZKypn7RNKLxjy7RXBOaR.Fbw90ZBalAyFevbw4LuzJLcRmNoTw9i', 3, '2021-12-01 08:12:01', '2021-12-01 08:12:01', 0),
(128, 'Nguyễn Huy Hoàng', 'hoang.nguyen290801@hcmut.edu.vn', '', '', '$2y$10$1YWpnhQxQbwTvaDpuedxd.Fil2Amvq10sAtwfy8HA3P/XfceuwZRm', 3, '2021-12-01 09:12:22', '2021-12-01 09:12:22', 0),
(129, 'Hồ Hoàng Huy', 'huy.hohcmut.edu@hcmut.edu.vn', '', '', '$2y$10$JxunolZmxg2PK44Yy8jfUOt3rUS3iYpfcq.Kq5qWJEfGyX3YEzgaO', 3, '2021-12-01 09:12:37', '2021-12-01 09:12:37', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `use_id` (`user_id`),
  ADD KEY `feedback_ibfk_2` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `orders_ibfk_2` (`product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`user_id`,`token`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
