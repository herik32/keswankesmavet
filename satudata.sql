-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table satudata_disbunak.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.cache: ~22 rows (approximately)
DELETE FROM `cache`;
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-captcha_13eef20c0c54e26bb18ac986a5ac4210', 's:9:"16 + 9 = ";', 1759981853),
	('laravel-cache-captcha_2f3151e25bb50bcfa36251454f56dc3c', 's:9:"14 + 5 = ";', 1759896017),
	('laravel-cache-captcha_2fad9c2c7f4cce5d6e5e0dc387da310d', 's:9:"18 + 4 = ";', 1759982474),
	('laravel-cache-captcha_385f0c64d42d62ac56d93ec8dd410276', 's:9:"19 + 1 = ";', 1759982157),
	('laravel-cache-captcha_3f749c912c85a592d4688c76849639c3', 's:9:"29 + 8 = ";', 1759997324),
	('laravel-cache-captcha_4c813132441bb1a0423b786422af4534', 's:9:"18 + 7 = ";', 1759982226),
	('laravel-cache-captcha_609898526c9e345b7e1426d7f9f0baf4', 's:9:"17 + 6 = ";', 1769745712),
	('laravel-cache-captcha_8924e58405ff6a6137817eacbca9d81b', 's:9:"12 + 5 = ";', 1759982426),
	('laravel-cache-captcha_8ab15cb09fec940ffce3773dd0f107d1', 's:9:"14 + 7 = ";', 1759827667),
	('laravel-cache-captcha_8ff8076cd539a854205d915fb68cbd2d', 's:9:"26 + 1 = ";', 1760423987),
	('laravel-cache-captcha_9229bb9e675afd47df066a9ebc479bf1', 's:9:"16 + 8 = ";', 1759982523),
	('laravel-cache-captcha_98b23964faafb634e7e85e29f12f827e', 's:9:"11 + 6 = ";', 1759982078),
	('laravel-cache-captcha_9b2c52f32e62400c2811fab94196a0e5', 's:9:"29 + 5 = ";', 1759981730),
	('laravel-cache-captcha_a794a9b0ffac39a107fbf5eac53eb8a1', 's:9:"17 + 7 = ";', 1762931437),
	('laravel-cache-captcha_aa3851cdd08a18222074ecb34ca5b172', 's:9:"15 + 6 = ";', 1759982146),
	('laravel-cache-captcha_b70dee2634d53ce2a855b4b0bfc31001', 's:9:"17 + 7 = ";', 1760501693),
	('laravel-cache-captcha_c1d1fc898d60317cda27a2060f0319ae', 's:9:"28 + 6 = ";', 1759981616),
	('laravel-cache-captcha_c98307d138dd0bf40155e5007e4fb266', 's:9:"23 + 2 = ";', 1759990222),
	('laravel-cache-captcha_dcc7f10ec4913a669c375e976d592a77', 's:9:"29 + 9 = ";', 1759982202),
	('laravel-cache-captcha_e15a12ff4f2508d1b0dbfcef3ab9813c', 's:9:"23 + 1 = ";', 1761102617),
	('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1795395414),
	('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1795395414;', 1795395414);

-- Dumping structure for table satudata_disbunak.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table satudata_disbunak.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table satudata_disbunak.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table satudata_disbunak.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table satudata_disbunak.kabupatens
CREATE TABLE IF NOT EXISTS `kabupatens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.kabupatens: ~14 rows (approximately)
DELETE FROM `kabupatens`;
INSERT INTO `kabupatens` (`id`, `nama`, `created_at`, `updated_at`) VALUES
	(6101, 'SAMBAS', '2025-09-24 08:12:27', NULL),
	(6102, 'BENGKAYANG', '2025-09-24 08:12:27', NULL),
	(6103, 'LANDAK', '2025-09-24 08:12:27', NULL),
	(6104, 'MEMPAWAH', '2025-09-24 08:12:27', NULL),
	(6105, 'SANGGAU', '2025-09-24 08:12:27', NULL),
	(6106, 'KETAPANG', '2025-09-24 08:12:27', NULL),
	(6107, 'SINTANG', '2025-09-24 08:12:27', NULL),
	(6108, 'KAPUAS HULU', '2025-09-24 08:12:27', NULL),
	(6109, 'SEKADAU', '2025-09-24 08:12:27', NULL),
	(6110, 'MELAWI', '2025-09-24 08:12:27', NULL),
	(6111, 'KAYONG UTARA', '2025-09-24 08:12:27', NULL),
	(6112, 'KUBU RAYA', '2025-09-24 08:12:27', NULL),
	(6171, 'PONTIANAK', '2025-09-24 08:12:27', NULL),
	(6172, 'SINGKAWANG', '2025-09-24 08:12:27', NULL);

-- Dumping structure for table satudata_disbunak.kecamatans
CREATE TABLE IF NOT EXISTS `kecamatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_kabupaten` bigint unsigned NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kecamatans_id_kabupaten_index` (`id_kabupaten`)
) ENGINE=InnoDB AUTO_INCREMENT=6172051 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.kecamatans: ~174 rows (approximately)
DELETE FROM `kecamatans`;
INSERT INTO `kecamatans` (`id`, `id_kabupaten`, `nama`, `created_at`, `updated_at`) VALUES
	(6101010, 6101, 'SELAKAU', '2025-09-24 08:18:50', NULL),
	(6101011, 6101, 'SELAKAU TIMUR', '2025-09-24 08:18:50', NULL),
	(6101020, 6101, 'PEMANGKAT', '2025-09-24 08:18:50', NULL),
	(6101021, 6101, 'SEMPARUK', '2025-09-24 08:18:50', NULL),
	(6101022, 6101, 'SALATIGA', '2025-09-24 08:18:50', NULL),
	(6101030, 6101, 'TEBAS', '2025-09-24 08:18:50', NULL),
	(6101031, 6101, 'TEKARANG', '2025-09-24 08:18:50', NULL),
	(6101040, 6101, 'SAMBAS', '2025-09-24 08:18:50', NULL),
	(6101041, 6101, 'SUBAH', '2025-09-24 08:18:50', NULL),
	(6101042, 6101, 'SEBAWI', '2025-09-24 08:18:50', NULL),
	(6101043, 6101, 'SAJAD', '2025-09-24 08:18:50', NULL),
	(6101050, 6101, 'JAWAI', '2025-09-24 08:18:50', NULL),
	(6101051, 6101, 'JAWAI SELATAN', '2025-09-24 08:18:50', NULL),
	(6101060, 6101, 'TELUK KERAMAT', '2025-09-24 08:18:50', NULL),
	(6101061, 6101, 'GALING', '2025-09-24 08:18:50', NULL),
	(6101062, 6101, 'TANGARAN', '2025-09-24 08:18:50', NULL),
	(6101070, 6101, 'SEJANGKUNG', '2025-09-24 08:18:50', NULL),
	(6101080, 6101, 'SAJINGAN BESAR', '2025-09-24 08:18:50', NULL),
	(6101090, 6101, 'PALOH', '2025-09-24 08:18:50', NULL),
	(6102010, 6102, 'SUNGAI RAYA', '2025-09-24 08:18:50', NULL),
	(6102011, 6102, 'CAPKALA', '2025-09-24 08:18:50', NULL),
	(6102012, 6102, 'SUNGAI RAYA KEPULAUAN', '2025-09-24 08:18:50', NULL),
	(6102030, 6102, 'SAMALANTAN', '2025-09-24 08:18:50', NULL),
	(6102031, 6102, 'MONTERADO', '2025-09-24 08:18:50', NULL),
	(6102032, 6102, 'LEMBAH BAWANG', '2025-09-24 08:18:50', NULL),
	(6102040, 6102, 'BENGKAYANG', '2025-09-24 08:18:50', NULL),
	(6102041, 6102, 'TERIAK', '2025-09-24 08:18:50', NULL),
	(6102042, 6102, 'SUNGAI BETUNG', '2025-09-24 08:18:50', NULL),
	(6102050, 6102, 'LEDO', '2025-09-24 08:18:50', NULL),
	(6102051, 6102, 'SUTI SEMARANG', '2025-09-24 08:18:50', NULL),
	(6102052, 6102, 'LUMAR', '2025-09-24 08:18:50', NULL),
	(6102060, 6102, 'SANGGAU LEDO', '2025-09-24 08:18:50', NULL),
	(6102061, 6102, 'TUJUH BELAS', '2025-09-24 08:18:50', NULL),
	(6102070, 6102, 'SELUAS', '2025-09-24 08:18:50', NULL),
	(6102080, 6102, 'JAGOI BABANG', '2025-09-24 08:18:50', NULL),
	(6102081, 6102, 'SIDING', '2025-09-24 08:18:50', NULL),
	(6103020, 6103, 'SEBANGKI', '2025-09-24 08:18:50', NULL),
	(6103030, 6103, 'NGABANG', '2025-09-24 08:18:50', NULL),
	(6103031, 6103, 'JELIMPO', '2025-09-24 08:18:50', NULL),
	(6103040, 6103, 'SENGAH TEMILA', '2025-09-24 08:18:50', NULL),
	(6103050, 6103, 'MANDOR', '2025-09-24 08:18:50', NULL),
	(6103060, 6103, 'MENJALIN', '2025-09-24 08:18:50', NULL),
	(6103070, 6103, 'MEMPAWAH HULU', '2025-09-24 08:18:50', NULL),
	(6103071, 6103, 'SOMPAK', '2025-09-24 08:18:50', NULL),
	(6103080, 6103, 'MENYUKE', '2025-09-24 08:18:50', NULL),
	(6103081, 6103, 'BANYUKE HULU', '2025-09-24 08:18:50', NULL),
	(6103090, 6103, 'MERANTI', '2025-09-24 08:18:50', NULL),
	(6103100, 6103, 'KUALA BEHE', '2025-09-24 08:18:50', NULL),
	(6103110, 6103, 'AIR BESAR', '2025-09-24 08:18:50', NULL),
	(6104080, 6104, 'JONGKAT', '2025-09-24 08:18:50', NULL),
	(6104081, 6104, 'SEGEDONG', '2025-09-24 08:18:50', NULL),
	(6104090, 6104, 'SUNGAI PINYUH', '2025-09-24 08:18:50', NULL),
	(6104091, 6104, 'ANJONGAN', '2025-09-24 08:18:50', NULL),
	(6104100, 6104, 'MEMPAWAH HILIR', '2025-09-24 08:18:50', NULL),
	(6104101, 6104, 'MEMPAWAH TIMUR', '2025-09-24 08:18:50', NULL),
	(6104110, 6104, 'SUNGAI KUNYIT', '2025-09-24 08:18:50', NULL),
	(6104120, 6104, 'TOHO', '2025-09-24 08:18:50', NULL),
	(6104121, 6104, 'SADANIANG', '2025-09-24 08:18:50', NULL),
	(6105010, 6105, 'TOBA', '2025-09-24 08:18:50', NULL),
	(6105020, 6105, 'MELIAU', '2025-09-24 08:18:50', NULL),
	(6105060, 6105, 'KAPUAS', '2025-09-24 08:18:50', NULL),
	(6105070, 6105, 'MUKOK', '2025-09-24 08:18:50', NULL),
	(6105120, 6105, 'JANGKANG', '2025-09-24 08:18:50', NULL),
	(6105130, 6105, 'BONTI', '2025-09-24 08:18:50', NULL),
	(6105140, 6105, 'PARINDU', '2025-09-24 08:18:50', NULL),
	(6105150, 6105, 'TAYAN HILIR', '2025-09-24 08:18:50', NULL),
	(6105160, 6105, 'BALAI', '2025-09-24 08:18:50', NULL),
	(6105170, 6105, 'TAYAN HULU', '2025-09-24 08:18:50', NULL),
	(6105180, 6105, 'KEMBAYAN', '2025-09-24 08:18:50', NULL),
	(6105190, 6105, 'BEDUAI', '2025-09-24 08:18:50', NULL),
	(6105200, 6105, 'NOYAN', '2025-09-24 08:18:50', NULL),
	(6105210, 6105, 'SEKAYAM', '2025-09-24 08:18:50', NULL),
	(6105220, 6105, 'ENTIKONG', '2025-09-24 08:18:50', NULL),
	(6106010, 6106, 'KENDAWANGAN', '2025-09-24 08:18:50', NULL),
	(6106020, 6106, 'MANIS MATA', '2025-09-24 08:18:50', NULL),
	(6106030, 6106, 'MARAU', '2025-09-24 08:18:50', NULL),
	(6106031, 6106, 'SINGKUP', '2025-09-24 08:18:50', NULL),
	(6106032, 6106, 'AIR UPAS', '2025-09-24 08:18:50', NULL),
	(6106040, 6106, 'JELAI HULU', '2025-09-24 08:18:50', NULL),
	(6106050, 6106, 'TUMBANG TITI', '2025-09-24 08:18:50', NULL),
	(6106051, 6106, 'PEMAHAN', '2025-09-24 08:18:50', NULL),
	(6106052, 6106, 'SUNGAI MELAYU RAYAK', '2025-09-24 08:18:50', NULL),
	(6106060, 6106, 'MATAN HILIR SELATAN', '2025-09-24 08:18:50', NULL),
	(6106061, 6106, 'BENUA KAYONG', '2025-09-24 08:18:50', NULL),
	(6106070, 6106, 'MATAN HILIR UTARA', '2025-09-24 08:18:50', NULL),
	(6106071, 6106, 'DELTA PAWAN', '2025-09-24 08:18:50', NULL),
	(6106072, 6106, 'MUARA PAWAN', '2025-09-24 08:18:50', NULL),
	(6106090, 6106, 'NANGA TAYAP', '2025-09-24 08:18:50', NULL),
	(6106100, 6106, 'SANDAI', '2025-09-24 08:18:50', NULL),
	(6106101, 6106, 'HULU SUNGAI', '2025-09-24 08:18:50', NULL),
	(6106110, 6106, 'SUNGAI LAUR', '2025-09-24 08:18:50', NULL),
	(6106120, 6106, 'SIMPANG HULU', '2025-09-24 08:18:50', NULL),
	(6106121, 6106, 'SIMPANG DUA', '2025-09-24 08:18:50', NULL),
	(6107060, 6107, 'SERAWAI', '2025-09-24 08:18:50', NULL),
	(6107070, 6107, 'AMBALAU', '2025-09-24 08:18:50', NULL),
	(6107080, 6107, 'KAYAN HULU', '2025-09-24 08:18:50', NULL),
	(6107110, 6107, 'SEPAUK', '2025-09-24 08:18:50', NULL),
	(6107120, 6107, 'TEMPUNAK', '2025-09-24 08:18:50', NULL),
	(6107130, 6107, 'SUNGAI TEBELIAN', '2025-09-24 08:18:50', NULL),
	(6107140, 6107, 'SINTANG', '2025-09-24 08:18:50', NULL),
	(6107150, 6107, 'DEDAI', '2025-09-24 08:18:50', NULL),
	(6107160, 6107, 'KAYAN HILIR', '2025-09-24 08:18:50', NULL),
	(6107170, 6107, 'KELAM PERMAI', '2025-09-24 08:18:50', NULL),
	(6107180, 6107, 'BINJAI HULU', '2025-09-24 08:18:50', NULL),
	(6107190, 6107, 'KETUNGAU HILIR', '2025-09-24 08:18:50', NULL),
	(6107200, 6107, 'KETUNGAU TENGAH', '2025-09-24 08:18:50', NULL),
	(6107210, 6107, 'KETUNGAU HULU', '2025-09-24 08:18:50', NULL),
	(6108010, 6108, 'SILAT HILIR', '2025-09-24 08:18:50', NULL),
	(6108020, 6108, 'SILAT HULU', '2025-09-24 08:18:50', NULL),
	(6108030, 6108, 'HULU GURUNG', '2025-09-24 08:18:50', NULL),
	(6108040, 6108, 'BUNUT HULU', '2025-09-24 08:18:50', NULL),
	(6108050, 6108, 'MENTEBAH', '2025-09-24 08:18:50', NULL),
	(6108060, 6108, 'BIKA', '2025-09-24 08:18:50', NULL),
	(6108070, 6108, 'KALIS', '2025-09-24 08:18:50', NULL),
	(6108080, 6108, 'PUTUSSIBAU SELATAN', '2025-09-24 08:18:50', NULL),
	(6108090, 6108, 'EMBALOH HILIR', '2025-09-24 08:18:50', NULL),
	(6108100, 6108, 'BUNUT HILIR', '2025-09-24 08:18:50', NULL),
	(6108110, 6108, 'BOYAN TANJUNG', '2025-09-24 08:18:50', NULL),
	(6108120, 6108, 'PENGKADAN', '2025-09-24 08:18:50', NULL),
	(6108130, 6108, 'JONGKONG', '2025-09-24 08:18:50', NULL),
	(6108140, 6108, 'SELIMBAU', '2025-09-24 08:18:50', NULL),
	(6108150, 6108, 'SUHAID', '2025-09-24 08:18:50', NULL),
	(6108160, 6108, 'SEBERUANG', '2025-09-24 08:18:50', NULL),
	(6108170, 6108, 'SEMITAU', '2025-09-24 08:18:50', NULL),
	(6108180, 6108, 'EMPANANG', '2025-09-24 08:18:50', NULL),
	(6108190, 6108, 'PURING KENCANA', '2025-09-24 08:18:50', NULL),
	(6108200, 6108, 'BADAU', '2025-09-24 08:18:50', NULL),
	(6108210, 6108, 'BATANG LUPAR', '2025-09-24 08:18:50', NULL),
	(6108220, 6108, 'EMBALOH HULU', '2025-09-24 08:18:50', NULL),
	(6108230, 6108, 'PUTUSSIBAU UTARA', '2025-09-24 08:18:50', NULL),
	(6109010, 6109, 'NANGA MAHAP', '2025-09-24 08:18:50', NULL),
	(6109020, 6109, 'NANGA TAMAN', '2025-09-24 08:18:50', NULL),
	(6109030, 6109, 'SEKADAU HULU', '2025-09-24 08:18:50', NULL),
	(6109040, 6109, 'SEKADAU HILIR', '2025-09-24 08:18:50', NULL),
	(6109050, 6109, 'BELITANG HILIR', '2025-09-24 08:18:50', NULL),
	(6109060, 6109, 'BELITANG', '2025-09-24 08:18:50', NULL),
	(6109070, 6109, 'BELITANG HULU', '2025-09-24 08:18:50', NULL),
	(6110010, 6110, 'SOKAN', '2025-09-24 08:18:50', NULL),
	(6110020, 6110, 'TANAH PINOH', '2025-09-24 08:18:50', NULL),
	(6110021, 6110, 'TANAH PINOH BARAT', '2025-09-24 08:18:50', NULL),
	(6110030, 6110, 'SAYAN', '2025-09-24 08:18:50', NULL),
	(6110040, 6110, 'BELIMBING', '2025-09-24 08:18:50', NULL),
	(6110041, 6110, 'BELIMBING HULU', '2025-09-24 08:18:50', NULL),
	(6110050, 6110, 'NANGA PINOH', '2025-09-24 08:18:50', NULL),
	(6110051, 6110, 'PINOH SELATAN', '2025-09-24 08:18:50', NULL),
	(6110052, 6110, 'PINOH UTARA', '2025-09-24 08:18:50', NULL),
	(6110060, 6110, 'ELLA HILIR', '2025-09-24 08:18:50', NULL),
	(6110070, 6110, 'MENUKUNG', '2025-09-24 08:18:50', NULL),
	(6111010, 6111, 'PULAU MAYA', '2025-09-24 08:18:50', NULL),
	(6111011, 6111, 'KEPULAUAN KARIMATA', '2025-09-24 08:18:50', NULL),
	(6111020, 6111, 'SUKADANA', '2025-09-24 08:18:50', NULL),
	(6111030, 6111, 'SIMPANG HILIR', '2025-09-24 08:18:50', NULL),
	(6111040, 6111, 'TELUK BATANG', '2025-09-24 08:18:50', NULL),
	(6111050, 6111, 'SEPONTI', '2025-09-24 08:18:50', NULL),
	(6112010, 6112, 'BATU AMPAR', '2025-09-24 08:18:50', NULL),
	(6112020, 6112, 'TERENTANG', '2025-09-24 08:18:50', NULL),
	(6112030, 6112, 'KUBU', '2025-09-24 08:18:50', NULL),
	(6112040, 6112, 'TELUK PAKEDAI', '2025-09-24 08:18:50', NULL),
	(6112050, 6112, 'SUNGAI KAKAP', '2025-09-24 08:18:50', NULL),
	(6112060, 6112, 'RASAU JAYA', '2025-09-24 08:18:50', NULL),
	(6112070, 6112, 'SUNGAI RAYA', '2025-09-24 08:18:50', NULL),
	(6112080, 6112, 'SUNGAI AMBAWANG', '2025-09-24 08:18:50', NULL),
	(6112090, 6112, 'KUALA MANDOR B', '2025-09-24 08:18:50', NULL),
	(6171010, 6171, 'PONTIANAK SELATAN', '2025-09-24 08:18:50', NULL),
	(6171011, 6171, 'PONTIANAK TENGGARA', '2025-09-24 08:18:50', NULL),
	(6171020, 6171, 'PONTIANAK TIMUR', '2025-09-24 08:18:50', NULL),
	(6171030, 6171, 'PONTIANAK BARAT', '2025-09-24 08:18:50', NULL),
	(6171031, 6171, 'PONTIANAK KOTA', '2025-09-24 08:18:50', NULL),
	(6171040, 6171, 'PONTIANAK UTARA', '2025-09-24 08:18:50', NULL),
	(6172010, 6172, 'SINGKAWANG SELATAN', '2025-09-24 08:18:50', NULL),
	(6172020, 6172, 'SINGKAWANG TIMUR', '2025-09-24 08:18:50', NULL),
	(6172030, 6172, 'SINGKAWANG UTARA', '2025-09-24 08:18:50', NULL),
	(6172040, 6172, 'SINGKAWANG BARAT', '2025-09-24 08:18:50', NULL),
	(6172050, 6172, 'SINGKAWANG TENGAH', '2025-09-24 08:18:50', NULL);

-- Dumping structure for table satudata_disbunak.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.migrations: ~36 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_09_17_071934_create_nilai_tukar_petanis_table', 1),
	(5, '2025_09_17_072009_create_produk_domestik_regional_brutos_table', 1),
	(6, '2025_09_18_035141_add_username_and_level_to_users_table', 2),
	(7, '2025_09_24_071031_create_kabupatens_table', 3),
	(8, '2025_09_24_071537_create_kecamatans_table', 3),
	(9, '2025_09_24_072819_create_komoditas_perkebunans_table', 3),
	(10, '2025_09_24_072829_create_komoditas_peternakans_table', 3),
	(11, '2025_09_24_072853_create_statistik_peternakans_table', 3),
	(12, '2025_09_24_072907_create_statistik_perkebunans_table', 3),
	(13, '2025_09_30_065957_create_data_informasis_table', 4),
	(14, '2025_09_30_070415_create_bidangs_table', 4),
	(16, '2025_09_30_071144_add_id_bidang_to_users_table', 5),
	(17, '2025_10_06_034643_create_agenda_dinas_table', 6),
	(18, '2025_10_09_042840_create_sub_bidangs_table', 7),
	(19, '2025_10_09_065920_create_pegawais_table', 8),
	(20, '2025_10_10_025848_create_pangkat_golongans_table', 9),
	(21, '2025_10_14_042105_create_programs_table', 10),
	(22, '2025_10_14_042126_create_kegiatans_table', 10),
	(23, '2025_10_14_042138_create_sub_kegiatans_table', 10),
	(24, '2025_10_14_042155_create_pagus_table', 10),
	(25, '2025_10_14_042206_create_targets_table', 10),
	(26, '2025_10_14_042218_create_realisasis_table', 10),
	(27, '2025_10_28_020258_create_surat_dinas_table', 11),
	(28, '2025_10_28_020923_create_surat_tugas_table', 11),
	(29, '2025_10_29_015429_add_link_to_data_informasis_table', 12),
	(31, '2025_10_29_042853_create_visitors_table', 13),
	(32, '2025_10_31_033513_add_foto_id_to_pegawais_table', 14),
	(33, '2026_01_28_082524_create_kamus_aktivitas_table', 15),
	(34, '2026_01_29_023731_create_aktivitas_table', 16),
	(36, '2026_09_03_072303_create_kurbans_table', 17),
	(37, '2026_09_07_033207_create_pemotongan_kurbans_table', 18),
	(38, '2026_09_07_062547_create_tempat_pemotongans_table', 19),
	(40, '2026_09_08_022620_create_pemotongan_tercatats_table', 20);

-- Dumping structure for table satudata_disbunak.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table satudata_disbunak.pemotongan_kurbans
CREATE TABLE IF NOT EXISTS `pemotongan_kurbans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun` year NOT NULL,
  `kabupaten_id` bigint unsigned NOT NULL,
  `jenis_ternak` enum('Sapi','Kambing','Domba','Kerbau') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pemotongan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pemotongan_kurbans_tahun_id_kabupaten_jenis_ternak_unique` (`tahun`,`kabupaten_id`,`jenis_ternak`),
  KEY `pemotongan_kurbans_id_kabupaten_foreign` (`kabupaten_id`),
  CONSTRAINT `pemotongan_kurbans_id_kabupaten_foreign` FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupatens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.pemotongan_kurbans: ~26 rows (approximately)
DELETE FROM `pemotongan_kurbans`;
INSERT INTO `pemotongan_kurbans` (`id`, `tahun`, `kabupaten_id`, `jenis_ternak`, `jumlah_pemotongan`, `created_at`, `updated_at`) VALUES
	(1, '2024', 6109, 'Kambing', 251, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(2, '2024', 6109, 'Sapi', 106, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(3, '2025', 6109, 'Kambing', 193, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(4, '2026', 6105, 'Kambing', 456, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(5, '2025', 6107, 'Kerbau', 232, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(6, '2026', 6109, 'Domba', 57, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(9, '2026', 6104, 'Domba', 86, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(10, '2025', 6171, 'Kerbau', 154, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(11, '2025', 6172, 'Domba', 340, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(12, '2025', 6109, 'Sapi', 231, '2026-09-03 19:34:10', '2026-09-03 20:57:49'),
	(14, '2026', 6110, 'Kambing', 138, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(15, '2025', 6102, 'Sapi', 331, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(17, '2026', 6108, 'Kerbau', 118, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(18, '2025', 6106, 'Kambing', 406, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(19, '2026', 6109, 'Sapi', 259, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(20, '2024', 6103, 'Sapi', 309, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(21, '2026', 6106, 'Sapi', 242, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(22, '2026', 6103, 'Domba', 442, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(23, '2025', 6108, 'Sapi', 271, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(24, '2026', 6104, 'Kerbau', 242, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(28, '2026', 6106, 'Kerbau', 371, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(30, '2025', 6112, 'Domba', 333, '2026-09-03 19:34:10', '2026-09-03 19:34:10'),
	(31, '2025', 6111, 'Kambing', 1, '2026-09-03 19:52:47', '2026-09-03 19:52:47'),
	(33, '2026', 6108, 'Sapi', 500, '2026-09-03 20:12:54', '2026-09-03 20:56:56'),
	(34, '2026', 6102, 'Sapi', 3000, '2026-09-03 20:13:12', '2026-09-03 20:16:18'),
	(35, '2026', 6172, 'Sapi', 2, '2026-09-06 21:23:01', '2026-09-06 21:23:14');

-- Dumping structure for table satudata_disbunak.pemotongan_tercatats
CREATE TABLE IF NOT EXISTS `pemotongan_tercatats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bulan` date NOT NULL,
  `tempat_pemotongan_id` bigint unsigned NOT NULL,
  `jenis_ternak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pemotongan` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pemotongan_tercatat_unique` (`bulan`,`tempat_pemotongan_id`,`jenis_ternak`),
  KEY `pemotongan_tercatats_tempat_pemotongan_id_foreign` (`tempat_pemotongan_id`),
  CONSTRAINT `pemotongan_tercatats_tempat_pemotongan_id_foreign` FOREIGN KEY (`tempat_pemotongan_id`) REFERENCES `tempat_pemotongans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.pemotongan_tercatats: ~6 rows (approximately)
DELETE FROM `pemotongan_tercatats`;
INSERT INTO `pemotongan_tercatats` (`id`, `bulan`, `tempat_pemotongan_id`, `jenis_ternak`, `jumlah_pemotongan`, `created_at`, `updated_at`) VALUES
	(1, '2026-08-01', 1, 'Babi', 15, '2026-09-07 20:48:46', '2026-09-07 20:55:17'),
	(2, '2026-09-01', 2, 'Ayam', 5, '2026-09-07 20:50:38', '2026-09-07 20:50:38'),
	(4, '2026-08-01', 3, 'Kerbau Betina Produktif', 1, '2026-09-22 02:50:03', '2026-09-22 02:50:03'),
	(5, '2026-09-01', 1, 'Kerbau Jantan', 2, '2026-09-22 02:50:24', '2026-09-22 02:50:24'),
	(6, '2025-11-01', 5, 'Sapi Jantan', 5, '2026-09-22 18:00:27', '2026-09-22 18:00:27'),
	(7, '2026-02-01', 1, 'Sapi Betina Produktif', 3, '2026-09-22 18:13:25', '2026-09-22 18:13:25'),
	(8, '2026-09-01', 6, 'Babi', 5, '2026-09-24 00:10:25', '2026-09-24 00:10:25');

-- Dumping structure for table satudata_disbunak.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.sessions: ~1 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('6NdK2lNqfTDBCOkoqwvnThmUAJrzXWdB4hcYJ4xi', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJjQ1p4V0hZVzBETUh2Y01CZ2tpQjZLVXdaMlNIbTBMR2VKRHJVNGM3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2tlc3dhbi50ZXN0XC9hZG1pblwvcGVtb3Rvbmdhbi10ZXJjYXRhdHMiLCJyb3V0ZSI6ImZpbGFtZW50LmFkbWluLnJlc291cmNlcy5wZW1vdG9uZ2FuLXRlcmNhdGF0cy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sInVybCI6W10sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo2LCJwYXNzd29yZF9oYXNoX3dlYiI6ImE1ZGU5Y2Y4MTY2Mjg5NGYyYjFmM2E4ZWYxYTc3YzM2N2M2OWJmOWI5NjgxMDk5YTgyYmZlMDZkNzQyM2IwMTAiLCJ0YWJsZXMiOnsiM2NlYmYzNzMyMTRhODI4MjNkZjhmM2MwODI2ODFjMWVfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJuYW1hIiwibGFiZWwiOiJOQU1BIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImthYnVwYXRlbi5uYW1hIiwibGFiZWwiOiJLQUJVUEFURU5cL0tPVEEiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoibGF0aXR1ZGUiLCJsYWJlbCI6IkxBVElUVURFIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImxvbmdpdHVkZSIsImxhYmVsIjoiTE9OR0lUVURFIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InN0YXR1c19ha3RpZiIsImxhYmVsIjoiU1RBVFVTIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH1dLCI4YTRmYjk5MDNlYjgwMWIxNDA4NjI3ZDUzN2ZiYTgzYl9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRhaHVuIiwibGFiZWwiOiJUQUhVTiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJrYWJ1cGF0ZW4ubmFtYSIsImxhYmVsIjoiS0FCVVBBVEVOXC9LT1RBIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImplbmlzX3Rlcm5hayIsImxhYmVsIjoiSkVOSVMgVEVSTkFLIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Imp1bWxhaF9wZW1vdG9uZ2FuIiwibGFiZWwiOiJKVU1MQUggUEVNT1RPTkdBTiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XSwiMzU1NWFiN2UzY2MyMjAxNzYwOGJhM2Y3NTg1ZTBmZjZfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJidWxhbiIsImxhYmVsIjoiQlVMQU4iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidGVtcGF0UGVtb3Rvbmdhbi5uYW1hIiwibGFiZWwiOiJSUEhcL1RQSCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ0ZW1wYXRQZW1vdG9uZ2FuLmthYnVwYXRlbi5uYW1hIiwibGFiZWwiOiJLQUJVUEFURU5cL0tPVEEiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiamVuaXNfdGVybmFrIiwibGFiZWwiOiJKRU5JUyBURVJOQUsiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoianVtbGFoX3BlbW90b25nYW4iLCJsYWJlbCI6IkpVTUxBSCBQRU1PVE9OR0FOIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH1dfX0=', 1795397821);

-- Dumping structure for table satudata_disbunak.tempat_pemotongans
CREATE TABLE IF NOT EXISTS `tempat_pemotongans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kabupaten_id` bigint unsigned NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tempat_pemotongans_kabupaten_id_foreign` (`kabupaten_id`),
  CONSTRAINT `tempat_pemotongans_kabupaten_id_foreign` FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupatens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.tempat_pemotongans: ~4 rows (approximately)
DELETE FROM `tempat_pemotongans`;
INSERT INTO `tempat_pemotongans` (`id`, `nama`, `kabupaten_id`, `latitude`, `longitude`, `status_aktif`, `created_at`, `updated_at`) VALUES
	(1, 'RPH Roban SKW', 6172, 0.85536200, 108.97956200, 1, '2026-09-07 19:11:21', '2026-09-24 00:39:18'),
	(2, 'RPH Kubu Satu', 6112, -0.48423400, 109.37718200, 1, '2026-09-07 19:20:00', '2026-09-07 19:20:00'),
	(3, 'RPH Sapi Sambas', 6101, 1.37790500, 109.30303900, 1, '2026-09-13 18:36:03', '2026-09-13 18:36:03'),
	(4, 'RPH Babi Kapuas Hulu', 6108, 0.88669800, 112.95331900, 1, '2026-09-13 18:37:01', '2026-09-13 18:37:01'),
	(5, 'TPH Danau Buntur', 6106, -2.61510000, 110.83073500, 1, '2026-09-13 18:39:30', '2026-09-13 18:39:30'),
	(6, 'RPH Tes Ketapang 2', 6106, -0.90255000, 110.74670600, 1, '2026-09-24 00:09:44', '2026-09-24 00:09:44');

-- Dumping structure for table satudata_disbunak.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `id_bidang` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table satudata_disbunak.users: ~5 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `level`, `id_bidang`, `remember_token`, `created_at`, `updated_at`) VALUES
	(6, 'Keswan Kesmavet', 'keswankesmavet', 'keswan.kesmavet@gmail.com', '2026-01-29 20:59:14', '$2y$12$d1Qnji0nQoxaXgp8iWjLLuvuZnLDbJjB3e0ncy7ZnZIk/8h003qCm', 'operator', 5, NULL, '2026-01-29 20:59:14', '2026-01-29 21:01:28');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
