-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: May 07, 2026 at 08:11 PM
-- Server version: 5.7.44
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'pending',
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `created_at`, `status`, `name`, `phone`, `address`) VALUES
(1, 2, 0, '2026-05-05 08:52:24', 'pending', NULL, NULL, NULL),
(2, 2, 199998, '2026-05-05 08:54:01', 'shipped', NULL, NULL, NULL),
(3, 2, 199998, '2026-05-05 08:55:37', 'shipped', 'kunchala ravi kumar', '07569091026', 'Satya towers 1st floor, paparaju, Mutyalammapadu,\r\nSatyaranayana Puram, Vijayawada, Andhra Pradesh, India.'),
(4, 2, 199998, '2026-05-05 08:59:05', 'shipped', 'kunchala ravi kumar', '07569091026', 'Satya towers 1st floor, paparaju, Mutyalammapadu,\r\nSatyaranayana Puram, Vijayawada, Andhra Pradesh, India.'),
(5, 2, 79999, '2026-05-07 19:21:54', 'pending', NULL, NULL, NULL),
(6, 2, 79999, '2026-05-07 19:22:45', 'pending', NULL, NULL, NULL),
(7, 2, 79999, '2026-05-07 19:24:12', 'pending', NULL, NULL, NULL),
(8, 2, 49995, '2026-05-07 19:27:21', 'pending', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 8, 4, 9999, 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(3, 'test1', 99999, '1778181928_headphones.jpg'),
(4, 'deepu', 9999, '1778181908_p2.jpg'),
(5, 'iPhone 15', 79999, '1778181315_shopping.webp'),
(6, 'Samsung Galaxy S24', 74999, '1778181336_download.webp'),
(7, 'OnePlus 12', 64999, '1778181354_download.jpg'),
(8, 'Realme GT', 35999, '1778181379_Realme GT.jpg'),
(9, 'Redmi Note 13', 22999, '1778181397_Redmi Note 13.jpg'),
(10, 'HP Laptop', 55999, '1778181412_HP Laptop.jpg'),
(11, 'Dell Inspiron', 62999, '1778181455_Dell Inspiron.jpg'),
(12, 'Lenovo ThinkPad', 68999, '1778181475_Lenovo ThinkPad.jpg'),
(13, 'Asus ROG', 99999, '1778181488_asurog.jpg'),
(14, 'MacBook Air', 109999, 'default.jpg'),
(15, 'Boat Headphones', 1999, 'default.jpg'),
(16, 'Sony Headphones', 7999, 'default.jpg'),
(17, 'JBL Speaker', 4999, 'default.jpg'),
(18, 'Noise Smartwatch', 2999, 'default.jpg'),
(19, 'FireBoltt Watch', 2499, 'default.jpg'),
(20, 'Nike Shoes', 4999, 'default.jpg'),
(21, 'Puma Shoes', 3999, 'default.jpg'),
(22, 'Adidas Shoes', 4599, 'default.jpg'),
(23, 'Reebok Shoes', 3499, 'default.jpg'),
(24, 'Campus Shoes', 1999, 'default.jpg'),
(25, 'Gaming Mouse', 1499, 'default.jpg'),
(26, 'Mechanical Keyboard', 3999, 'default.jpg'),
(27, 'Gaming Chair', 8999, 'default.jpg'),
(28, 'Monitor 24 Inch', 12999, 'default.jpg'),
(29, 'Webcam HD', 2499, 'default.jpg'),
(30, 'Power Bank', 1499, 'default.jpg'),
(31, 'USB Cable', 299, 'default.jpg'),
(32, 'Bluetooth Speaker', 1999, 'default.jpg'),
(33, 'Smart TV', 45999, 'default.jpg'),
(34, 'Air Conditioner', 38999, 'default.jpg'),
(35, 'Washing Machine', 28999, 'default.jpg'),
(36, 'Refrigerator', 34999, 'default.jpg'),
(37, 'Microwave Oven', 8999, 'default.jpg'),
(38, 'Electric Kettle', 1499, 'default.jpg'),
(39, 'Coffee Maker', 4999, 'default.jpg'),
(40, 'Study Table', 6999, 'default.jpg'),
(41, 'Office Chair', 5999, 'default.jpg'),
(42, 'Bookshelf', 3499, 'default.jpg'),
(43, 'LED Lamp', 999, 'default.jpg'),
(44, 'Wall Clock', 799, 'default.jpg'),
(45, 'Backpack', 1499, 'default.jpg'),
(46, 'Travel Bag', 2499, 'default.jpg'),
(47, 'Trolley Suitcase', 4999, 'default.jpg'),
(48, 'Water Bottle', 499, 'default.jpg'),
(49, 'Gym Bottle', 699, 'default.jpg'),
(50, 'Protein Powder', 2999, 'default.jpg'),
(51, 'Yoga Mat', 999, 'default.jpg'),
(52, 'Dumbbells', 3499, 'default.jpg'),
(53, 'Treadmill', 45999, 'default.jpg'),
(54, 'Fitness Band', 1999, 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `is_verified` tinyint(4) DEFAULT '0',
  `verify_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `is_verified`, `verify_token`) VALUES
(2, 'test1', 'dileepx06@gmail.com', '$2y$10$74guMv8Db/4AO.562FFnKOQR0jvYvz3V70hzYUc8TlWLnmJg4KcyW', 'admin', 0, NULL),
(3, 'k.dileep varma', 'dileepkunchala09@gmail.com', '$2y$10$N2FPiHpFPWSej4ALaa3sUuIVmKFIvatmw./x6qWYtN9U9qXmmehA2', 'admin', 0, NULL),
(6, 'test2', 'dileepdeepu1976@gmail.com', '$2y$10$/k/Xq4TeIwn04A4m//cmoO5u86zae.yi6EMamhWNNaCjVwdUrYOwi', 'user', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
