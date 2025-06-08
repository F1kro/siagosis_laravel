-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: school_management
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `absensi`
--

DROP TABLE IF EXISTS `absensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `absensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `kelas_id` bigint unsigned NOT NULL,
  `mapel_id` bigint unsigned DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alpa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `waktu` time DEFAULT NULL,
  `semester` enum('Ganjil','Genap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `absensi_unique_siswa_tanggal_mapel` (`siswa_id`,`tanggal`,`mapel_id`),
  KEY `absensi_kelas_id_foreign` (`kelas_id`),
  KEY `absensi_mapel_id_foreign` (`mapel_id`),
  CONSTRAINT `absensi_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `absensi_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE SET NULL,
  CONSTRAINT `absensi_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absensi`
--

/*!40000 ALTER TABLE `absensi` DISABLE KEYS */;
INSERT INTO `absensi` VALUES (3,1,1,1,'2025-05-13','Hadir','hadir','10:28:54','Ganjil','2022/2023','2025-05-26 02:28:54','2025-05-26 02:28:54'),(4,1,1,1,'2025-05-26','Izin',NULL,'10:29:08','Ganjil','2022/2023','2025-05-26 02:29:08','2025-05-26 02:29:08'),(5,1,1,1,'2025-06-07','Sakit',NULL,'13:22:37','Ganjil','2022/2023','2025-06-07 05:07:08','2025-06-07 05:22:37'),(6,5,1,1,'2025-06-07','Hadir',NULL,'13:22:37','Ganjil','2022/2023','2025-06-07 05:07:08','2025-06-07 05:22:37'),(7,1,1,1,'2025-06-05','Hadir',NULL,'13:07:59','Ganjil','2022/2023','2025-06-07 05:07:59','2025-06-07 05:07:59'),(8,5,1,1,'2025-06-05','Hadir',NULL,'13:07:59','Ganjil','2022/2023','2025-06-07 05:07:59','2025-06-07 05:07:59'),(9,2,2,2,'2025-06-07','Hadir',NULL,'15:46:22','Ganjil','2022/2023','2025-06-07 07:46:22','2025-06-07 07:46:22');
/*!40000 ALTER TABLE `absensi` ENABLE KEYS */;

--
-- Table structure for table `berita`
--

DROP TABLE IF EXISTS `berita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `berita` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unpublish',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `berita_user_id_foreign` (`user_id`),
  CONSTRAINT `berita_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `berita`
--

/*!40000 ALTER TABLE `berita` DISABLE KEYS */;
INSERT INTO `berita` VALUES (1,'Bapak Budi meninggal dunia , di usia 90 tahun','Perubahan Utama dan Penjelasannya:\r\nNama Variabel Diubah:\r\n\r\nSebelumnya: compact(\'berita\', \'name\')\r\nSekarang: compact(\'beritas\')\r\nAlasan: Ini adalah perubahan paling penting. Di dalam view yang baru, kita menggunakan loop @forelse ($beritas as $berita). Ini adalah konvensi umum di Laravel: variabel yang berisi banyak data (koleksi) diberi nama jamak (plural), seperti $beritas. Kode kamu sebelumnya menggunakan nama tunggal ($berita), yang akan menyebabkan error Undefined variable: beritas di view.\r\nFilter Berdasarkan Status:\r\n\r\nTambahan: ->where(\'status\', \'diterima\')\r\nAlasan: Kemungkinan besar, guru hanya perlu melihat berita yang sudah disetujui dan diterbitkan oleh admin. Baris ini akan memfilter dan hanya menampilkan berita dengan status diterima.\r\nVariabel $name Dihapus:\r\n\r\nSebelumnya: $name = Auth::user()->name;\r\nAlasan: Variabel $name tidak digunakan di dalam view berita yang baru. Menghapusnya membuat kode lebih bersih. Jika kamu ingin menampilkan nama guru yang sedang login di suatu tempat (misalnya di header), kamu bisa memanggil Auth::user()->name langsung di file layout utama.\r\nPenambahan Method show():\r\n\r\nIni adalah method yang diperlukan untuk menangani link \"Baca Selengkapnya\".\r\nIa menggunakan Route Model Binding (Berita $beritum) yang secara ajaib akan mengambil data berita dari database berdasarkan ID yang ada di URL.\r\nMethod ini akan mengembalikan view baru yang harus kamu buat, yaitu guru.berita.show, yang akan menampilkan isi berita secara lengkap.\r\nLangkah Selanjutnya:\r\nPerbarui Rute: Pastikan routes/web.php kamu sudah diubah untuk mengizinkan rute show bagi guru, seperti yang dijelaskan sebelumnya.\r\nBuat View show.blade.php: Buat file baru di resources/views/guru/berita/show.blade.php untuk menampilkan detail berita.','Informasi','berita/G8W8yg7lUWhgqh95o0KzmGczxwpdLss8T0B7KYxC.png',1,'Published','2025-06-04 06:43:50','2025-06-04 06:44:44'),(2,'Top Global Aldous','Artikel \"top global Aldous\" kemungkinan mengacu pada artikel yang membahas tentang Aldous sebagai hero Mobile Legends, khususnya mengenai build item dan strategi yang efektif untuk mencapai tingkat permainan tertinggi (top global). Aldous dikenal sebagai hero yang kuat di game ini, terutama dengan kemampuan untuk memberikan damage yang signifikan dengan serangan dasar dan skill-nya. \r\nBerikut adalah beberapa poin utama yang mungkin dibahas dalam artikel \"top global Aldous\":\r\nBuild Item:\r\nArtikel ini akan membahas item-item yang paling efektif untuk Aldous, seperti Endless Battle untuk true damage dan lifesteal, Blade of Heptaseas untuk burst damage, dan Malefic Roar untuk physical penetration. Item lain yang mungkin dibahas adalah Blade of Despair untuk damage besar, Hunter Strike untuk kecepatan, dan Brute Force Breastplate untuk sedikit tankiness. \r\nStrategi:\r\nArtikel ini akan membahas cara bermain Aldous yang efektif, termasuk memilih jalur yang tepat (mid atau jungle), memanfaatkan skill-nya dengan baik, dan strategi ganking yang efektif. \r\nTips:\r\nArtikel ini akan memberikan tips-tips penting untuk bermain Aldous, seperti cara menghitung damage, memanfaatkan kemampuan lifesteal, dan cara menghindari serangan musuh. \r\nTutorial:\r\nBeberapa artikel juga mungkin memberikan tutorial video atau tutorial tertulis tentang cara bermain Aldous yang efektif, termasuk cara menguasai skill-skillnya dan cara membaca situasi game. \r\nAnalisis:\r\nArtikel ini dapat menganalisis performa Aldous dalam berbagai pertandingan dan memberikan rekomendasi tentang cara meningkatkan skill dan pengetahuan tentang hero ini. \r\nContoh isi artikel yang mungkin:\r\n\"Aldous dikenal sebagai hero yang kuat, terutama dengan kemampuannya untuk memberikan damage yang sangat besar. Untuk itu, build item yang tepat sangat penting untuk memaksimalkan potensi Aldous. Salah satu build yang populer adalah kombinasi dari item-item yang memberikan true damage, lifesteal, dan physical penetration, seperti Endless Battle, Blade of Heptaseas, dan Malefic Roar. Selain itu, pemilihan item yang tepat juga akan membantu Aldous dalam mengalahkan hero-hero tank yang memiliki banyak armor.\" \r\nKeterangan tambahan:\r\nAldous adalah seorang hero Mobile Legends yang memiliki kemampuan untuk memberikan damage yang besar dengan serangan dasar dan skill-nya.\r\nAldous juga dikenal sebagai hero yang memiliki kemampuan lifesteal yang baik, yang membuatnya dapat bertahan dalam pertempuran yang lama.\r\nDengan build item yang tepat dan strategi yang efektif, Aldous dapat menjadi pilihan yang sangat kuat untuk mencapai tingkat permainan tertinggi di Mobile Legends.','Pendidikan','berita/CpUwCT1FraRKlemCc4MT5KBM9pm6QGc8h7eJxSdb.jpg',1,'Published','2025-06-07 07:01:11','2025-06-07 07:01:14'),(3,'jawa','Aduhai, Anda benar sekali! Mohon maaf, menggunakan <style> manual memang bukan cara yang \"tailwind\". Seharusnya fungsionalitas responsif dibuat langsung dengan utility class yang sudah disediakan Windmill/Tailwind.\r\n\r\nTerima kasih atas koreksinya. Kita akan rombak total bagian tabelnya agar menjadi \"pure Tailwind\" tanpa satu baris pun CSS manual.\r\n\r\nPendekatan barunya adalah dengan membuat \"label\" di dalam setiap sel (<td>) yang hanya akan muncul di layar kecil.\r\n\r\nController (Tidak Ada Perubahan)\r\nFile Siswa/JadwalController.php yang saya berikan sebelumnya sudah benar dan tidak perlu diubah. Logikanya untuk mengambil, mengurutkan, dan mengelompokkan data sudah sesuai. Perubahan hanya perlu dilakukan pada file view.\r\n\r\nView Jadwal Siswa (Versi Pure Tailwind)\r\nBerikut adalah kode index.blade.php yang telah ditulis ulang dengan pendekatan utility-class untuk tabel responsif.\r\n\r\nFile: resources/views/siswa/jadwal/index.blade.php','Informasi','berita/TJHnUC2rW2VN455myIydSxnqGBWPAOnfMs6YCfsN.jpg',1,'Published','2025-06-07 07:01:50','2025-06-07 07:01:52');
/*!40000 ALTER TABLE `berita` ENABLE KEYS */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;

--
-- Table structure for table `guru`
--

DROP TABLE IF EXISTS `guru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `pendidikan_terakhir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guru_nip_unique` (`nip`),
  KEY `guru_user_id_foreign` (`user_id`),
  CONSTRAINT `guru_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru`
--

/*!40000 ALTER TABLE `guru` DISABLE KEYS */;
INSERT INTO `guru` VALUES (1,'83746834','Juan','09235983745','Laki-laki','2025-05-19','S1 Matematika','Lopok atas barat','users/ork9qCHxEaQuhjAkqUhTdY2UdDBJH8dSOHSfwdaE.png',5,'2025-05-25 04:32:20','2025-06-07 01:18:53'),(2,'9847583645','Zainul Majdi','94875983745','Laki-laki','2025-05-12','S2 Komputer','Lotim','guru/HZ8Z2TBsMFPljGPhpBXox3MrcelJH3MvjaIUMudN.png',6,'2025-05-25 04:33:00','2025-05-25 04:33:00'),(3,'9375834','Syahrini','09847584543','Perempuan','2025-05-07','SMA Kesehatan','Teeeeeloooo','guru/8ESOjvpsnYH58JO32gBIQDqRz5CepJfrQwSYUyAv.png',7,'2025-05-25 04:33:39','2025-05-25 04:33:39'),(4,'93246734325','Ahmad Madani','08435375345','Laki-laki','2025-05-14','SMK Kristen','Looloo','guru/5KDoLuzBakQedXBvZy6NRHyHPpXGDapMrsNxOK1h.png',8,'2025-05-25 04:34:12','2025-05-25 04:34:12'),(5,'9032597345','Pahrul Irfan','09834658734','Laki-laki','2025-05-20','S2 INFORMASI','Pujut Lombok tengah','guru/tP4YuyECpEH3NjHrJVeK7CyIu1CXp4TaI50Pmwl6.png',17,'2025-06-04 05:31:09','2025-06-04 05:31:09');
/*!40000 ALTER TABLE `guru` ENABLE KEYS */;

--
-- Table structure for table `guru_mapel`
--

DROP TABLE IF EXISTS `guru_mapel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru_mapel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` bigint unsigned NOT NULL,
  `mapel_id` bigint unsigned NOT NULL,
  `kelas_id` bigint unsigned NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_mapel_guru_id_foreign` (`guru_id`),
  KEY `guru_mapel_mapel_id_foreign` (`mapel_id`),
  KEY `guru_mapel_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `guru_mapel_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `guru_mapel_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `guru_mapel_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru_mapel`
--

/*!40000 ALTER TABLE `guru_mapel` DISABLE KEYS */;
INSERT INTO `guru_mapel` VALUES (1,1,1,1,'2024/2025','2025-05-25 04:40:40','2025-05-25 04:40:40'),(2,1,1,2,'2024/2025','2025-05-25 04:41:07','2025-05-25 04:41:07'),(4,3,2,1,'2024/2025','2025-05-25 04:41:36','2025-05-25 04:41:36'),(5,4,3,3,'2024/2025','2025-05-25 04:52:09','2025-05-25 04:52:09'),(6,5,2,2,'2024/2025','2025-06-07 07:44:52','2025-06-07 07:44:52');
/*!40000 ALTER TABLE `guru_mapel` ENABLE KEYS */;

--
-- Table structure for table `jadwal`
--

DROP TABLE IF EXISTS `jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jadwal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint unsigned NOT NULL,
  `mapel_id` bigint unsigned NOT NULL,
  `guru_id` bigint unsigned NOT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_kelas_id_foreign` (`kelas_id`),
  KEY `jadwal_mapel_id_foreign` (`mapel_id`),
  KEY `jadwal_guru_id_foreign` (`guru_id`),
  CONSTRAINT `jadwal_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jadwal_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jadwal_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal`
--

/*!40000 ALTER TABLE `jadwal` DISABLE KEYS */;
INSERT INTO `jadwal` VALUES (1,1,1,1,'senin','09:00:00','11:00:00','X-IPA 1','2024/2025','Ganjil','2025-05-26 03:41:41','2025-05-26 03:41:41'),(2,2,1,1,'selasa','09:24:00','11:00:00','X-IPA 2','2024/2025','Ganjil','2025-05-26 03:44:41','2025-05-26 03:45:53'),(3,1,1,1,'kamis','14:45:00','15:45:00','X-IPA 1','2024/2025','Ganjil','2025-06-04 21:45:38','2025-06-04 21:45:38'),(4,1,1,1,'sabtu','22:13:00','23:13:00','X-IPA 1','2024/2025','Ganjil','2025-06-07 05:14:05','2025-06-07 05:14:05');
/*!40000 ALTER TABLE `jadwal` ENABLE KEYS */;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guru_id` bigint unsigned NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelas_kode_kelas_unique` (`kode_kelas`),
  KEY `kelas_guru_id_foreign` (`guru_id`),
  CONSTRAINT `kelas_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'10IPA1','X-IPA 1',1,'2024/2025','2025-05-25 04:35:26','2025-05-25 04:35:26'),(2,'10IPA2','X-IPA 2',2,'2024/2025','2025-05-25 04:35:48','2025-05-25 04:35:48'),(3,'11IPA1','XI-IPA 1',3,'2024/2025','2025-05-25 04:36:07','2025-05-25 04:36:07');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;

--
-- Table structure for table `kelas_mapel`
--

DROP TABLE IF EXISTS `kelas_mapel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas_mapel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint unsigned NOT NULL,
  `mapel_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_mapel_kelas_id_foreign` (`kelas_id`),
  KEY `kelas_mapel_mapel_id_foreign` (`mapel_id`),
  CONSTRAINT `kelas_mapel_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kelas_mapel_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas_mapel`
--

/*!40000 ALTER TABLE `kelas_mapel` DISABLE KEYS */;
INSERT INTO `kelas_mapel` VALUES (1,1,1,'2025-05-25 04:37:59','2025-05-25 04:37:59'),(2,2,1,'2025-05-25 04:38:08','2025-05-25 04:38:08'),(3,1,2,'2025-05-25 04:38:58','2025-05-25 04:38:58'),(4,2,2,'2025-05-25 04:38:58','2025-05-25 04:38:58'),(5,3,3,'2025-05-25 04:39:31','2025-05-25 04:39:31'),(6,3,4,'2025-05-25 04:53:32','2025-05-25 04:53:32');
/*!40000 ALTER TABLE `kelas_mapel` ENABLE KEYS */;

--
-- Table structure for table `mapel`
--

DROP TABLE IF EXISTS `mapel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mapel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kkm` int NOT NULL,
  `jumlah_jam` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mapel_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mapel`
--

/*!40000 ALTER TABLE `mapel` DISABLE KEYS */;
INSERT INTO `mapel` VALUES (1,'IPA1','Ilmu Pengetahuan Alam',65,5,'2025-05-25 04:37:58','2025-05-25 04:37:58'),(2,'MTK1','Matematika Dasar',75,4,'2025-05-25 04:38:58','2025-05-25 04:38:58'),(3,'IPA2','Ilmu Pengatahuan Alam Lanjutan',75,3,'2025-05-25 04:39:31','2025-05-25 04:39:31'),(4,'ORG1','Olahraga',75,3,'2025-05-25 04:53:32','2025-05-25 04:53:32');
/*!40000 ALTER TABLE `mapel` ENABLE KEYS */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_05_07_085200_create_roles_table',1),(2,'2025_05_07_085300_create_users_table',1),(3,'2025_05_07_085308_create_mapel_table',1),(4,'2025_05_07_085316_create_guru_table',1),(5,'2025_05_07_085323_create_berita_table',1),(6,'2025_05_07_085330_create_notifikasi_table',1),(7,'2025_05_07_085337_create_pesan_table',1),(8,'2025_05_07_085343_create_kelas_table',1),(9,'2025_05_07_085350_create_siswa_table',1),(10,'2025_05_07_085357_create_guru_mapel_table',1),(11,'2025_05_07_085402_create_jadwal_table',1),(12,'2025_05_07_085408_create_orangtua_table',1),(13,'2025_05_07_085414_create_nilai_table',1),(14,'2025_05_07_085420_create_absensi_table',1),(15,'2025_05_07_085425_create_todo_list_table',1),(16,'2025_05_07_104221_create_sessions_table',1),(17,'2025_05_07_190602_create_cache_table',1),(18,'2025_05_08_113025_add_role_column_to_users_table',1),(19,'2025_05_08_113045_drop_roles_table',1),(20,'2025_05_19_095303_create_kelas_mapel_table',1),(21,'2025_05_19_095435_drop_kelas_column_from_mapel_table',1),(22,'2025_05_20_142411_add_foto_to_berita_table',1),(23,'2025_06_07_170235_create_rankings_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

--
-- Table structure for table `nilai`
--

DROP TABLE IF EXISTS `nilai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nilai` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `mapel_id` bigint unsigned NOT NULL,
  `guru_id` bigint unsigned NOT NULL,
  `jenis_nilai` enum('Tugas','Ulangan','UTS','UAS') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` double NOT NULL,
  `semester` enum('Ganjil','Genap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nilai_entry` (`siswa_id`,`mapel_id`,`guru_id`,`jenis_nilai`,`semester`,`tahun_ajaran`),
  KEY `nilai_mapel_id_foreign` (`mapel_id`),
  KEY `nilai_guru_id_foreign` (`guru_id`),
  CONSTRAINT `nilai_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nilai_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nilai_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai`
--

/*!40000 ALTER TABLE `nilai` DISABLE KEYS */;
INSERT INTO `nilai` VALUES (1,1,1,1,'Tugas',90,'Ganjil','2024/2025','2025-06-07 06:09:34','2025-06-07 06:09:34'),(2,2,2,5,'Tugas',98,'Ganjil','2024/2025','2025-06-07 07:46:10','2025-06-07 07:46:10'),(3,5,1,1,'UAS',90,'Ganjil','2024/2025','2025-06-07 09:08:58','2025-06-07 09:08:58'),(4,1,1,1,'Ulangan',76,'Ganjil','2024/2025','2025-06-07 09:09:11','2025-06-07 09:09:11');
/*!40000 ALTER TABLE `nilai` ENABLE KEYS */;

--
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifikasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifikasi_user_id_foreign` (`user_id`),
  CONSTRAINT `notifikasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifikasi`
--

/*!40000 ALTER TABLE `notifikasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifikasi` ENABLE KEYS */;

--
-- Table structure for table `orangtua`
--

DROP TABLE IF EXISTS `orangtua`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orangtua` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `siswa_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orangtua_siswa_id_foreign` (`siswa_id`),
  KEY `orangtua_user_id_foreign` (`user_id`),
  CONSTRAINT `orangtua_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orangtua_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orangtua`
--

/*!40000 ALTER TABLE `orangtua` DISABLE KEYS */;
INSERT INTO `orangtua` VALUES (1,'Indah Permatasari','098485345734','Lopok bawa','Petani',2,14,'2025-06-02 03:19:54','2025-06-02 03:19:54'),(2,'diah ayu','934783475345','alamat','Perwira TNI',5,15,'2025-06-02 03:20:26','2025-06-02 03:20:26'),(3,'JancokOwi','asdadad','Oiya Alamat lengkap','asdadsad',4,16,'2025-06-02 03:21:00','2025-06-02 03:21:00'),(4,'Fiqro Najiah','087765544432','Solo , Jabar','Presiden',1,18,'2025-06-07 09:14:12','2025-06-07 09:14:12');
/*!40000 ALTER TABLE `orangtua` ENABLE KEYS */;

--
-- Table structure for table `pesan`
--

DROP TABLE IF EXISTS `pesan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pesan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pengirim_id` bigint unsigned NOT NULL,
  `penerima_id` bigint unsigned NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pesan_pengirim_id_foreign` (`pengirim_id`),
  KEY `pesan_penerima_id_foreign` (`penerima_id`),
  CONSTRAINT `pesan_penerima_id_foreign` FOREIGN KEY (`penerima_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pesan_pengirim_id_foreign` FOREIGN KEY (`pengirim_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesan`
--

/*!40000 ALTER TABLE `pesan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pesan` ENABLE KEYS */;

--
-- Table structure for table `rankings`
--

DROP TABLE IF EXISTS `rankings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rankings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `kelas_id` bigint unsigned NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('ganjil','genap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_nilai` decimal(8,2) NOT NULL,
  `rata_rata_nilai` decimal(5,2) NOT NULL,
  `ranking_kelas` int unsigned NOT NULL,
  `ranking_angkatan` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rankings_siswa_id_foreign` (`siswa_id`),
  KEY `rankings_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `rankings_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rankings_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rankings`
--

/*!40000 ALTER TABLE `rankings` DISABLE KEYS */;
/*!40000 ALTER TABLE `rankings` ENABLE KEYS */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('2P0L1lE9h81bQ75jLN9evFSA3g9oOuzrQekH0eMk',14,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWWtacXJnbHhVYWhmNDF2Qk1GdHJPVlBTQjNUWDJHbVdka0dRbGYxTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9zaWFnb3Npc3YyLnRlc3Qvb3Jhbmd0dWEvYmVyaXRhLzMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDt9',1749317837),('iuHRXJ8MgTRhmOFygmjxAr48WFK89TtOGdiQOb3i',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUm5NT1czc0haaHp2UnJYeHN6RWZKVEhNMWt3a3dLcDhvdjJpSnd3MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9zaWFnb3Npc3YyLnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1749388709),('IZfVLdx1QppJ7GFiN6OsiK89a77IStiDJKFwAjZQ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkhLVFZGZ2I2TlRjM0xGNHg3Skl5UlV5bFdvR2FObEZreTh5NFlZTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9zaWFnb3Npc3YyLnRlc3QvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1749388716);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

--
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `siswa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nisn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` bigint unsigned NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswa_nisn_unique` (`nisn`),
  KEY `siswa_kelas_id_foreign` (`kelas_id`),
  KEY `siswa_user_id_foreign` (`user_id`),
  CONSTRAINT `siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `siswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswa`
--

/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
INSERT INTO `siswa` VALUES (1,'9328734658345','Putri Ttitian',1,'Perempuan','Lopok Brew','2025-05-06','Lopok Beru','Islam','users/kln0GT15hntL3B1a3C5NdpL70gLfbTGA8HVrpzpn.jpg',9,'2025-05-25 04:36:46','2025-06-07 04:51:54'),(2,'3948687345','Ahmad Julian',2,'Laki-laki','Lopppppp','2025-05-13','Langam','Islam','siswa/wtCegaI4PagQmdIG4ZdSQiVZTPHI65O2r0gjsHr7.png',10,'2025-05-25 04:37:20','2025-05-25 04:37:20'),(3,'04758345','Konnci',3,'Laki-laki','aksjdkasdj','2025-05-13','awawa','aiwehiw','siswa/sjMZ1bnL0uriWvcR9PursITOt8dYPnzlcBaL4oEF.png',11,'2025-05-25 04:56:03','2025-05-25 04:56:03'),(4,'76346537','iasgdjhad',3,'Laki-laki','kgsdgsjdf','2025-05-21','jshdfjsdf','kjzdbfhjzdf','siswa/OyaBsN1OlPYYO1MdXgdCfAtTckOub5yNpKvYuDkd.png',12,'2025-05-25 04:56:27','2025-05-25 04:56:27'),(5,'9374984','Umar JIngan',1,'Laki-laki','lksjjkdsf','2025-05-20','Lopok','ISlam','siswa/mcPw6maJ8DDFdViLKwgmf35k6Chw93MeauKJ0rFl.png',13,'2025-05-26 02:36:40','2025-05-26 02:36:40');
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;

--
-- Table structure for table `todo_list`
--

DROP TABLE IF EXISTS `todo_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `todo_list` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `deadline` date NOT NULL,
  `mapel_id` bigint unsigned DEFAULT NULL,
  `selesai` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `todo_list_siswa_id_foreign` (`siswa_id`),
  KEY `todo_list_mapel_id_foreign` (`mapel_id`),
  CONSTRAINT `todo_list_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE SET NULL,
  CONSTRAINT `todo_list_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo_list`
--

/*!40000 ALTER TABLE `todo_list` DISABLE KEYS */;
INSERT INTO `todo_list` VALUES (1,1,'Halaman 9 , matematika','Madani anjay','2025-06-05',NULL,0,'2025-06-07 01:46:34','2025-06-07 04:06:38'),(3,1,'asfdf','asasfd','2025-06-13',1,1,'2025-06-07 02:13:43','2025-06-07 03:06:47'),(4,1,'kontol','saf','2025-06-13',3,1,'2025-06-07 02:35:37','2025-06-07 02:50:48'),(5,1,'asdsds','sasdf','2025-06-16',1,1,'2025-06-07 02:40:11','2025-06-07 02:50:23'),(6,1,'jawa','sdfsf','2025-06-22',3,0,'2025-06-07 04:07:05','2025-06-07 04:07:11'),(7,1,'asdadasd','ssadasd','2025-06-01',4,1,'2025-06-07 04:08:29','2025-06-07 04:12:50'),(8,1,'asd','asfdsdf','2025-06-18',3,0,'2025-06-07 04:16:57','2025-06-07 04:16:57'),(9,1,'ssdsfdsf','sdfdsf','2025-06-26',2,0,'2025-06-07 04:17:09','2025-06-07 04:17:09');
/*!40000 ALTER TABLE `todo_list` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','guru','siswa','orangtua') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@siagosis.com',NULL,'$2y$12$WxONXHhE6v7k1pdzpuF39OvNIgsv3D96iQs7/PCGTE.5ZSUArIfCa',NULL,'2025-05-25 04:22:47','2025-05-25 04:22:47','admin'),(5,'Juan','juan@siagosis.com',NULL,'$2y$12$PTIEY9aiUYJhQj/GNySdd.j.zq4T/lr1q/1BalkNaT8R.Vj2EvsDm',NULL,'2025-05-25 04:32:19','2025-06-04 20:30:22','guru'),(6,'Zainul Majdi','9847583645@siagosis.com',NULL,'$2y$12$vxkV1Rhosje58l5bcPdRu.qbLf5e/rbrglYBpfpasMXKdXtUhy6BC',NULL,'2025-05-25 04:33:00','2025-05-25 04:33:00','guru'),(7,'Syahrini','9375834@siagosis.com',NULL,'$2y$12$bmDLNMBSYF7/F1XhtpSSy.kowv7CRd/HLkly4NcU94.//R8edxfBW',NULL,'2025-05-25 04:33:39','2025-05-25 04:33:39','guru'),(8,'Ahmad Madani','madani@siagosis.com',NULL,'$2y$12$QS1cnsI1F5fZounRbNv8Ieu5BzPa18PRs8fNcEERc/KNnSSDGxSyq',NULL,'2025-05-25 04:34:12','2025-05-25 04:52:22','guru'),(9,'Putri Ttitian','putri@siagosis.com',NULL,'$2y$12$nEby2Norxgdn1fk.Wm3iIuhSIoHYJR3afuQnqkao2xjzKYuUfkGXi',NULL,'2025-05-25 04:36:46','2025-06-07 01:52:12','siswa'),(10,'Ahmad Julian','3948687345@siagosis.com',NULL,'$2y$12$I51xZlTEQ9wcoMg0u1zsd.KJRQJbIOT1QZ8.vExdezYHqgAPsrkDC',NULL,'2025-05-25 04:37:20','2025-05-25 04:37:20','siswa'),(11,'Konnci','04758345@siagosis.com',NULL,'$2y$12$62JLLDKFoV0ERReU3wEn/eWB53MR6P0xisOIfhK/eBs79vKJITjnG',NULL,'2025-05-25 04:56:03','2025-05-25 04:56:03','siswa'),(12,'iasgdjhad','76346537@siagosis.com',NULL,'$2y$12$BQ.FRYu.asQXjcRG8sAhE.K8wnEZYdQbc5VpBk.vYAMi3JyQG1U2i',NULL,'2025-05-25 04:56:27','2025-05-25 04:56:27','siswa'),(13,'Umar JIngan','9374984@siagosis.com',NULL,'$2y$12$rqL344txjMgQ50ImyC8G/.7rrWoE40vuX1eFS7GYP9a9SDkLzC.TG',NULL,'2025-05-26 02:36:39','2025-05-26 02:36:39','siswa'),(14,'Indah Permatasari','indah@siagosis.com',NULL,'$2y$12$GlhKTrpRkZoNZfQnZyWLBu3gqufu7DaK3dW8LhLhiqIKtYkJYCJ/6',NULL,'2025-06-02 03:19:54','2025-06-07 07:44:00','orangtua'),(15,'diah ayu','diah@siagosis.com',NULL,'$2y$12$pnrkTfQbHhVRRZQRdgPz9Oak6pkqveH/DFk3qjKbAnyMoFmXhKbUq',NULL,'2025-06-02 03:20:26','2025-06-07 09:10:57','orangtua'),(16,'JancokOwi','asdadad@siagosis.com',NULL,'$2y$12$9b0k9zht066mw.LKVQbeAOFPBjLn1Mji0HDFr2pnv7BIQJTZc4nla',NULL,'2025-06-02 03:21:00','2025-06-02 03:21:00','orangtua'),(17,'Pahrul Irfan','pahrul@siagosis.com',NULL,'$2y$12$.Vy6Yt0R7WchzSBNdDgny.t612ZCS1RJdd8fqkY89YPFmnmkSzJuu',NULL,'2025-06-04 05:31:08','2025-06-07 07:45:33','guru'),(18,'Fiqro Najiah','opik@siagosis.com',NULL,'$2y$12$VFI2m9JHbG6VituQSI75a.xGf3J19PtIOxBbT79rUmIfh.TQ9olRS',NULL,'2025-06-07 09:14:12','2025-06-07 09:15:01','orangtua');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Dumping routines for database 'school_management'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-08 23:03:50
