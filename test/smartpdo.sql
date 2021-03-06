-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 01 mei 2017 om 16:45
-- Serverversie: 10.1.19-MariaDB
-- PHP-versie: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartpdo`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `spdo_customer`
--

CREATE TABLE `spdo_customer` (
  `ID` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `info` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `spdo_customer`
--

INSERT INTO `spdo_customer` (`ID`, `name`, `info`) VALUES
(1, 'Customer abc', ''),
(2, 'Customer def', ''),
(3, 'Customer ghi', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `spdo_licences`
--

CREATE TABLE `spdo_licences` (
  `ID` int(11) UNSIGNED NOT NULL,
  `customerID` int(11) UNSIGNED NOT NULL,
  `licenseID` int(11) UNSIGNED NOT NULL,
  `expires` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `spdo_licences`
--

INSERT INTO `spdo_licences` (`ID`, `customerID`, `licenseID`, `expires`) VALUES
(1, 1, 1, NULL),
(2, 2, 1000, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `spdo_urbanareas`
--

CREATE TABLE `spdo_urbanareas` (
  `ID` int(11) NOT NULL,
  `city` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` decimal(9,6) NOT NULL,
  `longitude` decimal(9,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `spdo_urbanareas`
--

INSERT INTO `spdo_urbanareas` (`ID`, `city`, `country`, `latitude`, `longitude`) VALUES
(1, 'Sofia', 'Bulgaria', '42.700000', '23.330000'),
(2, 'Mandalay', 'Myanmar', '21.970000', '96.080000'),
(3, 'Nay Pyi Taw', 'Myanmar', '19.750000', '96.100000'),
(4, 'Yangon', 'Myanmar', '16.870000', '96.120000'),
(5, 'Minsk', 'Belarus', '53.890000', '27.570000'),
(6, 'Phnum Pénh', 'Cambodia', '11.560000', '104.910000'),
(7, 'El Djazaïr', 'Algeria', '36.780000', '3.050000'),
(8, 'Wahran', 'Algeria', '35.740000', '-0.520000'),
(9, 'Douala', 'Cameroon', '4.130000', '9.700000'),
(10, 'Yaoundé', 'Cameroon', '3.860000', '11.510000'),
(11, 'Calgary', 'Canada', '51.030000', '-114.040000'),
(12, 'Edmonton', 'Canada', '53.550000', '-113.500000'),
(13, 'Montréal', 'Canada', '45.540000', '-73.650000'),
(14, 'Ottawa-Gatineau', 'Canada', '45.370000', '-75.650000'),
(15, 'Toronto', 'Canada', '43.720000', '-79.410000'),
(16, 'Vancouver', 'Canada', '49.270000', '-122.960000'),
(17, 'N\'Djaména', 'Chad', '12.100000', '15.240000'),
(18, 'Santiago', 'Chile', '-33.430000', '-70.650000'),
(19, 'Valparaíso', 'Chile', '-33.020000', '-71.550000'),
(20, 'Anshan, Liaoning', 'China', '41.110000', '122.970000'),
(21, 'Anshun', 'China', '26.250000', '105.930000'),
(22, 'Anyang', 'China', '36.100000', '114.330000'),
(23, 'Baoding', 'China', '38.850000', '115.480000'),
(24, 'Baotou', 'China', '40.650000', '109.800000'),
(25, 'Beijing', 'China', '39.900000', '116.380000'),
(26, 'Bengbu', 'China', '32.930000', '117.350000'),
(27, 'Benxi', 'China', '41.300000', '123.770000'),
(28, 'Changchun', 'China', '43.880000', '125.310000'),
(29, 'Changde', 'China', '29.030000', '111.680000'),
(30, 'Changsha, Hunan', 'China', '28.090000', '113.000000'),
(31, 'Changzhou, Jiangsu', 'China', '31.780000', '119.970000'),
(32, 'Chengdu', 'China', '30.670000', '104.070000'),
(33, 'Chifeng', 'China', '42.270000', '118.950000'),
(34, 'Chongqing', 'China', '29.540000', '106.520000'),
(35, 'Dalian', 'China', '39.030000', '121.590000'),
(36, 'Dandong', 'China', '40.110000', '124.380000'),
(37, 'Daqing', 'China', '46.580000', '125.000000'),
(38, 'Datong, Shanxi', 'China', '40.060000', '113.280000'),
(39, 'Dongguan, Guangdong', 'China', '23.030000', '113.710000'),
(40, 'Foshan', 'China', '23.030000', '113.710000'),
(41, 'Fushun, Liaoning', 'China', '41.850000', '123.900000'),
(42, 'Fuxin', 'China', '42.010000', '121.650000'),
(43, 'Fuyang', 'China', '30.050000', '119.940000'),
(44, 'Fuzhou, Fujian', 'China', '26.070000', '119.300000'),
(45, 'Guangzhou, Guangdong', 'China', '23.090000', '113.290000'),
(46, 'Guilin', 'China', '25.270000', '110.290000'),
(47, 'Guiyang', 'China', '26.570000', '106.700000'),
(48, 'Haerbin', 'China', '45.750000', '126.620000'),
(49, 'Handan', 'China', '36.600000', '114.480000'),
(50, 'Hangzhou', 'China', '30.250000', '120.160000'),
(51, 'Hefei', 'China', '31.860000', '117.270000'),
(52, 'Hengyang', 'China', '26.900000', '112.600000'),
(53, 'Heze', 'China', '35.230000', '115.430000'),
(54, 'Hohhot', 'China', '40.810000', '111.640000'),
(55, 'Huai\'an', 'China', '33.500000', '119.130000'),
(56, 'Huaibei', 'China', '34.150000', '116.650000'),
(57, 'Huainan', 'China', '32.610000', '116.980000'),
(58, 'Huzhou', 'China', '30.860000', '120.100000'),
(59, 'Jiamusi', 'China', '46.830000', '130.350000'),
(60, 'Jiaozuo', 'China', '35.240000', '113.220000'),
(61, 'Jiaxing', 'China', '30.760000', '120.750000'),
(62, 'Jilin', 'China', '43.850000', '126.560000'),
(63, 'Jinan, Shandong', 'China', '36.650000', '116.960000'),
(64, 'Jining, Shandong', 'China', '35.400000', '116.560000'),
(65, 'Jinxi, Liaoning', 'China', '41.110000', '122.050000'),
(66, 'Jinzhou', 'China', '41.100000', '121.130000'),
(67, 'Jixi, Heilongjiang', 'China', '45.300000', '130.960000'),
(68, 'Kaifeng', 'China', '34.790000', '114.340000'),
(69, 'Kaohsiung', 'China', '22.600000', '120.280000'),
(70, 'Kunming', 'China', '25.050000', '102.700000'),
(71, 'Langfang', 'China', '39.510000', '116.700000'),
(72, 'Lanzhou', 'China', '36.110000', '103.590000'),
(73, 'Leshan', 'China', '29.580000', '103.750000'),
(74, 'Lianyungang', 'China', '41.260000', '119.160000'),
(75, 'Liaoyang', 'China', '41.260000', '123.170000'),
(76, 'Linfen', 'China', '36.080000', '111.510000'),
(77, 'Linyi, Shandong', 'China', '35.050000', '118.310000'),
(78, 'Liuan', 'China', '31.730000', '116.460000'),
(79, 'Liupanshui', 'China', '26.590000', '104.830000'),
(80, 'Liuzhou', 'China', '24.310000', '109.380000'),
(81, 'Luoyang', 'China', '34.670000', '112.360000'),
(82, 'Luzhou', 'China', '28.880000', '105.430000'),
(83, 'Mianyang, Sichuan', 'China', '31.460000', '104.750000'),
(84, 'Mudanjiang', 'China', '44.580000', '129.590000'),
(85, 'Nanchang', 'China', '28.670000', '115.880000'),
(86, 'Nanchong', 'China', '28.680000', '115.880000'),
(87, 'Nanjing, Jiangsu', 'China', '32.040000', '118.760000'),
(88, 'Nanning', 'China', '22.830000', '108.290000'),
(89, 'Nantong', 'China', '32.000000', '120.830000'),
(90, 'Nanyang, Henan', 'China', '33.000000', '112.530000'),
(91, 'Neijiang', 'China', '29.580000', '105.060000'),
(92, 'Ningbo', 'China', '29.860000', '121.550000'),
(93, 'Pingdingshan, Henan', 'China', '33.730000', '113.300000'),
(94, 'Pingxiang, Jiangxi', 'China', '27.630000', '113.850000'),
(95, 'Qingdao', 'China', '36.140000', '120.430000'),
(96, 'Qinhuangdao', 'China', '39.930000', '119.600000'),
(97, 'Qiqihaer', 'China', '47.340000', '123.960000'),
(98, 'Quanzhou', 'China', '24.910000', '118.580000'),
(99, 'Shanghai', 'China', '31.240000', '121.470000'),
(100, 'Shangqiu', 'China', '34.410000', '115.630000'),
(101, 'Shantou', 'China', '23.360000', '116.700000'),
(102, 'Shaoxing', 'China', '30.000000', '120.580000'),
(103, 'Shenyang', 'China', '41.800000', '123.380000'),
(104, 'Shenzhen', 'China', '22.550000', '114.100000'),
(105, 'Shijiazhuang', 'China', '38.070000', '114.550000'),
(106, 'Suining, Sichuan', 'China', '30.510000', '105.560000'),
(107, 'Suzhou, Anhui', 'China', '33.610000', '117.000000'),
(108, 'Suzhou, Jiangsu', 'China', '31.300000', '120.600000'),
(109, 'Taian, Shandong', 'China', '36.160000', '117.110000'),
(110, 'Taichung', 'China', '24.140000', '120.670000'),
(111, 'Tainan', 'China', '23.010000', '120.200000'),
(112, 'Taipei', 'China', '25.030000', '121.500000'),
(113, 'Taiyuan, Shanxi', 'China', '37.890000', '112.550000'),
(114, 'Tangshan, Hebei', 'China', '39.610000', '118.180000'),
(115, 'Tianjin', 'China', '39.120000', '117.180000'),
(116, 'Tianmen', 'China', '30.410000', '112.850000'),
(117, 'Tianshui', 'China', '34.580000', '105.730000'),
(118, 'Tongliao', 'China', '43.610000', '122.260000'),
(119, 'Ürümqi (Wulumqi)', 'China', '43.780000', '87.580000'),
(120, 'Weifang', 'China', '36.710000', '119.100000'),
(121, 'Wenzhou', 'China', '27.990000', '120.650000'),
(122, 'Wuhan', 'China', '30.570000', '114.270000'),
(123, 'Wuhu, Anhui', 'China', '31.330000', '118.350000'),
(124, 'Wuxi, Jiangsu', 'China', '33.000000', '120.000000'),
(125, 'Xiamen', 'China', '24.460000', '118.070000'),
(126, 'Xi\'an, Shaanxi', 'China', '34.260000', '108.900000'),
(127, 'Xiangfan, Hubei', 'China', '30.400000', '114.880000'),
(128, 'Xiantao', 'China', '30.380000', '113.400000'),
(129, 'Xianyang, Shaanxi', 'China', '34.350000', '108.710000'),
(130, 'Xingyi, Guizhou', 'China', '24.530000', '104.310000'),
(131, 'Xining', 'China', '36.640000', '101.760000'),
(132, 'Xinxiang', 'China', '35.300000', '113.860000'),
(133, 'Xinyang', 'China', '32.130000', '114.050000'),
(134, 'Xinyu', 'China', '27.790000', '114.920000'),
(135, 'Xuanzhou', 'China', '27.090000', '112.710000'),
(136, 'Xuzhou', 'China', '34.260000', '117.160000'),
(137, 'Yancheng, Jiangsu', 'China', '33.380000', '120.110000'),
(138, 'Yantai', 'China', '37.450000', '121.440000'),
(139, 'Yibin', 'China', '28.760000', '104.610000'),
(140, 'Yichang', 'China', '30.700000', '111.280000'),
(141, 'Yichun, Heilongjiang', 'China', '47.730000', '128.900000'),
(142, 'Yichun, Jiangxi', 'China', '27.800000', '114.380000'),
(143, 'Yinchuan', 'China', '38.460000', '106.260000'),
(144, 'Yingkou', 'China', '40.660000', '122.230000'),
(145, 'Yiyang, Hunan', 'China', '28.580000', '112.330000'),
(146, 'Yongzhou', 'China', '26.210000', '111.610000'),
(147, 'Yuci', 'China', '37.680000', '112.730000'),
(148, 'Yueyang', 'China', '29.360000', '113.100000'),
(149, 'Yulin, Guangxi', 'China', '22.630000', '110.150000'),
(150, 'Zaozhuang', 'China', '34.860000', '117.550000'),
(151, 'Zhangjiakou', 'China', '40.810000', '114.880000'),
(152, 'Zhanjiang', 'China', '21.200000', '110.400000'),
(153, 'Zhaotong', 'China', '27.310000', '103.710000'),
(154, 'Zhengzhou', 'China', '34.750000', '113.640000'),
(155, 'Zhenjiang, Jiangsu', 'China', '32.200000', '119.410000'),
(156, 'Zhuhai', 'China', '22.270000', '113.560000'),
(157, 'Zhuzhou', 'China', '27.850000', '113.130000'),
(158, 'Zibo', 'China', '36.780000', '118.050000'),
(159, 'Zigong', 'China', '29.400000', '104.780000'),
(160, 'Zunyi', 'China', '27.680000', '106.900000'),
(161, 'Barranquilla', 'Colombia', '10.980000', '-74.800000'),
(162, 'Bogotá', 'Colombia', '4.630000', '-74.080000'),
(163, 'Bucaramanga', 'Colombia', '7.110000', '-73.110000'),
(164, 'Cali', 'Colombia', '3.450000', '-76.520000'),
(165, 'Cartagena', 'Colombia', '10.410000', '-75.530000'),
(166, 'Medellín', 'Colombia', '6.240000', '-75.590000'),
(167, 'Brazzaville', 'Congo', '-4.280000', '15.280000'),
(168, 'Kananga', 'Democratic Republic of the Congo', '-5.890000', '22.400000'),
(169, 'Kinshasa', 'Democratic Republic of the Congo', '-4.320000', '15.290000'),
(170, 'Lubumbashi', 'Democratic Republic of the Congo', '-11.680000', '27.540000'),
(171, 'Mbuji-Mayi', 'Democratic Republic of the Congo', '-6.140000', '23.660000'),
(172, 'San José', 'Costa Rica', '9.930000', '-84.070000'),
(173, 'La Habana', 'Cuba', '23.040000', '-82.410000'),
(174, 'Praha', 'Czech Republic', '50.100000', '14.450000'),
(175, 'Cotonou', 'Benin', '6.350000', '2.430000'),
(176, 'København', 'Denmark', '55.710000', '12.540000'),
(177, 'Santo Domingo', 'Dominican Republic', '18.480000', '-69.890000'),
(178, 'Guayaquil', 'Ecuador', '-2.200000', '-79.900000'),
(179, 'Quito', 'Ecuador', '-0.220000', '-78.520000'),
(180, 'San Salvador', 'El Salvador', '13.700000', '-89.200000'),
(181, 'Addis Ababa', 'Ethiopia', '9.020000', '38.700000'),
(182, 'Huambo', 'Angola', '-12.760000', '15.730000'),
(183, 'Luanda', 'Angola', '-8.810000', '13.230000'),
(184, 'Helsinki', 'Finland', '60.190000', '24.970000'),
(185, 'Bordeaux', 'France', '44.840000', '-0.590000'),
(186, 'Lille', 'France', '50.630000', '3.060000'),
(187, 'Lyon', 'France', '45.740000', '4.850000'),
(188, 'Marseille-Aix-en-Provence', 'France', '43.280000', '5.380000'),
(189, 'Nice-Cannes', 'France', '43.550000', '7.010000'),
(190, 'Paris', 'France', '48.880000', '2.430000'),
(191, 'Toulouse', 'France', '43.590000', '1.430000'),
(192, 'Tbilisi', 'Georgia', '41.720000', '44.780000'),
(193, 'Berlin', 'Germany', '52.510000', '13.320000'),
(194, 'Hamburg', 'Germany', '53.570000', '10.020000'),
(195, 'Köln', 'Germany', '50.940000', '6.930000'),
(196, 'München', 'Germany', '48.140000', '11.540000'),
(197, 'Accra', 'Ghana', '5.550000', '-0.200000'),
(198, 'Kumasi', 'Ghana', '6.680000', '-1.620000'),
(199, 'Athínai', 'Greece', '37.940000', '23.650000'),
(200, 'Thessaloniki', 'Greece', '40.620000', '22.790000'),
(201, 'Baku', 'Azerbaijan', '40.320000', '49.810000'),
(202, 'Buenos Aires', 'Argentina', '-34.620000', '-58.440000'),
(203, 'Córdoba', 'Argentina', '-31.310000', '-64.170000'),
(204, 'Mendoza', 'Argentina', '-32.890000', '-68.830000'),
(205, 'Rosario', 'Argentina', '-32.930000', '-60.660000'),
(206, 'San Miguel de Tucumán', 'Argentina', '-26.820000', '-65.210000'),
(207, 'Ciudad de Guatemala (Guatemala City)', 'Guatemala', '14.610000', '-90.520000'),
(208, 'Conakry', 'Guinea', '9.540000', '-13.670000'),
(209, 'Port-au-Prince', 'Haiti', '18.520000', '-72.340000'),
(210, 'Tegucigalpa', 'Honduras', '14.090000', '-87.200000'),
(211, 'Hong Kong', 'China, Hong Kong Special Administrative Region', '22.270000', '114.170000'),
(212, 'Budapest', 'Hungary', '47.510000', '19.090000'),
(213, 'Agra', 'India', '27.180000', '78.020000'),
(214, 'Ahmadabad', 'India', '23.030000', '72.560000'),
(215, 'Aligarh', 'India', '27.880000', '78.080000'),
(216, 'Allahabad', 'India', '25.450000', '81.850000'),
(217, 'Amritsar', 'India', '31.630000', '74.870000'),
(218, 'Asansol', 'India', '23.680000', '86.980000'),
(219, 'Aurangabad', 'India', '19.780000', '75.290000'),
(220, 'Bangalore', 'India', '12.970000', '77.580000'),
(221, 'Bareilly', 'India', '28.550000', '80.120000'),
(222, 'Bhiwandi', 'India', '19.290000', '73.060000'),
(223, 'Bhopal', 'India', '23.220000', '77.410000'),
(224, 'Bhubaneswar', 'India', '20.260000', '85.830000'),
(225, 'Chandigarh', 'India', '30.730000', '76.780000'),
(226, 'Chennai', 'India', '13.060000', '80.240000'),
(227, 'Coimbatore', 'India', '11.010000', '76.970000'),
(228, 'Delhi', 'India', '28.660000', '77.210000'),
(229, 'Dhanbad', 'India', '23.800000', '86.450000'),
(230, 'Durg-Bhilainagar', 'India', '21.220000', '81.430000'),
(231, 'Faridabad', 'India', '28.420000', '77.300000'),
(232, 'Ghaziabad', 'India', '28.670000', '77.420000'),
(233, 'Guwahati', 'India', '26.170000', '91.770000'),
(234, 'Gwalior', 'India', '26.140000', '78.100000'),
(235, 'Hubli-Dharwad', 'India', '15.360000', '75.080000'),
(236, 'Hyderabad', 'India', '17.390000', '78.480000'),
(237, 'Indore', 'India', '22.420000', '75.540000'),
(238, 'Jabalpur', 'India', '23.150000', '79.970000'),
(239, 'Jaipur', 'India', '26.900000', '75.800000'),
(240, 'Jalandhar', 'India', '31.320000', '75.570000'),
(241, 'Jammu', 'India', '33.450000', '76.240000'),
(242, 'Jamshedpur', 'India', '22.800000', '86.180000'),
(243, 'Jodhpur', 'India', '26.280000', '73.020000'),
(244, 'Kanpur', 'India', '26.450000', '80.310000'),
(245, 'Kochi', 'India', '9.970000', '76.270000'),
(246, 'Kolkata', 'India', '22.540000', '88.330000'),
(247, 'Kota', 'India', '25.180000', '75.830000'),
(248, 'Kozhikode', 'India', '26.280000', '75.770000'),
(249, 'Lucknow', 'India', '26.840000', '80.910000'),
(250, 'Ludhiana', 'India', '30.910000', '75.850000'),
(251, 'Madurai', 'India', '9.910000', '78.120000'),
(252, 'Meerut', 'India', '28.990000', '77.700000'),
(253, 'Moradabad', 'India', '28.830000', '78.780000'),
(254, 'Mumbai', 'India', '19.070000', '72.820000'),
(255, 'Mysore', 'India', '12.300000', '76.650000'),
(256, 'Nagpur', 'India', '21.150000', '79.080000'),
(257, 'Nashik', 'India', '20.020000', '73.500000'),
(258, 'Patna', 'India', '25.610000', '85.130000'),
(259, 'Pune', 'India', '18.530000', '73.850000'),
(260, 'Raipur', 'India', '21.230000', '81.630000'),
(261, 'Rajkot', 'India', '22.300000', '70.780000'),
(262, 'Ranchi', 'India', '23.350000', '85.330000'),
(263, 'Salem', 'India', '11.650000', '78.160000'),
(264, 'Solapur', 'India', '17.680000', '75.920000'),
(265, 'Srinagar', 'India', '34.080000', '74.800000'),
(266, 'Surat', 'India', '21.160000', '72.830000'),
(267, 'Thiruvananthapuram', 'India', '8.480000', '76.950000'),
(268, 'Tiruchirappalli', 'India', '10.810000', '78.690000'),
(269, 'Vadodara', 'India', '22.300000', '73.200000'),
(270, 'Varanasi', 'India', '25.280000', '82.950000'),
(271, 'Vijayawada', 'India', '16.510000', '80.610000'),
(272, 'Visakhapatnam', 'India', '17.740000', '83.330000'),
(273, 'Adelaide', 'Australia', '-34.810000', '138.520000'),
(274, 'Brisbane', 'Australia', '-27.450000', '153.020000'),
(275, 'Melbourne', 'Australia', '-37.850000', '145.070000'),
(276, 'Perth', 'Australia', '-31.950000', '115.850000'),
(277, 'Sydney', 'Australia', '-33.880000', '151.020000'),
(278, 'Bandar Lampung', 'Indonesia', '-5.450000', '105.260000'),
(279, 'Bandung', 'Indonesia', '-6.910000', '107.600000'),
(280, 'Bogor', 'Indonesia', '-6.600000', '106.800000'),
(281, 'Jakarta', 'Indonesia', '-6.160000', '106.800000'),
(282, 'Malang', 'Indonesia', '-7.980000', '112.620000'),
(283, 'Medan', 'Indonesia', '3.580000', '98.670000'),
(284, 'Padang', 'Indonesia', '-0.950000', '100.350000'),
(285, 'Palembang', 'Indonesia', '-2.990000', '104.750000'),
(286, 'Pekan Baru', 'Indonesia', '0.530000', '101.450000'),
(287, 'Semarang', 'Indonesia', '-6.970000', '110.420000'),
(288, 'Surabaya', 'Indonesia', '-7.390000', '112.680000'),
(289, 'Ujung Pandang', 'Indonesia', '-5.130000', '119.410000'),
(290, 'Ahvaz', 'Iran (Islamic Republic of)', '31.310000', '48.680000'),
(291, 'Esfahan', 'Iran (Islamic Republic of)', '32.650000', '51.670000'),
(292, 'Karaj', 'Iran (Islamic Republic of)', '35.810000', '50.960000'),
(293, 'Kermanshah', 'Iran (Islamic Republic of)', '34.300000', '47.050000'),
(294, 'Mashhad', 'Iran (Islamic Republic of)', '36.280000', '59.590000'),
(295, 'Qom', 'Iran (Islamic Republic of)', '34.650000', '50.880000'),
(296, 'Shiraz', 'Iran (Islamic Republic of)', '29.600000', '52.530000'),
(297, 'Tabriz', 'Iran (Islamic Republic of)', '38.080000', '46.280000'),
(298, 'Tehran', 'Iran (Islamic Republic of)', '35.770000', '51.440000'),
(299, 'Al-Basrah', 'Iraq', '30.500000', '47.760000'),
(300, 'Al-Mawsil', 'Iraq', '36.330000', '43.130000'),
(301, 'Baghdad', 'Iraq', '33.330000', '44.390000'),
(302, 'Irbil', 'Iraq', '36.160000', '44.010000'),
(303, 'Dublin', 'Ireland', '53.340000', '-6.250000'),
(304, 'Hefa', 'Israel', '32.760000', '35.000000'),
(305, 'Tel Aviv-Yafo', 'Israel', '32.040000', '34.760000'),
(306, 'Milano', 'Italy', '45.470000', '9.180000'),
(307, 'Napoli', 'Italy', '40.830000', '14.250000'),
(308, 'Palermo', 'Italy', '38.120000', '13.350000'),
(309, 'Rome', 'Italy', '41.870000', '12.510000'),
(310, 'Torino', 'Italy', '45.070000', '7.660000'),
(311, 'Abidjan', 'Côte d\'Ivoire', '5.320000', '-4.020000'),
(312, 'Fukuoka-Kitakyushu', 'Japan', '33.570000', '130.400000'),
(313, 'Hiroshima', 'Japan', '34.370000', '132.440000'),
(314, 'Kyoto', 'Japan', '35.000000', '135.750000'),
(315, 'Nagoya', 'Japan', '35.150000', '136.920000'),
(316, 'Osaka-Kobe', 'Japan', '34.630000', '135.510000'),
(317, 'Sapporo', 'Japan', '43.050000', '141.340000'),
(318, 'Sendai', 'Japan', '38.250000', '140.890000'),
(319, 'Tokyo', 'Japan', '35.680000', '139.800000'),
(320, 'Almaty', 'Kazakhstan', '43.250000', '76.910000'),
(321, 'Kabul', 'Afghanistan', '34.530000', '69.130000'),
(322, 'Wien', 'Austria', '48.200000', '16.320000'),
(323, 'Amman', 'Jordan', '31.940000', '35.930000'),
(324, 'Mombasa', 'Kenya', '-4.050000', '39.650000'),
(325, 'Nairobi', 'Kenya', '-1.260000', '36.800000'),
(326, 'Hamhung', 'Democratic People\'s Republic of Korea', '39.910000', '127.550000'),
(327, 'N\'ampo', 'Democratic People\'s Republic of Korea', '38.730000', '125.400000'),
(328, 'P\'yongyang', 'Democratic People\'s Republic of Korea', '39.020000', '125.750000'),
(329, 'Bucheon', 'Republic of Korea', '37.500000', '126.780000'),
(330, 'Busan', 'Republic of Korea', '35.100000', '129.030000'),
(331, 'Daegu', 'Republic of Korea', '35.860000', '128.600000'),
(332, 'Daejon', 'Republic of Korea', '36.350000', '127.380000'),
(333, 'Goyang', 'Republic of Korea', '37.650000', '126.800000'),
(334, 'Gwangju', 'Republic of Korea', '35.160000', '126.910000'),
(335, 'Incheon', 'Republic of Korea', '37.480000', '126.630000'),
(336, 'Seongnam', 'Republic of Korea', '37.430000', '127.150000'),
(337, 'Seoul', 'Republic of Korea', '37.540000', '126.930000'),
(338, 'Suweon', 'Republic of Korea', '37.260000', '127.010000'),
(339, 'Ulsan', 'Republic of Korea', '35.550000', '129.310000'),
(340, 'Al Kuwayt (Kuwait City)', 'Kuwait', '29.380000', '47.970000'),
(341, 'Bishkek', 'Kyrgyzstan', '42.870000', '74.770000'),
(342, 'Bayrut', 'Lebanon', '33.880000', '35.490000'),
(343, 'Monrovia', 'Liberia', '6.300000', '-10.790000'),
(344, 'Banghazi', 'Libyan Arab Jamahiriya', '32.120000', '20.060000'),
(345, 'Tarabulus', 'Libyan Arab Jamahiriya', '32.900000', '13.180000'),
(346, 'Antananarivo', 'Madagascar', '-18.900000', '47.520000'),
(347, 'Johore Bharu', 'Malaysia', '1.500000', '103.760000'),
(348, 'Klang', 'Malaysia', '3.030000', '101.450000'),
(349, 'Kuala Lumpur', 'Malaysia', '3.140000', '101.700000'),
(350, 'Bamako', 'Mali', '12.650000', '-7.980000'),
(351, 'Aguascalientes', 'Mexico', '21.880000', '-102.290000'),
(352, 'Chihuahua', 'Mexico', '28.630000', '-106.070000'),
(353, 'Ciudad de México', 'Mexico', '19.420000', '-99.120000'),
(354, 'Ciudad Juárez', 'Mexico', '31.730000', '-106.480000'),
(355, 'Culiacán', 'Mexico', '24.800000', '-107.380000'),
(356, 'Guadalajara', 'Mexico', '20.670000', '-103.340000'),
(357, 'León de los Aldamas', 'Mexico', '21.110000', '-101.680000'),
(358, 'Mérida', 'Mexico', '20.970000', '-89.620000'),
(359, 'Mexicali', 'Mexico', '32.650000', '-115.460000'),
(360, 'Monterrey', 'Mexico', '25.670000', '-100.310000'),
(361, 'Puebla', 'Mexico', '19.040000', '-98.190000'),
(362, 'Querétaro', 'Mexico', '20.580000', '-100.380000'),
(363, 'Saltillo', 'Mexico', '25.410000', '-100.990000'),
(364, 'San Luis Potosí', 'Mexico', '22.150000', '-100.970000'),
(365, 'Tijuana', 'Mexico', '32.520000', '-117.030000'),
(366, 'Toluca de Lerdo', 'Mexico', '19.280000', '-99.660000'),
(367, 'Torreón', 'Mexico', '25.550000', '-103.760000'),
(368, 'Ulaanbaatar', 'Mongolia', '47.920000', '106.910000'),
(369, 'Chittagong', 'Bangladesh', '22.320000', '91.820000'),
(370, 'Dhaka', 'Bangladesh', '23.700000', '90.400000'),
(371, 'Khulna', 'Bangladesh', '22.840000', '89.550000'),
(372, 'Rajshahi', 'Bangladesh', '24.350000', '88.630000'),
(373, 'Dar-el-Beida', 'Morocco', '33.600000', '-7.630000'),
(374, 'Fès', 'Morocco', '34.040000', '-4.990000'),
(375, 'Marrakech', 'Morocco', '31.630000', '-8.010000'),
(376, 'Rabat', 'Morocco', '34.010000', '-6.830000'),
(377, 'Maputo', 'Mozambique', '-25.960000', '32.570000'),
(378, 'Yerevan', 'Armenia', '40.200000', '44.530000'),
(379, 'Kathmandu', 'Nepal', '27.710000', '85.310000'),
(380, 'Amsterdam', 'Netherlands', '52.370000', '4.890000'),
(381, 'Rotterdam', 'Netherlands', '51.920000', '4.480000'),
(382, 'Auckland', 'New Zealand', '-36.900000', '174.760000'),
(383, 'Managua', 'Nicaragua', '12.150000', '-86.270000'),
(384, 'Antwerpen', 'Belgium', '51.200000', '4.420000'),
(385, 'Bruxelles-Brussel', 'Belgium', '50.830000', '4.360000'),
(386, 'Niamey', 'Niger', '13.510000', '2.120000'),
(387, 'Abuja', 'Nigeria', '9.050000', '7.250000'),
(388, 'Benin City', 'Nigeria', '6.330000', '5.620000'),
(389, 'Ibadan', 'Nigeria', '7.370000', '3.890000'),
(390, 'Ilorin', 'Nigeria', '8.490000', '4.540000'),
(391, 'Kaduna', 'Nigeria', '10.510000', '7.440000'),
(392, 'Kano', 'Nigeria', '11.990000', '8.490000'),
(393, 'Lagos', 'Nigeria', '6.450000', '3.300000'),
(394, 'Maiduguri', 'Nigeria', '11.850000', '13.160000'),
(395, 'Ogbomosho', 'Nigeria', '8.130000', '4.250000'),
(396, 'Port Harcourt', 'Nigeria', '4.780000', '7.000000'),
(397, 'Zaria', 'Nigeria', '11.060000', '7.700000'),
(398, 'Oslo', 'Norway', '59.930000', '10.710000'),
(399, 'Faisalabad', 'Pakistan', '31.400000', '73.080000'),
(400, 'Gujranwala', 'Pakistan', '32.150000', '74.180000'),
(401, 'Hyderabad', 'Pakistan', '25.380000', '68.360000'),
(402, 'Islamabad', 'Pakistan', '33.710000', '73.060000'),
(403, 'Karachi', 'Pakistan', '24.890000', '67.020000'),
(404, 'Lahore', 'Pakistan', '31.540000', '74.340000'),
(405, 'Multan', 'Pakistan', '30.200000', '71.410000'),
(406, 'Peshawar', 'Pakistan', '34.000000', '71.540000'),
(407, 'Quetta', 'Pakistan', '30.200000', '67.010000'),
(408, 'Rawalpindi', 'Pakistan', '33.600000', '73.040000'),
(409, 'Ciudad de Panamá (Panama City)', 'Panama', '9.000000', '-79.510000'),
(410, 'Asunción', 'Paraguay', '-25.300000', '-57.620000'),
(411, 'Arequipa', 'Peru', '-16.390000', '-71.520000'),
(412, 'Lima', 'Peru', '-12.080000', '-77.040000'),
(413, 'Cebu', 'Philippines', '10.420000', '123.790000'),
(414, 'Davao', 'Philippines', '7.080000', '125.610000'),
(415, 'Manila', 'Philippines', '14.610000', '120.960000'),
(416, 'Zamboanga', 'Philippines', '6.900000', '122.060000'),
(417, 'Kraków', 'Poland', '50.060000', '19.940000'),
(418, 'Lódz', 'Poland', '51.770000', '19.470000'),
(419, 'Warszawa', 'Poland', '52.240000', '21.010000'),
(420, 'Lisboa', 'Portugal', '38.720000', '-9.120000'),
(421, 'Porto', 'Portugal', '41.160000', '-8.580000'),
(422, 'San Juan', 'Puerto Rico', '18.800000', '-71.220000'),
(423, 'Bucuresti', 'Romania', '44.430000', '26.120000'),
(424, 'Chelyabinsk', 'Russian Federation', '55.140000', '61.390000'),
(425, 'Kazan', 'Russian Federation', '55.730000', '49.140000'),
(426, 'Krasnoyarsk', 'Russian Federation', '56.010000', '92.830000'),
(427, 'Moskva', 'Russian Federation', '55.740000', '37.700000'),
(428, 'Nizhniy Novgorod', 'Russian Federation', '58.540000', '31.270000'),
(429, 'Novosibirsk', 'Russian Federation', '55.030000', '82.940000'),
(430, 'Omsk', 'Russian Federation', '55.060000', '73.250000'),
(431, 'Perm', 'Russian Federation', '58.000000', '56.230000'),
(432, 'Rostov-na-Donu', 'Russian Federation', '47.230000', '39.680000'),
(433, 'Samara', 'Russian Federation', '53.230000', '50.160000'),
(434, 'Sankt Peterburg', 'Russian Federation', '59.910000', '30.240000'),
(435, 'Saratov', 'Russian Federation', '51.490000', '45.950000'),
(436, 'Ufa', 'Russian Federation', '54.820000', '56.090000'),
(437, 'Volgograd', 'Russian Federation', '48.700000', '44.480000'),
(438, 'Voronezh', 'Russian Federation', '51.710000', '39.260000'),
(439, 'Yekaterinburg', 'Russian Federation', '56.830000', '60.580000'),
(440, 'Kigali', 'Rwanda', '-1.950000', '30.050000'),
(441, 'La Paz', 'Bolivia', '-16.500000', '-68.150000'),
(442, 'Santa Cruz', 'Bolivia', '-17.780000', '-63.190000'),
(443, 'Ad-Dammam', 'Saudi Arabia', '26.330000', '50.080000'),
(444, 'Al-Madinah', 'Saudi Arabia', '24.420000', '39.690000'),
(445, 'Ar-Riyadh', 'Saudi Arabia', '24.650000', '46.770000'),
(446, 'Jiddah', 'Saudi Arabia', '21.540000', '39.170000'),
(447, 'Makkah', 'Saudi Arabia', '21.420000', '39.810000'),
(448, 'Dakar', 'Senegal', '14.680000', '-17.450000'),
(449, 'Beograd', 'Serbia', '44.790000', '20.410000'),
(450, 'Freetown', 'Sierra Leone', '8.480000', '-13.230000'),
(451, 'Singapore', 'Singapore', '1.260000', '103.830000'),
(452, 'Hà Noi', 'Viet Nam', '21.030000', '105.820000'),
(453, 'Hai Phòng', 'Viet Nam', '20.860000', '106.670000'),
(454, 'Thành Pho Ho Chí Minh', 'Viet Nam', '10.750000', '106.660000'),
(455, 'Muqdisho', 'Somalia', '2.040000', '45.340000'),
(456, 'Cape Town', 'South Africa', '-33.970000', '18.480000'),
(457, 'Durban', 'South Africa', '-29.830000', '30.940000'),
(458, 'Ekurhuleni', 'South Africa', '-26.170000', '28.220000'),
(459, 'Johannesburg', 'South Africa', '-26.170000', '28.000000'),
(460, 'Port Elizabeth', 'South Africa', '-33.880000', '25.480000'),
(461, 'Pretoria', 'South Africa', '-25.730000', '28.210000'),
(462, 'Vereeniging', 'South Africa', '-26.670000', '27.930000'),
(463, 'Harare', 'Zimbabwe', '-17.820000', '31.020000'),
(464, 'Barcelona', 'Spain', '41.380000', '2.180000'),
(465, 'Madrid', 'Spain', '40.440000', '-3.690000'),
(466, 'Valencia', 'Spain', '39.470000', '-0.360000'),
(467, 'Al-Khartum', 'Sudan', '15.550000', '32.520000'),
(468, 'Stockholm', 'Sweden', '59.330000', '17.990000'),
(469, 'Zürich', 'Switzerland', '47.400000', '8.530000'),
(470, 'Baixada Santista', 'Brazil', '-23.950000', '-46.360000'),
(471, 'Belém', 'Brazil', '-1.430000', '-48.490000'),
(472, 'Belo Horizonte', 'Brazil', '-19.850000', '-43.900000'),
(473, 'Brasília', 'Brazil', '-15.790000', '-47.890000'),
(474, 'Campinas', 'Brazil', '-22.900000', '-47.050000'),
(475, 'Campo Grande', 'Brazil', '-20.450000', '-54.610000'),
(476, 'Cuiabá', 'Brazil', '-15.610000', '-56.090000'),
(477, 'Curitiba', 'Brazil', '-25.430000', '-49.280000'),
(478, 'Florianópolis', 'Brazil', '-27.570000', '-48.610000'),
(479, 'Fortaleza', 'Brazil', '-3.780000', '-38.580000'),
(480, 'Goiânia', 'Brazil', '-16.720000', '-49.250000'),
(481, 'Grande São Luís', 'Brazil', '-2.510000', '-44.300000'),
(482, 'Grande Vitória', 'Brazil', '-20.300000', '-40.350000'),
(483, 'João Pessoa', 'Brazil', '-7.120000', '-34.860000'),
(484, 'Maceió', 'Brazil', '-9.670000', '-35.740000'),
(485, 'Manaus', 'Brazil', '-3.120000', '-60.010000'),
(486, 'Natal', 'Brazil', '-5.800000', '-35.210000'),
(487, 'Norte/Nordeste Catarinense', 'Brazil', '-26.320000', '-48.840000'),
(488, 'Pôrto Alegre', 'Brazil', '-30.040000', '-51.200000'),
(489, 'Recife', 'Brazil', '-8.080000', '-34.910000'),
(490, 'Rio de Janeiro', 'Brazil', '-22.720000', '-43.450000'),
(491, 'Salvador', 'Brazil', '-12.990000', '-38.480000'),
(492, 'São Paulo', 'Brazil', '-23.580000', '-46.620000'),
(493, 'Teresina', 'Brazil', '-5.100000', '-42.800000'),
(494, 'Dimashq', 'Syrian Arab Republic', '33.490000', '36.290000'),
(495, 'Halab', 'Syrian Arab Republic', '36.210000', '37.150000'),
(496, 'Hims', 'Syrian Arab Republic', '34.730000', '36.710000'),
(497, 'Krung Thep', 'Thailand', '13.750000', '100.510000'),
(498, 'Lomé', 'Togo', '6.100000', '1.200000'),
(499, 'Dubayy', 'United Arab Emirates', '25.270000', '55.320000'),
(500, 'Adana', 'Turkey', '37.000000', '35.320000'),
(501, 'Ankara', 'Turkey', '39.920000', '32.850000'),
(502, 'Antalya', 'Turkey', '36.890000', '30.700000'),
(503, 'Bursa', 'Turkey', '40.190000', '29.070000'),
(504, 'Gaziantep', 'Turkey', '37.040000', '37.300000'),
(505, 'Istanbul', 'Turkey', '41.060000', '29.000000'),
(506, 'Izmir', 'Turkey', '38.430000', '27.140000'),
(507, 'Konya', 'Turkey', '37.870000', '32.480000'),
(508, 'Kampala', 'Uganda', '0.320000', '32.570000'),
(509, 'Dnipropetrovs\'k', 'Ukraine', '48.420000', '35.130000'),
(510, 'Donets\'k', 'Ukraine', '48.040000', '37.730000'),
(511, 'Kharkiv', 'Ukraine', '49.980000', '36.200000'),
(512, 'Kyiv', 'Ukraine', '50.440000', '30.500000'),
(513, 'Odesa', 'Ukraine', '46.460000', '30.730000'),
(514, 'Zaporizhzhya', 'Ukraine', '47.850000', '35.150000'),
(515, 'Al-Iskandariyah', 'Egypt', '31.200000', '29.900000'),
(516, 'Al-Qahirah', 'Egypt', '30.070000', '31.250000'),
(517, 'Birmingham', 'United Kingdom', '52.490000', '-1.860000'),
(518, 'Glasgow', 'United Kingdom', '55.860000', '-4.260000'),
(519, 'Liverpool', 'United Kingdom', '53.420000', '-2.970000'),
(520, 'London', 'United Kingdom', '51.480000', '-0.170000'),
(521, 'Manchester', 'United Kingdom', '53.470000', '-2.260000'),
(522, 'Newcastle upon Tyne', 'United Kingdom', '54.960000', '-1.600000'),
(523, 'West Yorkshire', 'United Kingdom', '53.790000', '-1.540000'),
(524, 'Dar es Salaam', 'United Republic of Tanzania', '-6.810000', '39.250000'),
(525, 'Atlanta', 'United States of America', '33.790000', '-84.340000'),
(526, 'Austin', 'United States of America', '30.270000', '-97.730000'),
(527, 'Baltimore', 'United States of America', '39.320000', '-76.610000'),
(528, 'Boston', 'United States of America', '42.370000', '-71.100000'),
(529, 'Bridgeport-Stamford', 'United States of America', '41.180000', '-73.190000'),
(530, 'Buffalo', 'United States of America', '42.890000', '-78.840000'),
(531, 'Charlotte', 'United States of America', '35.200000', '-80.830000'),
(532, 'Chicago', 'United States of America', '41.820000', '-87.640000'),
(533, 'Cincinnati', 'United States of America', '39.140000', '-84.470000'),
(534, 'Cleveland', 'United States of America', '41.390000', '-81.720000'),
(535, 'Columbus, Ohio', 'United States of America', '40.040000', '-82.990000'),
(536, 'Dallas-Fort Worth', 'United States of America', '32.760000', '-96.660000'),
(537, 'Dayton', 'United States of America', '39.750000', '-84.190000'),
(538, 'Denver-Aurora', 'United States of America', '39.570000', '-105.070000'),
(539, 'Detroit', 'United States of America', '42.390000', '-83.070000'),
(540, 'El Paso', 'United States of America', '31.770000', '-106.450000'),
(541, 'Hartford', 'United States of America', '41.760000', '-72.700000'),
(542, 'Honolulu', 'United States of America', '21.320000', '-157.860000'),
(543, 'Houston', 'United States of America', '29.770000', '-95.400000'),
(544, 'Indianapolis', 'United States of America', '39.810000', '-86.130000'),
(545, 'Jacksonville, Florida', 'United States of America', '30.330000', '-81.650000'),
(546, 'Kansas City', 'United States of America', '38.990000', '-94.620000'),
(547, 'Las Vegas', 'United States of America', '36.170000', '-115.130000'),
(548, 'Los Angeles-Long Beach-Santa Ana', 'United States of America', '34.000000', '-118.250000'),
(549, 'Louisville', 'United States of America', '38.250000', '-85.760000'),
(550, 'Memphis', 'United States of America', '35.110000', '-90.000000'),
(551, 'Miami', 'United States of America', '25.830000', '-80.270000'),
(552, 'Milwaukee', 'United States of America', '43.060000', '-87.990000'),
(553, 'Minneapolis-St. Paul', 'United States of America', '44.920000', '-93.300000'),
(554, 'Nashville-Davidson', 'United States of America', '36.140000', '-86.810000'),
(555, 'New Orleans', 'United States of America', '29.950000', '-90.090000'),
(556, 'New York-Newark', 'United States of America', '40.700000', '-73.900000'),
(557, 'Oklahoma City', 'United States of America', '35.480000', '-97.530000'),
(558, 'Orlando', 'United States of America', '28.540000', '-81.370000'),
(559, 'Philadelphia', 'United States of America', '39.920000', '-75.210000'),
(560, 'Phoenix-Mesa', 'United States of America', '33.500000', '-112.110000'),
(561, 'Pittsburgh', 'United States of America', '40.490000', '-79.990000'),
(562, 'Portland', 'United States of America', '45.440000', '-122.640000'),
(563, 'Providence', 'United States of America', '41.810000', '-71.420000'),
(564, 'Richmond', 'United States of America', '37.560000', '-77.470000'),
(565, 'Riverside-San Bernardino', 'United States of America', '34.120000', '-117.290000'),
(566, 'Rochester', 'United States of America', '43.210000', '-77.630000'),
(567, 'Sacramento', 'United States of America', '38.560000', '-121.420000'),
(568, 'Salt Lake City', 'United States of America', '40.690000', '-111.890000'),
(569, 'San Antonio', 'United States of America', '29.420000', '-98.520000'),
(570, 'San Diego', 'United States of America', '32.760000', '-117.120000'),
(571, 'San Francisco-Oakland', 'United States of America', '37.790000', '-122.380000'),
(572, 'San Jose', 'United States of America', '37.300000', '-121.840000'),
(573, 'Seattle', 'United States of America', '47.580000', '-122.310000'),
(574, 'St. Louis', 'United States of America', '38.630000', '-90.340000'),
(575, 'Tampa-St. Petersburg', 'United States of America', '27.990000', '-82.590000'),
(576, 'Tucson', 'United States of America', '32.220000', '-110.920000'),
(577, 'Virginia Beach', 'United States of America', '36.830000', '-76.080000'),
(578, 'Washington, D.C.', 'United States of America', '38.890000', '-76.950000'),
(579, 'Ouagadougou', 'Burkina Faso', '12.480000', '-1.670000'),
(580, 'Montevideo', 'Uruguay', '-34.920000', '-56.160000'),
(581, 'Tashkent', 'Uzbekistan', '41.240000', '69.340000'),
(582, 'Barquisimeto', 'Venezuela (Bolivarian Republic of)', '10.060000', '-69.330000'),
(583, 'Caracas', 'Venezuela (Bolivarian Republic of)', '10.490000', '-66.890000'),
(584, 'Maracaibo', 'Venezuela (Bolivarian Republic of)', '10.640000', '-71.630000'),
(585, 'Maracay', 'Venezuela (Bolivarian Republic of)', '10.240000', '-67.590000'),
(586, 'Valencia', 'Venezuela (Bolivarian Republic of)', '10.170000', '-68.000000'),
(587, 'Al-Hudaydah', 'Yemen', '14.790000', '42.940000'),
(588, 'Sana\'a\'', 'Yemen', '15.360000', '44.200000'),
(589, 'Ta\'izz', 'Yemen', '13.570000', '44.010000'),
(590, 'Lusaka', 'Zambia', '-15.420000', '28.170000');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `spdo_customer`
--
ALTER TABLE `spdo_customer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `spdo_licences`
--
ALTER TABLE `spdo_licences`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `cutomerId` (`customerID`),
  ADD KEY `licenseId` (`licenseID`);

--
-- Indexen voor tabel `spdo_urbanareas`
--
ALTER TABLE `spdo_urbanareas`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `spdo_customer`
--
ALTER TABLE `spdo_customer`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT voor een tabel `spdo_licences`
--
ALTER TABLE `spdo_licences`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `spdo_urbanareas`
--
ALTER TABLE `spdo_urbanareas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=591;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
