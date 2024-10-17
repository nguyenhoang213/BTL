-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 17, 2024 lúc 11:36 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `banhangonline`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_account`
--

CREATE TABLE `admin_account` (
  `admin_id` varchar(25) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_account`
--

INSERT INTO `admin_account` (`admin_id`, `admin_name`, `password`, `role`) VALUES
('324dc96e6b61', 'hoangnguyen', '123123', 0),
('385bdf6f3766', 'admin1', '123456', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `bill_id` varchar(25) NOT NULL,
  `order_id` int(25) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `prices` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`) VALUES
(14, 'e0af668fe8a9');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_product`
--

CREATE TABLE `cart_product` (
  `cart_id` int(25) NOT NULL,
  `product_id` varchar(25) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` varchar(25) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `parent` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `description`, `image`, `parent`) VALUES
('apple', ' Apple', 'Apple', '', 'DT'),
('AW', ' AppleWatch', 'AppleWatch', '', NULL),
('blackberry', ' BlackBerry', 'BlackBerry', '', 'DT'),
('BP', ' Bàn phím', 'Bàn phím', '', NULL),
('CM', ' Camera', 'Camera', '', NULL),
('DT', ' Điện thoại', 'Điện thoại', '', NULL),
('laptopasus', ' Laptop Asus', 'Laptop Asus', '', 'LT'),
('laptopdell', ' Laptop Dell', 'Laptop Dell', '', 'LT'),
('laptophp', ' Laptop HP', 'Laptop HP', '', 'LT'),
('LK', ' Linh kiện máy tính', 'Linh kiện máy tính', '', NULL),
('LT', ' Laptop', 'Laptop', '', NULL),
('macbook', ' Macbook', 'Macbook', '', 'LT'),
('MI', ' Thiết bị máy in', 'Thiết bị máy in', '', NULL),
('motorola', ' Motorola', 'Motorola', '', 'DT'),
('nokia', ' Nokia', 'Nokia', '', 'DT'),
('PC', ' Máy tính bộ', 'Máy tính bộ', '', NULL),
('PK', ' Phụ kiện', 'Phụ kiện', '', NULL),
('samsung', ' Samsung', 'Samsung', '', 'DT'),
('SM', ' SmartWatch', 'SmartWatch', '', NULL),
('tablet-beneve', ' Tablet Beneve', 'Tablet Beneve', '', 'TL'),
('tablet-ipad', ' Tablet Ipad', 'Tablet Ipad', '', 'TL'),
('tablet-itel', ' Tablet Itel', 'Tablet Itel', '', 'TL'),
('tablet-kindle', ' Tablet Kindle', 'Tablet Kindle', '', 'TL'),
('tablet-mobell', ' Tablet Mobell', 'Tablet Mobell', '', 'TL'),
('tablet-samsung', ' Tablet Samsung', 'Tablet Samsung', '', 'TL'),
('TL', ' Tablet', 'Tablet', '', NULL),
('TN', ' Tai nghe', 'Tai nghe', '', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(25) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `ward` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `discount_amount` int(11) NOT NULL DEFAULT 0,
  `order_status` varchar(25) NOT NULL,
  `order_time` datetime NOT NULL,
  `complete_time` datetime DEFAULT NULL,
  `user_id` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `full_name`, `phone`, `email`, `province`, `district`, `ward`, `address`, `payment_method`, `total`, `discount_amount`, `order_status`, `order_time`, `complete_time`, `user_id`) VALUES
(16, 'Nguyễn Như Hoàng', '0969839072', 'hoang23032003@gmail.com', '22', '206', '07132', 'Đông Anh', 'cod', '32080000', 0, 'Đã hoàn thành', '2024-10-17 02:59:09', '2024-10-16 22:04:48', 'e0af668fe8a9'),
(17, 'Nguyễn Như Hoàng', '0969839072', 'hoang23032003@gmail.com', '22', '202', '06970', 'Đông Anh', 'cod', '2490000', 0, 'Đang chờ', '2024-10-17 03:34:06', NULL, 'e0af668fe8a9'),
(18, 'Nguyễn Như Hoàng', '0969839072', 'hoang23032003@gmail.com', '25', '239', '08686', 'Đông Anh', 'cod', '4000000', 0, 'Đang chờ', '2024-10-17 03:37:58', NULL, 'e0af668fe8a9'),
(19, 'Nguyễn Như Hoàng', '0969839072', 'hoang23032003@gmail.com', '25', '237', '08494', 'Đông Anh', 'cod', '6345000', 0, 'Đang chờ', '2024-10-17 03:41:18', NULL, 'e0af668fe8a9'),
(20, 'Nguyễn Như Hoàng', '0969839072', 'hoang23032003@gmail.com', '19', '171', '05809', 'Đông Anh', 'cod', '6490000', 0, 'Đang chờ', '2024-10-17 03:43:33', NULL, 'e0af668fe8a9'),
(21, 'Nguyễn Như Hoàng', '0969839072', 'hoang23032003@gmail.com', '25', '239', '08683', 'Đông Anh', 'cod', '119990000', 0, 'Đang chờ', '2024-10-17 03:45:02', NULL, 'e0af668fe8a9'),
(22, 'Nguyễn Như Hoàng', '0969839072', 'hoang23032003@gmail.com', '27', '263', '09454', 'Đông Anh', 'cod', '119990000', 0, 'Đang chờ', '2024-10-17 03:47:11', NULL, 'e0af668fe8a9');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_product`
--

CREATE TABLE `order_product` (
  `order_id` int(25) NOT NULL,
  `product_id` varchar(25) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_product`
--

INSERT INTO `order_product` (`order_id`, `product_id`, `stock`, `price`) VALUES
(16, 'LTAS01', 1, 7590000),
(16, 'LTL01', 1, 24490000),
(17, '2', 1, 2490000),
(18, 'DTSGA05', 1, 4000000),
(19, '3', 1, 2345000),
(19, 'DTSGA05', 1, 4000000),
(20, '2', 1, 2490000),
(20, 'DTSGA05', 1, 4000000),
(21, 'LTAC04', 1, 119990000),
(22, 'LTAC04', 1, 119990000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `post_id` varchar(25) NOT NULL,
  `tittle` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `admin_id` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `product_id` varchar(25) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `description`, `image`, `price`, `stock`, `status`) VALUES
('2', 'Samsung A50', 'Samsung A50 giá bao nhiêu thu hút sự chú ý của không ít tín đồ công nghệ, đặc biệt là Samfan. Với người dùng có nhu cầu cơ bản như nghe gọi, lướt web, xem video hay chơi game cơ bản thì không còn gì phù hợp hơn Samsung A50 cũ. Khách hàng có thể tiết kiệm được chi phí khi mua sản phẩm với giá chỉ từ 2.490.000đ đối với bản cũ đẹp, từ 2.190.000đ với bản cũ trầy xước. Samsung A50 cạnh tranh không kém Xiaomi Redmi 12C đã kích hoạt, Nokia G21 cũ đẹp, Nokia G50 5G cũ trầy xước,...', 'samsung_a50.jpg', 2490000, 18, 1),
('3', 'Huawei 10 Pro', 'Huawei Mate 10 Pro có nhiều phiên bản dùng lượng bộ nhớ, RAM 6 GB hoặc 4 GB. Bộ nhớ trong lên đến 128 GB và 64 GB. Công nghệ AI trí thông minh nhân tạo cũng được tối ưu trên dòng chip Kirin 970 ứng dụng vào hoạt động của máy, càng dùng càng mượt, hiệu năng xử lý được học hỏi đển tốt hơn cũng như pin ngon hơn.', 'huawei_mate10_pro.jpg', 2345000, 9, 1),
('BPAK01', 'AKKO 3087 RF', 'Bàn phím cơ Akko 3087 RF là chiếc bàn phím được thiết kế với khả năng mang đến cho người dùng sự thoải mái nhất khi gõ phím. Chiếc bàn phím Akko với kích thước nhỏ gọn và trang bị đầy đủ keycaps PBT Double-Shot.', 'AKKO_3087_RF.png', 1599000, 19, 1),
('BPAK02', 'AKKO 3098S Onepiece', 'Bàn phím cơ Akko 3098S One Piece Jelly là dòng bàn phím cực kỳ độc đáo, thu hút được nhiều sự chú ý của các gamer và người sử dụng yêu thích anime One Piece. Không chỉ nổi bật với thiết kế độc đáo, cá tính mà Akko 3098S One Piece Jelly còn được trang bị switch cơ học cùng tính năng đèn nền RGB đa màu sắc, tạo nên trải nghiệm gaming tuyệt vời. ', 'AKKO_3098S_Onepiece.png', 2390000, 19, 1),
('BPAK03', 'AKKO 5108 World Tour Tokyo R2', 'Bàn phím cơ AKKO 5108 World Tour Tokyo R2 SP được thiết kế hình ảnh biểu tượng của Tokyo là núi Phú Sĩ và hoa anh đào. Series World Tour không chỉ là công cụ đánh máy mà còn có thể đóng vai trò là phương tiện giao tiếp và tương tác văn hóa, điều này tạo nét độc đáo trên sản phẩm này.', 'AKKO_5108_WorldTourTokyo_R2.png', 1799000, 19, 1),
('BPAK04', 'AKKO MonsGeek MG108', 'AKKO MonsGeek MG108 Black&Pink là dòng bàn phím cơ với thiết kế Fullsize 108 phím bấm tiện lợi, tông màu nổi bật làm không gian làm việc giải trí trở nên sinh động và tăng thêm phấn khởi khi chơi game. Hứa hẹn AKKO MonsGeek MG108 sẽ là dòng bàn phím máy tính mang đến cho bạn những trải nghiệm tuyệt vời với giá thành hấp dẫn phù hợp với mọi đối tượng.', 'AKKO_MonsGeek_MG108.png', 1099000, 19, 1),
('BPAK05', 'AKKO MX108', 'Akko MX108 sẽ là lựa chọn không nên bỏ qua dành cho những người yêu thích sự gọn gàng ngăn nắp tại khu vực bàn làm việc. Sở hữu kiểu dáng gọn nhẹ, đẹp mắt cùng khả năng kết nối Bluetooth linh hoạt, nhờ đó bàn phím này sẽ hỗ trợ người dùng nâng cao hiệu quả công việc, giải trí với trải nghiệm sử dụng tiện lợi và thoải mái nhất.', 'AKKO_MX108.png', 699000, 19, 1),
('BPAS01', 'Asus ROG Falchion 2', 'Bàn phím cơ chơi game không dây ROG Falchion 65% với 68 phím, đèn Aura Sync không dây, bảng điều khiển cảm ứng, ốp bảo vệ bàn phím, switch Cherry MX và thời lượng pin lên đến 450 giờ', 'Asus-ROG-Falchion_2.png', 1990000, 19, 1),
('BPAS02', 'Asus ROG Strix 2', 'Bàn phím chơi game không dây ROG Strix Scope II 96 với kết nối ba chế độ, phím nóng cho streamer, điều khiển đa chức năng, công tắc cơ học ROG NX Snow & Storm có thể thay thế nhanh chóng đã được bôi trơn trước, thanh ổn định bàn phím ROG, phím bấm PBT doubleshot và lớp mút chống rung silicone, ba góc nghiêng và giá đỡ cổ tay.', 'Asus-ROG-Strix_2.png', 1690000, 19, 1),
('BPAS03', 'Asus ROG Strix RX', 'Bàn phím chơi game quang học ROG Strix Scope RX RGB dành cho game thủ FPS, với switch quang ROG RX, hệ thống đèn Aura Sync RGB toàn diện, khả năng chống nước và chống bụi chuẩn IP57, cổng USB 2.0 và mặt trên bàn phím làm bằng hợp kim', 'Asus-ROG-Strix-RX.png', 3450000, 19, 1),
('BPAS04', 'Asus rog strix scope tkl', 'Bàn phím gaming cơ có dây ROG Strix Scope TKL Deluxe dành cho các trò chơi FPS, với switch Cherry MX, khung nhôm, đệm kê cổ tay công thái học và đèn Aura Sync', 'Asus-rog-strix-scope-tkl.png', 3390000, 19, 1),
('BPAS05', 'Asus ROG Strix', 'Bàn phím gaming cơ có dây ROG Strix dành cho các trò chơi FPS, với switch Cherry MX, khung nhôm, đệm kê cổ tay công thái học và đèn Aura Sync', 'Asus-ROG-Strix.png', 3350000, 19, 1),
('BPED01', 'E-Dra EK368L Beta', 'Bàn phím cơ không dây E-Dra EK368L Beta (bố trí keycap màu trắng ở xung quang và màu xám ở giữa) là một sản phẩm đột phá của E-Dra trong phân khúc bàn phím chơi game giá rẻ có kết nối không dây – với mức giá chưa tới 500K bạn sẽ sở hữu một chiếc phím có USB 2.4Ghz kết hợp kết nối bluetooth', 'E-Dra_EK368L_Beta.png', 470000, 19, 1),
('BPED02', 'E-Dra EK368L Alpha', 'Bàn phím cơ không dây E-Dra EK368L Alpha (bố trí keycap màu Xám ở xung quanh và màu trắng ở giữa) là một sản phẩm đột phá của E-Dra trong phân khúc bàn phím chơi game giá rẻ có kết nối không dây – với mức giá chưa tới 500K bạn sẽ sở hữu một chiếc phím có USB 2.4Ghz kết hợp bluetooth', 'E-Dra_EK368L_Alpha.png', 470000, 19, 1),
('BPED03', 'E-Dra EK398 Alpha', 'Bàn phím cơ E-Dra EK398 Alpha (White – Black) bố trí phối màu keycap màu đen ở giữa xen kẽ màu trắng ở bên, với layout 89 nút phím, có núm vặn bên phải phía trên bàn phím để thay đổi đèn led nhanh. Phím có bố cục hợp lý phù hợp cho chơi game và văn phòng.', 'E-Dra_EK398_Alpha.png', 495000, 19, 1),
('BPED04', 'E-Dra K398 Beta', 'Bàn phím cơ E-Dra EK398 Beta (Black-White) bố trí phối màu keycap màu trắng nổi bật xen kẽ với màu đen, với layout 89 nút phím, có núm vặn bên phải phía trên bàn phím để thay đổi đèn led nhanh. Phím có bố cục hợp lý phù hợp cho chơi game và văn phòng.', 'E-Dra_K398_Beta.png', 485000, 19, 1),
('BPKC', 'Keychron K2 Nhựa', 'Keychron K2 V2 Bản nhựa | Phân phối chính hãng Việt Nam', 'Keychron_K2_Nhựa.png', 1690000, 19, 1),
('BPKC01', 'Keychron K1v4 Led', 'Bàn phím cơ TKL không dây Keychron K1V4 Led RGB có thiết kế nhỏ gọn và trang bị phím cơ Gateron mang đến hiệu suất cao nhất.', 'Keychron_K1v4_Led.png', 2190000, 19, 1),
('BPKC03', 'Keychron K4 Nhựa', 'Kết nối tiện lợi tùy theo nhu cầu sử dụng. Chiếc K4 được trang bị công nghệ Bluetooth dành cho những người ưa sự gọn gàng và đơn giản.', 'Keychron_K4_Nhựa.png', 1850000, 19, 1),
('BPKC04', 'Keychron K4v2 Nhôm', 'Bàn phím cơ không dây Keychron K4V2 Aluminum Led RGB có thiết kế nhỏ gọn và trang bị phím cơ Gateron mang đến hiệu suất cao nhất.', 'Keychron_K4v2_Nhôm.png', 1950000, 19, 1),
('CAS01', 'Asus ROG Gladius III', 'Chuột chơi game bất đối xứng kiểu cổ điển với cảm biến 19.000 dpi được tinh chỉnh đặc biệt với độ trễ bằng 0 khi click chuột, độ trễ RF bằng không.', 'Asus-ROG_Gladius_III.png', 2390000, 19, 1),
('CAS02', 'Asus GOG Strix Impact II', 'ROG Strix Impact II là chuột chơi game thuận cả hai tay, có thiết kế công thái học, cảm biến quang học 6200 dpi, thiết kế socket cho switch Push-Fit và đèn Aura Sync RGB.', 'Asus-GOG-Strix_Impact_II.png', 890000, 19, 1),
('CAS03', 'Asus TUF Gaming M3', 'Thiết kế công thái học và nhẹ, thoải mái cho nhiều giờ chơi, với hình dạng được tối ưu hóa giúp tăng cường cả xử lý và kiểm soát.', 'Asus_TUF_Gaming_M3.png', 389000, 19, 1),
('CAS04', 'Asus TUF M3 Gen II', 'ASUS TUF Gaming M3 Gen II là một chuột chơi game có dây siêu nhẹ chỉ nặng 59 gram, chống nước và bụi IP56, được trang bị ASUS Antibacterial Guard, cảm biến 8000 dpi, công tắc có tuổi thọ 60 triệu lần nhấp, chân chuột PTFE và sáu nút có thể lập trình.', 'Asus_TUF_M3_Gen_II.png', 450000, 19, 1),
('CAS05', 'Asus GOG Chakram X', 'Chuột chơi game không dây ROG Chakram X có đèn RGB với cảm biến quang học ROG AimPoint 36.000 dpi, chỉ số Polling rate 8000 Hz, kết nối ba chế độ (2.4 GHz/ Bluetooth/ dây) độ trễ thấp, 11 nút có thể lập trình, cần điều khiển joystick tín hiệu analog và thiết kế socket cho switch micro có thể tháo lắp dễ dàng (hotswap) (cơ/ quang).', 'Asus-GOG-Chakram_X.png', 3090000, 19, 1),
('CCS01', 'Corsair Dark Core RGB Pro', 'Chuột Corsair Dark Core RGB Pro Kết nối không dây siêu nhanh với tốc độ 2.4Ghz DPI tối đa 16.000. Thiết kế công thái học cho cảm giác cầm nắm thoải mái', 'Corsair_DarkCore_RGB_Pro.png', 2050000, 19, 1),
('CCS02', 'Corsair Harpoon', 'Đặc điểm nổi bật. Thiết kế năng động, khối lượng nhẹ chỉ 85 g, dễ thao tác. Hiệu ứng đèn RGB cho chuột nổi bật trong bóng tối.', 'Corsair_Harpoon.png', 1290000, 19, 1),
('CCS03', 'Corsair Iron Claw', 'Thiết kế công thái học cho người dùng tay phải Cảm biến quang học siêu cao cấp PMW3391 DPI tối đa 18.000 Nút bấm 50 triệu lần click Nhiều tính năng cao cấp.', 'Corsair_IronClaw.png', 1950000, 19, 1),
('CCS04', 'Corsair Katar Pro', 'Chuột Corsair Katar Pro Mắt cảm biến PAW3327 Trọng lượng nhẹ chỉ 73g Độ phân giải : 12400DPI Led RGB có thể tuỳ chỉnh qua ICUE.', 'Corsair_Katar_Pro.png', 790000, 19, 1),
('CCS05', 'Corsair M55 Pro', 'Chuột Corsair M55 RGB PRO mang lại tính linh hoạt cho trò chơi với thiết kế đối xứng thuận cả hai tay và cảm biến quang 12.400 DPI mang lại độ chính xác cao.', 'Corsair_M55_Pro.png', 840000, 19, 1),
('CLGT01', 'Logitech G102', 'Chuột chơi game Logitech G102 Prodigy có cảm biến quang học tiên tiến, tính năng chiếu sáng RGB có thể lập trình và hiệu suất đẳng cấp chơi game.', 'Logitech_G102.png', 400000, 19, 1),
('CLGT02', 'Logitech G Pro X', 'Nhẹ hơn 63 gram. Công nghệ LIGHTSPEED không dây tiên tiến có độ trễ thấp. Độ chỉnh xác đến từng micro-mét với cảm biến HERO 25K.', 'Logitech_G_Pro_X.png', 3490000, 19, 1),
('CLGT03', 'Logitech G Pro X', 'Nhẹ hơn 63 gram. Công nghệ LIGHTSPEED không dây tiên tiến có độ trễ thấp. Độ chỉnh xác đến từng micro-mét với cảm biến HERO 25K.', 'Logitech_G_Pro_X.png', 2900000, 19, 1),
('CLGT04', 'Logitech G302', 'Chuột được thiết kế cho Game thủ chuyên nghiệp. G302 MOBA Gaming Mouse. Chuột Logitech G302 sử dụng cảm biến quang học công nghệ Logitech Delta Zero™.', 'Logitech_G302.png', 450000, 19, 1),
('CLGT05', 'Logitech G502 Hero', 'Chuột chơi game Logitech G502 Hero Gaming USB Black , là sản phẩm chuột có dây chuyên cho game thủ. Mua tại HACOM để được hưởng những ưu đãi tốt nhất.', 'Logitech_G502_Hero.png', 2450000, 19, 1),
('CRZ01', 'Razer Basilisk X', 'Razer Basilisk x Hyperspeed là một trong những dòng chuột không dây nhanh hơn 25% so với bất kỳ công nghệ không dây nào khác hiện nay.', 'Razer_Basilisk_X.png', 890000, 19, 1),
('CRZ02', 'Razer Orochi V2', 'Razer Orochi V2 — chuột không dây siêu gọn nhẹ có thời lượng pin ấn tượng,trọng lượng siêu nhẹ 59g, lên đến 900 giờ sử dụng chỉ với duy nhất một pin AA.', 'Razer_Orochi_V2.png', 1300000, 19, 1),
('DTSGA05', 'Điện thoại Samsung Galaxy A05 6GB', 'Công nghệ màn hình: PLS LCD\r\nĐộ phân giải: HD+ (720 x 1600 Pixels)\r\nMàn hình rộng: 6.7\" - Tần số quét 60 Hz\r\nĐộ sáng tối đa: 576 nits\r\nMặt kính cảm ứng: Kính cường lực', 'samsung-galaxy-a05-black-thumbnew-600x600.jpg', 4000000, 47, 1),
('ip15', 'Iphone 15 - 64GB', 'Iphone 15 - 64GB', '', 15000000, 4, 1),
('LTAC', 'Laptop Acer Nitro 5 Tiger AN515 58 773Y', 'Acer Nitro 5 Tiger AN515-58-773Y là dòng laptop gaming quốc dân sở hữu diện mạo mới và công nghệ hàng đầu thu hút được đông đảo các game thủ yêu thích và lựa chọn. Bên cạnh đó là cấu hình laptop Acer Nitro cực chất để mang đến những trải nghiệm game vô cùng ấn tượng.', 'Acer-Nitro5-Tiger-1.png', 22990000, 10, 1),
('LTAC01', 'Acer Aspire ', 'Laptop Acer Gaming Aspire 7 A715-76-53PJ là chiếc laptop sở hữu cấu hình mạnh với bộ vi xử lý Intel Core thế hệ 12 và card đồ họa Intel UHD Graphics. Máy có màn hình 15.6 inch, độ phân giải Full HD (1920 x 1080), bộ nhớ RAM 16GB DDR4 và dung lượng lưu trữ SSD 512GB. Ngoài ra, máy còn được trang bị các cổng kết nối như HDMI, USB Type-C, USB 3.2 Gen 1 Type-A, RJ-45 và có khả năng chơi game tốt.', 'Acer-Aspire-1.png', 14690000, 10, 1),
('LTAC03', 'Laptop Acer Swift X SFX14 71G 75CV', 'Laptop Acer Swift X SFX14-71G-75CV sở hữu bộ vi xử lý i7-13700H mạnh mẽ cho hiệu năng ấn tượng. Kết hợp RAM 32GB cùng ổ SSD 1TB mang lại trải nghiệm đỉnh cao trong công việc, không gian lưu trữ vô hạn, hiệu suất ổn định. Từ phục vụ giải trí đến edit video máy đều sẵn sàng đáp ứng mọi nhu cầu với khả năng vận hành đỉnh cao và tốc độ xử lý mượt mà.', 'Acer-Swift-1.png', 39990000, 10, 1),
('LTAC04', 'Laptop gaming ACER Predator Helios 18 PH18 71 94SJ', 'Laptop Acer Predator Helios 18 PH18-71-94SJ NH.QKRSV.002 là siêu phẩm Laptop Gaming thuộc vào Series Acer Predator được Game thủ cực kỳ yêu thích. Kể từ khi ra mắt,  dòng sản phẩm này luôn được coi như là biểu tượng cho những mẫu Laptop chuyên game cao cấp. Acer Predator Helios 2023 được trang bị CPU Intel thế hệ 13 và RTX40 Series hứa hẹn trở thành mẫu Laptop sở hữu hiệu năng “khủng” nhất từ trước tới nay.', 'Acer-Predator-i9-1.png', 119990000, 8, 1),
('LTAC05', 'Laptop gaming Acer Predator Helios 300 PH315 55 751D', 'Acer Predator Helios 300 PH315-55-751D NH.QFTSV.002 hứa hẹn là chiếc laptop - máy tính xách tay mang tới trải nghiệm chơi game mượt mà cùng đồ họa chuyên nghiệp. Chiếc laptop gaming thuộc dòng Acer Predator với bộ vi xử lý Intel thế hệ 12 mới nhất  cùng phong cách cá tính đậm chất gaming hứa hẹn sẽ đáp ứng đầy đủ các nhu cầu cần thiết của một game thủ đích thực. Cùng An Phát Computer khám phá chiếc siêu phẩm laptop Acer này nhé!', 'Acer-Predator-1.png', 44990000, 10, 1),
('LTAS01', 'Laptop ASUS D515UA EJ045T', 'Bạn là học sinh, sinh viên đang tìm kiếm mẫu laptop với vẻ ngoài sang trọng, cấu hình ổn với giá thành rẻ. Vậy laptop Asus D515UA - EJ045T sẽ là sản phẩm mà bạn không nên bỏ qua.', 'Asus-D5-1.png', 7590000, 10, 1),
('LTAS02', 'Laptop Asus ExpertBook Flip B3402FEA EC0714T', 'Với thiết kế gọn nhẹ dựa theo công thái học đẳng cấp kết hợp cùng hiệu suất mạnh mẽ đỉnh cao, laptop Asus Expertbook B3402FEA-EC0714T chính là sự lựa chọn hoàn hảo tích hợp tất cả những gì bạn mong chờ. Chiếc laptop này sẽ là cánh tay phải đắc lực của bạn, giúp bạn chinh phục mọi tác vụ đỉnh cao và chạm tới mọi thành công.', 'Asus-Exp-1.png', 15990000, 10, 1),
('LTAS03', 'Laptop ASUS ProArt Studiobook Pro 16 OLED W7600Z3A L2048W', 'ASUS ProArt Studiobook 16 OLED được thiết kế chuyên biệt dành cho những nhà sáng tạo như chuyên gia đồ họa, kiến trúc sư, nhà phát triển game, biên tập phim ảnh hay Youtuber cho phép người sáng tạo khai phóng mọi tiềm năng. Kết hợp hiệu năng đẳng cấp chuyên nghiệp với vi xử lý lên tới Intel® Core™ i9 đột phá, đồ họa NVIDIA GeForce RTX™ A3000 12 GB đẳng cấp chuyên nghiệp, bộ nhớ lưu trữ siêu nhanh cao cấp, chuẩn kết nối I/O tiện lợi và khả năng điều khiển bằng ngón tay siêu chính xác với các ứng dụng sáng tạo nhờ ASUS Dial mới, trang bị màn hình HDR OLED 16 inch lên đến 4K 60 Hz 16:10 dải màu rộng và độ chính xác màu xuất sắc. Cùng ASUS ProArt Studiobook 16 OLED Khám phá các cách thức làm việc mới với ASUS Dial độc quyền hoàn toàn mới.', 'Asus-ProArt-1.png', 82990000, 10, 1),
('LTAS04', 'Laptop Asus ROG Strix G15 G513IH HN015W', 'Asus ROG Strix G15 G513IH-HN015TW là chiếc laptop có cấu hình mạnh mẽ, đáp ứng được hầu hết các tựa game trên thị trường hiện nay. Ngay cả khi hoạt động trong nhiều giờ liền máy vẫn khá mát mẻ do có hệ thống tản nhiệt cao cấp. Nếu bạn là một game thủ hay người dùng muốn tìm máy có cấu hình cao thì đừng bỏ qua chiếc laptop Asus chất lượng này.', 'Asus-Rog-1.png', 17890000, 10, 1),
('LTAS05', 'Laptop Asus Tuf FX506LHB HN188W', 'Với những tựa game \"bom tấn\" gay cấn và hấp dẫn hiện nay, game thủ sẽ cần đến laptop ASUS TUF Gaming F15 FX506LHB-HN188W chứa đựng CPU Intel thế hệ 10 cùng đồ họa GeForce GTX để có được trải nghiệm gaming tối ưu ở thiết lập đồ họa cao.', 'Asus-Tuf-1.png', 14990000, 10, 1),
('LTAS06', 'Laptop ASUS Vivobook 15 OLED A1505ZA L1245W', 'Laptop Asus Vivobook 15 OLED A1505ZA-L1245W được trang bị con chip Intel Core i5 Gen 12th mạnh mẽ cùng dung lượng RAM 8GB cho phép người dùng có thể làm việc, học tập thoải mái với cường độ cao. Laptop còn có được độ mỏng ấn tượng dù sở hữu màn hình kích thước 15,6 inch để thoải mái mang theo mọi nơi.', 'Asus-vivobook.png', 15490000, 10, 1),
('LTD01', 'Laptop Dell Inspiron 3530 N3530I716W1 Silver', 'Laptop Dell Inspiron 15 3530 i7 1355U (N3530I716W1) giá rẻ, trả góp - Mua online, xét duyệt nhanh, giao hàng tận nơi trong 1 giờ, cà thẻ tại nhà.', 'Dell-Inspiron3530-1.png', 23990000, 10, 1),
('LTD02', 'Laptop Dell Latitude 3520 P108F001 70280543', 'Laptop Dell Latitude 3520 70280543 dòng Laptop văn phòng với hiệu năng ấn tượng. Cấu hìn mạnh mẽ với CPU Core i5, Ram 8GB, 256GB SSD. Mỏng nhẹ chỉ 1.79kg.', 'Dell-Latitude3520-1.png', 13990000, 10, 1),
('LTD03', 'Laptop Dell Vostro 14 V3430 i7U165W11GRD2', 'Laptop Dell Vostro 3430 V3430-i7U165W11GRD2 là sản phẩm laptop dành cho dân văn phòng và kế toán viên. Cấu hình Core i7-1355U, RAM 16GB.', 'Dell-Vostro14-1.png', 23890000, 10, 1),
('LTD04', 'Laptop Dell XPS 13 Plus 71013325', 'CPU, Intel Core i5-1340P Gen 12th ( 12 Cores, 12 Threads, 18MB Cache ). RAM, 16GB LPDDR5 Onboard 5200MHz ( Không nâng cấp). Ổ cứng, 512GB M.2 PCIe Gen4.', 'Dell-XPS13Plus-1.png', 52990000, 10, 1),
('LTD05', 'Laptop gaming Dell Alienware M15 R6 P109F001CBL', 'CPU: Intel® Core™ i7-11800H (2.3 GHz - 4.6 GHz/ 24MB/ 8 nhân, 16 luồng) - RAM: 2 x 16GB 3200MHz DDR4 (Hỗ trợ tối đa 64GB) - VGA: GeForce RTX™ 3060 6GB GDDR6', 'Dell-Alienware-M15-1.png', 40990000, 10, 1),
('LTL01', 'Laptop gaming Lenovo Legion 5 15ARH7 82RE0035VN', 'Lenovo Legion 5 15ARH7 (82RE0035VN) · Bộ vi xử lý AMD Ryzen 7 6800H mạnh mẽ · Màn hình chiến game mượt mà · GPU NVIDIA RTX 3050 4GB mạnh mẽ · Âm thanh Nahimic 3D.', 'Lenovo-Legion-5-1.png', 24490000, 10, 1),
('LTL02', 'Laptop gaming Lenovo Legion Slim 5 16IRH8 82YA00BSVN', 'Laptop Lenovo Legion Slim 5 16IRH8 82YA00BSVN dòng laptop gaming cao cấp với cấu hình hiện đại tân tiến i5-13500H, Ram 16GB, 512GB.', 'Lenovo-Legion-1.png', 31990000, 10, 1),
('LTL03', 'Laptop gaming Lenovo LOQ 15APH8 82XT00BTVN', 'Laptop Lenovo LOQ 15APH8 - 82XT00BTVN được trang bị card đồ họa RTX 4050 6GB GDDR6 và RAM 16GB là trợ thủ đắc lực cho mọi công việc và giải trí', 'Lenovo-LOQ-1.png', 21990000, 10, 1),
('LTL04', 'Laptop Lenovo IdeaPad 5 Pro 16ARH7 82SN003LVN', 'CPU, AMD Ryzen 5 6600HS Creator Edition (6C / 12T, 3.3 / 4.5GHz, 3MB L2 / 16MB L3). RAM, 16GB LPDDR5 6400MHz dual-channel onboard (Không nâng cấp).', 'Lenovo-Ideapad-5-pro-1.png', 26490000, 10, 1),
('LTL05', 'Laptop Lenovo ThinkPad E14 21E300E3VN', 'Lenovo ThinkPad E14 Gen 4 21E300E3VN được trang bị màn hình 14 inch chống chói FHD (1920 x 1080) với góc nhìn rộng, độ sáng 300 nits và dải màu khổng lồ.', 'Lenovo-ThinkPad-E14-1.png', 18990000, 10, 1),
('MHAC01', 'Màn hình Acer CBL282K 28 IPS 4K HDR10 chuyên đồ họa', 'Màn hình Acer CBL282K sở hữu kích thước 28 inch, độ phân giải UHD chất lượng trên tấm nền IPS. ', 'Screen-28.png', 7490000, 19, 1),
('MHAC02', 'Màn hình Acer K273 E 27 IPS 100Hz', 'Acer K273 E được trang bị màn hình kích thước 27 inch siêu gọn, độ phân giải FullHD dưới tấm nền IPS mang lại khả năng tái tạo màu sắc ấn tượng.', 'Screen-27.png', 3290000, 19, 1),
('MHAC03', 'Màn hình ACER VG270 S 27 IPS 165Hz chuyên game', 'Màn hình gaming Acer Nitro VG270 S 27 inch IPS 165Hz chính hãng, bảo hành 36 tháng. Không gian hiển thị rộng lớn, khả năng diễn tả hình ảnh màu sắc chân thực.', 'Screen-27.png', 4390000, 19, 1),
('MHAS01', 'Màn hình ASUS ProArt PA278CV 27 IPS 2K 75Hz USBC chuyên đồ họa', 'Màn hình ASUS ProArt PA278CV 27\" IPS 2K 75Hz USBC chuyên đồ họa mang đến cho bạn khả năng tương thích tuyệt vời với USB-C, HDMI và DisplayPort với hầu hết các ...', 'Screen-27-2k.png', 8590000, 19, 1),
('MHAS02', 'Màn hình ASUS ProArt PA279CV 27 IPS 4K chuyên đồ họa', 'Chiếc màn hình này sở hữu kích thước 27 inch, tấm nền IPS chống choáng cùng độ bao phủ màu sắc 100% sRGB cực kỳ thích hợp cho công việc thiết kế đồ hoạ.', 'Screen-27-4K.png', 12490000, 19, 1),
('MHAS03', 'Màn hình ASUS VA27EHF 27 IPS 100Hz viền mỏng', 'ASUS VA27EHF sở hữu kích thước màn hình 27 inch tiêu chuẩn và tấm nền IPS với độ phân giải tiêu chuẩn, mang đến góc nhìn rộng và khả năng hiển thị hình ảnh sống ...', 'Screen-27.png', 3490000, 19, 1),
('MHAS04', 'Màn hình ASUS VZ24EHE 24 IPS 75Hz viền mỏng', 'Màn hình ASUS VZ24EHE sở hữu màn hình 24 inch, cấu hình siêu mỏng chỉ 6,5mm. Thiết kế không khung ấn tượng, làm cho nó trở nên lý tưởng cho các thiết lập đa màn ...', 'Screen-24_1.png', 2550000, 19, 1),
('MHAS05', 'Màn hình cong Asus ROG Strix XG49VQ 49 VA 144Hz', 'Màn hình Gaming ASUS ROG Strix XG49VQ (49 inch - Super ultrawide - Cong - 144Hz) bảo hành 36 tháng. Hàng chính hãng giá rẻ nhất tại An Phát, trả góp 0%.', 'Screen-49.png', 24990000, 19, 1),
('MHD01', 'Màn hình cong Dell UltraSharp U3423WE 34 IPS 2K RJ45', 'Màn Hình Dell UltraSharp U3423WE (34.0 inch - WQHD - IPS - 60Hz - 5ms - USB TypeC - Curved) ; Độ phân giải. WQHD 3440 x 1440 ; Tỉ lệ. 21:9 ; Tấm nền màn hình. IPS.', 'Screen-34.png', 20990000, 10, 1),
('MHD02', 'Màn hình cong Dell UltraSharp U3821DW 38 IPS 2K RJ45', 'Kích thước màn hình (inch). 38 Inch. Độ phân giải. WQHD 3840 x 1600. Tỉ lệ hiển thị. 21:9. Độ sáng. 300 cd/m². Gam màu. 95% DCI-P3. Độ sâu màu.', 'Screen-38.png', 27490000, 10, 1),
('MHD03', 'Màn hình Dell UltraSharp U2422HE 24 IPS USBC RJ45', 'Thương hiệu: Dell. Bảo hành: 36 tháng. Kích thước: 24\". Độ phân giải: FullHD 1920x1080. Tấm nền: IPS. Tần số quét: 60 Hz. Thời gian phản hồi: 5 ms.', 'Screen-24.png', 6500000, 10, 1),
('MHD04', 'Màn Hình Dell UltraSharp U2520D 25 IPS 2K chuyên đồ họa', 'Thương hiệu, Dell. Bảo hành, 36 Tháng. Kích thước, 25 inch. Độ phân giải, 2K QHD 2560 x 1440 ( 16 : 9 ). Tấm nền, IPS. Tần số quét, 60Hz.', 'Screen-25.png', 7600000, 10, 1),
('MHD05', 'Màn hình Dell UltraSharp U2722D 27 IPS 2K chuyên đồ họa', 'Dell UltraSharp U2722D mang lại hình ảnh vô cùng sắc nét nhớ vào độ phủ màu đạt 100% sRGB, 100% Rec.709 và 95% DCI-P3 cùng 1.07 tỷ màu.', 'Screen-27.png', 9990000, 10, 1),
('MHL01', 'Màn hình di động Lenovo L15 16 IPS FHD USBC', 'Được đánh giá là một trong những màn hình di động mỏng nhẹ nhất trên thị trường hiện nay, Lenovo L15 16“ IPS FHD USBC sở hữu vẻ ngoài thu hút, nổi bật.', 'Screen-16.png', 3890000, 19, 1),
('MHL02', 'Màn hình di động Lenovo ThinkVision M14 14 IPS FHD USBC', 'Màn hình di động Lenovo M14 · Kích thước 14 inch FHD 1920 x 1080 · Tấm nền IPS cho góc nhìn rộng 178/178 · 2 x cổng USB Type-C hỗ trợ DisplayPort 1. 2 và Pd2. 0.', 'Screen-14.png', 5990000, 19, 1),
('MHL03', 'Màn hình Lenovo G24-20 24 IPS 144Hz Gsync compatible', 'Màn hình Lenovo G24-20 sở hữu ngoại hình vô cùng ấn tượng với tông màu đen nhám chủ đạo. ', 'Screen-24.png', 3250000, 19, 1),
('MHL04', 'Màn hình Lenovo Legion Y25-30 25 IPS 240Hz G-Sync 1ms chuyên game', 'Kích thước, 24.5 inch. Tỷ lệ khung hình, 16:9. Tấm nền, IPS. Góc nhìn, 178°/ 178°. Độ phân giải, Full HD 1920x1080. Độ sáng, 400 cd/m2.', 'Screen-25.png', 5790000, 19, 1),
('MHL05', 'Màn hình Lenovo Legion Y27-30 27 IPS 165Hz chuyên game', 'Kích thước, 27 inch. Tỷ lệ khung hình, 16:9. Tấm nền, IPS. Góc nhìn, 178°/ 178°. Độ phân giải, Full HD 1920x1080. Độ sáng, 400 cd/m2. ', 'Screen-27.png', 4890000, 19, 1),
('PC01', 'PC GVN G-STUDIO 9 Plus i4090', 'PC GVN G-STUDIO Intel i9-14900K/ VGA RTX 4090 (Powered by ASUS) chính hãng giá rẻ, build PC cao cấp online tại GEARVN cấu hình mạnh - Bảo hành 1 đổi 1', 'PC-GVN-studio9plus-i9_1.png', 107000000, 10, 1),
('PC02', 'PC GVN Homework R5', 'Máy tính để bàn GVN Homework R5 sở hữu không gian lưu trữ 250GB đến từ Kingston NV2 250GB M.2 PCIe NVMe Gen4.', 'PC-GVN-Homework_1.png', 7590000, 10, 1),
('PC03', 'PC GVN PHANTOM i3060', 'Mua PC gaming GVN PHANTOM i3060 (i7 14700F / RTX 3060) được phân phối tại GEARVN - Bảo hành 1 đổi 1 - Hỗ trợ trả góp 0% - Giao hàng miễn phí toàn quốc.', 'PC-GVN-phantom-i7_1.png', 29990000, 10, 1),
('PC04', 'PC GVN VIPER i1660S', 'Bộ máy tính để bàn này sử dụng CPU Intel Core i5-12400F đã khiến thị trường dòng chip tầm trung \"nóng\" hơn rất nhiều. ', 'PC-GVN-viper-i5_1.png', 19490000, 10, 1),
('PC05', 'PC GVN VIPER Plus i4060', 'Mua PC GVN VIPER Plus i4060 cấu hình vượt trội, giá rẻ, mua máy tính chơi game tại GEARVN bảo hành 1 đổi 1 - Trả góp 0% - Giao hàng toàn quốc. Click ngay!', 'PC-GVN-viper-plus-i5_1.png', 29490000, 10, 1),
('TNAS01', 'Tai nghe Asus ROG Cetra True Wireless White', 'Tai nghe Asus ROG Cetra True Wireless được trang bị công nghệ chống ồn kép (Hybrid ANC) hiện đại, giúp lọc tiếng ồn bên ngoài lẫn bên trong một cách hiệu quả.', 'Asus-ROG-Cetra.png', 2490000, 19, 1),
('TNAS02', 'Tai nghe Asus ROG Delta S Animate', 'Thương hiệu. Asus. Model. ROG Delta S Animate. Màu sắc. Đen. Kết nối. Có dây. Đầu nối. USB 2.0. Type-C. Chất liệu trình điều khiển. Nam châm neođim.', 'Asus-ROG_Delta_S_Animate.png', 5190000, 19, 1),
('TNAS03', 'Tai Nghe Asus ROG Delta S Core', 'ROG Delta S Core là tai nghe gaming kết nối chuẩn 3.5 mm, siêu nhẹ mang đến chất âm sống động với âm thanh vòm 7.1 ảo.', 'Asus-ROG_Delta_S_Core.png', 1970000, 19, 1),
('TNAS04', 'Tai nghe không dây Asus ROG STRIX GO 2.4', 'Tai nghe không dây Asus ROG STRIX GO 2.4 có cho mình dung lượng pin vô cùng khủng cho bạn thoải mái sử dụng liên tục lên tới 25 tiếng đồng hồ. ', 'Asus-ROG_STRIX_GO.png', 2990000, 19, 1),
('TNCS01', 'Tai nghe Corsair HS50 Pro Stereo Blue', 'Tai Nghe Corsair HS50 Stereo Blue sở hữu màng loa có kích thước 50mm với âm trầm mạnh mẽ cùng với âm trung và cao sống động.', 'Corsair_HS50_Pro.png', 1090000, 19, 1),
('TNCS02', 'Tai nghe Corsair HS55 Stereo White', 'Phiên bản mới, củ loa 50mm với nam chân đất hiếm cho chất lượng âm thanh vượt trội. Thiết kế mới cực kỳ đẹp mắt và cho độ thoải mái tối đa.', 'Corsair_HS55.png', 1090000, 19, 1),
('TNCS03', 'Tai nghe Corsair HS60 Pro Surround Carbon', 'Thương hiệu, Corsair. Tương thích, PC, Xbox One, PS4, Nintendo Switch và các thiết bị di động. Đáp ứng tần số tai nghe, 20Hz - 20 kHz. Kết nối, Jack 3.5mm.', 'Corsair_HS60_Pro.png', 1530000, 19, 1),
('TNCS04', 'Tai nghe Corsair HS65 Surround White', 'Thương hiệu: Corsair. Bảo hành: 24 Tháng. Model: Corsair HS65 Surround White. Màu sắc: Trắng. Kiểu tai nghe, Over-ear. Kiểu kết nối: Có dây.', 'Corsair_HS65.png', 1790000, 19, 1),
('TNCS05', 'Tai nghe Corsair HS80 MAX Wireless Steel Gray', 'Loại: Tai Nghe Gaming; Chuẩn kết nối: Không dây USB 2.4Ghz Wireless; Công nghệ: Dolby Atmos Surround; Màu sắc: Black, White; Bảo hành: 24 tháng.', 'Corsair_HS80_MAX.png', 3660000, 19, 1),
('TNDU01', 'Tai nghe DareU A700 Wireless', 'Thời gian lượng pin cực dài. Tai nghe DareU A700 Wireless có Li-polymer 930mAh cho phép thời gian chơi game lên đến 12 giờ chỉ với 2 giờ sạc.', 'Dareu_A700.png', 980000, 19, 1),
('TNDU02', 'Tai nghe DAREU A710 RGB Wireless', 'Thương hiệu: DareU. Bảo hành: 12 tháng. Series/Model: A710 Wireless. Màu sắc: Đen. Kiểu tai nghe: Over-ear. Kiểu kết nối: Không dây. LED: RGB.', 'Draeu_A710.png', 1450000, 19, 1),
('TNDU03', 'Tai nghe DareU D2 (TWS EARBUDS) True Wireless', 'Tai nghe TWS Earbuds – BLUETOOTH 5.1. Chống nước IPX4 Pin: 400 mAh. Thời gian sử dụng: 3h ~ 5h. Thời gian sạc (tai nghe hoặc case): 1.5h', 'Dareu_D2.png', 579000, 19, 1),
('TNDU04', 'Tai nghe DareU D5 ANC True Wireless', 'Tai nghe không dây DAREU D5 ANC (TWS EARBUDS, BT 5.0) · ANC (Active Noise Cancelling) – Chống ồn chủ động · Pin case: 400 mAh · Thời gian sử dụng: 3h ~ 5h.', 'Dareu_D5_ANC.png', 909000, 19, 1),
('TNDU05', 'Tai nghe DareU EH722X 7.1 Pink', 'Tai nghe DareU EH722X 7.1 Pink với hiệu ứng âm thanh giả lập 7.1 giúp tạo ra âm thanh ấn tượng, trong trẻo. ', 'Dareu_EH722X.png', 650000, 19, 1),
('TNL01', 'Tai nghe G331 chơi game Âm thanh nổi (Stereo Gaming Headset) - WHITE', 'Được thiết kế cho sự thoải mái & bền bỉ, G331 có màng loa âm thanh 50 mm, cần mic 6mm gấp vào để tắt tiếng, độ nhạy 107DB & nhiều hơn nữa.', 'G331.png', 1050000, 19, 1),
('TNL02', 'Tai nghe logitech G331 chơi game Âm thanh nổi (Stereo Gaming Headset) - BLACK', 'Được thiết kế cho sự thoải mái & bền bỉ, G331 có màng loa âm thanh 50 mm, cần mic 6mm gấp vào để tắt tiếng, độ nhạy 107DB & nhiều hơn nữa.', 'G331_1.png', 1050000, 19, 1),
('TNL03', 'Tai nghe Logitech G733 LIGHTSPEED Wireless Black', 'Thương hiệu: Logitech. Bảo hành: 24 tháng. Series/Model: G733 LightSpeed Wireless Black. Màu sắc: Đen. Kiểu tai nghe: Over-ear. Kiểu kết nối: Không dây.', 'G733.png', 2449000, 19, 1),
('TNL04', 'Tai Nghe Logitech G933 Artemis Spectrum 7.1 Wireless', 'Logitech G933 Artemis Spectrum 7.1 Wireless có bộ phụ kiện rất đầy đủ bao gồm: 1 dây USB, 1 dây 3.5mm kèm control talk, 1 dây RCA dùng cho các thiết bị giải trí ...', 'G933.png', 2800000, 19, 1),
('TNMSI01', 'Tai nghe gaming có dây MSI Immerse GH20', 'Tai nghe GAMING · Bộ trình điều khiển 13,5mm mạnh mẽ · Thiết kế thoải mái · Điều khiển nội dòng tiện dụng · Mic Boom có ​​thể tháo rời · Được thiết kế cho trò chơi.', 'MSI_Immerse_GH20.png', 890000, 19, 1),
('TNMSI02', 'Tai nghe MSI Immerse GH61', 'Tai nghe MSI Immerse GH61 sở hữu củ loa Hi-Res do Onkyo lắp đặt giúp tái tạo mọi âm thanh trong game với độ phân giải cao và màng loa 40mm đã được ...', 'MSI_Immerse_GH61.png', 1490000, 19, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category`
--

CREATE TABLE `product_category` (
  `product_id` varchar(25) NOT NULL,
  `category_id` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
('2', 'DT'),
('3', 'DT'),
('3', 'tablet-samsung'),
('DTSGA05', 'DT'),
('ip15', 'DT'),
('ip15', 'macbook'),
('LTAC', 'LT'),
('LTAC01', 'LT'),
('LTAC03', 'LT'),
('LTAC04', 'LT'),
('LTAC05', 'LT'),
('LTAS01', 'LT'),
('LTAS04', 'LT'),
('LTD03', 'LT'),
('LTL01', 'LT');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_image`
--

CREATE TABLE `product_image` (
  `product_id` varchar(25) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slider`
--

CREATE TABLE `slider` (
  `slider_id` int(11) NOT NULL,
  `slider_name` varchar(255) NOT NULL,
  `slider_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `slider`
--

INSERT INTO `slider` (`slider_id`, `slider_name`, `slider_image`) VALUES
(41, 'slider 1', 'image_slider/slider1.jpg'),
(42, 'slider 2', 'image_slider/slider2.jpg'),
(43, 'slider 3', 'image_slider/slider 3.jpg'),
(44, 'slider 4', 'image_slider/slider 3.jpg'),
(45, 'slider 5', 'image_slider/slider3.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support`
--

CREATE TABLE `support` (
  `support_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_response` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `support`
--

INSERT INTO `support` (`support_id`, `user_id`, `order_id`, `message`, `status`, `time`, `admin_response`) VALUES
(24, 'e0af668fe8a9', 16, 'Đơn hàng của tôi bị sai', 'Đang xử lý', '2024-10-17 00:54:20', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` varchar(25) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birth` date NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `gender`, `birth`, `phone`, `email`, `address`) VALUES
('e0af668fe8a9', 'Nguyễn Như', 'Hoàng', 'Nam', '2002-09-15', '0969839072', 'hoang23032003@gmail.com', '');

--
-- Bẫy `user`
--
DELIMITER $$
CREATE TRIGGER `cart_create` AFTER INSERT ON `user` FOR EACH ROW INSERT INTO cart (user_id) VALUES (NEW.user_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_account`
--

CREATE TABLE `user_account` (
  `email` varchar(25) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_account`
--

INSERT INTO `user_account` (`email`, `user_id`, `password`, `phone`) VALUES
('hoang23032003@gmail.com', 'e0af668fe8a9', '$2y$10$7sHbFjoxKmHZ1ifPHGqdvejZkQ6/TRSoF6Vgq9NNR3YiNFvY3osmK', '0969839072');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_favorites`
--

CREATE TABLE `user_favorites` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_login_history`
--

CREATE TABLE `user_login_history` (
  `user_id` varchar(25) NOT NULL,
  `time` date NOT NULL,
  `ip` varchar(25) NOT NULL,
  `device` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_login_history`
--

INSERT INTO `user_login_history` (`user_id`, `time`, `ip`, `device`) VALUES
('e0af668fe8a9', '2024-10-17', '::1', 'Desktop');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_product_history`
--

CREATE TABLE `user_product_history` (
  `user_id` varchar(25) NOT NULL,
  `product_id` varchar(25) NOT NULL,
  `time` datetime NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_product_history`
--

INSERT INTO `user_product_history` (`user_id`, `product_id`, `time`, `type`) VALUES
('e0af668fe8a9', '2', '2024-10-17 02:46:25', 0),
('e0af668fe8a9', '2', '2024-10-17 03:33:44', 0),
('e0af668fe8a9', '2', '2024-10-17 03:33:46', 0),
('e0af668fe8a9', '2', '2024-10-17 03:43:21', 0),
('e0af668fe8a9', '2', '2024-10-17 03:43:22', 0),
('e0af668fe8a9', '3', '2024-10-17 02:47:34', 0),
('e0af668fe8a9', '3', '2024-10-17 02:53:04', 0),
('e0af668fe8a9', '3', '2024-10-17 02:53:05', 0),
('e0af668fe8a9', '3', '2024-10-17 03:39:29', 0),
('e0af668fe8a9', '3', '2024-10-17 03:39:32', 1),
('e0af668fe8a9', '3', '2024-10-17 16:20:20', 0),
('e0af668fe8a9', '3', '2024-10-17 16:20:21', 0),
('e0af668fe8a9', '3', '2024-10-17 16:20:23', 0),
('e0af668fe8a9', 'DTSGA05', '2024-10-17 03:37:46', 0),
('e0af668fe8a9', 'DTSGA05', '2024-10-17 03:37:47', 0),
('e0af668fe8a9', 'DTSGA05', '2024-10-17 03:41:00', 0),
('e0af668fe8a9', 'DTSGA05', '2024-10-17 03:41:02', 0),
('e0af668fe8a9', 'DTSGA05', '2024-10-17 03:41:03', 0),
('e0af668fe8a9', 'DTSGA05', '2024-10-17 03:41:31', 0),
('e0af668fe8a9', 'DTSGA05', '2024-10-17 03:41:32', 0),
('e0af668fe8a9', 'DTSGA05', '2024-10-17 15:27:22', 0),
('e0af668fe8a9', 'LTAC01', '2024-10-17 16:20:26', 0),
('e0af668fe8a9', 'LTAC01', '2024-10-17 16:20:27', 0),
('e0af668fe8a9', 'LTAC01', '2024-10-17 16:20:31', 0),
('e0af668fe8a9', 'LTAC01', '2024-10-17 16:20:32', 0),
('e0af668fe8a9', 'LTAC03', '2024-10-17 02:46:29', 0),
('e0af668fe8a9', 'LTAC03', '2024-10-17 02:46:30', 0),
('e0af668fe8a9', 'LTAC03', '2024-10-17 02:46:32', 0),
('e0af668fe8a9', 'LTAC04', '2024-10-17 03:44:47', 0),
('e0af668fe8a9', 'LTAC04', '2024-10-17 03:44:49', 0),
('e0af668fe8a9', 'LTAC04', '2024-10-17 03:46:59', 0),
('e0af668fe8a9', 'LTAC04', '2024-10-17 03:47:01', 0),
('e0af668fe8a9', 'LTAC04', '2024-10-17 07:54:48', 0),
('e0af668fe8a9', 'LTAC04', '2024-10-17 16:17:44', 0),
('e0af668fe8a9', 'LTAC04', '2024-10-17 16:17:45', 0),
('e0af668fe8a9', 'LTAC05', '2024-10-17 02:46:53', 0),
('e0af668fe8a9', 'LTAC05', '2024-10-17 02:46:54', 0),
('e0af668fe8a9', 'LTAC05', '2024-10-17 02:56:58', 0),
('e0af668fe8a9', 'LTAC05', '2024-10-17 02:56:59', 0),
('e0af668fe8a9', 'LTAS01', '2024-10-17 02:58:50', 0),
('e0af668fe8a9', 'LTAS01', '2024-10-17 02:58:51', 0),
('e0af668fe8a9', 'LTL01', '2024-10-17 02:46:35', 0),
('e0af668fe8a9', 'LTL01', '2024-10-17 02:46:37', 0),
('e0af668fe8a9', 'LTL01', '2024-10-17 02:46:42', 0),
('e0af668fe8a9', 'LTL01', '2024-10-17 02:46:43', 0),
('e0af668fe8a9', 'LTL01', '2024-10-17 02:58:42', 0),
('e0af668fe8a9', 'LTL01', '2024-10-17 02:58:44', 0),
('e0af668fe8a9', 'LTL01', '2024-10-17 02:58:46', 0),
('e0af668fe8a9', 'LTL01', '2024-10-17 15:26:42', 0),
('e0af668fe8a9', 'MHAS04', '2024-10-17 15:30:07', 0),
('e0af668fe8a9', 'MHAS04', '2024-10-17 15:30:20', 0),
('e0af668fe8a9', 'MHAS04', '2024-10-17 15:32:53', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_voucher`
--

CREATE TABLE `user_voucher` (
  `user_id` varchar(255) NOT NULL,
  `voucher_id` int(255) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `voucher`
--

CREATE TABLE `voucher` (
  `voucher_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `discount_type` enum('fixed','percent') NOT NULL,
  `min_order_value` decimal(10,2) DEFAULT 0.00,
  `expiration_date` date DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `status` enum('active','expired','disabled') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `voucher`
--

INSERT INTO `voucher` (`voucher_id`, `code`, `discount_value`, `discount_type`, `min_order_value`, `expiration_date`, `usage_limit`, `status`) VALUES
(1, '123123', 10.00, 'percent', 0.00, '2024-10-17', 2, 'active'),
(2, 'Hello', 30.00, 'percent', 0.00, NULL, 1, 'active'),
(3, '37147', 30000.00, 'fixed', 0.00, NULL, 5, 'active');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `voucher_product`
--

CREATE TABLE `voucher_product` (
  `voucher_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`cart_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_description` (`parent`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`product_id`,`image`);

--
-- Chỉ mục cho bảng `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`),
  ADD UNIQUE KEY `slider_id` (`slider_id`),
  ADD UNIQUE KEY `slider_id_2` (`slider_id`);

--
-- Chỉ mục cho bảng `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`support_id`),
  ADD KEY `support_ibfk_1` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `user_login_history`
--
ALTER TABLE `user_login_history`
  ADD PRIMARY KEY (`user_id`,`time`);

--
-- Chỉ mục cho bảng `user_product_history`
--
ALTER TABLE `user_product_history`
  ADD PRIMARY KEY (`user_id`,`product_id`,`time`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `user_voucher`
--
ALTER TABLE `user_voucher`
  ADD PRIMARY KEY (`user_id`,`voucher_id`,`time`),
  ADD KEY `user_voucher_ibfk_2` (`voucher_id`);

--
-- Chỉ mục cho bảng `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucher_id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `code_2` (`code`);

--
-- Chỉ mục cho bảng `voucher_product`
--
ALTER TABLE `voucher_product`
  ADD PRIMARY KEY (`voucher_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `cart_product`
--
ALTER TABLE `cart_product`
  MODIFY `cart_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `support`
--
ALTER TABLE `support`
  MODIFY `support_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `user_favorites`
--
ALTER TABLE `user_favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `voucher`
--
ALTER TABLE `voucher`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bill_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `cart_product_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_account` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `support`
--
ALTER TABLE `support`
  ADD CONSTRAINT `support_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `support_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `user_account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD CONSTRAINT `user_favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_favorites_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_login_history`
--
ALTER TABLE `user_login_history`
  ADD CONSTRAINT `user_login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_product_history`
--
ALTER TABLE `user_product_history`
  ADD CONSTRAINT `user_product_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_product_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_voucher`
--
ALTER TABLE `user_voucher`
  ADD CONSTRAINT `user_voucher_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_voucher_ibfk_2` FOREIGN KEY (`voucher_id`) REFERENCES `voucher` (`voucher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `voucher_product`
--
ALTER TABLE `voucher_product`
  ADD CONSTRAINT `voucher_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `voucher_product_ibfk_2` FOREIGN KEY (`voucher_id`) REFERENCES `voucher` (`voucher_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
