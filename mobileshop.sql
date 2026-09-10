-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2026 at 04:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobileshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `alternative_phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `full_name`, `phone_number`, `pincode`, `address`, `city`, `state`, `alternative_phone`, `created_at`, `updated_at`) VALUES
(1, 1, 'Avijit Das', '7501142958', '721467', 'hr-86', 'kolkata', 'West Bengal', '8145574092', '2025-09-09 20:18:35', '2025-09-09 20:26:58'),
(3, 1, 'avi', '9786516494', '721467', 'kh-86', 'kolkata', 'West Bengal', '7943165491', '2025-09-10 03:57:09', '2025-09-10 03:57:09');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(4, 'Chargers', 'categories/XpCQ2euYIWl0yp0NVRbOUQbmboTxp1OTqaEEaHEv.jpg'),
(5, 'Earbuds', 'categories/9mxl9jjRP9NVPMjiJ2CKNuiwy9Wvl4FytufLksyS.jpg'),
(6, 'Hard Drive', 'categories/J3kmIV7s7ZIoEQxKmfSjcIiaiItzqmKKxs1YCc4C.jpg'),
(7, 'Head Phones', 'categories/48A9sfEsY7UkTlwEPnBXMdxSbwXXnLp1NDqHG8hf.jpg'),
(8, 'Mobiles', 'categories/vklpDcBG3OsM0XcVoxM1wyu7NfwxznPnfpj2T0P1.jpg'),
(9, 'Tablets', 'categories/ypAJknBHc9h5juDrpUgW9gHbDa5wd2icnj9wAgXy.jpg'),
(10, 'Smart Watchs', 'categories/3WlVPI0RDuu7ATehMwVk3YmXXkOoIDnkrvlF5Whn.jpg'),
(11, 'Power Bank', 'categories/8PzOjSZZ2qLHJjQczosXnNfSqf7bTcvOVhHIPGqe.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(24, '0001_01_01_000000_create_users_table', 1),
(25, '0001_01_01_000001_create_cache_table', 1),
(26, '0001_01_01_000002_create_jobs_table', 1),
(27, '2025_07_16_200116_categories', 2),
(28, '2025_07_18_013054_products', 2),
(32, '2025_07_24_015741_carts', 3),
(34, '2025_09_03_093506_create_wishlists_table', 4),
(35, '2025_09_06_160332_create_addresses_table', 5),
(36, '2025_09_10_013127_create_orders_table', 6),
(37, '2025_09_10_013139_create_order_items_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `shipping` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_method` enum('cod','card','upi') NOT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `order_number`, `subtotal`, `tax`, `shipping`, `total`, `payment_method`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'ORD-1757469726-1', 230897.00, 4617.94, 0.00, 235514.94, 'cod', 'pending', NULL, '2025-09-09 20:32:06', '2025-09-09 20:32:06'),
(2, 1, 3, 'ORD-1757496481-1', 194899.00, 3897.98, 0.00, 198796.98, 'cod', 'pending', NULL, '2025-09-10 03:58:01', '2025-09-10 03:58:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 2, 17999.00, 35998.00, '2025-09-09 20:32:06', '2025-09-09 20:32:06'),
(2, 1, 3, 1, 59999.00, 59999.00, '2025-09-09 20:32:06', '2025-09-09 20:32:06'),
(3, 1, 5, 1, 134900.00, 134900.00, '2025-09-09 20:32:06', '2025-09-09 20:32:06'),
(4, 2, 3, 1, 59999.00, 59999.00, '2025-09-10 03:58:01', '2025-09-10 03:58:01'),
(5, 2, 5, 1, 134900.00, 134900.00, '2025-09-10 03:58:01', '2025-09-10 03:58:01');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(3, 8, 'Huawei Pura 70 Smartphone', 'The Huawei Pura 70 features a stunning 6.6-inch OLED display with a 120Hz refresh rate for ultra-smooth visuals. Powered by the Kirin 9000S processor, it comes with 12GB RAM and 256GB internal storage, ensuring fast performance and ample space for apps and media. The phone boasts a powerful triple rear camera setup including a 50MP main sensor with advanced AI photography, a 12MP ultra-wide lens, and a 12MP telephoto lens with 5x optical zoom. It runs on HarmonyOS with smart features for seamless multitasking. The 4900mAh battery supports 66W fast charging, allowing the device to charge up to 60% in just 20 minutes. Designed with premium materials, the Pura 70 offers IP68 water and dust resistance and an in-display fingerprint sensor for secure access. Perfect for users seeking flagship-level performance, exceptional camera quality, and elegant design.', 59999.00, 10, 'products/JwvrFsRv6KZpRIx4GVqdikk8Noj9XZbgoQvlMgyp.jpg', '2025-07-21 04:14:57', '2025-07-21 04:14:57'),
(4, 8, 'Tecno Pova Curve 5G', 'The Tecno Pova Curve 5G features a large 6.78-inch curved AMOLED display with Full HD+ resolution and a smooth 120Hz refresh rate, providing immersive visuals for gaming and videos. It is powered by the MediaTek Dimensity 6080 5G processor coupled with 8GB RAM and 128GB internal storage, expandable via microSD for enhanced performance and storage flexibility. The device comes with a dual rear camera setup including a 50MP primary sensor and an AI lens for detailed photos and enhanced portrait shots. It runs on HiOS based on Android 13, offering smart features and customizable UI options. The massive 5000mAh battery supports 33W fast charging, keeping the device powered throughout the day with minimal downtime. Additionally, it includes a side-mounted fingerprint sensor, face unlock, and 5G connectivity for ultra-fast internet speeds. Ideal for budget-conscious users seeking a stylish curved display, reliable performance, and future-ready 5G connectivity.', 17999.00, 20, 'products/DfPtErEvZEmPsa9KFLB0zMO3HtdWJXsMNosTop7v.jpg', '2025-07-21 04:16:29', '2025-07-21 04:16:29'),
(5, 8, 'Apple iPhone 15 Pro', 'The Apple iPhone 15 Pro features a stunning 6.1-inch Super Retina XDR OLED display with ProMotion technology, offering up to a 120Hz adaptive refresh rate for ultra-smooth scrolling and responsiveness. It is powered by the latest A17 Pro Bionic chip built on a 3nm process, ensuring lightning-fast performance, efficient power management, and advanced graphics capabilities ideal for gaming and professional apps. The device includes 8GB RAM with storage options starting from 128GB up to 1TB, catering to all user needs. Its triple rear camera system includes a 48MP main camera with second-generation sensor-shift OIS, a 12MP ultra-wide lens, and a 12MP 3x telephoto lens, enabling high-resolution photography, cinematic 4K video recording, and macro shots with incredible detail. The front TrueDepth camera supports Face ID and captures stunning selfies with advanced AI processing. It features an aerospace-grade titanium frame, Ceramic Shield front cover, and is IP68 water and dust resistant for durability. The iPhone 15 Pro also introduces the USB-C port for faster data transfer, runs on iOS 17 with new personalization features, and supports MagSafe charging and accessories. Ideal for professionals, content creators, and anyone seeking unmatched performance and premium design in a smartphone.', 134900.00, 10, 'products/As1rJAWyCiQT4VgyQF1T0Xj9BqErYvxwhE6UWWiO.jpg', '2025-07-21 04:26:03', '2025-07-21 04:26:03'),
(6, 8, 'Samsung Galaxy M14 5G', 'The Samsung Galaxy M14 5G comes with a large 6.6‑inch TFT LCD display featuring Full HD+ resolution and a smooth 90Hz refresh rate, delivering a responsive and vibrant viewing experience for everyday use. It is powered by the Exynos 1330 octa‑core processor paired with 6GB RAM and 128GB storage, expandable via microSD up to 1TB, ensuring efficient performance for multitasking and ample space for apps and media. The phone sports a versatile triple rear camera setup consisting of a 50MP primary sensor, a 5MP ultrawide lens, and a 2MP depth sensor, along with a 13MP front camera for clear selfies and video calls. It runs on Android 14 with Samsung’s One UI 6, offering intuitive features like enhanced security and seamless multitasking. The Galaxy M14 includes a powerful 6000mAh battery with 15W fast charging support, designed to offer more than two days of regular usage on a single charge. Additional features include a side-mounted fingerprint sensor for secure access, a 3.5mm headphone jack, dual-SIM capability, and robust 5G connectivity across India. Ideal for users seeking long-lasting battery life, essential camera features, and reliable network speeds in a budget-friendly 5G smartphone.', 12499.00, 15, 'products/MvFaoJ7xblrkdtWOHLhooXtzt5xKqdRzyu5XhDGE.webp', '2025-07-21 04:27:19', '2025-07-21 04:27:19'),
(7, 6, 'Seagate One Touch 5TB External HDD with Password Protection', 'The Seagate One Touch 5TB External HDD offers massive portable storage in a sleek and stylish light blue design. It provides a generous 5TB capacity, ideal for backing up large files, storing multimedia content, and expanding your laptop or desktop storage instantly. This hard drive supports USB 3.0 connectivity, ensuring fast transfer speeds of up to 120 MB/s for quick backup and file access. The device comes with built-in password protection and 256-bit AES hardware encryption to keep your data secure from unauthorized access. It is compatible with Windows and Mac out of the box without requiring reformatting, and Seagate’s Toolkit software allows easy scheduled backups and folder mirroring for seamless data management. Its compact and lightweight build makes it convenient to carry in your backpack or laptop bag. The drive also includes a complimentary 4-month Adobe Creative Cloud Photography Plan membership, enabling users to edit and manage photos effortlessly. Ideal for students, professionals, photographers, and content creators who require reliable, secure, and spacious external storage on the go.', 10999.00, 20, 'products/0utEVZ9OncKdJkYQN6zCqnpy8iKwGGj3qwmmjdx9.jpg', '2025-07-21 04:28:43', '2025-07-21 04:28:43'),
(8, 11, 'boAt EnergyShroom PB400 Pro 20000 mAh Power Bank', 'The boAt EnergyShroom PB400 Pro is a high-capacity 20,000 mAh power bank designed to keep your devices charged all day. Featuring dual USB‑A and USB‑C output ports, it delivers fast charging at up to 22.5 W (maximum), supporting Power Delivery (PD) 3.0 and Quick Charge 3.0 technologies. The power bank includes a USB‑C input port for quick recharging in around 6 hours using a 20 W charger. Equipped with 4‑LED indicators, it allows you to easily check the remaining battery level. The sleek mushroom-shaped design in glossy red combines style with portability, while the compact size (approx. 150 × 75 × 25 mm) and lightweight build make it travel‑friendly. With smart protection features including overcharge, over-discharge, overcurrent, and short circuit safeguards, your devices remain safe while charging. Compatible with smartphones, tablets, wireless earbuds, and Bluetooth speakers, this power bank is ideal for travelers, students, and professionals needing reliable backup power on the go.', 2199.00, 10, 'products/wwQmoBdRK3NW67KOOAkQ3pSAecClrJZTOlLlPs4o.jpg', '2025-07-21 04:35:38', '2025-07-21 04:35:38'),
(9, 8, 'Samsung Galaxy S24 FE 5G AI Smartphone', 'The Samsung Galaxy S24 FE 5G AI Smartphone is designed to deliver flagship-level features at an affordable price. It is expected to come with a 6.4-inch Dynamic AMOLED 2X display with Full HD+ resolution and a smooth 120Hz refresh rate for vivid visuals and buttery-smooth scrolling. Powered by the Exynos 2400 or Snapdragon 8 Gen 2 processor (market-dependent), paired with up to 8GB RAM and 256GB storage, it ensures top-tier performance for multitasking, gaming, and AI-based tasks. The rear camera setup includes a powerful 50MP primary sensor with optical image stabilization (OIS), a 12MP ultrawide camera for expansive shots, and an 8MP telephoto lens with 3x optical zoom, offering versatile photography and stable 4K video recording. The front houses a 10MP selfie camera for clear, bright selfies even in low light.\r\n\r\nRunning on Android 14 with Samsung’s One UI 6.1, it integrates AI features such as live translation, photo editing suggestions, and adaptive battery management. The phone packs a 4500mAh battery with 25W fast charging support, promising all-day usage and quick recharges. Additional features include an in-display fingerprint sensor, IP68 dust and water resistance, stereo speakers with Dolby Atmos, and advanced 5G connectivity. This smartphone is ideal for users seeking premium AI features, powerful cameras, and seamless performance at a competitive price point.', 49999.00, 5, 'products/GwAv2GACctMBfPltVAfsO2nZlrgwmDJW1EtrjiSF.jpg', '2025-07-21 12:56:57', '2025-07-21 12:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`) VALUES
(1, 'avi', 'avi@gmail.com', '$2y$12$EKFIAj7YZ0jc2vOaxW71Q.wBXb8igdxxspEYhgYOHnrnQJT0mN9e.', 1),
(2, 'santu', 's@gmail.com', '$2y$12$Q5JmIXiUJf6BEPnXhG8XWemfFNXTYaxceFB7BFCsvtf6iQh40tRPu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 6, NULL, NULL),
(2, 1, 7, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
