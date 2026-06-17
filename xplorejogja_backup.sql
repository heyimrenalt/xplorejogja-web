-- MariaDB dump 10.19  Distrib 10.4.21-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: db_myadmin
-- ------------------------------------------------------
-- Server version	10.4.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_categories_parent_id` (`parent_id`),
  CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Wisata Alam',NULL,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(2,'Wisata Pantai',1,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(3,'Wisata Air Terjun',1,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(4,'Wisata Sungai/Waduk',1,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(5,'Wisata Hutan',1,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(6,'Wisata Pegunungan/Bukit',1,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(7,'Wisata Goa',1,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(8,'Hiburan Keluarga',NULL,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(9,'Taman Bermain',8,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(10,'Wahana Air',8,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(11,'Kebun Binatang',8,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(12,'Pantai Parangtritis',NULL,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(13,'Info Pantai',12,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(14,'Aktivitas Pantai',12,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(15,'Penginapan',NULL,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(16,'Hotel',15,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(17,'Villa',15,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(18,'Homestay',15,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(19,'Transportasi',NULL,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(20,'Sewa Motor',19,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(21,'Sewa Mobil',19,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(22,'Ojek Wisata',19,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(23,'Kuliner',NULL,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(24,'Cafe & Resto',23,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(25,'Kuliner Tradisional',23,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(26,'Street Food',23,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(27,'Blog & Informasi',NULL,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(28,'Tips Wisata',27,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(29,'Berita',27,'2026-05-02 21:29:28','2026-05-02 21:29:28'),(30,'Panduan',27,'2026-05-02 21:29:28','2026-05-02 21:29:28');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deskripsi_kotas`
--

DROP TABLE IF EXISTS `deskripsi_kotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deskripsi_kotas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deskripsi_kotas`
--

LOCK TABLES `deskripsi_kotas` WRITE;
/*!40000 ALTER TABLE `deskripsi_kotas` DISABLE KEYS */;
INSERT INTO `deskripsi_kotas` VALUES (1,'1778427076_deskripsi_kota_jogja1.jpg','Sebagai satu-satunya kota kerajaan Indonesia yang masih berada di bawah pemerintahan monarki, Yogyakarta dianggap sebagai pusat penting seni dan budaya klasik Jawa, seperti tari, tekstil batik, drama, sastra, musik, puisi, seni ukir perak, seni rupa, dan pertunjukan wayang. Dikenal sebagai pusat pendidikan Indonesia, Yogyakarta menjadi rumah bagi populasi mahasiswa yang besar dan puluhan sekolah dan universitas, termasuk Universitas Gadjah Mada, institusi pendidikan tinggi terbesar di negara ini dan salah satu yang paling bergengsi. Yogyakarta adalah ibu kota Kesultanan Yogyakarta dan pernah menjadi ibu kota Indonesia dari tahun 1946 hingga 1948 selama Revolusi Nasional Indonesia, dengan Gedung Agung sebagai kantor presiden. Salah satu distrik di bagian tenggara Yogyakarta, Kotagede, adalah ibu kota Kesultanan Mataram antara tahun 1587 dan 1613.','2026-05-10 08:28:23','2026-05-10 08:31:16');
/*!40000 ALTER TABLE `deskripsi_kotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_05_01_131213_create_wisatas_table',1),(6,'2026_05_03_040615_add_sosmed_to_wisatas_table',2),(7,'2026_05_03_055033_add_slug_to_wisatas_table',3),(8,'2026_05_03_124752_add_link_sumber_to_wisatas_table',4),(9,'2026_05_04_000001_create_pamflets_table',5),(10,'2026_05_04_000002_add_populer_to_wisatas_table',5),(11,'2026_05_04_120000_add_rincian_fasilitas_to_wisatas_table',6),(12,'2026_05_04_120001_rename_rincian_fasilitas_to_rincian_penginapan',7),(13,'2026_05_05_000001_add_tampil_home_to_wisatas_table',8),(14,'2026_05_08_000001_create_ulasans_table',9),(15,'2026_05_10_000001_create_deskripsi_kotas_table',10),(16,'2026_05_12_000001_add_urutan_subkategori_to_wisatas_table',11),(17,'2026_06_15_000000_add_performance_indexes',12);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pamflets`
--

DROP TABLE IF EXISTS `pamflets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pamflets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pamflets`
--

LOCK TABLES `pamflets` WRITE;
/*!40000 ALTER TABLE `pamflets` DISABLE KEYS */;
INSERT INTO `pamflets` VALUES (13,'1778203738_pamflet_promo8.jpg',1,'2026-05-05 07:07:23','2026-06-16 22:14:21'),(14,'1777990054_pamflet_promo4.jpg',2,'2026-05-05 07:07:34','2026-06-16 22:14:21'),(16,'1778203710_pamflet_promo5.jpg',3,'2026-05-07 18:28:30','2026-06-16 22:14:21');
/*!40000 ALTER TABLE `pamflets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ulasans`
--

DROP TABLE IF EXISTS `ulasans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ulasans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wisata_id` bigint(20) unsigned NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `teks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ulasans_wisata_status` (`wisata_id`,`status`),
  CONSTRAINT `ulasans_wisata_id_foreign` FOREIGN KEY (`wisata_id`) REFERENCES `wisatas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ulasans`
--

LOCK TABLES `ulasans` WRITE;
/*!40000 ALTER TABLE `ulasans` DISABLE KEYS */;
INSERT INTO `ulasans` VALUES (3,18,'eky',5,'cakep',NULL,NULL,NULL,6,'approved','2026-05-08 21:29:47','2026-06-16 22:18:17'),(4,18,'Edoo',4,'Pingin balik lagi','1778301059_ulasan_1_pantai2.jpg',NULL,NULL,3,'approved','2026-05-08 21:30:59','2026-06-16 22:18:17'),(5,18,'chicko',5,'Tempatnya bagus sekalii','1778302189_ulasan_1_pantai6.jpg',NULL,NULL,4,'approved','2026-05-08 21:49:49','2026-06-16 22:18:17'),(6,18,'chicko',5,'Tempatnya bagus sekalii','1778302513_ulasan_foto1_pantai6.jpg',NULL,NULL,2,'approved','2026-05-08 21:55:13','2026-06-16 22:18:17'),(7,18,'cherris',5,'suka banget','1778302555_ulasan_foto1_pantai3.jpg',NULL,NULL,7,'approved','2026-05-08 21:55:55','2026-06-16 22:18:17'),(8,20,'nancy',5,'suka banget sama pantainya','1778429770_ulasan_foto1_IMG_3386.jpeg',NULL,NULL,1,'approved','2026-05-10 09:16:10','2026-05-10 09:16:39'),(9,42,'Jessica',5,'Cafenya cekp banget, kalau ke jogja mau balik lagi kesini','1778584317_ulasan_foto1_0bccf5caef9545853d362fa6c3a5a007.jpg',NULL,NULL,1,'approved','2026-05-12 04:11:57','2026-05-12 04:12:22'),(10,14,'anjing',4,'waoww','1780565403_ulasan_foto1_GAMBAR 1.png',NULL,NULL,1,'approved','2026-06-04 02:30:03','2026-06-04 02:30:40'),(11,20,'IKa',5,'baguss banget sukaaaa',NULL,NULL,NULL,2,'approved','2026-06-15 02:10:11','2026-06-15 02:10:11'),(12,18,'BAGUS',4,'CAKEP',NULL,NULL,NULL,8,'approved','2026-06-15 02:11:59','2026-06-16 22:18:17'),(13,18,'edo',4,'suka banget sama pantai ini',NULL,NULL,NULL,1,'approved','2026-06-15 02:13:01','2026-06-16 22:18:17'),(14,18,'eka',5,'pantainya cakep parah',NULL,NULL,NULL,5,'approved','2026-06-15 02:17:27','2026-06-16 22:18:17'),(15,20,'jericho',5,'bakalan balik lagi kesini',NULL,NULL,NULL,3,'pending','2026-06-15 02:18:42','2026-06-15 02:18:42'),(16,47,'Renalt',5,'Pantai ini cakep sekali','1781673034_ulasan_foto1_parangtritis.png',NULL,NULL,1,'approved','2026-06-16 22:10:34','2026-06-16 22:11:11');
/*!40000 ALTER TABLE `ulasans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@gmail.com',NULL,'$2y$10$PPd.IQMasL2crRIFzdYlpu9maog8y46XhqSX8yeZzRByqTqGBWH6u','4qFUMasqGlHcT3ACzpMZMkpxsQV85cXSteXAAGppEnpjhx5HCL7FHzgYTQOf','2026-05-01 10:29:50','2026-06-15 01:45:30'),(2,'admin1','admin1@gmail.com',NULL,'$2y$10$MVzG1xHjnlnGTzc1RM.Kqu6BfMP8g2JbxOgUxNO6fSsJkR89m1BeW','Zs9kT04FUx0Rs63hqyDPrSROcUbUdvlRuBuYu3jbO9HIeR4OglyXF63BeQrq','2026-05-31 03:28:15','2026-06-15 01:45:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wisatas`
--

DROP TABLE IF EXISTS `wisatas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wisatas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `nama_wisata` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_buka` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_tutup` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_tiket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fasilitas` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rincian_penginapan` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya_parkir` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya_penginapan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_tiket_tambahan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_gmaps` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ulasan_raw` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_navigasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_sumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_populer` tinyint(1) NOT NULL DEFAULT 0,
  `urutan_populer` int(11) DEFAULT NULL,
  `urutan_subkategori` int(11) DEFAULT NULL,
  `tampil_home` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wisatas_slug_unique` (`slug`),
  KEY `wisatas_category_id_foreign` (`category_id`),
  KEY `idx_wisatas_tampil_home` (`tampil_home`),
  KEY `idx_wisatas_is_populer` (`is_populer`),
  CONSTRAINT `wisatas_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wisatas`
--

LOCK TABLES `wisatas` WRITE;
/*!40000 ALTER TABLE `wisatas` DISABLE KEYS */;
INSERT INTO `wisatas` VALUES (14,16,'The Alana Hotel & Conference Center Malioboro Yogyakarta by ASTON','the-alana-hotel-conference-center-malioboro-yogyakarta-by-aston-280','1777815839_gambar1_hotel1.jpg','1777815839_gambar2_hotel2.jpg','1777815839_gambar3_hotel3.jpg','',NULL,NULL,'Rp. 450.000 - Rp. 1.000.000','Ac, Tirai Blackout, Air Panas, Shower, Televisi, Desk, Brankas dalam kamar, Hair dryer',NULL,'',NULL,NULL,'Sleman, Yogyakarta','https://maps.app.goo.gl/KEymA93BBh2zjJ149','@alanahotel','82882928291',NULL,NULL,NULL,NULL,'Amalia|5|Hotel bintang 5 terdebest yang perna ada di yogyakarta',NULL,NULL,0,NULL,1,1,'2026-05-03 06:43:59','2026-05-12 23:06:28'),(15,21,'Sewa Mobil Renalt','sewa-mobil-renalt-273','1777818091_gambar1_mobil1.jpg','1777818091_gambar2_mobil2.jpg','1777818091_gambar3_mobil3.jpg','',NULL,NULL,'Rp. 250.000/24jam - Rp. 5.000.000/24jam','Asuransi kecelakaan, Peralatan darurat, Admin 24jam, Layanan antar jemput, Tisu dan air mineral',NULL,'',NULL,NULL,'Sleman, Yogyakarta','https://maps.app.goo.gl/KEymA93BBh2zjJ149','@Permatamobil','8181818818181','@permatamobil',NULL,NULL,NULL,'Kenny|5|Pelayanannya cakep',NULL,NULL,0,NULL,NULL,1,'2026-05-03 07:21:31','2026-05-07 18:23:59'),(16,25,'Sate Ratu','sate-ratu-592','1777869494_gambar1_sate3.jpg','1777869700_gambar2_sate2.jpg','1777869700_gambar3_sate3.jpg','','07:00 WIB','22:00 WIB','Rp. 15.000 - Rp. 70.000','Free Wifi, Kamar Mandi, Self Service, Mushola',NULL,'',NULL,'Tutup Setiap Senin dan Hari Libur Nasional','Sleman, Yogyakarta','https://maps.app.goo.gl/KEymA93BBh2zjJ149','@sateratuyk','081927364527','@sateratuyk','@sateratuyk','@sateratuyk','@sateratuyk','Kenn|5|Jujur uwenak banget\r\nIbas|4|lovee banget\r\nNancy|5|Typical sate favoriteku\r\nGordard|5|Jujur kalau ke jogja aku bakalan balik lagi sih ini, sate terenak yang perna aku makan',NULL,NULL,1,6,NULL,1,'2026-05-03 21:38:14','2026-05-09 00:05:19'),(17,28,'10 Tips Liburan ke Jogja bagi Pemula agar Tetap Hemat dan Nyaman','10-tips-liburan-ke-jogja-bagi-pemula-agar-tetap-hemat-dan-nyaman-820','1777888182_gambar1_blog&info1.png',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Traveloka.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://www.traveloka.com/id-id/explore/destination/pl-tips-liburan-ke-jogja-bagi-pemula/174121','https://www.traveloka.com/id-id/explore/destination/pl-tips-liburan-ke-jogja-bagi-pemula/174121',0,NULL,NULL,1,'2026-05-04 02:49:42','2026-05-12 23:20:47'),(18,2,'Pantai Raja Ampat','pantai-raja-ampat-429','1777891627_gambar1_pantai1.jpg','1777891627_gambar2_pantai2.jpg','1777891627_gambar3_pantai3.jpg','Pantai Papuma, yang terletak di Jember, Jawa Timur, merupakan salah satu destinasi wisata alam yang menawarkan keindahan eksotis. Pantai ini dikenal dengan pasir putihnya yang lembut, ombak yang cukup besar, serta deretan batu karang unik yang menjulang di tengah laut. Nama Papuma sendiri merupakan singkatan dari “Pasir Putih Malikan.” Selain menikmati pemandangan, pengunjung juga dapat melihat aktivitas nelayan atau menjelajahi area sekitar yang masih asri. Fasilitas di Pantai Papuma cukup lengkap, mulai dari penginapan hingga warung makan. Keindahan matahari terbit dan terbenam di pantai ini menjadi daya tarik utama bagi wisatawan lokal maupun mancanegara','06:00 WIB','20:00 WIB','Rp. 50.000/orang','Kamar Mandi Umum, Tim Sar, Gazebo, Pujasera, Mushola, Penginapan= Range Rp. 200.000 - Rp. 500.000/malam','hai\r\nhalo','Parkir Mobil=Rp. 5000\r\nParkir Motor=Rp. 2000\r\nParkir Bus/ELF=Rp. 10.000',NULL,'Asurnsi=Rp. 5000','Parantritis, Yogyakarta','https://maps.app.goo.gl/KEymA93BBh2zjJ149','@pantaipapuma','081245671827',NULL,NULL,NULL,'@pantaipapuma','amelia|5|cakep',NULL,NULL,1,1,1,1,'2026-05-04 03:47:07','2026-05-12 22:46:36'),(19,9,'Obelix Sea View','obelix-sea-view-261','1777902403_gambar1_hiburankel1.jpg','1777902403_gambar2_hiburankel2.jpg','1777902403_gambar3_hiburankel3.jpg','Obelix Sea View merupakan salah satu destinasi wisata populer di Yogyakarta yang menawarkan panorama laut dari ketinggian. Terletak di kawasan Gunungkidul, tempat ini menyuguhkan pemandangan langsung ke Samudra Hindia dengan suasana yang menenangkan dan eksotis. Daya tarik utamanya adalah keindahan sunset yang terlihat jelas dari atas tebing, menjadikannya spot favorit bagi wisatawan. Selain itu, tersedia berbagai fasilitas modern seperti restoran, infinity pool, amphitheater, serta spot foto Instagramable. Kombinasi antara keindahan alam dan konsep wisata kekinian menjadikan Obelix Sea View cocok untuk bersantai, berlibur, maupun menikmati pengalaman visual yang berkesan.','06:00 WIB','01:00 WIB','Rp. 30.000','Kamar Mandi, Wifi, View Yogyakarta 360 derajat, Penginapan=Range Rp.200.000-Rp. 700.000/malam, Sewa Mobil=Range Rp.350.000-Rp. 3.000.000/24jam',NULL,'Mobil= Rp.5000\r\nMotor= Rp.2000\r\nBus/ELF= Rp. 10.000',NULL,NULL,'Sleman, Yogyakarta','https://maps.app.goo.gl/CtBHtms5PgqVgRo56','@obelixseaview','091829384859','@obelixseaview','@obelixseaview','@obelixseaview','@obelixseaview','Amelia|5|Obelix Sea View punya pemandangan yang benar-benar stunning, terutama saat sunset. Dari atas tebing, kita bisa lihat laut lepas dengan warna langit yang cantik banget.\r\nJerremy|4|Saya datang sore hari dan suasananya sangat nyaman. Infinity pool dan amphitheater jadi daya tarik utama di sini. Makan di restoran sambil lihat laut itu pengalaman yang memorable.\r\nKenny|4|View-nya bagus banget, tapi akses ke lokasi cukup menantang karena jalanan menanjak dan agak sempit. Selain itu, saat ramai, area parkir bisa penuh dan perlu menunggu. Tapi setelah sampai, semua terbayar dengan pemandangan yang indah dan banyak spot menarik.\r\nJhordania|5|Tempatnya memang cantik, tapi menurut saya harga makanan dan tiket agak mahal untuk fasilitas yang didapat. Pelayanan juga masih bisa ditingkatkan, terutama saat kondisi ramai.',NULL,NULL,1,3,NULL,1,'2026-05-04 06:46:43','2026-05-09 00:05:19'),(20,2,'Pantai Papuma','pantai-papuma-686','1777903887_gambar1_pantai2.jpg','1777903887_gambar2_pantai1.jpg','1777903887_gambar3_pantai3.jpg','Pantai Papuma, yang terletak di Jember, Jawa Timur, merupakan salah satu destinasi wisata alam yang menawarkan keindahan eksotis. Pantai ini dikenal dengan pasir putihnya yang lembut, ombak yang cukup besar, serta deretan batu karang unik yang menjulang di tengah laut. Nama Papuma sendiri merupakan singkatan dari “Pasir Putih Malikan.” Selain menikmati pemandangan, pengunjung juga dapat melihat aktivitas nelayan atau menjelajahi area sekitar yang masih asri. Fasilitas di Pantai Papuma cukup lengkap, mulai dari penginapan hingga warung makan. Keindahan matahari terbit dan terbenam di pantai ini menjadi daya tarik utama bagi wisatawan lokal maupun mancanegara','06:00 WIB','22:00 WIB','Rp. 50.000/orang','Area Parkir, Kamar Mandi Umum, Tim Sar, Gazebo, Pujasera, Mushola, Penginapan= Range Rp. 200.000 - Rp. 500.000/malam',NULL,'Parkir Mobil=Rp. 5000\r\nParkir Motor=Rp. 2000\r\nParkir Bus/ELF=Rp. 10.000',NULL,'Asurnsi=Rp. 5000','Parantritis, Yogyakarta','https://maps.app.goo.gl/nfccUJdhKgVnFCp7A','@pantaipapuma','098162785167','@pantaipapuma','@pantaipapuma','@pantaipapuma',NULL,'Kenny|5|Pantai Papuma punya pemandangan yang sangat indah dengan pasir putih yang bersih dan laut yang jernih.\r\nClarice|5|Saya datang pagi hari dan suasananya masih sepi, jadi terasa lebih nyaman. Dari atas bukit, pemandangannya luar biasa, laut terlihat hijau kebiruan seperti zamrud.\r\nXlerry|5|Pantainya memang cantik dan fasilitasnya cukup lengkap, bahkan ada penginapan dan tempat makan. Tapi akses menuju lokasi agak menantang karena jalannya menanjak dan berliku. Meski begitu, setelah sampai, pemandangannya benar-benar worth it.\r\nJho|5|Tempatnya bagus, tapi saat ramai suasananya jadi kurang nyaman. Area parkir bisa penuh dan beberapa fasilitas terasa kurang terawat. Selain itu, ombak di beberapa area cukup besar, jadi harus lebih hati-hati saat bermain air.',NULL,NULL,1,5,2,1,'2026-05-04 07:11:27','2026-05-12 22:46:36'),(21,3,'Air Terjun Jiguan','air-terjun-jiguan-142','1777973157_gambar1_airterjun1.jpg','1777973157_gambar2_airterjun2.jpg','1777973157_gambar3_airterjun3.jpg','Air terjun merupakan salah satu keajaiban alam yang menawarkan pemandangan menenangkan sekaligus menyegarkan. Aliran air yang jatuh dari ketinggian menciptakan suara gemericik yang khas, memberikan efek relaksasi bagi siapa saja yang berkunjung. Dikelilingi pepohonan hijau dan udara yang sejuk, suasana di sekitar air terjun terasa alami dan jauh dari hiruk-pikuk kota. Percikan air yang halus juga menambah kesan segar, terutama saat terkena sinar matahari yang membentuk pelangi kecil. Keindahan ini menjadikan air terjun sebagai destinasi favorit untuk healing, fotografi, maupun sekadar menikmati ketenangan alam.','08:00 WIB','16:00 WIB','Rp. 7000','Mushola, Kamar Mandi=Rp. 2000, Tim Sar, Warung',NULL,'Parkir Mobil=Rp. 5000\r\nParkir Motor=Rp. 2000\r\nParkir Elf/Bus=Rp. 10.000',NULL,'Asuransi=Rp. 5000','Sleman, Yogyakarta','https://maps.app.goo.gl/ogEx1vob1PwSigL6A','@airterjunjiguan','091827384728','@airterjunjiguan',NULL,'@airterjunjiguan','@airterjunjiguan','Edward|5|Air terjunnya sangat indah dan masih alami. Suara air yang jatuh bikin suasana jadi tenang dan cocok untuk melepas penat. Tempatnya juga bersih dan udaranya segar banget.\r\nIvory|5|Pemandangan di sekitar air terjun luar biasa, banyak spot foto yang cantik. Airnya jernih dan dingin, cocok untuk bermain air atau sekadar menikmati suasana alam.\r\nErnando|5|Tempatnya memang indah, tapi akses menuju lokasi cukup melelahkan karena harus trekking cukup jauh. Namun, rasa lelah langsung terbayar saat melihat keindahan air terjunnya.\r\nDerrel|3|Air terjunnya bagus, tapi fasilitas di sekitar masih kurang memadai. Saat ramai, area jadi agak kotor dan kurang terkelola dengan baik.',NULL,NULL,1,4,1,1,'2026-05-05 02:25:57','2026-05-12 05:59:57'),(22,10,'Taman Sari Yogyakarta','taman-sari-yogyakarta-535','1778204469_gambar1_Waterpark2.jpg','1778204469_gambar2_waterpark1.jpg','1778204469_gambar3_waterpark3.jpg','Taman Sari merupakan salah satu destinasi wisata bersejarah di Yogyakarta yang dikenal sebagai “Water Castle” peninggalan Kesultanan Yogyakarta. Tempat ini dibangun pada masa Sri Sultan Hamengkubuwono I dan dahulu digunakan sebagai tempat rekreasi, pemandian, serta area peristirahatan keluarga kerajaan. Taman Sari memiliki arsitektur unik yang memadukan gaya Jawa dan Eropa, sehingga memberikan suasana klasik dan estetik. Kompleks ini terdiri dari kolam pemandian, lorong bawah tanah, hingga bangunan bersejarah yang masih terawat dengan baik. Selain menjadi objek wisata budaya, Taman Sari juga populer sebagai spot fotografi karena keindahan arsitektur dan nilai sejarahnya yang khas.','07:00 WIB','17:00 WIB','Rp. 50.000/orang','Kamar Mandi, Persewaan Ban=Range Rp. 5000 - Rp. 50.000/2jam, Kantin, Playground, Hall, Banyak Varian Seluncuran, Penjaga Waterpark',NULL,'Mobil=Rp. 5000\r\nMotor=Rp. 2000\r\nBus/ELF=Rp. 10.000',NULL,'Asuransi=Rp. 10.000','Sleman, Yogyakarta','https://maps.app.goo.gl/cEPgbgSWc9c6SrmZ7','@tamansariyk','081273829371','@tamansariyk','@tamansariyk','@tamansariyk','@tamansariyk','Amelia|4|Tempatnya bagus banyak banget wahana permainannya\r\nKenny|5|Tempatnya seruh cocok kesini bareng bareng teman\r\nEdo|4|Tempatnya luar biasa seruhnya, baklan balik lagi\"\r\nNancy|5|Tempatnya cocok untuk healing',NULL,NULL,1,7,1,1,'2026-05-07 18:41:09','2026-05-12 23:06:05'),(24,4,'Kali Kuning','kali-kuning-208','1778205804_gambar1_sunga1.jpg','1778205804_gambar2_sungai2.jpg','1778205804_gambar3_sungai3.jpg','Kali Kuning merupakan salah satu destinasi wisata alam di Yogyakarta yang terletak di kawasan lereng Gunung Merapi. Tempat ini menawarkan suasana sejuk dengan aliran sungai yang jernih, pepohonan hijau, dan pemandangan alam yang menenangkan. Kali Kuning dikenal sebagai lokasi favorit untuk camping, tracking, piknik, hingga kegiatan outbound karena memiliki area terbuka yang luas dan udara yang segar. Selain itu, wisata ini juga menjadi salah satu spot terbaik untuk menikmati panorama Gunung Merapi dari jarak yang cukup dekat. Keindahan alamnya yang masih asri membuat Kali Kuning cocok dijadikan tempat healing dan melepas penat dari suasana perkotaan.','06:00 WIB','17:00 WIB','Rp. 5000','Kamar Mandi Umum=Rp. 2000, Tim sar',NULL,'Motor=Rp. 2000\r\nMobil=RP. 5000',NULL,NULL,'Kaliurang, Yogyakarta','https://maps.app.goo.gl/dMhqav8cY6adt8Ss7','@kalikuningyk','081234567891','@kalikuningyk','@kalikuningyk','@kalikuningyk','@kalikuningyk','Amelia|5|Suasananya cakep\r\nNancy|5|Asri banget alamnya\r\nKenn|5|Sungainya deras\r\nEmally|5|Airnya dingin',NULL,NULL,0,NULL,1,0,'2026-05-07 19:03:24','2026-05-12 05:59:59'),(25,5,'Hutan Pinus Pengger','hutan-pinus-pengger-574','1778206100_gambar1_hutan1.jpg','1778206100_gambar2_hutan2.jpg','1778206100_gambar3_hutan3.jpg','Hutan Pinus Pengger merupakan salah satu destinasi wisata alam populer di Yogyakarta yang terkenal dengan suasana hutan pinus yang sejuk dan pemandangan kota dari ketinggian. Terletak di kawasan Dlingo, Bantul, tempat ini menawarkan udara segar serta suasana tenang yang cocok untuk bersantai dan menikmati alam. Hutan Pinus Pengger juga dikenal karena berbagai spot foto artistik dan Instagramable yang dibuat dari susunan kayu dan ranting, terutama saat malam hari dengan latar lampu kota Yogyakarta yang indah. Selain menjadi tempat wisata favorit, lokasi ini juga sering digunakan untuk camping, fotografi, dan menikmati sunset bersama keluarga maupun teman.','06:00 WIB','17:00 WIB','Rp. 10.000','Mushola, Kamar Mandi Umum=Rp. 2000, Banyak Spot foto, Kantin',NULL,'Motor=Rp. 2000',NULL,NULL,'Kab Bantul, Yogyakarta','https://maps.app.goo.gl/FWFa5WcacWEfwwNZ6','@hutanpinuspengger','081234892387','@hutanpinuspengger','@hutanpinuspengger','@hutanpinuspengger','@hutanpinuspengger','Amelia|5|Tempatnya Cakep\r\nNancy|5|Tempatnya sejuk\r\nRenalt|5|Next time harus balik lagi kesini\r\nEdo|5|Asri banget, cocok buat healing',NULL,NULL,0,NULL,NULL,1,'2026-05-07 19:08:20','2026-05-07 19:23:28'),(26,6,'Bukit Bintang','bukit-bintang-767','1778206377_gambar1_bukit1.jpg','1778206377_gambar2_bukit2.jpg',NULL,'Bukit Bintang merupakan salah satu destinasi wisata malam populer di Yogyakarta yang menawarkan pemandangan gemerlap lampu kota dari ketinggian. Terletak di kawasan perbukitan Pathuk, Gunungkidul, tempat ini menjadi favorit wisatawan untuk menikmati suasana malam yang tenang dengan udara sejuk. Dari Bukit Bintang, pengunjung dapat melihat panorama Kota Yogyakarta yang terlihat seperti hamparan bintang, terutama saat cuaca cerah. Selain menikmati pemandangan, terdapat banyak warung dan tempat makan di sepanjang area wisata yang cocok untuk bersantai bersama teman maupun keluarga. Bukit Bintang juga sering dijadikan spot romantis untuk menikmati sunset hingga malam hari.','00:00 WIB','23:59 WIB','Free','Mushola, Kamar Mandi Umum, Indomart',NULL,'Moto=Rp. 2000',NULL,NULL,'Gunungkidul, Yogyakarta','https://maps.app.goo.gl/JfCg2A72mYo8wqjs5','@bukitbintangyk','081236482918','@bukitbintangyk','@bukitbintangyk','@bukitbintangyk','@bukitbintangyk','Amelia|5|Bukitnya cakep banget suka\r\nXlerry|5|Pemadangannya mantab\r\nJerry|5|Suasananya syahdu\r\nErigo|5|Disini tempatnya tenang',NULL,NULL,0,NULL,NULL,0,'2026-05-07 19:12:57','2026-05-07 19:12:57'),(27,7,'Goa Pindul','goa-pindul-420','1778206671_gambar1_Goa2.jpg','1778206671_gambar2_goa1.jpg','1778206671_gambar3_goa3.jpg','Goa Pindul merupakan salah satu destinasi wisata alam terkenal di Yogyakarta yang menawarkan pengalaman menyusuri gua menggunakan ban pelampung atau dikenal dengan aktivitas cave tubing. Terletak di kawasan Gunungkidul, Goa Pindul memiliki aliran sungai bawah tanah dengan air yang jernih serta suasana gua yang sejuk dan alami. Pengunjung dapat menikmati keindahan stalaktit dan stalagmit yang terbentuk secara alami di dalam gua, termasuk stalaktit besar yang menjadi daya tarik utama. Selain cave tubing, wisatawan juga dapat menikmati aktivitas lain seperti river tubing dan eksplorasi alam sekitar. Keunikan suasana petualangan dan keindahan alam membuat Goa Pindul menjadi destinasi favorit wisatawan lokal maupun mancanegara.','07:00 WIB','17:00 WIB','Rp. 10.000','Mushola, Gazebo, Kantin, Tim Sar, Kamar bilas, Rest area',NULL,'Motor=Rp. 2000\r\nMobil=Rp. 5000\r\nBus/ELF=Rp. 10.000',NULL,'Asuransi=Rp. 5000','GunungKidul, Yogyakarta','https://maps.app.goo.gl/1gaJyT8Vd5MrGXR3A',NULL,NULL,NULL,NULL,NULL,NULL,'Jyco|5|Tempatnya cocok buat explore alam\r\nEric|5|Tempatnya menantang\r\nIgo|5|Tempatnya ngga kalah keren dari tempat lain\r\nChika|5|Wajib balik kesini ini mah',NULL,NULL,0,NULL,NULL,0,'2026-05-07 19:17:51','2026-05-07 19:17:51'),(28,11,'Gembira Loka Zoo','gembira-loka-zoo-412','1778206961_gambar1_zoo2.jpg','1778206961_gambar2_zoo1.jpg',NULL,'Gembira Loka Zoo merupakan kebun binatang terbesar dan paling populer di Yogyakarta yang menjadi destinasi wisata edukasi sekaligus rekreasi bagi keluarga. Tempat ini memiliki koleksi berbagai jenis satwa dari dalam maupun luar negeri, seperti gajah, harimau, orangutan, reptil, hingga aneka burung eksotis. Selain melihat satwa, pengunjung juga dapat menikmati berbagai fasilitas dan wahana seperti perahu kayuh, kereta mini, feeding animals, serta area bermain anak. Lingkungan kebun binatang yang hijau dan tertata membuat suasana terasa nyaman untuk berwisata. Gembira Loka Zoo tidak hanya menjadi tempat hiburan, tetapi juga berperan dalam edukasi dan konservasi satwa bagi masyarakat.','08:00 WIB','17:00 WIB','Rp. 50.000','Mushola, Gazebo, Rest Area, Kamar Mandi Umum, Pemandu, Scooter',NULL,'Mobil=Rp. 5000\r\nMotor=Rp. 2000\r\nBus/ELF=Rp. 10.00',NULL,NULL,'kotagede, Yogyakarta','https://maps.app.goo.gl/LYQwrWnbzMUw3PpQ7','@gembiralokazooyk','0912349182738','@gembiralokazooyk','@gembiralokazooyk','@gembiralokazooyk','@gembiralokazooyk','Caira|5|Tempatnya bagus\r\nJurry|5|tempatnya cocok buat ngedate\r\nIcha|5|Tempatnya bikin aku happy\r\nIlu|5|Tempatnya cocok buat family time',NULL,NULL,0,NULL,NULL,1,'2026-05-07 19:22:41','2026-05-07 19:23:17'),(29,17,'Bohemian Jogja Villas','bohemian-jogja-villas-902','1778207963_gambar1_villa1.jpg','1778207963_gambar2_villa2.jpg',NULL,'',NULL,NULL,'Rp. 1.500.000 - 2.000.000/malam','Wifi, Hair dryer, Air Conditioner, Minibar, Water Heater, Private bathroom',NULL,'',NULL,NULL,'Sleman, Yogyakarta','https://maps.app.goo.gl/SJR4Jn4uea8y6Wdm7?g_st=ic','@bohemianvillas','081236471829','@bohemianvillas','@bohemianvillas','@bohemianvillas','@bohemianvillas','Chico|5|Tempatnya bohemian banget\r\nEdward|5|Tempatnya cocok untul family time\r\nIvory|5|Tempatnya berasa stay di luar negeri\r\nObvy|5|Tempatnya ga kalah bohemian sama kayak yang lain',NULL,NULL,0,NULL,NULL,1,'2026-05-07 19:39:23','2026-05-07 19:49:26'),(30,18,'Bring in Homestay','bring-in-homestay-479','1778208283_gambar1_homestay1.jpg','1778208283_gambar2_homestay2.jpg',NULL,'',NULL,NULL,'Rp. 500.000 - Rp. 1.000.000/malam','Wifi, Private Pool, Bathroom nature, hair dryer, Water heater, Mini pantry',NULL,'',NULL,NULL,'Mantrijeron, Kota Yogyakart','https://maps.app.goo.gl/tyGkrhULTUSpCzQV7','@bringinhomestayyk','081237482937','@bringinhomestayyk','@bringinhomestayyk','@bringinhomestayyk','@bringinhomestayyk','Briella|5|Tempatnya cocok banget untuk honeymoon\r\nJessica|5|Ini mah bukan homestay, tapi udah kayak villa\r\nPutri|5|tempatnya cocok buat staycation bareng keluarga\r\nKorry|5|Tempatnya nyaman dan asri',NULL,NULL,0,NULL,NULL,1,'2026-05-07 19:44:43','2026-05-07 19:49:28'),(31,16,'Yogyakarta Marriot Hotel','yogyakarta-marriot-hotel-334','1778208561_gambar1_hotel4.jpg','1778208561_gambar2_hotel5.jpg',NULL,'',NULL,NULL,'Rp. 2.000.000 - Rp. 20.000.000/malam','Wifi, Private Pool, infinity pool, Hair dryer, Hall, Gym, Spa, Sauna',NULL,'',NULL,NULL,'Depok, Yogyakarta','https://maps.app.goo.gl/Y6vLfvkcqj7PN8Hj8','@jwmarriotyk','081293874627','@jwmarriotyk','@jwmarriotyk','@jwmarriotyk','@jwmarriotyk','Vior|5|Tempatnya sesuai dengan harganya\r\nDior|5|Tempatnya sangat nyaman sekali\r\nPiyo|5|Memang cocok 5 star ni hotel\r\njibran|5|Servicenya suka helpful banget',NULL,NULL,0,NULL,2,1,'2026-05-07 19:49:21','2026-05-12 23:06:28'),(32,20,'Global Yogya Rent','global-yogya-rent-413','1778208863_gambar1_motor1.jpg','1778208863_gambar2_motor2.jpg',NULL,'',NULL,NULL,'Rp.100.000 - Rp. 1.000.000/24jam','Helm 2, Jas Hujan 2, Ada holder hp, Kunci ganda, Admin 24h',NULL,'',NULL,NULL,'Danurejan, Yogyakarta','https://maps.app.goo.gl/5tr3rQbLK2cKoFKd6','@globalykrent','0812937182936','@globalykrent','@globalykrent','@globalykrent','@globalykrent','Ifa|5|Layanannya mantab, bakalan repeat rent\r\nOdoo|5|Motornya bagus bagus\r\nDella|5|Harga sewanya sesuai dengan kualitas motor\r\nEva|5|Banyak pilihan sehingga ngga takut kehabisan pilihan motor buat sewa',NULL,NULL,0,NULL,NULL,1,'2026-05-07 19:54:23','2026-05-07 20:00:32'),(33,22,'Campa Tour','campa-tour-253','1778209217_gambar1_trip1.jpg','1778209217_gambar2_trip2.jpg',NULL,'',NULL,NULL,'Rp. 300.000 - Rp. 500.000','Professional Guide, P3K, Asuransi, Antar Jemput, Service Makan 2x= Tergantung Trip kemana',NULL,'',NULL,NULL,'Sleman, Yogyakarta','https://maps.app.goo.gl/p58gcWEvSZr7GZB26','@campatouryk','08123476593','@campatouryk','@campatouryk','@campatouryk','@campatouryk','Jerricho|5|Bakal balik lagi pakai jasa ini\r\nClarice|5|Semua guidenya professional\r\nJimpa|5|Next time bakal private trip\r\nEjik|5|Bakal ngajak sama temen pakai trip ini lagi',NULL,NULL,0,NULL,NULL,1,'2026-05-07 20:00:17','2026-05-07 20:00:29'),(34,21,'Jogja Empat Roda','jogja-empat-roda-630','1778209583_gambar1_mobil4.jpg','1778209583_gambar2_mobil5.jpg',NULL,'',NULL,NULL,'Rp. 1.000.000 - Rp. 12.000.000/24jam','Admin 24h, Dongkrak otomatis, Layanan antar jemput, Layanan private rental',NULL,'',NULL,NULL,'Sleman, Yogyakarta','https://maps.app.goo.gl/J2QxALp33xPsp1MW7','@Jogjaempatrodayk','0812934618932','@Jogjaempatrodayk',NULL,'@Jogjaempatrodayk','@Jogjaempatrodayk','Jirro|5|Bakalan sewa mobil disini lagi, pilihannya bagus bagus\r\nEbvory|5|Mobilnya cakep cakep, bakalan repeat rent disini\r\nGordard|5|Pelayanannya puas banget, bahkan pas mobil mogok di derek sama pihak rental\r\nSheva|5|Semua pilihan mobilnya banyak',NULL,NULL,0,NULL,NULL,1,'2026-05-07 20:06:23','2026-05-07 20:06:28'),(35,24,'Mediterranea Restaurant by Kamil','mediterranea-restaurant-by-kamil-505','1778210012_gambar1_resto3.jpg','1778210012_gambar2_resto1.png',NULL,'','07:00 WIB','22:00 WIB','Rp. 40.000 - Rp. 2.000.000','Mushola, Free Wifi, Alcohol, Private Dining, Metting Area= Range Rp. 1.000.000 - Rp. 2.000.000',NULL,'',NULL,'Tutup Hari Libur Nasional, Minggu buka','Mantrijeron, Yogyakarta','https://maps.app.goo.gl/jRWwP1zLzX8kDrj78','@Mediterranea','081928374682','@Mediterranea','@Mediterranea','@Mediterranea','@Mediterranea',NULL,NULL,NULL,0,NULL,4,0,'2026-05-07 20:13:32','2026-05-12 22:41:14'),(36,24,'Kalluna Cafe Yogyakarta','kalluna-cafe-yogyakarta-807','1778210328_gambar1_cafe1.jpg','1778210328_gambar2_cafe2.jpg',NULL,'','09:00 WIB','23:00 WIB','Rp. 50.000 - Rp. 700.000','Mushola, Kamar Mandi, Free Wifi, Meeting Area, Layanan Antar Jemput',NULL,'',NULL,NULL,'Gondokusuman, Yogyakarta','https://maps.app.goo.gl/YG5yuBzRtVoWpEzdA','@kallunacafeyk','081234672819','@kallunacafeyk','@kallunacafeyk','@kallunacafeyk','@kallunacafeyk','elbarack|5|Bakalan balik ke cafe yang warm ini\r\nEboard|5|Cocok banget kesini pas cuaca summer\r\nGordard|5|Cocok buat makan makan juga sama keluarga\r\nIyuss|5|Bakalan bawa pacar kesini lagi kalau pas ke jogja',NULL,NULL,0,NULL,2,1,'2026-05-07 20:18:48','2026-05-12 22:41:14'),(37,26,'Hongkong Street Food Yogyakarta','hongkong-street-food-yogyakarta-127','1778210614_gambar1_streetfood1.jpg','1778210614_gambar2_streetfood3.jpg',NULL,'','15:00 WIB','00:00 WIB','Rp. 2000 - Rp. 100.000','Mushola, Tenant, Gazebo, Dining Area, Kamar Mandi',NULL,'',NULL,'Tutup setiap hari Senin dan Rabu','Tegalrejo, Yogyakarta','https://maps.app.goo.gl/TjYzgDySywosZkgp9','@hongkongstreetfoodyk','0819272937391','@hongkongstreetfoodyk','@hongkongstreetfoodyk','@hongkongstreetfoodyk','@hongkongstreetfoodyk',NULL,NULL,NULL,0,NULL,NULL,1,'2026-05-07 20:23:34','2026-05-07 20:23:40'),(38,10,'Jogja Bay Waterpark','jogja-bay-waterpark-271','1778211170_gambar1_waterpark4.jpg','1778211170_gambar2_waterpark5.jpg',NULL,'@jogjabaywaterparkyk','07:00 WIB','22:00 WIB','Rp. 50.000 - Rp. 125.000','Gazebo, Kamar bilas, Gazebo, Kantin, Persewaan ban= Rp. 5000 - Rp. 50.000/jam',NULL,'Motor=Rp. 1000\r\nMobil=Rp. 3000\r\nBus/ELF= Rp. 7000',NULL,'Asuransi=Rp. 10.000','Sleman, Yogyakarta','https://maps.app.goo.gl/B8QehSUSQdcExVDG6','@jogjabaywaterparkyk','081927365478','@jogjabaywaterparkyk','@jogjabaywaterparkyk','@jogjabaywaterparkyk','@jogjabaywaterparkyk','Edward|5|Bakalan balik lagi ke waterpark ini sama temen temen\r\nChika|5|Tempatnya luas dan seruh',NULL,NULL,1,2,2,1,'2026-05-07 20:32:50','2026-05-12 23:06:05'),(39,29,'5 Tempat Nongkrong di Kotabaru Yogyakarta','5-tempat-nongkrong-di-kotabaru-yogyakarta-199','1778211706_gambar1_berita3.jpg',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Detik.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://travel.detik.com/domestic-destination/d-8473304/jangan-ke-malioboro-aja-ini-5-tempat-nongkrong-di-kotabaru-jogja','https://travel.detik.com/domestic-destination/d-8473304/jangan-ke-malioboro-aja-ini-5-tempat-nongkrong-di-kotabaru-jogja',0,NULL,2,1,'2026-05-07 20:41:46','2026-05-12 23:23:46'),(40,29,'Situasi Jogja Saat ini, Malioboro Padat','situasi-jogja-saat-ini-malioboro-padat-521','1778211872_gambar1_berita4.jpg',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Detik.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://www.detik.com/jogja/berita/d-8419368/situasi-jogja-sore-ini-malioboro-padat-tugu-keraton-lengang','https://www.detik.com/jogja/berita/d-8419368/situasi-jogja-sore-ini-malioboro-padat-tugu-keraton-lengang',0,NULL,1,1,'2026-05-07 20:44:32','2026-05-12 23:23:45'),(41,30,'Let\'s Go! Tips Liburan ke Yogya, Indonesia','lets-go-tips-liburan-ke-yogya-indonesia-855','1778212005_gambar1_jogja1.jpg',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Traveloka.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://www.traveloka.com/id-id/explore/destination/pl-pt-tips-liburan-yogya/196274','https://www.traveloka.com/id-id/explore/destination/pl-pt-tips-liburan-yogya/196274',0,NULL,NULL,1,'2026-05-07 20:46:45','2026-05-12 23:21:02'),(42,24,'Phoenix Gastrobar by Holywings','phoenix-gastrobar-by-holywings-743','1778496927_gambar1_cafe3.jpg','1778496927_gambar2_cafe4.jpg',NULL,'','00:00 WIB','23:59 WIB','Rp. 50.000 - Rp.3.000.000','Free Wifi, Kamar Mandi, Mushola, Colokan friendly, Vallet',NULL,'',NULL,NULL,'Sleman, Yogyakarta','https://maps.app.goo.gl/uXbSwaX8uhGia8wY6','@phoenixyk','081923847591','@phoenixyk',NULL,'@phoenixyk',NULL,NULL,NULL,NULL,0,NULL,5,1,'2026-05-11 03:55:27','2026-05-12 22:41:14'),(43,25,'The House of Raminten','the-house-of-raminten-422','1778497426_gambar1_kuliner1.jpg','1778497426_gambar2_kuliner2.jpg',NULL,'','00:00 WIB','23:59 WIB','Rp. 2000 - Rp. 100.000','Mushola, Gazebo, Show performance with raminten, DJ',NULL,'',NULL,'open 24h','Sleman, Yogyakarta','https://maps.app.goo.gl/vKEJ1ZdsqeMY6kEbA','@ramintenyk','099182989179',NULL,'@ramintenyk',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'2026-05-11 04:03:46','2026-05-11 04:03:46'),(44,25,'Gudeg Yu Djum Pusat','gudeg-yu-djum-pusat-954','1778498140_gambar1_kuliner1.jpg','1778498140_gambar2_kuliner4.jpg',NULL,'','07:00 WIB','21:00 WIB','Rp. 2000 - Rp. 100.000','Mushola, Gazebo, Kamar mandi, Free Wifi, Cathering',NULL,'',NULL,NULL,'Sleman, Yogyakarta','https://maps.app.goo.gl/7VzM2GXp5vNfjQix5','@gudegyudjum',NULL,'@gudegyudjum','@gudegyudjum','@gudegyudjum','@gudegyudjum',NULL,NULL,NULL,0,NULL,NULL,0,'2026-05-11 04:15:40','2026-05-11 04:15:40'),(45,24,'The Madawa Jogja','the-madawa-jogja-245','1778499080_gambar1_cafe5.jpg','1778499080_gambar2_cafe6.jpg',NULL,'','09:00 WIB','22:00 WIB','Rp. 1.000.000 - Rp. 12.000.000','Private dining room, live music, VIP area, rooftop seating, wine cellar, open kitchen, reservation service, valet parking, free Wi-Fi, air conditioning, aesthetic interior, Vallet',NULL,'',NULL,NULL,'Sleman, Yogyakarta','https://maps.app.goo.gl/7VzM2GXp5vNfjQix5','@themadawayk','091823748593','@themadawayk','@themadawayk',NULL,NULL,NULL,NULL,NULL,0,NULL,1,0,'2026-05-11 04:31:20','2026-05-12 22:41:14'),(46,24,'Mayadaya Palace','mayadaya-palace-849','1778500161_gambar1_cafe7.jpg','1778500161_gambar2_cafe8.jpg',NULL,'','09:00 WIB','22:00 WIB','Rp. 300.000 - Rp. 1.500.000','outdoor seating, smoking area, non-smoking area, bar lounge, meeting room, Instagramable spot, premium table setting, parking area, prayer room, restroom, charging station, romantic dinner setup',NULL,'',NULL,'senin tutup','Kaliurang, Yogyakarta','https://maps.app.goo.gl/7VzM2GXp5vNfjQix5','@mayadayapalace','091827394718','@mayadayapalace',NULL,'@mayadayapalace',NULL,NULL,NULL,NULL,0,NULL,3,0,'2026-05-11 04:49:21','2026-05-12 22:41:14'),(47,2,'Pantai Parangtritis','pantai-parangtritis-737','1781598827_gambar1_parangtritis.png','1781598827_gambar2_parangtritis1.png','1781598827_gambar3_parangtritis2.png','Pantai Parangtritis merupakan salah satu destinasi wisata pesisir paling populer di Yogyakarta, terletak sekitar 27 kilometer di sebelah selatan pusat kota. Pantai ini berbatasan langsung dengan pesisir Samudra Hindia dan terkenal dengan hamparan pasir hitamnya yang luas, deburan ombak yang besar, serta pemandangan bukit pasir atau \"gumuk\" di sekitarnya. Karakteristik ombaknya yang kuat membuat area ini tidak disarankan untuk aktivitas berenang, namun pantai ini tetap menjadi lokasi favorit bagi para wisatawan untuk menikmati pemandangan laut yang indah serta pesona matahari terbenam (sunset).','06:00 WIB','17:00 WIB','Rp. 15.000/orang','Penyewaan ATV dan Jeep Wisata=Range Rp. 50.000 - Rp. 200.000, Kereta Kuda (Bendi)=Rang Rp. 50.000, Payung dan Tikar, Kamar Mandi dan Toilet, Warung Makan dan Pusat Suvenir, Area Parkir Luas, Home Stay',NULL,'Mobil= Rp. 10.00, Motor= Rp. 1.000',NULL,'Termasuk Asuransi Rp. 5.000','Kabupaten Bantul, Yogyakarta','https://www.google.com/maps/place//data=!4m2!3m1!1s0x2e7b00975eac533d:0x351bfe1453e22e36?entry=gemini&utm_source=gemini&utm_campaign=gem-default','@pantaiparangtritisidn','081625437262','@pantaiparangtritisidn','@pantaiparangtritisidn','@pantaiparangtritisidn','@pantaiparangtritisidn',NULL,NULL,NULL,0,NULL,NULL,0,'2026-06-16 01:33:47','2026-06-16 04:16:01'),(48,3,'Air Terjun Sri Gethuk','air-terjun-sri-gethuk-647','1781599409_gambar1_srigethuk.png','1781599409_gambar2_srigethuk1.png',NULL,'Air Terjun Sri Gethuk adalah destinasi wisata alam yang terletak di Dusun Menggoran, Desa Bleberan, Kecamatan Playen, Kabupaten Gunungkidul. Air terjun ini memiliki ketinggian sekitar 50 meter dan mengalir dari tiga mata air alami. Aliran air tersebut jatuh melewati tebing karst dan langsung menuju aliran Sungai Oyo. Debit air di lokasi ini selalu terjaga sehingga area sekitarnya tetap rimbun pada musim kemarau. Kamu harus menyusuri sungai menggunakan rakit tradisional terlebih dahulu untuk mencapai titik utama air terjun.','06:00 WIB','17:00 WIB','Rp. 15.000/orang','Perahu Wisata dan Rakit=Rp. 50.000/antar jemput, Kolam Alami dan Penyewaan Pelampung, Wahana Body Rafting dan Flying Fox, Warung Makan, Kamar Mandi dan Toilet, Penitipan Barang, Area Parkir Luas dan Musala',NULL,'https://maps.app.goo.gl/21JtXSx7QQwV3mv87',NULL,NULL,'Kab. Gunungkidul, Yogyakarta','https://maps.app.goo.gl/21JtXSx7QQwV3mv87','@airterjunsrigethuk','0817263716182','@airterjunsrigethuk','@airterjunsrigethuk','@airterjunsrigethuk','@airterjunsrigethuk',NULL,NULL,NULL,0,NULL,NULL,0,'2026-06-16 01:43:29','2026-06-16 04:17:04'),(49,3,'Air Terjun LEPO Dlingo','air-terjun-lepo-dlingo-574','1781609302_gambar1_airterjunlepodlingo.png','1781609302_gambar2_airterjunlepodlingo1.png',NULL,'Detail Air Terjun Lepo ini sudah terstruktur dan siap kamu ketik ke dalam formulir basis data administratif XPloreJogja. Lokasi air terjun ini berada di Dusun Pokoh I, Kecamatan Dlingo, Kabupaten Bantul. Penduduk setempat mengambil nama Lepo dari singkatan Ledok Pokoh. Jam buka operasional berlaku setiap hari dari pukul 6 pagi hingga 5 sore. Destinasi ini memiliki lanskap tiga tingkat air terjun dengan empat kolam alami. Dinding batu kapur berundak mengelilingi tepian kolam. Kolam paling atas memiliki kedalaman dua meter untuk perenang dewasa. Kolam pada undakan bawah memiliki air yang dangkal. Pengunjung anak kecil bisa bermain air dengan aman di kolam bawah tersebut.','06:00 WIB','17:00 WIB','Rp. 15.000/orang','Penyewaan ban karet dan pelampung, Warung makanan ringan dan minuman, Layanan sewa tikar lantai, Kamar mandi dan toilet bilas, Lahan parkir sepeda motor dan mobil, Mushola, Bangunan aula pertemuan, Gazebo kayu',NULL,'Mobil= Rp. 5000, Motor= Rp. 2000',NULL,'Termasuk Asuransi Rp. 5.000','Kab. Bantu, Yogyakarta','https://maps.app.goo.gl/6V5N2UYqPrkeSxjf6','@airterjunlepodlingo','082125675432','@airterjunlepodlingo','@airterjunlepodlingo','@airterjunlepodlingo','@airterjunlepodlingo',NULL,NULL,NULL,0,NULL,NULL,0,'2026-06-16 04:28:22','2026-06-16 04:28:22');
/*!40000 ALTER TABLE `wisatas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-17 20:07:14
