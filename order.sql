-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-01-07 08:53:52
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `test`
--

-- --------------------------------------------------------

--
-- 資料表結構 `order`
--

CREATE TABLE `order` (
  `id` int(10) NOT NULL,
  `commodity` text NOT NULL,
  `total` int(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '未處理',
  `userId` varchar(11) NOT NULL,
  `Mid` varchar(10) NOT NULL,
  `evaluate` varchar(10) NOT NULL DEFAULT '無'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `order`
--

INSERT INTO `order` (`id`, `commodity`, `total`, `status`, `userId`, `Mid`, `evaluate`) VALUES
(1, '洗衣精 * 3,', 600, '已送達', 'c1', 'm1', '三星'),
(2, '牙刷 * 5,', 1000, '未處理', 'c1', 'm2', '無'),
(3, '洗衣精 * 1,', 200, '未處理', 'c2', 'm1', '無'),
(4, '牙刷 * 1,', 200, '未處理', 'c2', 'm2', '無');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
