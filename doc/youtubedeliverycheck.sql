-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2018 at 02:50 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `youtube`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin-rule', 1, 'can all', NULL, NULL, NULL, NULL),
('create-customers-profile', 1, 'create-customers-profile', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin-rule', 'create-customers-profile');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_management`
--

CREATE TABLE `category_management` (
  `auto_id` int(11) NOT NULL,
  `category_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `category_desc` text CHARACTER SET utf8 NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `active_status` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_management`
--

INSERT INTO `category_management` (`auto_id`, `category_name`, `category_desc`, `slug`, `category_image`, `active_status`) VALUES
(1, 'Home', 'Home Category', 'home', 'images/youtube/960199_566587433410405_886778407_n71227 (1)85742.jpg', '1'),
(2, 'Cooking', 'Cookings Category', 'cookings', 'images/youtube/a-267852.jpg', '1'),
(3, 'Devotional ', 'Devotional Category', 'devotional ', 'images/youtube/download43978.jpg', '1'),
(4, 'Songs', 'Songs Category', 'songs', 'images/youtube/0616e88e69809c5d8e6d0293fdfc90c347076.jpg', '1'),
(5, 'Health', 'health', 'Health', 'images/youtube/b2433c9362c267536fffe2ccdea9286235220.jpg', '1'),
(6, 'Beauty Tips', 'Beauty Tips', 'Beauty Tips', '', '1'),
(7, 'House Keeping', 'House KeepinG', 'HOUSE KEEPING', '', '1'),
(8, 'Motivational ', 'MOTIVATIONAL ', 'MOTIVATIONAL ', '', '1'),
(9, 'Social Activities/AWARENESS', 'SOCIAL ACTIVITIES/AWARENESS', 'SOCIAL ACTIVITIES/AWARENESS', '', '1'),
(10, 'Family Celebration', 'CELEBRATION', 'CELEBRATION', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `home_management`
--

CREATE TABLE `home_management` (
  `home_id` int(11) NOT NULL,
  `youtubelink` varchar(250) DEFAULT NULL,
  `youtube_id` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home_management`
--

INSERT INTO `home_management` (`home_id`, `youtubelink`, `youtube_id`) VALUES
(1, 'test', 'dreupGtSrzA');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1459344856),
('m130524_201442_init', 1459344861),
('m140506_102106_rbac_init', 1462199506);

-- --------------------------------------------------------

--
-- Table structure for table `swim_servicecenterlogin`
--

CREATE TABLE `swim_servicecenterlogin` (
  `id` int(11) NOT NULL,
  `servicecenter_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `user_type` enum('A','U','P') COLLATE utf8_unicode_ci NOT NULL COMMENT 'A=Admin, U=User, P=Player',
  `city` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `rights` text COLLATE utf8_unicode_ci NOT NULL,
  `status_flag` enum('A','I') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'A' COMMENT 'A=Active, I=Inactive',
  `user_level` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `swim_servicecenterlogin`
--

INSERT INTO `swim_servicecenterlogin` (`id`, `servicecenter_id`, `username`, `first_name`, `last_name`, `dob`, `user_type`, `city`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`, `rights`, `status_flag`, `user_level`, `mobile_number`, `designation`) VALUES
(1, '1', 'tansi', '', '', '0000-00-00', 'A', '', '', '$2y$13$zh6.wnuZ3kTN3V75sPz5yOlxF9iMpIt/SMs0ozeUM1cV3ytKhPBZO', NULL, 10, 0, 0, '', 'A', '', '', ''),
(2, '1', 'tansi2', '', '', '0000-00-00', 'A', '', '', '$2y$13$bLG255BEBvMOXzYJmVEGJuIYj2mlLPb2F6HUblBId0hQF2QuFsJvu', NULL, 10, 0, 0, '', 'A', '', '', ''),
(3, '1', 'admin', '', '', '0000-00-00', 'A', '', '', '$2y$13$04h5Rr1SHyTvNkgGM0ot6OMWvkv9eHRZjVO..ZYRfZvQM3wQHa6tS', NULL, 10, 0, 0, '', 'A', '', '', ''),
(4, '1', 'administrator', '', '', '0000-00-00', 'A', '', '', '$2y$13$NrgRaNE0zmwE9ifNGw3UFe1x24AdMznxM2WjQjK6QXC3Kd2JI225K', NULL, 10, 0, 0, '', 'A', '', '', ''),
(5, '1', 'fdgfdsgdsg', '', '', '0000-00-00', 'A', '', '', '$2y$13$OMav8zrREU1PbWWX9F.lbedRYgvBGpgRxItvthq9wb8M0JSiJqa7.', NULL, 10, 0, 0, '', 'A', '', '', ''),
(6, '1', 'prasanth', '', '', '0000-00-00', 'A', '', '', '$2y$13$evoChQgKj7b4VftpPBYAxeZSCgJ7UIlEx0kfM8PKsHtIY6WZLI3ua', NULL, 10, 0, 0, '', 'A', '', '', ''),
(7, '1', 'test123', '', '', '0000-00-00', 'A', '', '', '$2y$13$Sh5ln5HAL/s8vSVp1JvZoe0TQ2JKNp2LSPFSK6vB/r.IAQ2DZ8vEK', NULL, 10, 0, 0, '', 'A', '', '', ''),
(8, '1', 'test', '', '', '0000-00-00', 'A', '', '', '$2y$13$TVEAFzE3stVDbSJ3tGbPeuNWSHhMv.xLe8Zjxn9h0cm4xa4EHCYMy', NULL, 10, 0, 0, '', 'A', '', '', ''),
(9, '1', 't21', '', '', '0000-00-00', 'A', '', '', '$2y$13$xKleCiPyJIF9K0wkKGD94uY3Xz2kREZWCGUPJ7Yf/stOnhOeUM3m.', NULL, 10, 0, 0, '', 'A', '', '', ''),
(10, '1', 't11', '', '', '0000-00-00', 'A', '', '', '$2y$13$/OFM5tMLKuoMDgQv8kitou3jzjg3YPzhFSkuAYvt0oKqS2.nAhwOS', NULL, 10, 0, 0, '', 'A', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `user_type` enum('A','U','P') COLLATE utf8_unicode_ci NOT NULL COMMENT 'A=Admin, U=User, P=Player',
  `city` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `rights` text COLLATE utf8_unicode_ci NOT NULL,
  `status_flag` enum('A','I') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'A' COMMENT 'A=Active, I=Inactive',
  `user_level` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `first_name`, `last_name`, `dob`, `user_type`, `city`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`, `rights`, `status_flag`, `user_level`, `mobile_number`, `designation`) VALUES
(1, 'admin', 'Admin', 'aerert', '0000-00-00', 'A', 'chennai', '8nAQquRZCfOFOdOngHc2lEhhJ5brco1t', '$2y$13$04h5Rr1SHyTvNkgGM0ot6OMWvkv9eHRZjVO..ZYRfZvQM3wQHa6tS', NULL, 10, 1459345080, 1459345080, '', 'A', '3', '978655225553', 'Manager'),
(5, 'admin111', '111', 'aaa', '0000-00-00', '', 'es', '8nAQquRZCfOFOdOngHc2lEhhJ5brco1t', '$2y$13$04h5Rr1SHyTvNkgGM0ot6OMWvkv9eHRZjVO..ZYRfZvQM3wQHa6tS', NULL, 10, 1459345080, 1459345080, '', 'A', '3', '', ''),
(6, 'test', '', '', '0000-00-00', '', '', '', '098f6bcd4621d373cade4e832627b4f6\r\n', NULL, 10, 0, 0, '', 'A', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `video_management`
--

CREATE TABLE `video_management` (
  `video_id` int(11) NOT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `video_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `video_image` varchar(255) DEFAULT NULL,
  `you_desc` varchar(255) CHARACTER SET utf8 NOT NULL,
  `youtube_id` varchar(255) DEFAULT NULL,
  `video_type` varchar(250) CHARACTER SET utf8 DEFAULT 'No',
  `auto_id` int(11) NOT NULL,
  `active_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_management`
--

INSERT INTO `video_management` (`video_id`, `youtube_url`, `video_name`, `video_image`, `you_desc`, `youtube_id`, `video_type`, `auto_id`, `active_status`) VALUES
(13, 'https://www.youtube.com/watch?v=QHTRpq4NIjw', 'குழந்தைகள் தேர்வுக்குப் படித்ததை மறக்காமல் இருக்க/CHILDREN MEMORY DEVELOPMENT', '', 'test', 'QHTRpq4NIjw', 'No', 3, 1),
(14, 'https://www.youtube.com/watch?v=IJzd2OvPjl0', 'பித்ரு தோஷ பரிகாரங்கள்/pithru dosha remedies', '', 'test', 'IJzd2OvPjl0', 'YES', 3, 1),
(16, 'https://www.youtube.com/watch?v=5CsoYtOl8Zg', 'குடியை நிறுத்த சித்தர்கள் சொன்ன மூலிகை/REMEDIES FOR STOP DRINKING ALCOHOL', '', 'fadfq', '5CsoYtOl8Zg', 'YES', 5, 1),
(17, 'https://www.youtube.com/watch?v=rYkkqh2DhX4', 'பித்ரு தோஷம் அறிகுறிகள்/SYMPTOMS OF PITHRU DOSHA/', '', '', 'rYkkqh2DhX4', 'No', 3, 1),
(18, 'https://www.youtube.com/watch?v=MUygdx1bF_A', 'விரதமிருப்பதால் இவ்வளவு நன்மைகளா?!/SO MANY BENEFITS IN FASTING?!', '', '', 'MUygdx1bF_A', 'No', 3, 1),
(19, 'https://www.youtube.com/watch?v=pR2Bn348TYg', 'வரகு அரிசி பன்னீர் புலாவ்/CODO MILLET RICE PANEER BROCCOLI PULAV', '', '', 'pR2Bn348TYg', 'YES', 2, 1),
(20, 'https://www.youtube.com/watch?v=RB8bw_1r-gs', 'வறுத்த ஆளி விதையைப் பயன் படுத்தும் முறை/HOW TO STORE FLAX SEEDS', '', '', 'RB8bw_1r-gs', 'No', 5, 1),
(21, 'https://www.youtube.com/watch?v=XPdtg9ajx4g', 'மாதவிடாய் வலிக்கு வீட்டு வைத்தியம்/HOME REMEDIES FOR PERIOD STOMACH PAIN', '', '', 'XPdtg9ajx4g', 'No', 5, 1),
(22, 'https://www.youtube.com/watch?v=_hOfKL4Yf-8', 'இண்டிகோ பவுடர் என்றால் என்ன?/WHAT IS INDIGO POWDER', '', '', '_hOfKL4Yf-8', 'YES', 6, 1),
(23, 'https://www.youtube.com/watch?v=FJ5PwHCPW-U', 'அம்மன் பாடலை DR.PUSHPAVANAM KUPPUSAMY தன் கணீரென்ற தெய்வீகக் குரலால் பாடினால் அதிசயங்கள் ', '', '', 'FJ5PwHCPW-U', 'YES', 4, 1),
(24, 'https://www.youtube.com/watch?v=S0gfBCWJBAU', 'MOTHER IN LAW DAUGHTER IN LAW GOOD RELATIONSHIP REMEDIES/மாமியார் மருமகள் அன்பு பெருக', '', '', 'S0gfBCWJBAU', 'No', 3, 1),
(25, 'https://www.youtube.com/watch?v=jjlSl7j2P3g', 'நாம் படைக்கும் நைவேத்யத்தை இறைவன் எப்படி ஏற்றுக் கொள்கிறார்?/HOW DOES GOD ACCEPT ''NAIVEDHYA''', '', '', 'jjlSl7j2P3g', 'No', 3, 1),
(26, 'https://www.youtube.com/watch?v=kRwzOCzAoys', 'எங்கள் மகள் DR.பல்லவி பாடிய பாடல்/SONG SUNG BY OUR DAUGHTER DR.PALLAVI', '', '', 'kRwzOCzAoys', 'No', 4, 1),
(27, 'https://www.youtube.com/watch?v=aQ_l1BH6qLw', 'நரம்பு வீக்கம் வீட்டுக்குறிப்புகள்/HOME REMEDIES FOR VARICOSE VEINS', '', '', 'aQ_l1BH6qLw', 'No', 5, 1),
(28, 'https://www.youtube.com/watch?v=ykl1fKinAtQ', 'கேன்சர் நோயை தடுக்கும் ''flax seed'' இட்லிபொடி/FLAX SEEDS PREVENT FROM CANCER', '', '', 'ykl1fKinAtQ', 'No', 5, 1),
(29, 'https://www.youtube.com/watch?v=jFZW4K98L6A', 'வெண்தோல் பிரச்சினைக்கு வீட்டுக் குறிப்புகள்/HOME REMEDIES FOR VITILIGO', '', '', 'jFZW4K98L6A', 'No', 5, 1),
(30, 'https://www.youtube.com/watch?v=wHePCFqru3w', 'திருமணத் தடைகள் விலகப் பரிகாரங்கள்/MARRIAGE REMEDIES', '', '', 'wHePCFqru3w', 'No', 3, 1),
(31, 'https://www.youtube.com/watch?v=4T7QcDKT3KE', 'சர்வ வலி நிவாரணி தைலம்/PAIN RELIEF,COLD RELIEF OIL', '', '', '4T7QcDKT3KE', 'No', 5, 1),
(32, 'https://www.youtube.com/watch?v=JVl0LuJji7Q', 'கரப்பான் பூச்சித் தொல்லையிலிருந்து விடுபட/COCKROACH PROBLEM HOME REMEDIES', '', '', 'JVl0LuJji7Q', 'YES', 7, 1),
(33, 'https://www.youtube.com/watch?v=KG9Zj1Z4XfU', 'உயரம் குறைவானவர்கள் அதைக் குறையாக நினைக்க வேண்டாம்/ DON''T FEEL BAD FOR BEING SHORT', '', '', 'KG9Zj1Z4XfU', 'YES', 8, 1),
(34, 'https://www.youtube.com/watch?v=x0QrBatw8tQ', 'கார்த்திகை தீபம்/KARTHIGAI DEEPAM DETAILS', '', '', 'x0QrBatw8tQ', 'No', 3, 1),
(35, 'https://www.youtube.com/watch?v=-u61W0qhbwg', 'உடல் வலிமை பெற சத்து மாவு கஞ்சி,கூழ்/HEALTH MIX KANJI,KOOZH', '', '', '-u61W0qhbwg', 'No', 5, 1),
(36, 'https://www.youtube.com/watch?v=DtiBIAQTyig', 'கஜா புயல் கோர தாண்டவம்/HELP THE PEOPLE WHO WERE AFFECTED BY THE GAJA CYCLON', '', '', 'DtiBIAQTyig', 'YES', 9, 1),
(37, 'https://www.youtube.com/watch?v=zyazGwz2MrI', '100%இயற்கையான ''ஹேர் டை''/ 100% NATURAL HAIR DYE', '', '', 'zyazGwz2MrI', 'No', 6, 1),
(38, 'https://www.youtube.com/watch?v=_Suw_7LJJiw', 'சகல ஐஸ்வர்யம் தரும் துளசி பூஜை/TULSI POOJA', '', '', '_Suw_7LJJiw', 'No', 3, 1),
(39, 'https://www.youtube.com/watch?v=bCipV-7W9qI', 'கெட்ட கனவு வராமலிருக்க,தீய சக்தி விலக/TO AVOID BAD DREAM AND DISSOLUTION OF EVIL POWER', '', '', 'bCipV-7W9qI', 'No', 3, 1),
(40, 'https://www.youtube.com/watch?v=ECIOHsOkQ1M', 'நல்ல வேலை கிடைக்க எளிய பரிகாரங்கள்/BEST SOLUTIONS FOR JOB', '', '', 'ECIOHsOkQ1M', 'No', 3, 1),
(41, 'https://www.youtube.com/watch?v=T0ssVyzsGBA', 'HAPPY CHILDREN''DAY/SONG BY ANITHA KUPPUSAMY/MUSIC BY DR.PUSHPAVANAM KUPPUSAMY', '', '', 'T0ssVyzsGBA', 'No', 4, 1),
(42, 'https://www.youtube.com/watch?v=y22sd0wIay4', 'கியாஸ் சிலிண்டர் விலை ஏறிடுச்சு என்ன செய்யலாம்?/HOW TO MANAGE GAS CYLINDER PRICE HIKE', '', '', 'y22sd0wIay4', 'No', 2, 1),
(43, 'https://www.youtube.com/watch?v=Fj99xKYT7LI', 'டென்ஷன் இல்லாமல் வீடு சுத்தம் செய்வது எப்படி?/HOW TO CLEAN THE HOUSE WITH NO TENSION', '', '', 'Fj99xKYT7LI', 'No', 7, 1),
(44, 'https://www.youtube.com/watch?v=AAMcdXAarbs', 'அடிக்கடி சளி பிடிக்க இதுவும் ஒரு காரணம்/THIS IS ALSO A REASON TO GET TOO COLD', '', '', 'AAMcdXAarbs', 'No', 5, 1),
(45, 'https://www.youtube.com/watch?v=P_qE7mpt4-0', 'REMEDY FOR COLD,COUGH,WHEEZING/சளி,இருமல்,மூச்சுப் பிரச்சினைக்குத் தீர்வு', '', '', 'P_qE7mpt4-0', 'No', 5, 1),
(46, 'https://www.youtube.com/watch?v=DydS6_mTwyE', 'பொடுகிற்குத் தீர்வு/Remedies for dandruff', '', '', 'DydS6_mTwyE', 'No', 6, 1),
(47, 'https://www.youtube.com/watch?v=xNo7y9eASzw', 'HOW TO PREPARE WINTER MOISTURE & FAIRNESS CREAM/சருமத்திற்குப் பொலிவு தரும் க்ரீம்', '', '', 'xNo7y9eASzw', 'No', 6, 1),
(48, 'https://www.youtube.com/watch?v=hVanEYOkUNQ', 'சத்து மாவு செய்வது எப்படி?/HOW TO PREPARE HEALTH MIX/Sathu Maavu', '', '', 'hVanEYOkUNQ', 'No', 5, 1),
(49, 'https://www.youtube.com/watch?v=ztibZPvMNQw', 'தீபாவளி மஹாலஷ்மி பூஜை/DIWALI/DEEPAVALILAKSHMI POOJA', '', '', 'ztibZPvMNQw', 'No', 3, 1),
(50, 'https://www.youtube.com/watch?v=OzQnap8yB64', 'FAMILY DIWALI CELEBRATION', '', '', 'OzQnap8yB64', 'YES', 10, 1),
(51, 'https://www.youtube.com/watch?v=HaBt9xr5niw', 'DIWALI FAMILY PICTURES/Anitha Pushpavanam Kuppusamy', '', '', 'HaBt9xr5niw', 'No', 10, 1),
(52, 'https://www.youtube.com/watch?v=-4HKExkTweU', 'மஹாலக்ஷ்மி பூஜை நைவேத்திய பாயசம்/MAHALAKSHMI POOJA NAIVEDHYA PAYASAM', '', '', '-4HKExkTweU', 'No', 2, 1),
(53, 'https://www.youtube.com/watch?v=_Mj38Qmg23w', 'இறை சக்தியை ஆகர்ஷிப்பது எப்படி/தெய்வ ரகசியம்/TO GET DIVINE BLESSINGS DO THIS', '', '', '_Mj38Qmg23w', 'No', 3, 1),
(54, 'https://www.youtube.com/watch?v=sFuwcSnmXUA', 'பாரம்பரிய தீபாவளி இனிப்புப் பலகாரம் TRADITIONAL DEEPAVALI/DIWALI SWEET', '', '', 'sFuwcSnmXUA', 'No', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `category_management`
--
ALTER TABLE `category_management`
  ADD PRIMARY KEY (`auto_id`);

--
-- Indexes for table `home_management`
--
ALTER TABLE `home_management`
  ADD PRIMARY KEY (`home_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `swim_servicecenterlogin`
--
ALTER TABLE `swim_servicecenterlogin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `video_management`
--
ALTER TABLE `video_management`
  ADD PRIMARY KEY (`video_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_management`
--
ALTER TABLE `category_management`
  MODIFY `auto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `home_management`
--
ALTER TABLE `home_management`
  MODIFY `home_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `swim_servicecenterlogin`
--
ALTER TABLE `swim_servicecenterlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `video_management`
--
ALTER TABLE `video_management`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
