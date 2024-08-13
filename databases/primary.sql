/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.39-0ubuntu0.22.04.1 : Database - sms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `sms`;

/*Table structure for table `absensi` */

CREATE TABLE `absensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `santri_id` bigint unsigned NOT NULL,
  `jadwal_id` bigint unsigned NOT NULL,
  `status` enum('hadir','izin','sakit','tidak hadir') DEFAULT 'hadir',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `att_santri_fk` (`santri_id`),
  KEY `att_jadwal_fk` (`jadwal_id`),
  CONSTRAINT `att_jadwal_fk` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `att_santri_fk` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `absensi` */

insert  into `absensi`(`id`,`santri_id`,`jadwal_id`,`status`,`created_at`,`updated_at`) values 
(24,64,24,'hadir','2022-07-08 08:35:07',NULL),
(25,65,24,'hadir','2022-07-08 08:35:21',NULL);

/*Table structure for table `bill_items` */

CREATE TABLE `bill_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `total_item` int DEFAULT NULL,
  `price` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_id_fk` (`bill_id`),
  KEY `product_id_fk` (`product_id`),
  CONSTRAINT `bill_id_fk` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bill_items` */

insert  into `bill_items`(`id`,`bill_id`,`product_id`,`total_item`,`price`) values 
(146,97,20,1,5000),
(147,97,34,1,8000),
(184,113,34,1,8000),
(185,113,20,1,5000),
(186,120,34,1,8000),
(187,121,20,2,5000),
(188,121,23,2,6000),
(191,123,34,1,8000),
(192,123,20,1,5000),
(193,124,20,2,5000),
(194,124,23,2,6000);

/*Table structure for table `bills` */

CREATE TABLE `bills` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `santri_id` bigint unsigned DEFAULT NULL,
  `wali_id` bigint unsigned DEFAULT NULL,
  `gross_amount` bigint DEFAULT NULL,
  `payment_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_paid` int DEFAULT '203',
  `paid_at` datetime DEFAULT NULL,
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deadline` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `santri_bill_fk` (`santri_id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bills` */

insert  into `bills`(`id`,`payment_id`,`order_id`,`santri_id`,`wali_id`,`gross_amount`,`payment_type`,`bank`,`bank_account`,`status_paid`,`paid_at`,`link`,`deadline`,`created_at`,`updated_at`,`deleted_at`) values 
(97,'62ca7b6c06b41a73175ecce7','20220710141035',65,17,19980,'transfer_bank','BCA','107669999185303',203,NULL,NULL,'2022-07-10 17:10:35','2022-07-10 14:10:35',NULL,NULL),
(113,'62cb8ea3ee64724de05c31a4','20220711094449',65,17,19980,'transfer_bank','BCA','107669999334371',203,NULL,NULL,'2022-07-11 12:44:49','2022-07-11 09:44:49',NULL,NULL),
(116,'62ce4d50151da7646050114b','20220713114253',65,17,105000,'transfer_bank','BCA','107669999721335',200,'2022-07-13 11:43:09',NULL,'2022-07-13 14:42:53','2022-07-13 11:42:53','2022-07-13 11:43:09',NULL),
(117,'62ce8297151da7026a5030f4','20220713153014',66,17,205000,'transfer_bank','BCA','107669999231570',200,'2022-07-13 16:01:49',NULL,'2022-07-13 18:30:14','2022-07-13 15:30:14','2022-07-13 16:01:49',NULL),
(118,'62ce8da6d84100a4091581a5','20220713161724',66,17,205000,'transfer_bank','BCA','107669999938283',200,'2022-07-13 16:17:38',NULL,'2022-07-13 19:17:24','2022-07-13 16:17:24','2022-07-13 16:17:38',NULL),
(119,NULL,'13072022171458',64,NULL,10000,NULL,NULL,NULL,200,NULL,NULL,NULL,'2022-07-13 17:14:58',NULL,NULL),
(120,'qr_b14da8cb-8a22-4154-a5f5-6540fa9ae80a','20220814203326',65,17,14430,'qrcode','QRIS','DYNAMIC',203,NULL,'mock-QR-string-use-simulate-payment-to-test-flow','2022-08-14 23:33:26','2022-08-14 20:33:26',NULL,NULL),
(121,'646ad8cfa97fb1095f8f1040','20230522095158',8,11,22200,'transfer_bank','BCA','107669999627014',203,NULL,NULL,'2023-05-22 12:51:58','2023-05-22 09:51:58',NULL,NULL),
(123,'646adc3ea97fb1095f8f1467','20230522100638',65,17,19980,'transfer_bank','MANDIRI','889089999967499',203,NULL,NULL,'2023-05-22 13:06:38','2023-05-22 10:06:38',NULL,NULL),
(124,'646add68a97fb1095f8f15b2','20230522101135',8,11,22200,'transfer_bank','BCA','107669999085206',203,NULL,NULL,'2023-05-22 13:11:35','2023-05-22 10:11:35',NULL,NULL);

/*Table structure for table `cart` */

CREATE TABLE `cart` (
  `id_cart` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `wali_id` bigint unsigned NOT NULL,
  `checkout_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cart`),
  KEY `cart_product_id` (`product_id`),
  KEY `card_wali_santri` (`wali_id`),
  CONSTRAINT `card_wali_santri` FOREIGN KEY (`wali_id`) REFERENCES `wali_santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cart_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cart` */

insert  into `cart`(`id_cart`,`product_id`,`wali_id`,`checkout_at`,`created_at`) values 
(111,20,17,'2022-07-10 14:10:35','2022-07-05 09:51:15'),
(114,34,17,'2022-07-10 14:10:35','2022-07-05 13:33:40'),
(116,34,17,'2022-07-11 09:44:49','2022-07-11 08:52:13'),
(117,20,17,'2022-07-11 09:44:49','2022-07-11 08:52:14'),
(118,34,17,'2022-08-14 20:33:26','2022-08-12 14:42:17'),
(119,20,17,'2023-05-22 09:50:51','2023-05-22 09:41:43'),
(120,34,17,'2023-05-22 09:50:51','2023-05-22 09:47:35'),
(121,20,17,'2023-05-22 09:55:34','2023-05-22 09:53:52'),
(122,44,17,'2023-05-22 09:55:34','2023-05-22 09:53:54'),
(123,34,17,'2023-05-22 09:57:12','2023-05-22 09:57:04'),
(124,20,17,'2023-05-22 09:57:12','2023-05-22 09:57:05'),
(125,34,17,'2023-05-22 10:00:36','2023-05-22 09:59:24'),
(126,42,17,'2023-05-22 10:00:36','2023-05-22 09:59:26'),
(127,34,17,'2023-05-22 10:06:38','2023-05-22 10:06:30'),
(128,20,17,'2023-05-22 10:06:38','2023-05-22 10:06:31'),
(129,34,17,NULL,'2023-05-22 10:54:38');

/*Table structure for table `category` */

CREATE TABLE `category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `category` */

insert  into `category`(`id`,`title`,`images`,`created_at`,`updated_at`) values 
(5,'Makanan','','2022-04-27 08:27:36',NULL),
(6,'Minuman','','2022-04-27 08:37:23',NULL),
(7,'Unit Usaha','','2022-05-24 15:31:07',NULL),
(8,'Alat Tulis','','2022-06-28 10:22:31',NULL);

/*Table structure for table `config` */

CREATE TABLE `config` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `config` */

insert  into `config`(`id`,`name`,`value`,`description`) values 
(1,'APP_NAME','ADM Ponpes','nama aplikasi'),
(2,'NAMA_PESANTREN','Pesantren Al-Amanah Al-Gontori','nama pesantren'),
(3,'ALAMAT','Jl. Taman Makam Bahagia, Parigi Baru, Kec. Pd. Aren, Kota Tangerang Selatan, Banten 15228','alamat pesantren'),
(4,'PHONE','(021) 74862163','nomor telpon pondok pesantren'),
(5,'LOGO_FULL','logo-full.png','logo pondok pesantren'),
(6,'SHORT_APP_NAME','ADM Ponpes','nama singkat aplikasi'),
(7,'VISI','Menjadi lembaga pendidikan berbasis kepesantrenan yang memiliki keunggulan dalam menghasilkan generasi yang sholeh, memiliki pemahaman syar’i , serta jiwa kepemimpinan',NULL),
(8,'MISI','&lt;ul&gt;\r\n&lt;li style=&quot;list-style-position: outside; margin-left: 20px; list-style-type: decimal;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet congue lectus, id eleifend nisi efficitur ut. Phasellus tincidunt eros nec metus porttitor, nec malesuada massa consectetur. Nunc nec risus fringilla, consectetur urna a, vehicula arcu. Suspendisse bibendum, magna a sodales suscipit, elit sapien sollicitudin lacus, varius accumsan purus massa vel eros. Aliquam nulla arcu, gravida vitae lorem eget, volutpat aliquet orci. Curabitur eleifend dignissim dolor, eget tristique risus cursus ac. Phasellus semper erat turpis, ut convallis risus imperdiet aliquam. Vivamus dictum magna vel risus volutpat commodo. Sed ac ex eget ipsum finibus dignissim. Integer quis quam tortor. Donec in pharetra libero, sit amet eleifend enim&lt;/span&gt;&lt;/li&gt;&lt;li style=&quot;list-style-position: outside; margin-left: 20px; list-style-type: decimal;&quot;&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif;&quot;&gt;Nunc pharetra felis at sapien faucibus, ac ornare neque pulvinar. Vestibulum efficitur a est sed mollis. Sed facilisis sodales sapien quis hendrerit. Pellentesque mollis lectus a arcu suscipit, in venenatis mi tincidunt. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi rhoncus id libero sed dapibus. In id mi sed augue maximus pulvinar. Pellentesque viverra ut dolor et consequat. Nunc tortor elit, bibendum quis justo at, congue venenatis massa. Nulla in purus fermentum, euismod urna eu, malesuada tortor.&lt;/p&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif;&quot;&gt;Fusce ac pulvinar nisi. Fusce lobortis nibh erat, ac cursus nulla congue id. Quisque dictum interdum ligula, ut volutpat massa venenatis nec. Aenean tempor dignissim erat et commodo. Integer nulla lorem, convallis non justo in, varius volutpat diam. Praesent tincidunt consequat risus, in euismod arcu sollicitudin id. Sed auctor nec mi laoreet elementum. Integer imperdiet diam et neque egestas, nec blandit elit maximus. Sed tincidunt vel ex sit amet mollis. Curabitur in semper nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse semper pretium justo, a viverra nisi viverra rutrum.&lt;/p&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif;&quot;&gt;Cras a dictum metus. Donec auctor leo nibh, vel viverra magna sodales sed. Maecenas rhoncus, nisl id aliquam efficitur, purus nunc laoreet nibh, in fermentum erat urna vel nisl. Etiam ut tellus et tortor efficitur euismod eget sed risus. Nunc nec enim at urna lobortis egestas. Mauris consequat dolor eget lobortis scelerisque. Vivamus ac mauris neque. Interdum et malesuada fames ac ante ipsum primis in faucibus. In in odio tristique, venenatis eros eu, pharetra ex.&lt;/p&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif;&quot;&gt;Proin viverra eget nisl vel pulvinar. Morbi nec imperdiet nibh, eget euismod quam. Maecenas viverra ultrices dictum. Suspendisse egestas tortor ullamcorper diam mollis, eu efficitur ligula varius. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec nec congue nunc, ut imperdiet orci. Ut vel ullamcorper purus.&lt;/p&gt;&lt;/li&gt;\r\n&lt;/ul&gt;',NULL),
(9,'LOGO_MINI','logo-mini.png',NULL),
(10,'EMAIL','pondokpesantren@gmail.com','email pesantren resmi'),
(11,'NOMOR_SK','AHU-00123123.AH.01.02.TAHUN 2015','nomor sk pesantren'),
(12,'TANGGAL_PENDIRIAN','20-05-1997','tanggal di dirikan pesantren'),
(13,'NAMA_PENDIRI','Ahmad Fatoni, S.Kom','nama pendiri pesantren'),
(14,'NPWP','65.468.789.7-975.454','npwp pesantren'),
(15,'XENDIT_KEY','xnd_development_B4CZVphDJWN7fMBcnda1eVLpWyv4N5zcgh5nduq1IDNitY1CKhr0QklwdB7kEzF','PRIVATE KEY XENDIT DEV / PUBLIC'),
(16,'XENDIT_PUBLIC_KEY','xnd_public_development_d94RCm7fOcc9n6A1NfO3yvBNGMfEIGxSpEx6XhiQ4bqez2AoBZi8XsEtNdlM','PUBLIC KEY XENDIT'),
(17,'XENDIT_CALLBACK_TOKEN','w8Bm9dglMGVashh9CMRzAHw3dxMkP8uNB0bLvxHPkTOKhR0f','TOKEN CALLBACK YANG ADA PADA XENDIT');

/*Table structure for table `jadwal` */

CREATE TABLE `jadwal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mapel_id` bigint unsigned NOT NULL,
  `ustadz_id` bigint unsigned NOT NULL,
  `kelas_id` bigint unsigned NOT NULL,
  `hari` enum('senin','selasa','rabu','kamis','jumat','sabtu','minggu') DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `jadwal_mapel_id_fk` (`mapel_id`),
  KEY `jadwal_kelas_id_fk` (`kelas_id`),
  KEY `jadwal_ustadz_id_fk` (`ustadz_id`),
  CONSTRAINT `jadwal_kelas_id_fk` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jadwal_mapel_id_fk` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jadwal_ustadz_id_fk` FOREIGN KEY (`ustadz_id`) REFERENCES `ustadz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `jadwal` */

insert  into `jadwal`(`id`,`mapel_id`,`ustadz_id`,`kelas_id`,`hari`,`waktu_mulai`,`created_at`,`updated_at`) values 
(19,19,35,11,'kamis','16:00:00','2022-06-30 13:43:23','2022-06-30 16:00:35'),
(24,19,35,11,'jumat','09:00:00','2022-07-08 08:23:16',NULL);

/*Table structure for table `kelas` */

CREATE TABLE `kelas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tingkat` int unsigned DEFAULT NULL,
  `tahun_ajaran_id` bigint unsigned NOT NULL,
  `wali_kelas_id` bigint unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  KEY `kelas_wali_kelas_id` (`wali_kelas_id`),
  CONSTRAINT `kelas_wali_kelas_id` FOREIGN KEY (`wali_kelas_id`) REFERENCES `ustadz` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tahun_ajaran_id` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kelas` */

insert  into `kelas`(`id`,`nama_kelas`,`slug`,`tingkat`,`tahun_ajaran_id`,`wali_kelas_id`,`created_at`,`updated_at`) values 
(11,'MA 1','ma-1',1,5,35,'2022-06-30 13:42:48',NULL),
(12,'MA 2','ma-2',2,5,36,'2022-06-30 13:43:00',NULL),
(13,'MA 3','ma-3',3,5,37,'2022-06-30 13:43:08',NULL),
(14,'IPA 1','ipa-1',1,5,37,'2022-06-30 15:31:58',NULL),
(15,'IPA 2','ipa-2',2,5,38,'2022-06-30 15:32:17',NULL),
(16,'IPA 3','ipa-3',3,5,39,'2022-06-30 15:32:27',NULL);

/*Table structure for table `logs` */

CREATE TABLE `logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_type` varchar(50) DEFAULT NULL,
  `event_page` varchar(100) DEFAULT NULL,
  `event_name` varchar(100) DEFAULT NULL,
  `event_description` text,
  `affected_user` varchar(100) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=483 DEFAULT CHARSET=latin1;

/*Data for the table `logs` */

insert  into `logs`(`id`,`event_type`,`event_page`,`event_name`,`event_description`,`affected_user`,`ip_address`,`created_at`) values 
(109,'insert','master-data > mapel','tambah mata pelajaran','tambah data mata pelajaran pada halaman mapel','Administrator','103.119.66.176','2022-06-08 09:34:16'),
(110,'delete','master-data > mapel','delete mata pelajaran','delete data mata pelajaran pada halaman mapel','Administrator','103.119.66.176','2022-06-08 09:34:20'),
(111,'delete',' > daftar-user','delete user','delete data user pada halaman user','Administrator','103.119.66.176','2022-06-08 10:51:09'),
(112,'insert','master-data > tahun_ajaran','tambah tahun ajaran','tambah data tahun ajaran pada halaman tahun ajaran','Administrator','103.119.66.176','2022-06-08 10:52:43'),
(113,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 11:14:34'),
(114,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 11:18:53'),
(115,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 11:20:56'),
(116,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 11:30:47'),
(117,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 11:35:24'),
(118,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 11:35:54'),
(119,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 11:41:58'),
(120,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 11:45:54'),
(121,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:44:47'),
(122,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:46:15'),
(123,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:47:22'),
(124,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:47:45'),
(125,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:49:01'),
(126,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:49:57'),
(127,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:50:22'),
(128,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:51:00'),
(129,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:51:16'),
(130,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:52:44'),
(131,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-08 13:52:57'),
(132,'insert','master-data > ustadz','tambah ustadz','tambah data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-08 13:59:31'),
(133,'insert','master-data > ustadz','tambah ustadz','tambah data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-08 13:59:42'),
(134,'insert','master-data > ustadz','tambah ustadz','tambah data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-08 14:00:50'),
(135,'update','master-data > ustadz','update ustadz','update data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-08 14:03:22'),
(136,'insert','master-data > walisantri','tambah wali santri','tambah data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-08 14:11:47'),
(137,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-08 14:11:59'),
(138,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-08 14:12:26'),
(139,'delete','master-data > walisantri','delete wali santri','delete data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-08 14:12:34'),
(140,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-09 08:37:57'),
(141,'insert','master-data > walisantri','tambah wali santri','tambah data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-09 08:38:26'),
(142,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-09 08:38:38'),
(143,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-09 08:41:00'),
(144,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-09 08:41:58'),
(145,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Ayah','103.119.66.176','2022-06-09 08:50:20'),
(146,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Ayah','103.119.66.176','2022-06-09 08:50:22'),
(147,'delete','order','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-09 14:10:45'),
(148,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-09 14:15:20'),
(149,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-09 14:15:23'),
(150,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-09 14:15:27'),
(151,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-09 14:15:29'),
(152,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-09 14:15:31'),
(153,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-09 14:19:43'),
(154,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-09 14:19:45'),
(155,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-09 14:19:49'),
(156,'insert','maklumat','tambah maklumat','tambah data maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-10 10:59:52'),
(157,'update','maklumat','update maklumat','posting maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-10 11:00:55'),
(158,'update','maklumat','update maklumat','posting maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-10 11:02:07'),
(159,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-14 08:54:11'),
(160,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-14 08:54:13'),
(161,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-14 08:54:14'),
(162,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-14 08:54:16'),
(163,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-14 08:54:19'),
(164,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-14 08:54:21'),
(165,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-14 08:54:23'),
(166,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-14 08:54:25'),
(167,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Ayah','103.119.66.176','2022-06-14 08:54:28'),
(168,'delete','order','delete order','delete data order pada halaman order','Administrator','103.119.66.176','2022-06-14 09:34:31'),
(169,'delete','order','delete order','delete data order pada halaman order','Administrator','103.119.66.176','2022-06-14 09:34:33'),
(170,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 09:19:13'),
(171,'delete','store > product','delete produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 09:19:32'),
(172,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 09:35:23'),
(173,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 09:35:29'),
(174,'delete','store > product','delete produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 09:35:40'),
(175,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 09:42:56'),
(176,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 11:15:43'),
(177,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 11:16:03'),
(178,'delete','store > product','delete produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 11:16:36'),
(179,'delete','store > product','delete produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 11:33:18'),
(180,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 11:33:54'),
(181,'delete','store > product','delete produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 11:41:27'),
(182,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 13:34:23'),
(183,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 14:16:44'),
(184,'delete','store > product','delete produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 14:17:28'),
(185,'delete','store > product','delete produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 14:17:37'),
(186,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 14:17:59'),
(187,'delete','store > product','delete produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 14:19:14'),
(188,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 14:19:35'),
(189,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 14:22:34'),
(190,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 14:23:36'),
(191,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 14:24:21'),
(192,'delete','store > product','delete produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:05:05'),
(193,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:05:37'),
(194,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:20:55'),
(195,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:21:10'),
(196,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:21:31'),
(197,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:23:06'),
(198,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:23:12'),
(199,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:27:51'),
(200,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:28:47'),
(201,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:30:21'),
(202,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:34:35'),
(203,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-15 15:34:39'),
(204,'insert','master-data > ustadz','tambah ustadz','tambah data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-16 10:25:14'),
(205,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-16 15:30:50'),
(206,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-16 15:31:08'),
(207,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-16 15:31:13'),
(208,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-16 15:31:36'),
(209,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-16 15:32:07'),
(210,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-16 15:32:28'),
(211,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 08:37:49'),
(212,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 08:39:38'),
(213,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 08:40:38'),
(214,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 08:41:40'),
(215,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 08:51:39'),
(216,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 08:52:27'),
(217,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 08:53:07'),
(218,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-17 08:54:25'),
(219,'insert','master-data > ustadz','tambah ustadz','tambah data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-17 08:55:58'),
(220,'update','master-data > ustadz','update ustadz','update data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-17 08:56:15'),
(221,'update','master-data > ustadz','update ustadz','update data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-17 09:05:50'),
(222,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-17 09:06:26'),
(223,'insert','master-data > mapel','tambah mata pelajaran','tambah data mata pelajaran pada halaman mapel','Administrator','103.119.66.176','2022-06-17 09:06:42'),
(224,'insert','master-data > mapel','tambah mata pelajaran','tambah data mata pelajaran pada halaman mapel','Administrator','103.119.66.176','2022-06-17 09:06:57'),
(225,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-17 09:07:36'),
(226,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-17 09:08:28'),
(227,'insert','master-data > santri','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-17 09:09:12'),
(228,'insert','master-data > walisantri','tambah wali santri','tambah data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:09:52'),
(229,'insert','master-data > walisantri','tambah wali santri','tambah data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:10:45'),
(230,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:11:34'),
(231,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:11:50'),
(232,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:11:57'),
(233,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:12:09'),
(234,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:12:15'),
(235,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:12:23'),
(236,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:12:29'),
(237,'insert','rombel','tambah rombel','tambah data rombel pada halaman rombel','Administrator','103.119.66.176','2022-06-17 09:13:08'),
(238,'insert','rombel','tambah rombel','tambah data rombel pada halaman rombel','Administrator','103.119.66.176','2022-06-17 09:13:13'),
(239,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-17 09:13:56'),
(240,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-17 09:14:22'),
(241,'update','jadwal','update jadwal','update data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-17 09:14:27'),
(242,'update','jadwal','update jadwal','update data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-17 09:14:36'),
(243,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:22:06'),
(244,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-17 09:22:13'),
(245,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Sakimah','103.119.66.176','2022-06-17 09:30:28'),
(246,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Sakimah','103.119.66.176','2022-06-17 09:30:35'),
(247,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 10:44:59'),
(248,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 10:45:04'),
(249,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 10:45:48'),
(250,'update','store > product','update produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-17 10:46:43'),
(251,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','182.0.210.39','2022-06-17 11:48:17'),
(252,'insert','maklumat','tambah maklumat','tambah data maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-17 15:27:16'),
(253,'delete','maklumat','delete maklumat','delete data maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-17 15:27:37'),
(254,'insert','maklumat','tambah maklumat','tambah data maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-17 15:29:45'),
(255,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 14:56:16'),
(256,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 14:56:18'),
(257,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 14:56:19'),
(258,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:28:09'),
(259,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:28:10'),
(260,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:28:11'),
(261,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:38:43'),
(262,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:38:43'),
(263,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:38:44'),
(264,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:46:48'),
(265,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:46:50'),
(266,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:47:57'),
(267,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:47:58'),
(268,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:47:59'),
(269,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:48:38'),
(270,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:48:38'),
(271,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:48:39'),
(272,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:49:23'),
(273,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-20 15:49:24'),
(274,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 08:29:21'),
(275,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 08:29:23'),
(276,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 09:01:47'),
(277,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 09:01:48'),
(278,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 09:15:40'),
(279,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 09:15:41'),
(280,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 11:00:53'),
(281,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 11:00:54'),
(282,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 11:39:51'),
(283,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-21 11:39:52'),
(284,'update','maklumat','update maklumat','update data maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-21 16:02:26'),
(285,'update','maklumat','update maklumat','posting maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-21 16:02:33'),
(286,'update','maklumat','update maklumat','update data maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-21 16:02:47'),
(287,'update','maklumat','update maklumat','update data maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-21 16:04:13'),
(288,'update','maklumat','update maklumat','update data maklumat pada halaman maklumat','Administrator','103.119.66.176','2022-06-21 16:11:51'),
(289,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-21 16:45:13'),
(290,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-21 16:45:21'),
(291,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-21 16:45:28'),
(292,'update','master-data > santri','update santri','update data santri pada halaman santri','Administrator','103.119.66.176','2022-06-21 16:45:35'),
(293,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-22 09:21:08'),
(294,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-22 09:21:09'),
(295,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Wali Santri','103.119.66.176','2022-06-22 09:35:11'),
(296,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-22 09:35:37'),
(297,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Wali Santri','103.119.66.176','2022-06-22 09:36:11'),
(298,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-22 09:37:13'),
(299,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-22 09:37:14'),
(300,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Wali Santri','103.119.66.176','2022-06-22 09:52:34'),
(301,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Wali Santri','103.119.66.176','2022-06-22 09:52:38'),
(302,'update','master-data > walisantri','update wali santri','update data wali santri pada halaman wali santri','Administrator','103.119.66.176','2022-06-22 10:05:54'),
(303,'update','master-data > ustadz','update ustadz','update data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-22 10:12:11'),
(304,'delete','store-ws > order-ws','delete order','delete data order pada halaman order','Wali Santri','103.119.66.176','2022-06-23 09:52:37'),
(305,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 09:53:59'),
(306,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 09:54:00'),
(307,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 09:56:00'),
(308,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 09:56:01'),
(309,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 09:56:02'),
(310,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 09:58:18'),
(311,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 09:58:18'),
(312,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:34:16'),
(313,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:34:17'),
(314,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:38:51'),
(315,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:38:51'),
(316,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:40:27'),
(317,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:40:27'),
(318,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:40:29'),
(319,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:41:54'),
(320,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:41:55'),
(321,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:43:01'),
(322,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:43:01'),
(323,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:44:17'),
(324,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:44:18'),
(325,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:47:47'),
(326,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:47:48'),
(327,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:51:54'),
(328,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:51:55'),
(329,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:58:25'),
(330,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 11:58:26'),
(331,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 13:48:20'),
(332,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 13:48:21'),
(333,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 14:16:50'),
(334,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 14:16:51'),
(335,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 14:24:04'),
(336,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 14:24:05'),
(337,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 14:24:33'),
(338,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 14:24:33'),
(339,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 14:25:36'),
(340,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Wali Santri','103.119.66.176','2022-06-23 14:25:36'),
(341,'update','config','update konfigurasi','update data konfigurasi pada halaman konfigurasi','Administrator','103.119.66.176','2022-06-24 15:54:58'),
(342,'update','store > product','update stok','Data produk pada admin','Administrator','103.119.66.176','2022-06-28 08:49:29'),
(343,'update','store > product','update stok','Data produk pada admin','Administrator','103.119.66.176','2022-06-28 08:49:35'),
(344,'update','store > product','update stok','Data produk pada admin','Administrator','103.119.66.176','2022-06-28 08:49:42'),
(345,'insert','store > category','tambah kategori','tambah data kategori pada halaman kategori','Administrator','103.119.66.176','2022-06-28 10:22:31'),
(346,'insert','store > product','Tambah Produk','Data produk pada admin','Administrator','103.119.66.176','2022-06-28 10:24:14'),
(347,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-28 14:22:14'),
(348,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-28 14:22:29'),
(349,'insert','master-data > ustadz','tambah ustadz','tambah data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-28 14:23:29'),
(350,'update','master-data > ustadz','update ustadz','update data ustadz pada halaman ustadz','Administrator','103.119.66.176','2022-06-28 14:23:39'),
(351,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-28 14:23:59'),
(352,'insert','master-data > mapel','tambah mata pelajaran','tambah data mata pelajaran pada halaman mapel','Administrator','103.119.66.176','2022-06-28 14:25:14'),
(353,'insert','master-data > mapel','tambah mata pelajaran','tambah data mata pelajaran pada halaman mapel','Administrator','103.119.66.176','2022-06-28 14:25:21'),
(354,'insert','master-data > mapel','tambah mata pelajaran','tambah data mata pelajaran pada halaman mapel','Administrator','103.119.66.176','2022-06-28 14:25:36'),
(355,'insert','master-data > mapel','tambah mata pelajaran','tambah data mata pelajaran pada halaman mapel','Administrator','103.119.66.176','2022-06-28 14:25:44'),
(356,'update','master-data > mapel','update mata pelajaran','update data mata pelajaran pada halaman mapel','Administrator','103.119.66.176','2022-06-28 14:25:50'),
(357,'delete','jadwal','delete jadwal','delete data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:26:51'),
(358,'delete','jadwal','delete jadwal','delete data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:26:53'),
(359,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:27:43'),
(360,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:28:08'),
(361,'update','jadwal','update jadwal','update data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:28:19'),
(362,'delete','jadwal','delete jadwal','delete data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:28:30'),
(363,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:28:38'),
(364,'delete','jadwal','delete jadwal','delete data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:28:41'),
(365,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:39:49'),
(366,'delete','jadwal','delete jadwal','delete data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:40:19'),
(367,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-28 14:40:48'),
(368,'delete','order','delete order','delete data order pada halaman order','Ahmad Fatoni','103.119.66.176','2022-06-28 15:12:32'),
(369,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:46'),
(370,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:46'),
(371,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:46'),
(372,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:46'),
(373,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:46'),
(374,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:46'),
(375,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:46'),
(376,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:46'),
(377,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:47'),
(378,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 15:25:47'),
(379,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:30'),
(380,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:30'),
(381,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:31'),
(382,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:31'),
(383,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:31'),
(384,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:31'),
(385,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:31'),
(386,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:31'),
(387,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:31'),
(388,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:01:31'),
(389,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(390,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(391,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(392,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(393,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(394,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(395,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(396,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(397,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(398,'insert','master-data > import-massal','tambah santri','tambah data santri pada halaman santri','Administrator','103.119.66.176','2022-06-29 16:05:21'),
(399,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:48'),
(400,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:48'),
(401,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:48'),
(402,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:48'),
(403,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:48'),
(404,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:48'),
(405,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:49'),
(406,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:49'),
(407,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:49'),
(408,'insert','master-data > import-massal','tambah wali santri','tambah data wali santri menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:16:49'),
(409,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:55'),
(410,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:55'),
(411,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:55'),
(412,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:55'),
(413,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:55'),
(414,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:55'),
(415,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:56'),
(416,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:56'),
(417,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:56'),
(418,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:31:56'),
(419,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(420,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(421,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(422,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(423,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(424,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(425,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(426,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(427,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(428,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:33:57'),
(429,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:40'),
(430,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:40'),
(431,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:40'),
(432,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:40'),
(433,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:40'),
(434,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:40'),
(435,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:40'),
(436,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:41'),
(437,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:41'),
(438,'insert','master-data > import-massal','tambah ustadz','tambah data ustadz menggunakan import massal','Administrator','103.119.66.176','2022-06-29 16:34:41'),
(439,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-30 13:42:48'),
(440,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-30 13:43:00'),
(441,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-30 13:43:08'),
(442,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 13:43:23'),
(443,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 13:44:49'),
(444,'delete','jadwal','delete jadwal','delete data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 13:44:55'),
(445,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 13:45:01'),
(446,'delete','jadwal','delete jadwal','delete data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 13:45:04'),
(447,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 13:45:54'),
(448,'delete','jadwal','delete jadwal','delete data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 13:46:01'),
(449,'update','jadwal','update jadwal','update data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 14:15:19'),
(450,'update','jadwal','update jadwal','update data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 14:15:26'),
(451,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 15:27:48'),
(452,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-30 15:31:58'),
(453,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-30 15:32:17'),
(454,'insert','master-data > kelas','tambah kelas','tambah data kelas pada halaman kelas','Administrator','103.119.66.176','2022-06-30 15:32:27'),
(455,'insert','rombel','tambah rombel','tambah data rombel pada halaman rombel','Administrator','103.119.66.176','2022-06-30 15:32:59'),
(456,'insert','rombel','tambah rombel','tambah data rombel pada halaman rombel','Administrator','103.119.66.176','2022-06-30 15:33:03'),
(457,'insert','rombel','tambah rombel','tambah data rombel pada halaman rombel','Administrator','103.119.66.176','2022-06-30 15:33:07'),
(458,'insert','rombel','tambah rombel','tambah data rombel pada halaman rombel','Administrator','103.119.66.176','2022-06-30 15:33:11'),
(459,'insert','rombel','tambah rombel','tambah data rombel pada halaman rombel','Administrator','103.119.66.176','2022-06-30 15:33:15'),
(460,'insert','rombel','tambah rombel','tambah data rombel pada halaman rombel','Administrator','103.119.66.176','2022-06-30 15:33:18'),
(461,'delete','jadwal','delete jadwal','delete data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-06-30 15:33:42'),
(462,'insert','store-ws > product-ws','tambah cart','wali santri menambahkan produk kedalam keranjang','Sumanto','103.119.66.176','2022-07-05 09:51:15'),
(463,'insert','jadwal','tambah jadwal','tambah data jadwal pada halaman jadwal','Administrator','103.119.66.176','2022-07-08 08:23:16'),
(464,'delete','order','delete order','delete data order pada halaman order','Administrator','103.119.66.176','2022-07-08 08:47:01'),
(465,'delete','order','delete order','delete data order pada halaman order','Administrator','103.119.66.176','2022-07-08 08:47:03'),
(466,'insert','keuangan > tabungan','tambah tabungan','tambah data tabungan pada halaman tabungan','Administrator','103.119.66.176','2022-07-08 08:47:41'),
(467,'insert','keuangan > tabungan','tambah tabungan','tambah data tabungan pada halaman tabungan','Administrator','103.119.66.176','2022-07-08 08:48:00'),
(468,'insert','keuangan > spp','tambah spp','tambah data spp pada halaman spp','Administrator','103.119.66.176','2022-07-13 09:48:37'),
(469,'insert','keuangan > spp','tambah spp','tambah data spp pada halaman spp','Administrator','103.119.66.176','2022-07-13 10:09:33'),
(470,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 13:44:18'),
(471,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 13:46:00'),
(472,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 14:01:47'),
(473,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 14:09:09'),
(474,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 14:26:01'),
(475,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 14:26:33'),
(476,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 14:28:52'),
(477,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 14:29:43'),
(478,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 15:04:12'),
(479,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 15:04:38'),
(480,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 15:07:21'),
(481,'insert','visitor','pengunjung check in','Penerimaan tamu','Administrator','103.119.66.176','2022-07-14 15:09:52'),
(482,'insert','keuangan > spp','tambah spp','tambah data spp pada halaman spp','Administrator','103.119.66.176','2023-05-23 23:08:31');

/*Table structure for table `mata_pelajaran` */

CREATE TABLE `mata_pelajaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(100) NOT NULL,
  `slug_mapel` varchar(100) DEFAULT NULL,
  `tingkat` bigint unsigned DEFAULT NULL,
  `nilai_kkm` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `mata_pelajaran` */

insert  into `mata_pelajaran`(`id`,`nama_mapel`,`slug_mapel`,`tingkat`,`nilai_kkm`,`created_at`,`updated_at`) values 
(19,'Matematika','matematika',1,75,'2022-06-17 09:06:42',NULL),
(20,'Bahasa Arab','bahasa-arab',2,75,'2022-06-17 09:06:57',NULL),
(21,'Tauhid','tauhid',1,75,'2022-06-28 14:25:14',NULL),
(22,'Tauhid','tauhid',2,75,'2022-06-28 14:25:21',NULL),
(23,'Bahasa Arab','bahasa-arab',1,75,'2022-06-28 14:25:36',NULL),
(24,'Matematika','matematika',2,75,'2022-06-28 14:25:44','2022-06-28 14:25:50');

/*Table structure for table `menus` */

CREATE TABLE `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `parrent_id` bigint DEFAULT NULL,
  `role_id` bigint unsigned NOT NULL,
  `sequence` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `role_menus` (`role_id`),
  CONSTRAINT `role_menus` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `menus` */

insert  into `menus`(`id`,`name`,`slug`,`icon`,`parrent_id`,`role_id`,`sequence`,`created_at`,`updated_at`) values 
(1,'Dashboard','dashboard','ri-home-4-line',0,1,1,'2022-04-14 11:54:39','2022-05-19 10:47:38'),
(2,'Store','store','ri-store-2-fill',0,1,3,'2022-04-14 11:54:39','2022-05-30 09:36:47'),
(3,'Kategori','category','ri-briefcase-3-line',2,1,1,'2022-04-14 11:54:39','2022-05-19 10:47:48'),
(4,'Produk','product','ri-product-hunt-line',2,1,2,'2022-04-14 11:54:39','2022-05-19 10:47:49'),
(5,'Master Data','master-data','ri-database-line',0,1,2,'2022-04-14 11:54:39','2022-05-30 09:36:48'),
(6,'Santri','santri','ri-shield-user-fill',5,1,4,'2022-04-14 11:54:39','2022-05-24 11:16:06'),
(7,'Wali Santri','walisantri','ri-shield-user-line',5,1,5,'2022-04-14 11:54:39','2022-05-24 11:16:07'),
(12,'Dashboard','dashboard','ri-home-4-line',0,2,1,'2022-04-14 11:54:39','2022-06-10 08:32:22'),
(13,'Transaksi','transaksi-k','ri-exchange-dollar-fill',0,2,2,'2022-04-14 11:54:39','2022-05-19 10:48:26'),
(14,'Pesanan','order','ri-briefcase-4-fill',0,2,3,'2022-04-14 11:54:39','2022-05-31 09:16:37'),
(17,'Ustadz','ustadz','ri-shield-user-line',5,1,6,'2022-04-14 11:54:39','2022-05-24 11:16:11'),
(18,'Kelas','kelas','ri-government-fill',5,1,2,'2022-04-14 11:54:39','2022-05-24 11:16:40'),
(20,'Rombongan Belajar','rombel','ri-folder-user-fill',0,1,4,'2022-05-09 11:53:52','2022-05-19 15:12:03'),
(21,'Mata Pelajaran','mapel','ri-book-mark-line',5,1,3,'2022-05-09 11:53:52','2022-05-24 11:16:17'),
(22,'Jadwal','jadwal','ri-timer-flash-line',0,1,5,'2022-05-09 11:53:52','2022-05-19 15:12:03'),
(23,'Kehadiran','kehadiran','ri-timer-flash-line',0,1,6,'2022-05-09 11:53:52','2022-05-19 15:12:03'),
(24,'Transaksi','order','ri-briefcase-4-fill',0,1,9,'2022-05-09 11:53:52','2022-07-13 11:44:45'),
(26,'Dashboard','dashboard','ri-home-4-line',0,5,1,'2022-04-14 11:54:39','2022-06-10 08:32:26'),
(27,'Jadwal','jadwal-us','ri-timer-flash-line',0,5,3,'2022-04-14 11:54:39','2022-07-11 17:47:02'),
(28,'Absensi','absensi-us','ri-list-check-2',0,5,4,'2022-04-14 11:54:39','2022-07-11 17:47:03'),
(30,'Raport','raport-us','ri-file-chart-line',0,5,5,'2022-04-14 11:54:39','2022-05-22 21:45:08'),
(31,'Tahun Ajaran','tahun_ajaran','ri-government-fill',5,1,1,'2022-04-14 11:54:39','2022-05-24 11:16:39'),
(32,'Keuangan','keuangan','ri-money-dollar-box-line',0,1,8,'2022-04-14 11:54:39','2022-05-25 10:40:33'),
(33,'Tabungan Santri','tabungan','ri-money-dollar-box-line',32,1,2,'2022-04-14 11:54:39','2022-05-25 10:40:21'),
(34,'Pembayaran SPP','spp','ri-money-dollar-box-line',32,1,1,'2022-04-14 11:54:39','2022-05-25 10:40:13'),
(37,'Dashboard','dashboard','ri-home-4-line',0,4,1,'2022-04-14 11:54:39','2022-06-10 08:32:44'),
(38,'Daftar Santri','santri-ws','ri-folder-user-line',0,4,2,'2022-04-14 11:54:39','2022-07-11 17:48:59'),
(40,'Keuangan','keuangan-ws','ri-money-dollar-circle-line',0,4,4,'2022-04-14 11:54:39','2022-06-02 08:32:58'),
(41,'Tabungan','tabungan-ws','ri-bank-card-2-fill',40,4,1,'2022-04-14 11:54:39','2022-06-02 08:33:20'),
(42,'Pembayaran SPP','spp-ws','ri-bank-card-line',40,4,2,'2022-04-14 11:54:39','2022-06-02 08:33:28'),
(44,'Pesanan','order-ws','ri-git-repository-private-line',47,4,3,'2022-04-14 11:54:39','2022-06-02 13:57:22'),
(45,'Konfigurasi','config','ri-settings-3-line',0,1,11,'2022-04-14 11:54:39','2022-05-31 09:34:08'),
(46,'Maklumat','maklumat','ri-article-fill',0,1,10,'2022-04-14 11:54:39','2022-05-31 09:34:07'),
(47,'Store','store-ws','ri-store-2-fill',0,4,3,'2022-04-14 11:54:39','2022-06-02 10:51:54'),
(48,'Produk','product-ws','ri-git-repository-private-line',47,4,1,'2022-04-14 11:54:39','2022-06-02 10:52:53'),
(49,'Cart','transaksi-ws','ri-shopping-cart-2-line',47,4,2,'2022-04-14 11:54:39','2022-06-02 14:08:30'),
(50,'Import Massal','import-massal','ri-table-fill',5,1,7,'2022-04-14 11:54:39','2022-06-07 15:10:57'),
(51,'Daftar User','daftar-user','ri-shield-user-fill',0,1,12,'2022-04-14 11:54:39','2022-05-31 09:34:08'),
(52,'Maklumat','maklumat-ws','ri-article-fill',0,4,4,'2022-04-14 11:54:39','2022-05-31 09:34:07'),
(53,'Tambah Saldo','saldo-ws','ri-money-dollar-box-line',40,4,3,'2022-04-14 11:54:39','2022-06-02 08:33:28'),
(54,'History Saldo','saldo','ri-money-dollar-box-line',32,1,3,'2022-04-14 11:54:39','2022-05-25 10:40:13'),
(55,'Profil','profil-ws','ri-file-user-fill',0,4,6,'2022-04-14 11:54:39','2022-06-29 09:59:54'),
(56,'Profil','profil-us','ri-file-user-fill',0,5,8,'2022-04-14 11:54:39','2022-07-11 17:47:27'),
(57,'Sembako Ustadz','sembako-k','ri-store-fill',0,2,4,'2022-04-14 11:54:39','2022-06-20 11:20:59'),
(58,'Laporan','laporan','ri-folder-chart-line',0,1,14,'2022-04-14 11:54:39','2022-07-14 09:15:14'),
(59,'Laporan Transaksi','laporan-transaksi','ri-folder-chart-line',58,1,1,'2022-04-14 11:54:39','2022-05-25 16:19:07'),
(60,'Laporan','laporan-us','ri-folder-chart-line',0,5,7,'2022-04-14 11:54:39','2022-07-11 17:47:25'),
(61,'Laporan Absensi','laporan-us-absensi','ri-folder-chart-line',60,5,1,'2022-04-14 11:54:39','2022-06-29 09:56:49'),
(62,'Laporan','laporan-ws','ri-folder-chart-line',0,4,5,'2022-04-14 11:54:39','2022-06-29 09:59:59'),
(63,'Laporan Absensi','laporan-ws-absensi','ri-folder-chart-line',62,4,1,'2022-04-14 11:54:39','2022-06-29 10:00:49'),
(64,'Daftar Santri','santri-us','ri-file-user-fill',0,5,2,'2022-04-14 11:54:39','2022-07-11 17:47:18'),
(65,'History SPP','history-spp','ri-money-dollar-box-line',32,1,4,'2022-04-14 11:54:39','2022-05-25 10:40:13'),
(66,'Penerimaan Tamu','visitor','ri-pin-distance-line',0,1,13,'2022-04-14 11:54:39','2022-07-14 10:41:14');

/*Table structure for table `mkl_category` */

CREATE TABLE `mkl_category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `udpated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `mkl_category` */

insert  into `mkl_category`(`id`,`title`,`slug`,`created_at`,`udpated_at`) values 
(12,'Pengumuman','pengumuman','2022-06-10 10:59:52',NULL);

/*Table structure for table `mkl_post` */

CREATE TABLE `mkl_post` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `title_excerpt` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `slug` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `thumbnail` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('draft','posted') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'draft',
  `category_id` bigint unsigned DEFAULT NULL COMMENT 'relasi mkl category',
  `role_id` bigint DEFAULT NULL COMMENT 'tujuan postingan untuk sole apa',
  `user_id` bigint unsigned NOT NULL COMMENT 'penulis',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mkl_user_fk` (`user_id`),
  KEY `mkl_category_id` (`category_id`),
  CONSTRAINT `mkl_category_id` FOREIGN KEY (`category_id`) REFERENCES `mkl_category` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `mkl_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mkl_post` */

insert  into `mkl_post`(`id`,`title`,`title_excerpt`,`slug`,`thumbnail`,`content`,`status`,`category_id`,`role_id`,`user_id`,`created_at`,`updated_at`,`deleted_at`) values 
(10,'PENGUMUMAN HASIL SELEKSI CALON SANTRI BARU TA. 2022-2023 M','PENGUMUMAN HASIL SELEKSI CALON SANTRI BA','pengumuman-hasil-seleksi-calon-santri-ba','Untitled.jpg','&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(33, 37, 41); background-color: rgb(249, 249, 249);&quot;&gt;Keputusan Pimpinan Pondok Pesantren DarussalamtentangPenetapan kelulusan peserta seleksi penerimaan santri-santriah baru Tarbiyatul Mu’allimin Al-Islamiyah (TMI) Pondok Pesantren Darussalam:LAMPIRAN SURAT PENETAPAN KELULUSAN NOMOR : 268/OC-a/III/2021Surat Penetapan KelulusanPelaksanaan Silaturahim&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(33, 37, 41); background-color: rgb(249, 249, 249);&quot;&gt;Keputusan Pimpinan Pondok Pesantren DarussalamtentangPenetapan kelulusan peserta seleksi penerimaan santri-santriah baru Tarbiyatul Mu’allimin Al-Islamiyah (TMI) Pondok Pesantren Darussalam:LAMPIRAN SURAT PENETAPAN KELULUSAN NOMOR : 268/OC-a/III/2021Surat Penetapan KelulusanPelaksanaan Silaturahim&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;h1 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 36px; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;Keputusan Pimpinan Pondok Pesantren Darussalam&lt;/h1&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;tentang&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;Penetapan kelulusan peserta seleksi penerimaan santri-santriah baru Tarbiyatul Mu’allimin Al-Islamiyah (TMI) Pondok Pesantren Darussalam:&lt;/p&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;LAMPIRAN SURAT PENETAPAN KELULUSAN NOMOR : 268/OC-a/III/2021&lt;/h4&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/attachment/0001/&quot; rel=&quot;attachment wp-att-1979&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1979&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-scaled.jpg&quot; alt=&quot;&quot; width=&quot;1810&quot; height=&quot;2560&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-scaled.jpg 1810w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1086x1536.jpg 1086w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1448x2048.jpg 1448w&quot; sizes=&quot;(max-width: 1810px) 100vw, 1810px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/attachment/0002/&quot; rel=&quot;attachment wp-att-1980&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1980&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-scaled.jpg&quot; alt=&quot;&quot; width=&quot;1810&quot; height=&quot;2560&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-scaled.jpg 1810w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1086x1536.jpg 1086w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1448x2048.jpg 1448w&quot; sizes=&quot;(max-width: 1810px) 100vw, 1810px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/surat-penetapan-kelulusan/&quot; rel=&quot;attachment wp-att-1978&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;Surat Penetapan Kelulusan&lt;/a&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;Pelaksanaan Silaturahim dan pengenalan Kepesantrenan dilaksanakan pada ;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;a. Putra – Hari Sabtu, 23 Sya’ban 1443H / 26 Maret 2022 M&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;b. Putri – Hari Ahad, 24 Sya’ban 1443H / 27 Maret 2022 M&amp;nbsp;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;Lampiran nama-nama calon santri yang dinyatakan LULUS dan berhak mengikuti pendidikan dan pengajaran di Pondok Pesantren Darussalam Tahun Ajaran 2022-2023 M / 1443 – 1444 H :&lt;/p&gt;&lt;ol style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 20px; outline: 0px; padding: 0px; vertical-align: baseline; list-style-position: initial; list-style-image: initial; color: rgb(51, 51, 51);&quot;&gt;&lt;li style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; font-style: inherit; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;INTENSIF&lt;/h4&gt;&lt;/li&gt;&lt;/ol&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;ul style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 20px; outline: 0px; padding: 0px; vertical-align: baseline; list-style-type: disc; color: rgb(51, 51, 51);&quot;&gt;&lt;li style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; font-style: inherit; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;KELAS INTENSIF “&lt;strong style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: bold; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;PUTRA”&lt;/strong&gt;&lt;/h4&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/0001-2/&quot; rel=&quot;attachment wp-att-1981&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1981&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-scaled.jpg&quot; alt=&quot;&quot; width=&quot;1810&quot; height=&quot;2560&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-scaled.jpg 1810w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-1086x1536.jpg 1086w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-1448x2048.jpg 1448w&quot; sizes=&quot;(max-width: 1810px) 100vw, 1810px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/0002-2/&quot; rel=&quot;attachment wp-att-1982&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1982&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-scaled.jpg&quot; alt=&quot;&quot; width=&quot;1810&quot; height=&quot;2560&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-scaled.jpg 1810w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-1086x1536.jpg 1086w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-1448x2048.jpg 1448w&quot; sizes=&quot;(max-width: 1810px) 100vw, 1810px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-intensif-putra-lulus/&quot; rel=&quot;attachment wp-att-2000&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;Lampiran Intensif Putra Lulus&lt;/a&gt;&lt;/p&gt;&lt;ul style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 20px; outline: 0px; padding: 0px; vertical-align: baseline; list-style-type: disc; color: rgb(51, 51, 51);&quot;&gt;&lt;li style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; font-style: inherit; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;KELAS INTENSIF “&lt;strong style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: bold; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;PUTRI”&lt;/strong&gt;&lt;/h4&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-intensif-putri-lulus_page-0001/&quot; rel=&quot;attachment wp-att-1983&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1983&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-intensif-putri-lulus_page-0002/&quot; rel=&quot;attachment wp-att-1984&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1984&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-intensif-putri-lulus/&quot; rel=&quot;attachment wp-att-2001&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;Lampiran Intensif Putri Lulus&lt;/a&gt;&lt;/p&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;2. REGULER&lt;/h4&gt;&lt;ul style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 20px; outline: 0px; padding: 0px; vertical-align: baseline; list-style-type: disc; color: rgb(51, 51, 51);&quot;&gt;&lt;li style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; font-style: inherit; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;KELAS&lt;strong style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: bold; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&amp;nbsp;REGULER PUTRA&lt;/strong&gt;&lt;/h4&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus1_page-0001/&quot; rel=&quot;attachment wp-att-1985&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1985&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus1_page-0002/&quot; rel=&quot;attachment wp-att-1986&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1986&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0002.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0002.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0002-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0002-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0002-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0002-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus1_page-0003/&quot; rel=&quot;attachment wp-att-1987&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1987&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0003.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0003.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0003-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0003-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0003-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0003-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus1_page-0004/&quot; rel=&quot;attachment wp-att-1988&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1988&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0004.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0004.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0004-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0004-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0004-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0004-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus2_page-0001/&quot; rel=&quot;attachment wp-att-1989&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1989&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0001.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0001.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0001-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0001-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0001-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0001-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus2_page-0002/&quot; rel=&quot;attachment wp-att-1990&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1990&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0002.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0002.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0002-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0002-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0002-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0002-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus2_page-0003/&quot; rel=&quot;attachment wp-att-1991&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1991&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0003.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0003.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0003-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0003-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0003-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0003-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus2_page-0004/&quot; rel=&quot;attachment wp-att-1992&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1992&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0004.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0004.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0004-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0004-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0004-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus2_page-0004-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus/&quot; rel=&quot;attachment wp-att-2002&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;Lampiran Reguler Putra Lulus&lt;/a&gt;&lt;/p&gt;&lt;ul style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 20px; outline: 0px; padding: 0px; vertical-align: baseline; list-style-type: disc; color: rgb(51, 51, 51);&quot;&gt;&lt;li style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; font-style: inherit; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;KELAS&lt;strong style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: bold; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&amp;nbsp;REGULER PUTRI&lt;/strong&gt;&lt;/h4&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putri-lulus1_page-0001/&quot; rel=&quot;attachment wp-att-1993&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1993&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0001.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0001.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0001-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0001-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0001-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0001-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putri-lulus1_page-0002/&quot; rel=&quot;attachment wp-att-1994&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1994&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0002.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0002.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0002-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0002-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0002-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0002-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putri-lulus1_page-0003/&quot; rel=&quot;attachment wp-att-1995&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1995&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0003.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0003.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0003-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0003-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0003-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0003-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putri-lulus1_page-0004/&quot; rel=&quot;attachment wp-att-1996&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1996&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0004.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0004.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0004-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0004-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0004-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus1_page-0004-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putri-lulus2_page-0001/&quot; rel=&quot;attachment wp-att-1997&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1997&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0001.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0001.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0001-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0001-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0001-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0001-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putri-lulus2_page-0002/&quot; rel=&quot;attachment wp-att-1998&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1998&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0002.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0002.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0002-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0002-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0002-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0002-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putri-lulus2_page-0003/&quot; rel=&quot;attachment wp-att-1999&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1999&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0003.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0003.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0003-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0003-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0003-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putri-Lulus2_page-0003-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putri-lulus/&quot; rel=&quot;attachment wp-att-2003&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;Lampiran Reguler Putri Lulus&lt;/a&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;Terimakasih atas kepercayaan bapak/ibu/saudara telah mendaftarkan putra putri terbaiknya, mohon maaf atas segala kekurangan dan ketidaknyamanan yang diterima selama proses pendaftaran.&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(33, 37, 41); background-color: rgb(249, 249, 249);&quot;&gt;Keputusan Pimpinan Pondok Pesantren DarussalamtentangPenetapan kelulusan peserta seleksi penerimaan santri-santriah baru Tarbiyatul Mu’allimin Al-Islamiyah (TMI) Pondok Pesantren Darussalam:LAMPIRAN SURAT PENETAPAN KELULUSAN NOMOR : 268/OC-a/III/2021Surat Penetapan KelulusanPelaksanaan Silaturahim&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(33, 37, 41); background-color: rgb(249, 249, 249);&quot;&gt;Keputusan Pimpinan Pondok Pesantren DarussalamtentangPenetapan kelulusan peserta seleksi penerimaan santri-santriah baru Tarbiyatul Mu’allimin Al-Islamiyah (TMI) Pondok Pesantren Darussalam:LAMPIRAN SURAT PENETAPAN KELULUSAN NOMOR : 268/OC-a/III/2021Surat Penetapan KelulusanPelaksanaan Silaturahim&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;h1 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 36px; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;Keputusan Pimpinan Pondok Pesantren Darussalam&lt;/h1&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;tentang&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;Penetapan kelulusan peserta seleksi penerimaan santri-santriah baru Tarbiyatul Mu’allimin Al-Islamiyah (TMI) Pondok Pesantren Darussalam:&lt;/p&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;LAMPIRAN SURAT PENETAPAN KELULUSAN NOMOR : 268/OC-a/III/2021&lt;/h4&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/attachment/0001/&quot; rel=&quot;attachment wp-att-1979&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1979&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-scaled.jpg&quot; alt=&quot;&quot; width=&quot;1810&quot; height=&quot;2560&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-scaled.jpg 1810w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1086x1536.jpg 1086w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1448x2048.jpg 1448w&quot; sizes=&quot;(max-width: 1810px) 100vw, 1810px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/attachment/0002/&quot; rel=&quot;attachment wp-att-1980&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1980&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-scaled.jpg&quot; alt=&quot;&quot; width=&quot;1810&quot; height=&quot;2560&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-scaled.jpg 1810w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1086x1536.jpg 1086w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1448x2048.jpg 1448w&quot; sizes=&quot;(max-width: 1810px) 100vw, 1810px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/surat-penetapan-kelulusan/&quot; rel=&quot;attachment wp-att-1978&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;Surat Penetapan Kelulusan&lt;/a&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;Pelaksanaan Silaturahim dan pengenalan Kepesantrenan dilaksanakan pada ;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;a. Putra – Hari Sabtu, 23 Sya’ban 1443H / 26 Maret 2022 M&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;b. Putri – Hari Ahad, 24 Sya’ban 1443H / 27 Maret 2022 M&amp;nbsp;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;Lampiran nama-nama calon santri yang dinyatakan LULUS dan berhak mengikuti pendidikan dan pengajaran di Pondok Pesantren Darussalam Tahun Ajaran 2022-2023 M / 1443 – 1444 H :&lt;/p&gt;&lt;ol style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 20px; outline: 0px; padding: 0px; vertical-align: baseline; list-style-position: initial; list-style-image: initial; color: rgb(51, 51, 51);&quot;&gt;&lt;li style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; font-style: inherit; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;INTENSIF&lt;/h4&gt;&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;ul style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 20px; outline: 0px; padding: 0px; vertical-align: baseline; list-style-type: disc; color: rgb(51, 51, 51);&quot;&gt;&lt;li style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; font-style: inherit; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;KELAS INTENSIF “&lt;strong style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: bold; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;PUTRA”&lt;/strong&gt;&lt;/h4&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/0001-2/&quot; rel=&quot;attachment wp-att-1981&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1981&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-scaled.jpg&quot; alt=&quot;&quot; width=&quot;1810&quot; height=&quot;2560&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-scaled.jpg 1810w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-1086x1536.jpg 1086w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0001-1-1448x2048.jpg 1448w&quot; sizes=&quot;(max-width: 1810px) 100vw, 1810px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/0002-2/&quot; rel=&quot;attachment wp-att-1982&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1982&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-scaled.jpg&quot; alt=&quot;&quot; width=&quot;1810&quot; height=&quot;2560&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-scaled.jpg 1810w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-1086x1536.jpg 1086w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/0002-1-1448x2048.jpg 1448w&quot; sizes=&quot;(max-width: 1810px) 100vw, 1810px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-intensif-putra-lulus/&quot; rel=&quot;attachment wp-att-2000&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;Lampiran Intensif Putra Lulus&lt;/a&gt;&lt;/p&gt;&lt;ul style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 20px; outline: 0px; padding: 0px; vertical-align: baseline; list-style-type: disc; color: rgb(51, 51, 51);&quot;&gt;&lt;li style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; font-style: inherit; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;KELAS INTENSIF “&lt;strong style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: bold; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;PUTRI”&lt;/strong&gt;&lt;/h4&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-intensif-putri-lulus_page-0001/&quot; rel=&quot;attachment wp-att-1983&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1983&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0001-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-intensif-putri-lulus_page-0002/&quot; rel=&quot;attachment wp-att-1984&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1984&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Intensif-Putri-Lulus_page-0002-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-intensif-putri-lulus/&quot; rel=&quot;attachment wp-att-2001&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;Lampiran Intensif Putri Lulus&lt;/a&gt;&lt;/p&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;2. REGULER&lt;/h4&gt;&lt;ul style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 20px; outline: 0px; padding: 0px; vertical-align: baseline; list-style-type: disc; color: rgb(51, 51, 51);&quot;&gt;&lt;li style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&lt;h4 style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; font-size: 20px; font-style: inherit; margin-bottom: 15px; outline: 0px; padding: 0px; vertical-align: baseline; clear: both; line-height: 1.3; color: rgb(51, 51, 51);&quot;&gt;KELAS&lt;strong style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: bold; margin: 0px; outline: 0px; padding: 0px; vertical-align: baseline;&quot;&gt;&amp;nbsp;REGULER PUTRA&lt;/strong&gt;&lt;/h4&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;overflow-wrap: break-word; border: 0px; font-family: Roboto, sans-serif; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; outline: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51);&quot;&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lulus1_page-0001/&quot; rel=&quot;attachment wp-att-1985&quot; style=&quot;border: 0px; font-family: inherit; font-style: inherit; font-weight: inherit; margin: 0px; outline-style: initial; outline-width: 0px; padding: 0px; vertical-align: baseline; color: rgb(0, 81, 28); transition-duration: 0.3s; transition-timing-function: ease-in-out;&quot;&gt;&lt;img loading=&quot;lazy&quot; class=&quot;aligncenter size-full wp-image-1985&quot; src=&quot;http://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001.jpg&quot; alt=&quot;&quot; width=&quot;1241&quot; height=&quot;1755&quot; srcset=&quot;https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001.jpg 1241w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001-212x300.jpg 212w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001-724x1024.jpg 724w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001-768x1086.jpg 768w, https://darussalamgarut.or.id/wp-content/uploads/2022/03/Lampiran-Reguler-Putra-Lulus1_page-0001-1086x1536.jpg 1086w&quot; sizes=&quot;(max-width: 1241px) 100vw, 1241px&quot; style=&quot;height: auto; max-width: 100%; border: 0px; clear: both; display: block; margin: 0px auto;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;https://darussalamgarut.or.id/pengumuman-hasil-seleksi-calon-santri-baru-ta-2022-2023-m/lampiran-reguler-putra-lul','posted',12,4,1,'2022-06-10 10:59:52','2022-06-21 16:04:13',NULL),
(12,'PENGUMUMAN HASIL SELEKSI CALON SANTRI BA','PENGUMUMAN HASIL SELEKSI CALON SANTRI BA','pengumuman-hasil-seleksi-calon-santri-ba','leila66Artboard_1-100.jpg','&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(33, 37, 41); background-color: rgb(249, 249, 249);&quot;&gt;Keputusan Pimpinan Pondok Pesantren DarussalamtentangPenetapan kelulusan peserta seleksi penerimaan santri-santriah baru Tarbiyatul Mu’allimin Al-Islamiyah (TMI) Pondok Pesantren Darussalam:LAMPIRAN SURAT PENETAPAN KELULUSAN NOMOR : 268/OC-a/III/2021Surat Penetapan KelulusanPelaksanaan Silaturahim&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(33, 37, 41); background-color: rgb(249, 249, 249);&quot;&gt;Keputusan Pimpinan Pondok Pesantren DarussalamtentangPenetapan kelulusan peserta seleksi penerimaan santri-santriah baru Tarbiyatul Mu’allimin Al-Islamiyah (TMI) Pondok Pesantren Darussalam:LAMPIRAN SURAT PENETAPAN KELULUSAN NOMOR : 268/OC-a/III/2021Surat Penetapan KelulusanPelaksanaan Silaturahim&lt;/span&gt;&lt;br&gt;&lt;/p&gt;','posted',12,4,1,'2022-06-17 15:29:45','2022-06-21 16:11:51',NULL);

/*Table structure for table `payment_types` */

CREATE TABLE `payment_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `type_slug` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `name_slug` varchar(50) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `fee` int unsigned DEFAULT NULL,
  `method` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `payment_types` */

insert  into `payment_types`(`id`,`type`,`type_slug`,`name`,`name_slug`,`logo`,`fee`,`method`) values 
(1,'Transfer Bank','transfer_bank','BCA','BCA','https://dashboard.xendit.co/assets/images/bca-logo.svg',5000,'<ul class=\"nav nav-tabs\" id=\"myTab-three\" role=\"tablist\">\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"atm-tab-three\" data-toggle=\"tab\" href=\"#atm-three\" role=\"tab\" aria-controls=\"atm\"\r\n            aria-selected=\"false\">ATM</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"ibanking-tab-three\" data-toggle=\"tab\" href=\"#ibanking-three\" role=\"tab\"\r\n            aria-controls=\"ibanking\" aria-selected=\"false\">IBANKING</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link active\" id=\"mbanking-tab-three\" data-toggle=\"tab\" href=\"#mbanking-three\" role=\"tab\"\r\n            aria-controls=\"mbanking\" aria-selected=\"true\">MBANKING</a>\r\n    </li>\r\n</ul>\r\n<div class=\"tab-content\" id=\"myTabContent-4\">\r\n    <div class=\"tab-pane fade\" id=\"atm-three\" role=\"tabpanel\" aria-labelledby=\"atm-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;TEMUKAN ATM TERDEKAT</strong></p>\r\n        <p>1. Masukkan Kartu ATM BCA</p>\r\n        <p>2. Masukkan PIN</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih menu &quot;Transaksi Lainnya&quot;</p>\r\n        <p>2. Pilih menu &quot;Transfer&quot;</p>\r\n        <p>3. Pilih menu &quot;ke Rekening BCA Virtual Account&quot;</p>\r\n        <p>4. Masukkan Nomor Virtual Account Anda&nbsp;1076619566405. Tekan &quot;Benar&quot; untuk melanjutkan</p>\r\n        <p>5. Di halaman konfirmasi, pastikan detil pembayaran sudah sesuai seperti No VA, Nama, Perus/Produk dan Total\r\n            Tagihan,\r\n            tekan &quot;Benar&quot; untuk melanjutkan</p>\r\n        <p>6. Pastikan nama kamu dan Total Tagihannya benar</p>\r\n        <p>7. Tekan &quot;Ya&quot; jika sudah benar</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n    <div class=\"tab-pane fade\" id=\"ibanking-three\" role=\"tabpanel\" aria-labelledby=\"ibanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n        <p>1. Lakukan log in pada aplikasi KlikBCA Individual (<a href=\"https://ibank.klikbca.com/\"\r\n                target=\"_blank\">https://ibank.klikbca.com</a>)</p>\r\n        <p>2. Masukkan User ID dan PIN</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih &quot;Transfer Dana&quot;, kemudian pilih &quot;Transfer ke BCA Virtual Account&quot;</p>\r\n        <p>2. Masukkan Nomor Virtual Account&nbsp;1076619566405</p>\r\n        <p>3. Pilih &quot;Lanjutkan&quot;</p>\r\n        <p>4. Masukkan &quot;RESPON KEYBCA APPLI 1&quot; yang muncul pada Token BCA anda, kemudian tekan tombol\r\n            &quot;Kirim&quot;</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n    <div class=\"tab-pane fade active show\" id=\"mbanking-three\" role=\"tabpanel\" aria-labelledby=\"mbanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n        <p>1. Buka aplikasi BCA Mobile</p>\r\n        <p>2. Pilih menu &quot;m-BCA&quot;, kemudian masukkan kode akses m-BCA</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih &quot;m-Transfer&quot;, kemudian pilih &quot;BCA Virtual Account&quot;</p>\r\n        <p>2. Masukkan Nomor Virtual Account anda&nbsp;1076619566405, kemudian tekan &quot;OK&quot;</p>\r\n        <p>3. Tekan tombol &quot;Kirim&quot; yang berada di sudut kanan atas aplikasi untuk melakukan transfer</p>\r\n        <p>4. Tekan &quot;OK&quot; untuk melanjutkan pembayaran</p>\r\n        <p>5. Masukkan PIN Anda untuk meng-otorisasi transaksi</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n</div>'),
(2,'Transfer Bank','transfer_bank','BNI','BNI','https://dashboard.xendit.co/assets/images/bni-logo.svg',5000,'<ul class=\"nav nav-tabs\" id=\"myTab-three\" role=\"tablist\">\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"atm-tab-three\" data-toggle=\"tab\" href=\"#atm-three\" role=\"tab\" aria-controls=\"atm\"\r\n            aria-selected=\"false\">ATM</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"ibanking-tab-three\" data-toggle=\"tab\" href=\"#ibanking-three\" role=\"tab\"\r\n            aria-controls=\"ibanking\" aria-selected=\"false\">IBANKING</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link active\" id=\"mbanking-tab-three\" data-toggle=\"tab\" href=\"#mbanking-three\" role=\"tab\"\r\n            aria-controls=\"mbanking\" aria-selected=\"true\">MBANKING</a>\r\n    </li>\r\n</ul>\r\n<div class=\"tab-content\" id=\"myTabContent-4\">\r\n    <div class=\"tab-pane fade\" id=\"atm-three\" role=\"tabpanel\" aria-labelledby=\"atm-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;TEMUKAN ATM TERDEKAT</strong></p>\r\n        <p>1. Masukkan kartu ATM anda</p>\r\n        <p>2. Pilih bahasa</p>\r\n        <p>3. Masukkan PIN ATM anda</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih &quot;Menu Lainnya&quot;</p>\r\n        <p>2. Pilih &quot;Transfer&quot;</p>\r\n        <p>3. Pilih jenis rekening yang akan anda gunakan (contoh: &quot;Dari Rekening Tabungan&quot;)</p>\r\n        <p>4. Pilih &quot;Virtual Account Billing&quot;</p>\r\n        <p>5. Masukkan Nomor Virtual Account anda&nbsp;880883532715</p>\r\n        <p>6. Tagihan yang harus dibayarkan akan muncul pada layar konfirmasi</p>\r\n        <p>7. Konfirmasi, apabila telah sesuai, lanjutkan transaksi</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n    <div class=\"tab-pane fade\" id=\"ibanking-three\" role=\"tabpanel\" aria-labelledby=\"ibanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n        <p>1. Buka situs&nbsp;<a href=\"https://ibank.bni.co.id/\" target=\"_blank\">https://ibank.bni.co.id</a></p>\r\n        <p>2. Masukkan User ID dan Password</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih menu &quot;Transfer&quot;</p>\r\n        <p>2. Pilih menu &quot;Virtual Account Billing&quot;</p>\r\n        <p>3. Masukkan Nomor Virtual Account&nbsp;880883532715</p>\r\n        <p>4. Lalu pilih rekening debet yang akan digunakan. Kemudian tekan &quot;Lanjut&quot;</p>\r\n        <p>5. Tagihan yang harus dibayarkan akan muncul pada layar konfirmasi</p>\r\n        <p>6. Masukkan Kode Otentikasi Token</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n    <div class=\"tab-pane fade active show\" id=\"mbanking-three\" role=\"tabpanel\" aria-labelledby=\"mbanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n        <p>1. Akses BNI Mobile Banking melalui handphone</p>\r\n        <p>2. Masukkan User ID dan Password</p>\r\n        <p>3. Pilih menu &quot;Transfer&quot;</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih menu &quot;Virtual Account Billing&quot;, lalu pilih rekening debet</p>\r\n        <p>2. Masukkan Nomor Virtual Account anda&nbsp;880883532715&nbsp;pada menu &quot;Input Baru&quot;</p>\r\n        <p>3. Tagihan yang harus dibayarkan akan muncul pada layar konfirmasi</p>\r\n        <p>4. Konfirmasi transaksi dan masukkan Password Transaksi</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n</div>'),
(3,'Transfer Bank','transfer_bank','MANDIRI','MANDIRI','https://dashboard.xendit.co/assets/images/mandiri-logo.svg',5000,'<ul class=\"nav nav-tabs\" id=\"myTab-three\" role=\"tablist\">\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"atm-tab-three\" data-toggle=\"tab\" href=\"#atm-three\" role=\"tab\" aria-controls=\"atm\"\r\n            aria-selected=\"false\">ATM</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"ibanking-tab-three\" data-toggle=\"tab\" href=\"#ibanking-three\" role=\"tab\"\r\n            aria-controls=\"ibanking\" aria-selected=\"false\">IBANKING</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link active\" id=\"mbanking-tab-three\" data-toggle=\"tab\" href=\"#mbanking-three\" role=\"tab\"\r\n            aria-controls=\"mbanking\" aria-selected=\"true\">MBANKING</a>\r\n    </li>\r\n</ul>\r\n<div class=\"tab-content\" id=\"myTabContent-4\">\r\n    <div class=\"tab-pane fade\" id=\"atm-three\" role=\"tabpanel\" aria-labelledby=\"atm-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;TEMUKAN ATM TERDEKAT</strong></p>\r\n        <p>1. Masukkan ATM dan tekan &quot;Bahasa Indonesia&quot;</p>\r\n        <p>2. Masukkan PIN, lalu tekan &quot;Benar&quot;</p>\r\n        <p>3. Pilih &quot;Pembayaran&quot;, lalu pilih &quot;Multi Payment&quot;</p>\r\n        <p>&nbsp;</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Masukkan kode perusahaan &#39;88608&#39; (88608 XENDIT), lalu tekan &#39;BENAR&#39;</p>\r\n        <p>2. Masukkan Nomor Virtual Account&nbsp;8860810925987, lalu tekan &#39;BENAR&#39;</p>\r\n        <p>3. Masukkan nominal yang ingin di transfer, lalu tekan &quot;BENAR&quot;</p>\r\n        <p>4. Informasi pelanggan akan ditampilkan, pilih nomor 1 sesuai dengan nominal pembayaran kemudian tekan\r\n            &quot;YA&quot;\r\n        </p>\r\n        <p>5. Konfirmasi pembayaran akan muncul, tekan &quot;YES&quot;, untuk melanjutkan</p>\r\n        <p>&nbsp;</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Simpan bukti transaksi anda</p>\r\n        <p>2. Transaksi anda berhasil</p>\r\n        <p>3. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n    <div class=\"tab-pane fade\" id=\"ibanking-three\" role=\"tabpanel\" aria-labelledby=\"ibanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n        <p>1. Buka situs Mandiri Internet Banking&nbsp;<a href=\"https://ibank.bankmandiri.co.id/\"\r\n                target=\"_blank\">https://ibank.bankmandiri.co.id</a></p>\r\n        <p>2. Masuk menggunakan USER ID dan PASSWORD anda</p>\r\n        <p>3. Buka halaman beranda, kemudian pilih &quot;Pembayaran&quot;</p>\r\n        <p>4. Pilih &quot;Multi Payment&quot;</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih 88608 XENDIT sebagai penyedia jasa</p>\r\n        <p>2. Masukkan Nomor Virtual Account&nbsp;8860810925987</p>\r\n        <p>3. Lalu pilih Lanjut</p>\r\n        <p>4. Apabila semua detail benar tekan &quot;KONFIRMASI&quot;</p>\r\n        <p>5. Masukkan PIN / Challenge Code Token</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Setelah transaksi pembayaran Anda selesai, simpan bukti pembayaran</p>\r\n        <p>2. Invoice ini akan diperbarui secara otomatis. Ini bisa memakan waktu hingga 5 menit</p>\r\n    </div>\r\n    <div class=\"tab-pane fade active show\" id=\"mbanking-three\" role=\"tabpanel\" aria-labelledby=\"mbanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n        <p>1. Buka aplikasi Livin by Mandiri, masukkan PASSWORD atau lakukan verifikasi wajah</p>\r\n        <p>2. Pilih &quot;Bayar&quot;</p>\r\n        <p>3. Cari &quot;Xendit 88608&quot;</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih Xendit 88608 sebagai penyedia jasa</p>\r\n        <p>2. Masukkan Nomor Virtual Account&nbsp;8860810925987</p>\r\n        <p>3. Nominal pembayaran akan terisi secara otomatis</p>\r\n        <p>4. Tinjau dan konfirmasi detail transaksi anda, lalu tekan Konfirmasi</p>\r\n        <p>5. Selesaikan transaksi dengan memasukkan MPIN anda</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Setelah transaksi pembayaran Anda selesai, simpan bukti pembayaran</p>\r\n        <p>2. Invoice ini akan diperbarui secara otomatis. Ini bisa memakan waktu hingga 5 menit</p>\r\n    </div>\r\n</div>'),
(4,'Transfer Bank','transfer_bank','PERMATA','PERMATA','https://dashboard.xendit.co/assets/images/permata-logo.svg',5000,'<ul class=\"nav nav-tabs\" id=\"myTab-three\" role=\"tablist\">\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"atm-tab-three\" data-toggle=\"tab\" href=\"#atm-three\" role=\"tab\" aria-controls=\"atm\"\r\n            aria-selected=\"false\">ATM</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"ibanking-tab-three\" data-toggle=\"tab\" href=\"#ibanking-three\" role=\"tab\"\r\n            aria-controls=\"ibanking\" aria-selected=\"false\">IBANKING</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link active\" id=\"mbanking-tab-three\" data-toggle=\"tab\" href=\"#mbanking-three\" role=\"tab\"\r\n            aria-controls=\"mbanking\" aria-selected=\"true\">MBANKING</a>\r\n    </li>\r\n</ul>\r\n<div class=\"tab-content\" id=\"myTabContent-4\">\r\n    <div class=\"tab-pane fade\" id=\"atm-three\" role=\"tabpanel\" aria-labelledby=\"atm-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;TEMUKAN ATM TERDEKAT</strong></p>\r\n        <p>1. Masukkan kartu ATM Permata anda</p>\r\n        <p>2. Masukkan PIN</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih menu &quot;Transaksi Lainnya&quot;</p>\r\n        <p>2. Pilih menu &quot;Pembayaran&quot;</p>\r\n        <p>3. Pilih menu &quot;Pembayaran Lainnya&quot;</p>\r\n        <p>4. Pilih menu &quot;Virtual Account&quot;</p>\r\n        <p>5. Masukkan Nomor Virtual Account&nbsp;729359198010</p>\r\n        <p>6. Lalu pilih rekening debet yang akan digunakan</p>\r\n        <p>7. Konfirmasi detail transaksi anda</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n    <div class=\"tab-pane fade\" id=\"ibanking-three\" role=\"tabpanel\" aria-labelledby=\"ibanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n        <p>1. Buka situs&nbsp;<a href=\"https://new.permatanet.com/\" target=\"_blank\">https://new.permatanet.com</a></p>\r\n        <p>2. Masukkan User ID dan Password</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih &quot;Pembayaran Tagihan&quot;</p>\r\n        <p>2. Pilih &quot;Virtual Account&quot;</p>\r\n        <p>3. Masukk Nomor Virtual Account&nbsp;729359198010</p>\r\n        <p>4. Periksa kembali detail pembayaran anda</p>\r\n        <p>5. Masukkan otentikasi transaksi/token</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n    <div class=\"tab-pane fade active show\" id=\"mbanking-three\" role=\"tabpanel\" aria-labelledby=\"mbanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n        <p>1. Buka aplikasi PermataMobile Internet</p>\r\n        <p>2. Masukkan User ID dan Password</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Pilih &quot;Pembayaran Tagihan&quot;</p>\r\n        <p>2. Pilih &quot;Virtual Account&quot;</p>\r\n        <p>3. Masukkan Nomor Virtual Account Anda&nbsp;729359198010</p>\r\n        <p>4. Masukkan otentikasi transaksi/token</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n</div>'),
(5,'Transfer Bank','transfer_bank','SAHABAT SAMPOERNA','SAHABAT_SAMPOERNA','https://dashboard.xendit.co/assets/images/bss-logo.svg',5000,NULL),
(6,'Transfer Bank','transfer_bank','BRI','BRI','https://dashboard.xendit.co/assets/images/bri-logo.svg',5000,'<ul class=\"nav nav-tabs\" id=\"myTab-three\" role=\"tablist\">\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"atm-tab-three\" data-toggle=\"tab\" href=\"#atm-three\" role=\"tab\" aria-controls=\"atm\"\r\n            aria-selected=\"false\">ATM</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"ibanking-tab-three\" data-toggle=\"tab\" href=\"#ibanking-three\" role=\"tab\"\r\n            aria-controls=\"ibanking\" aria-selected=\"false\">IBANKING</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link active\" id=\"mbanking-tab-three\" data-toggle=\"tab\" href=\"#mbanking-three\" role=\"tab\"\r\n            aria-controls=\"mbanking\" aria-selected=\"true\">MBANKING</a>\r\n    </li>\r\n</ul>\r\n<div class=\"tab-content\" id=\"myTabContent-4\">\r\n    <div class=\"tab-pane fade\" id=\"atm-three\" role=\"tabpanel\" aria-labelledby=\"atm-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;TEMUKAN ATM TERDEKAT</strong></p>\r\n        <p>1. Masukkan kartu, kemudian pilih bahasa dan masukkan PIN anda</p>\r\n        <p>2. Pilih &quot;Transaksi Lain&quot; dan pilih &quot;Pembayaran&quot;</p>\r\n        <p>3. Pilih menu &quot;Lainnya&quot; dan pilih &quot;Briva&quot;</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Masukkan Nomor Virtual Account&nbsp;9200122391342&nbsp;dan jumlah yang ingin anda bayarkan</p>\r\n        <p>2. Periksa data transaksi dan tekan &quot;YA&quot;</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n    </div>\r\n    <div class=\"tab-pane fade\" id=\"ibanking-three\" role=\"tabpanel\" aria-labelledby=\"ibanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n        <p>1. Buka situs&nbsp;<a href=\"https://ib.bri.co.id/ib-bri/\" target=\"_blank\">https://ib.bri.co.id/ib-bri/</a>,\r\n            dan\r\n            masukkan USER ID dan PASSWORD anda</p>\r\n        <p>2. Pilih &quot;Pembayaran&quot; dan pilih &quot;Briva&quot;</p>\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n        <p>1. Masukkan Nomor Virtual Account&nbsp;9200122391342&nbsp;dan jumlah yang ingin anda bayarkan</p>\r\n        <p>2. Masukkan password anda kemudian masukkan mToken internet banking</p>\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n        <p>1. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n\r\n    </div>\r\n    <div class=\"tab-pane fade active show\" id=\"mbanking-three\" role=\"tabpanel\" aria-labelledby=\"mbanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n\r\n        <p>1. Buka aplikasi BRI Mobile Banking, masukkan USER ID dan PIN anda</p>\r\n\r\n        <p>2. Pilih &quot;Pembayaran&quot; dan pilih &quot;Briva&quot;</p>\r\n\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n\r\n        <p>1. Masukkan Nomor Virtual Account anda&nbsp;9200122391342&nbsp;dan jumlah yang ingin anda bayarkan</p>\r\n\r\n        <p>2. Masukkan PIN Mobile Banking BRI</p>\r\n\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n\r\n        <p>1. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n\r\n    </div>\r\n</div>'),
(7,'Transfer Bank','transfer_bank','BSI','BSI','https://dashboard.xendit.co/assets/images/bsi-logo.svg',5000,'<ul class=\"nav nav-tabs\" id=\"myTab-three\" role=\"tablist\">\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"atm-tab-three\" data-toggle=\"tab\" href=\"#atm-three\" role=\"tab\" aria-controls=\"atm\"\r\n            aria-selected=\"false\">ATM</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link\" id=\"ibanking-tab-three\" data-toggle=\"tab\" href=\"#ibanking-three\" role=\"tab\"\r\n            aria-controls=\"ibanking\" aria-selected=\"false\">IBANKING</a>\r\n    </li>\r\n    <li class=\"nav-item\">\r\n        <a class=\"nav-link active\" id=\"mbanking-tab-three\" data-toggle=\"tab\" href=\"#mbanking-three\" role=\"tab\"\r\n            aria-controls=\"mbanking\" aria-selected=\"true\">MBANKING</a>\r\n    </li>\r\n</ul>\r\n<div class=\"tab-content\" id=\"myTabContent-4\">\r\n    <div class=\"tab-pane fade\" id=\"atm-three\" role=\"tabpanel\" aria-labelledby=\"atm-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;TEMUKAN ATM TERDEKAT</strong></p>\r\n\r\n        <p>1. Masukkan kartu ATM BSI anda</p>\r\n\r\n        <p>2. Masukkan PIN</p>\r\n\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n\r\n        <p>1. Pilih menu &quot;Pembayaran/Pembelian&quot;</p>\r\n\r\n        <p>2. Pilih menu &quot;Institusi&quot;</p>\r\n\r\n        <p>3. Masukkan kode BSI VA Nomor Virtual Account&nbsp;9347999947581998</p>\r\n\r\n        <p>4. Detail yang ditampilkan: NIM, Nama, &amp; Total Tagihan</p>\r\n\r\n        <p>5. Konfirmasi detail transaksi anda</p>\r\n\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n\r\n    </div>\r\n    <div class=\"tab-pane fade\" id=\"ibanking-three\" role=\"tabpanel\" aria-labelledby=\"ibanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n\r\n        <p>1. Buka situs&nbsp;<a href=\"https://bsinet.bankbsi.co.id/\" target=\"_blank\">https://bsinet.bankbsi.co.id</a>\r\n        </p>\r\n\r\n        <p>2. Masukkan User ID dan Password</p>\r\n\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n\r\n        <p>1. Pilih Menu &quot;Pembayaran&quot;</p>\r\n\r\n        <p>2. Pilih Nomor Rekening BSI Anda</p>\r\n\r\n        <p>3. Pilih menu &quot;Institusi&quot;</p>\r\n\r\n        <p>4. Masukkan nama institusi Xendit (kode 9347)</p>\r\n\r\n        <p>5. Masukkan Nomor Virtual Account tanpa diikuti kode institusi (tanpa 4 digit pertama)&nbsp;9347999947581998\r\n        </p>\r\n\r\n        <p>6. Konfirmasi detail transaksi anda</p>\r\n\r\n        <p>7. Masukkan otentikasi transaksi/token</p>\r\n\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n\r\n    </div>\r\n    <div class=\"tab-pane fade active show\" id=\"mbanking-three\" role=\"tabpanel\" aria-labelledby=\"mbanking-tab-three\">\r\n        <p><strong>LANGKAH&nbsp;1:&nbsp;MASUK KE AKUN ANDA</strong></p>\r\n\r\n        <p>1. Buka aplikasi BSI Mobile</p>\r\n\r\n        <p>2. Masukkan User ID dan Password</p>\r\n\r\n        <p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n\r\n        <p>1. Pilih Menu &quot;Pembayaran&quot;</p>\r\n\r\n        <p>2. Pilih Nomor Rekening BSI Anda</p>\r\n\r\n        <p>3. Pilih menu &quot;Institusi&quot;</p>\r\n\r\n        <p>4. Masukkan nama institusi Xendit (kode 9347)</p>\r\n\r\n        <p>5. Masukkan Nomor Virtual Account tanpa diikuti kode institusi (tanpa 4 digit pertama)&nbsp;9347999947581998\r\n        </p>\r\n\r\n        <p>6. Konfirmasi detail transaksi anda</p>\r\n\r\n        <p>7. Masukkan otentikasi transaksi/token</p>\r\n\r\n        <p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n\r\n        <p>1. Transaksi Anda telah selesai</p>\r\n\r\n        <p>2. Setelah transaksi anda selesai, invoice ini akan diupdate secara otomatis. Proses ini mungkin memakan\r\n            waktu hingga\r\n            5 menit</p>\r\n\r\n        <p>&nbsp;</p>\r\n\r\n    </div>\r\n</div>'),
(8,'EWallets','ewallets','OVO','ID_OVO','https://dashboard.xendit.co/assets/images/ovo-logo.svg',3000,NULL),
(9,'EWallets','ewallets','DANA','ID_DANA','https://dashboard.xendit.co/assets/images/dana-logo.svg',3000,NULL),
(10,'EWallets','ewallets','LINKAJA','ID_LINKAJA','https://dashboard.xendit.co/assets/images/linkaja-logo.svg',5000,NULL),
(11,'Retail Outlets','retails','ALFAMART','ALFAMART','https://dashboard.xendit.co/assets/images/alfamart-logo.svg',5000,'<p><strong>LANGKAH&nbsp;1:&nbsp;TEMUKAN CABANG TERDEKAT</strong></p>\r\n\r\n<p>1. Kunjungi Alfamart or Alfamidi terdekat sebelum invoice kadaluarsa</p>\r\n\r\n<p>2. Sebutkan pembayaran melalui&nbsp;&quot;Checkout Demo Account&quot;&nbsp;ke kasir, atau berikan kode barcode untuk di scan oleh kasir.</p>\r\n\r\n<p><strong>LANGKAH&nbsp;2:&nbsp;DETAIL PEMBAYARAN</strong></p>\r\n\r\n<p>1. Berikan kode pembayaran yang ada di invoice, dan pastikan nominal yang akan dibayarkan sudah benar</p>\r\n\r\n<p>2. Lanjutkan pembayaran anda dengan nominal yang disebutkan di invoice</p>\r\n\r\n<p><strong>LANGKAH&nbsp;3:&nbsp;TRANSAKSI BERHASIL</strong></p>\r\n\r\n<p>1. Terima bukti pembayaran anda dari kasir</p>\r\n\r\n<p>2. Pembayaran anda berhasil</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(12,'QR Codes','qrcode','QRIS','QRIS','https://dashboard.xendit.co/assets/images/qris-logo.svg',5000,NULL),
(13,'Credit Card','credit_card','CREDIT CARD','credit_card','https://arakbrembali.com/wp-content/uploads/2021/03/brandcc.jpg',5000,NULL);

/*Table structure for table `pembayaran_spp` */

CREATE TABLE `pembayaran_spp` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` bigint unsigned DEFAULT NULL,
  `santri_id` bigint unsigned NOT NULL,
  `nominal` bigint DEFAULT NULL,
  `bulan` enum('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tahun_ajaran_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `status_code` int DEFAULT '203',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `spp_santri_fk` (`santri_id`),
  KEY `spp_tahun_ajaran_id` (`tahun_ajaran_id`),
  KEY `spp_bill_id_fk` (`bill_id`),
  KEY `spp_user_fk` (`user_id`),
  CONSTRAINT `spp_bill_id_fk` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `spp_santri_fk` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `spp_tahun_ajaran_id` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `spp_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pembayaran_spp` */

insert  into `pembayaran_spp`(`id`,`bill_id`,`santri_id`,`nominal`,`bulan`,`tahun_ajaran_id`,`user_id`,`status_code`,`created_at`,`updated_at`) values 
(6,117,66,200000,'januari',5,1,200,'2022-07-13 15:30:16','2022-07-13 16:08:14'),
(7,118,66,200000,'februari',5,1,200,'2022-07-13 16:17:26','2022-07-13 16:18:15');

/*Table structure for table `penilaian` */

CREATE TABLE `penilaian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `raport_id` bigint unsigned NOT NULL,
  `mapel_id` bigint unsigned NOT NULL,
  `nilai_angka` int DEFAULT NULL,
  `nilai_huruf` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nilai_mapel_fk` (`mapel_id`),
  KEY `nilai_raport_id` (`raport_id`),
  CONSTRAINT `nilai_mapel_fk` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_raport_id` FOREIGN KEY (`raport_id`) REFERENCES `raport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penilaian` */

/*Table structure for table `personal_access_tokens` */

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `product_images` */

CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned DEFAULT NULL,
  `file_name` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `images_product_id_fk` (`product_id`),
  CONSTRAINT `images_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

/*Data for the table `product_images` */

insert  into `product_images`(`id`,`product_id`,`file_name`,`created_at`) values 
(33,43,'abeb36ce22dd5b51e7ab6b266f68f83f.jpg','2022-06-17 08:39:38'),
(34,43,'IMG_03062020_160943__822_x_430_piksel_.jpg','2022-06-17 08:39:38'),
(35,24,'069244600_1585909700-fried-2509089_1920.jpg','2022-06-17 08:52:27'),
(36,23,'cara-membuat-nasi-uduk-MAHI-1.jpg','2022-06-17 08:53:07'),
(37,34,'ffda46b8-9226-48a2-b419-f93270992817.jpg','2022-06-17 10:44:59'),
(38,44,'merk-mesin-fotocopy-.jpg','2022-06-17 10:45:48'),
(39,20,'data.jpeg','2022-06-17 10:46:43'),
(40,45,'alat-tulis_20170902_121415.jpg','2022-06-28 10:24:14');

/*Table structure for table `products` */

CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `barcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `price` double NOT NULL,
  `stok` int NOT NULL DEFAULT '1',
  `satuan` enum('pcs','kilo','lembar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pcs',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_fk` (`category_id`),
  CONSTRAINT `category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `products` */

insert  into `products`(`id`,`title`,`description`,`barcode`,`category_id`,`price`,`stok`,`satuan`,`created_at`,`updated_at`) values 
(20,'Jus Alpukat','jus alpukat murah meriah','1554487',6,5000,1,'pcs','2022-06-09 08:41:00',NULL),
(23,'Nasi Uduk','nasi uduk + ayam + oreg tempe\r\n','1554487',5,15000,-4,'kilo','2022-06-15 09:35:29',NULL),
(24,'Nasi Goreng','nasi goreng + ayam goreng + baso + telor','1554487',5,15000,47,'pcs','2022-06-15 09:42:56',NULL),
(34,'Es teh manis','es teh manis campur gula 1 kilo','1554487',6,8000,39,'pcs','2022-06-15 15:05:37',NULL),
(42,'Keripik Kentang','Keripik kentang enak','1554487',5,2000,8,'pcs','2022-06-17 08:37:49',NULL),
(43,'Keripik Pisang','keripik pisang enak 1 bungkus 2000','7897545478',5,2000,38,'pcs','2022-06-17 08:39:38',NULL),
(44,'Fotocopy','jasa fotocopy murah 250/lembar','258741414',7,250,10000,'lembar','2022-06-17 08:40:38',NULL),
(45,'Pulpen Standard','Pulpen merek standard','254654654',8,2000,100,'pcs','2022-06-28 10:24:14',NULL);

/*Table structure for table `raport` */

CREATE TABLE `raport` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `santri_id` bigint unsigned NOT NULL,
  `tahun_ajaran_id` bigint unsigned NOT NULL,
  `naik_kelas` varchar(20) DEFAULT NULL,
  `total_sakit` int unsigned DEFAULT NULL,
  `total_izin` int unsigned DEFAULT NULL,
  `total_tanpa_keterangan` int unsigned DEFAULT NULL,
  `akhlak_kepribadian` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `raport_santri_id` (`santri_id`),
  KEY `raport_tahun_ajaran_id` (`tahun_ajaran_id`),
  CONSTRAINT `raport_santri_id` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `raport_tahun_ajaran_id` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `raport` */

/*Table structure for table `roles` */

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`slug`,`created_at`,`updated_at`) values 
(1,'Administrator','admin','2022-04-13 13:08:53','2022-04-13 13:08:53'),
(2,'Kasir','kasir','2022-04-13 13:08:53','2022-04-13 13:08:53'),
(3,'Santri','santri','2022-04-27 13:20:29',NULL),
(4,'Wali Santri','wali_santri','2022-04-28 14:31:49',NULL),
(5,'Ustadz','ustadz','2022-05-19 11:35:02',NULL);

/*Table structure for table `rombel` */

CREATE TABLE `rombel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint unsigned NOT NULL,
  `santri_id` bigint unsigned NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `rombel_kelas_fk` (`kelas_id`),
  KEY `rombel_santri_fk` (`santri_id`),
  CONSTRAINT `rombel_kelas_fk` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rombel_santri_fk` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

/*Data for the table `rombel` */

insert  into `rombel`(`id`,`kelas_id`,`santri_id`,`created_at`,`updated_at`) values 
(26,11,64,'2022-06-30 15:32:59',NULL),
(27,11,65,'2022-06-30 15:32:59',NULL),
(28,13,66,'2022-06-30 15:33:03',NULL),
(29,13,67,'2022-06-30 15:33:03',NULL),
(30,15,68,'2022-06-30 15:33:07',NULL),
(31,15,69,'2022-06-30 15:33:07',NULL),
(32,12,70,'2022-06-30 15:33:11',NULL),
(33,12,71,'2022-06-30 15:33:11',NULL),
(34,14,72,'2022-06-30 15:33:15',NULL),
(35,16,73,'2022-06-30 15:33:18',NULL);

/*Table structure for table `santri` */

CREATE TABLE `santri` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tag_id` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nis` int NOT NULL,
  `jenis_kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `wali_id` bigint unsigned DEFAULT NULL,
  `saldo` bigint DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_fk` (`user_id`),
  KEY `wali_id` (`wali_id`),
  CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `santri` */

insert  into `santri`(`id`,`user_id`,`tag_id`,`nis`,`jenis_kelamin`,`tempat_lahir`,`tanggal_lahir`,`wali_id`,`saldo`,`created_at`,`updated_at`) values 
(64,3,NULL,854231312,'L','Serang','2022-08-03',14,10000,'2022-06-29 16:05:21','2023-04-17 08:46:24'),
(65,4,'2B71171A',456489787,'L','Cilegon','0000-00-00',17,100000,'2022-06-29 16:05:21','2022-07-13 17:14:40'),
(66,5,'3B3CD719',58748262,'L','Banten','0000-00-00',17,0,'2022-06-29 16:05:21','2022-07-14 10:09:28'),
(67,6,NULL,338993263,'P','Tanggerang','0000-00-00',NULL,0,'2022-06-29 16:05:21',NULL),
(68,7,NULL,736734788,'P','Bali','0000-00-00',NULL,0,'2022-06-29 16:05:21',NULL),
(69,8,NULL,1134476313,'L','Kalimantan','0000-00-00',NULL,0,'2022-06-29 16:05:21',NULL),
(70,9,NULL,1532217838,'L','Banten','0000-00-00',NULL,0,'2022-06-29 16:05:21',NULL),
(71,10,NULL,1929959363,'L','Pandeglang','0000-00-00',NULL,0,'2022-06-29 16:05:21',NULL),
(72,11,NULL,2147483647,'L','Rangkas','0000-00-00',NULL,0,'2022-06-29 16:05:21',NULL),
(73,12,NULL,2147483647,'P','Jakarta','0000-00-00',NULL,0,'2022-06-29 16:05:21',NULL);

/*Table structure for table `sembako` */

CREATE TABLE `sembako` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ustadz_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL COMMENT 'kasir yang memberikan',
  `tahun_ajaran_id` bigint unsigned DEFAULT NULL,
  `bulan` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sembako_ustadz_id_fk` (`ustadz_id`),
  KEY `sembako_tahun_ajaran_fk` (`tahun_ajaran_id`),
  KEY `sembako_user_id` (`user_id`),
  CONSTRAINT `sembako_tahun_ajaran_fk` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`),
  CONSTRAINT `sembako_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `sembako_ustadz_id_fk` FOREIGN KEY (`ustadz_id`) REFERENCES `ustadz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sembako` */

/*Table structure for table `sembako_detail` */

CREATE TABLE `sembako_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sembako_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `total_item` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sd_sembako_id_fk` (`sembako_id`),
  KEY `sd_product_id_fk` (`product_id`),
  CONSTRAINT `sd_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `sd_sembako_id_fk` FOREIGN KEY (`sembako_id`) REFERENCES `sembako` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sembako_detail` */

/*Table structure for table `tabungan` */

CREATE TABLE `tabungan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `santri_id` bigint unsigned NOT NULL,
  `nominal` bigint DEFAULT NULL,
  `debit_kredit` enum('debit','kredit') DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL COMMENT 'User Penerima uang',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tabungan_santri_fk` (`santri_id`),
  KEY `tabungan_user_fk` (`user_id`),
  CONSTRAINT `tabungan_santri_fk` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tabungan_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `tabungan` */

insert  into `tabungan`(`id`,`santri_id`,`nominal`,`debit_kredit`,`user_id`,`created_at`,`updated_at`) values 
(5,73,200000,'debit',1,'2022-07-08 08:47:41',NULL),
(6,65,250000,'debit',1,'2022-07-08 08:48:00',NULL);

/*Table structure for table `tags` */

CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `in_use` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tags` */

insert  into `tags`(`id`,`tag_id`,`in_use`,`created_at`) values 
(29,'2B71171A',1,'2022-07-08 08:33:49'),
(30,'B33F745',1,'2022-07-08 08:34:41'),
(31,'3B3CD719',1,'2022-07-14 10:09:25');

/*Table structure for table `tahun_ajaran` */

CREATE TABLE `tahun_ajaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` varchar(30) NOT NULL,
  `semester` enum('genap','ganjil') DEFAULT NULL,
  `status` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tahun_ajaran` */

insert  into `tahun_ajaran`(`id`,`tahun_ajaran`,`semester`,`status`) values 
(5,'2021 / 2022','genap',1);

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint unsigned NOT NULL,
  `status` bigint DEFAULT '0',
  `images` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `roles_users` (`role_id`),
  CONSTRAINT `roles_users` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`role_id`,`status`,`images`,`created_at`,`updated_at`) values 
(1,'Administrator','admin@mindotek.com',NULL,'$2y$10$UFcHvhQLBZxdLT69jXnc3uQ94yDw1EiD4zA7/o5.ZTS4UMFPtlsqW','VA3V9DSkyzJzxC1gW2lRXcg1TGppHKQsv0wIMl8PXRnHd9b65KOyYSrLsMo8Zdca',1,1,'8d7cce30957206cd83a26b986052f5c4.png','2022-04-13 13:08:53','2022-04-13 13:08:53'),
(2,'Ahmad Fatoni','kasir@mindotek.com',NULL,'$2y$10$UFcHvhQLBZxdLT69jXnc3uQ94yDw1EiD4zA7/o5.ZTS4UMFPtlsqW',NULL,2,1,'380fc46cce1a93965798d8414d154b17.png','2022-04-13 13:08:53','2022-04-13 13:08:53'),
(3,'Ahmad Fatoni','ahmad_fatoni@gmail.com',NULL,'$2y$10$E0hwokYYC1no64whqrCGzeyLRak7SyTN4eb.sSdXlODzxs14FrHNS',NULL,3,0,NULL,'2022-06-29 16:05:20',NULL),
(4,'Ilham Taufik','ilham_taufik@gmail.com',NULL,'$2y$10$XznqOr7pVcMqxaR6KRrree.iQj6UfRrx7DPU60555Ro1JWNyDIsWq',NULL,3,0,NULL,'2022-06-29 16:05:21',NULL),
(5,'Rian','rian@gmail.com',NULL,'$2y$10$045S07rdvRwhV91Yh7hxO.EykSjcbsu2Cli0gvB4fsaQKiWEuDhj.',NULL,3,0,NULL,'2022-06-29 16:05:21',NULL),
(6,'Risa Nurhanipah','risa_nurhanipah@gmail.com',NULL,'$2y$10$nX191EX4IQ3mxSr857xzBOXqefhoas9qBTGgB6eUBhUw9ToD58kKG',NULL,3,0,NULL,'2022-06-29 16:05:21',NULL),
(7,'Sarah','sarah@gmail.com',NULL,'$2y$10$z2ceJ5xYf6HKxnRRh6Dszu2Esl8RhrFIXC1IwBp.eScXN2SK1u4ym',NULL,3,0,NULL,'2022-06-29 16:05:21',NULL),
(8,'Irsyad','irsyad@gmail.com',NULL,'$2y$10$aYJCZ96W3YMZRNsqXhYFzeGRWzqxF.SdvPFdS6Qk9JGzsRGa2dm1C',NULL,3,0,NULL,'2022-06-29 16:05:21',NULL),
(9,'Topik','topik@gmail.com',NULL,'$2y$10$nR8jmk/S4/1UQwWxbVOfqelOATW/g.ONyP83rVokAOJGSkxiBrMoy',NULL,3,0,NULL,'2022-06-29 16:05:21',NULL),
(10,'Marsha','marsha@gmail.com',NULL,'$2y$10$NYay0XhnpHJuopXIaTJ50.HDtrKBN0jfHqecNQZk5huFTQ00yzBPe',NULL,3,0,NULL,'2022-06-29 16:05:21',NULL),
(11,'Irfan','irfan@gmail.com',NULL,'$2y$10$HCkjWHzIDy8KBMO7PydhKum4nMK3qfQ5/i9QLRD9Y4LD6AkYndv9C',NULL,3,0,NULL,'2022-06-29 16:05:21',NULL),
(12,'Nurul','nurul@gmail.com',NULL,'$2y$10$AByNer5eRjzB0GjYPD8b3.Ft69dwCOYU8RaFgQt.fUOJZec/8owUa',NULL,3,0,NULL,'2022-06-29 16:05:21',NULL),
(13,'Munir','munir@gmail.com',NULL,'$2y$10$WZwTheJpPuAjpciU/EbnUOoabJmUEXPQGCkqLo23hQUCqdstoJ0AG',NULL,4,1,NULL,'2022-06-29 16:16:48',NULL),
(14,'Prasojo Utomo','prasojo_utomo@gmail.com',NULL,'$2y$10$6ojk9gBxd8JJYttjcILLwelrFEImVHgu1z2tdazTZL5cz4jEPBSG2',NULL,4,1,NULL,'2022-06-29 16:16:48',NULL),
(15,'Arvita','arvita@gmail.com',NULL,'$2y$10$dF9hFGKr13r3udbswzjqKOn/2ONqMagwhStrHScTFIH//BIo9Tjq.',NULL,4,1,NULL,'2022-06-29 16:16:48',NULL),
(16,'Maemunah','maemunah@gmail.com',NULL,'$2y$10$qIRc6XWg5FaMltDql/mHOuNSVLW2/EhW4Bu7GJM1Y72/H7QSptVRK',NULL,4,1,NULL,'2022-06-29 16:16:48',NULL),
(17,'Supardi','supardi@gmail.com',NULL,'$2y$10$MF2qzMeeJRF/JG9Qiic1ru1/JcOv5zQtHk6dTSu3EujfctbkFu8Ny',NULL,4,1,NULL,'2022-06-29 16:16:48',NULL),
(18,'Sakimah','sakimah@gmail.com',NULL,'$2y$10$PdAiQe8c5TEjz60Pjm0YjOsHVFdwIjJP7ufoD4jsL9zky5.rRFWuy',NULL,4,1,NULL,'2022-06-29 16:16:48',NULL),
(19,'Sumanto','sumanto@gmail.com',NULL,'$2y$10$OUNDwaB7Yv4Hrc3DnMR.A.mbla3lfDQ4qcbXv/IwZBJNgDjRXaGLW',NULL,4,1,NULL,'2022-06-29 16:16:49',NULL),
(20,'Arif Hidayat','arif_hidayat@gmail.com',NULL,'$2y$10$4UaP1tJMYUuQ1PKxOlxm3esO7754CHwsJtu.lhs8whXxS9BSWAnPu',NULL,4,1,NULL,'2022-06-29 16:16:49',NULL),
(21,'Hidayatullah','hidayatullah@gmail.com',NULL,'$2y$10$HNyoth0WmTNOkWXhDQYpAu6BCjfSKjVhbbHMgIa4up35duQ4DrXYm',NULL,4,1,NULL,'2022-06-29 16:16:49',NULL),
(22,'Maman','maman@gmail.com',NULL,'$2y$10$yhvDGyHueIoa6CidMz6UbOwBuIWDOhn0Ojt89gkTM4ty/EMVlzQRy',NULL,4,1,NULL,'2022-06-29 16:16:49',NULL),
(33,'Lia Karlina','lia_karlina@gmail.com',NULL,'$2y$10$yOtTUGTMyA5IttHJuEiLIuJcV7ywqS79/Zsr7VacL2YmbdnAQl7Oy','5ZyFtBuuQ9bYWJRw4zHJivhCXEp4qOns80cMcd61GVjGrDmyfXbZBlo32VfvwlpF',5,1,'184abfec652a23c3106c06d117425b34.jpg','2022-06-29 16:34:40',NULL),
(34,'Ahmad Abuja','ahmad_abuja@gmail.com',NULL,'$2y$10$nIUDTKxp7A174FmXft2zF.9jxI2aBkJKDE8d8Z4EXGI1zVpow.zNG',NULL,5,1,NULL,'2022-06-29 16:34:40',NULL),
(35,'Eman Firdaus','eman_firdaus@gmail.com',NULL,'$2y$10$PzPiCAE/a0Uupr386E6.quNcr83yKXXXvIoyGQuG3t39J05RT04Ry',NULL,5,1,NULL,'2022-06-29 16:34:40',NULL),
(36,'Sudarto','sudarto@gmail.com',NULL,'$2y$10$iq2rJFjFAI5qE9J6bTp2.O.SWdK8Pg4/QF7pb4511GIAfC02LRkNu',NULL,5,1,NULL,'2022-06-29 16:34:40',NULL),
(37,'Ahmad Rizky','ahmad_rizky@gmail.com',NULL,'$2y$10$NiXs82q0IFfF/8tzJkhKku1RA0n.azAxDZWFHvrWoVOAj0Z/GMP.W',NULL,5,1,NULL,'2022-06-29 16:34:40',NULL),
(38,'Nurdiana Putri','nurdiana_putri@gmail.com',NULL,'$2y$10$01RclhaQxBmH185F4Oqyfe5OLJ9JshSoXMClwUVgwX28ofMn4SX3a',NULL,5,1,NULL,'2022-06-29 16:34:40',NULL),
(39,'Lisa Nurlela','lisa_nurlela@gmail.com',NULL,'$2y$10$fI2sFzkZFbeoTu8tsqsaZ.Zb1Jpu6QfXN9oY7121mrvtuZUgxz2u.',NULL,5,1,NULL,'2022-06-29 16:34:40',NULL),
(40,'Lina Karlina','lina_karlina@gmail.com',NULL,'$2y$10$xv9iHawUnLaNhA4cd3yGXeOmRMF1aA3mQvBRqG.oxJk7xaoG.qA16',NULL,5,1,NULL,'2022-06-29 16:34:41',NULL),
(41,'Debi Sutisna','debi_sutisna@gmail.com',NULL,'$2y$10$McrSoQ5K4BcH/awRrwCdO.4kES//jWI.KluL0Q9KfRtGnm8iLWykm',NULL,5,1,NULL,'2022-06-29 16:34:41',NULL),
(42,'Iraj Wahyumi','iraj_wahyumi@gmail.com',NULL,'$2y$10$A0wvXcxwbkpolusPtL6oaOY1Ayyv20sCDUMZ3.tqkDsEhIOl6OgcK',NULL,5,1,NULL,'2022-06-29 16:34:41',NULL);

/*Table structure for table `ustadz` */

CREATE TABLE `ustadz` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tag_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` bigint unsigned DEFAULT NULL,
  `nik` bigint unsigned DEFAULT NULL,
  `jenis_kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `phone` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_fk_orangtua` (`user_id`),
  CONSTRAINT `users_ustadz_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ustadz` */

insert  into `ustadz`(`id`,`user_id`,`tag_id`,`nip`,`nik`,`jenis_kelamin`,`tempat_lahir`,`tanggal_lahir`,`phone`,`created_at`,`updated_at`) values 
(35,33,NULL,5454889622,2568654784541250,'P','Serang','0000-00-00','','2022-06-29 16:34:40','2022-06-30 15:35:48'),
(36,34,NULL,5588712121,2154567989878400,'L','Cilegon','0000-00-00',NULL,'2022-06-29 16:34:40',NULL),
(37,35,NULL,5722534620,1740481195215550,'L','Pandeglang','0000-00-00',NULL,'2022-06-29 16:34:40',NULL),
(38,36,NULL,5856357119,1326394400552700,'L','Serang','0000-00-00',NULL,'2022-06-29 16:34:40',NULL),
(39,37,NULL,5990179618,5454871495421120,'L','Merak','0000-00-00',NULL,'2022-06-29 16:34:40',NULL),
(40,38,NULL,6124002117,9583348590289540,'P','Jakarta','0000-00-00',NULL,'2022-06-29 16:34:40',NULL),
(41,39,NULL,6257824616,1371182568515000,'P','Tanggerang','0000-00-00',NULL,'2022-06-29 16:34:40',NULL),
(42,40,NULL,6391647115,1784030278006400,'P','Kebumen','0000-00-00',NULL,'2022-06-29 16:34:41',NULL),
(43,41,NULL,6525469614,2196877987494800,'L','Ngawi','0000-00-00',NULL,'2022-06-29 16:34:41',NULL),
(44,42,NULL,6659292113,2609725696763200,'L','Garut','0000-00-00',NULL,'2022-06-29 16:34:41',NULL);

/*Table structure for table `visitor_logs` */

CREATE TABLE `visitor_logs` (
  `id_visitor` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` varchar(10) DEFAULT NULL,
  `nama_lengkap` varchar(150) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `date_in` datetime DEFAULT NULL,
  `date_out` datetime DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL COMMENT 'id admin penerima tamu',
  PRIMARY KEY (`id_visitor`),
  KEY `vis_user_fk` (`user_id`),
  CONSTRAINT `vis_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `visitor_logs` */

insert  into `visitor_logs`(`id_visitor`,`tag_id`,`nama_lengkap`,`keterangan`,`date_in`,`date_out`,`user_id`) values 
(11,'3B3CD719','Ilham','wedfswdfsd','2022-07-14 15:04:12','2022-07-14 15:04:23',1),
(14,'3B3CD719','Fatoni','sdfsdf','2022-07-14 15:09:52','2022-07-14 15:10:00',1);

/*Table structure for table `visitor_tags` */

CREATE TABLE `visitor_tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` varchar(10) DEFAULT NULL,
  `in_out` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*Data for the table `visitor_tags` */

insert  into `visitor_tags`(`id`,`tag_id`,`in_out`,`created_at`) values 
(33,'3B3CD719',0,'2022-07-14 15:04:07'),
(34,'3B3CD719',1,'2022-07-14 15:04:20'),
(40,'1BDF1C1A',0,'2022-07-14 15:09:47'),
(41,'1BDF1C1A',0,'2022-07-14 15:09:58');

/*Table structure for table `wali_santri` */

CREATE TABLE `wali_santri` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nik` bigint unsigned DEFAULT NULL,
  `jenis_kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `phone` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_fk_orangtua` (`user_id`),
  CONSTRAINT `user_fk_orangtua` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `wali_santri` */

insert  into `wali_santri`(`id`,`user_id`,`nik`,`jenis_kelamin`,`tempat_lahir`,`tanggal_lahir`,`phone`,`created_at`,`updated_at`) values 
(11,13,15648797987845,'L','Garut','0000-00-00',NULL,'2022-06-29 16:16:48',NULL),
(12,14,64978798454646,'L','Gombong','0000-00-00',NULL,'2022-06-29 16:16:48',NULL),
(13,15,114308798921447,'P','Kebumen','0000-00-00',NULL,'2022-06-29 16:16:48',NULL),
(14,16,163638799388248,'P','Serang','0000-00-00',NULL,'2022-06-29 16:16:48',NULL),
(15,17,212968799855049,'L','Cilegon','0000-00-00',NULL,'2022-06-29 16:16:48',NULL),
(16,18,262298800321850,'P','Tanggerang','0000-00-00',NULL,'2022-06-29 16:16:48',NULL),
(17,19,311628800788651,'L','Sulawesi','0000-00-00',NULL,'2022-06-29 16:16:49',NULL),
(18,20,360958801255452,'L','Kalimantan','0000-00-00',NULL,'2022-06-29 16:16:49',NULL),
(19,21,410288801722253,'L','Pandeglang','0000-00-00',NULL,'2022-06-29 16:16:49',NULL),
(20,22,459618802189054,'L','Rangkas','0000-00-00',NULL,'2022-06-29 16:16:49',NULL);

/*Table structure for table `wallet_history` */

CREATE TABLE `wallet_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` bigint unsigned NOT NULL,
  `amount` int unsigned NOT NULL,
  `validation_at` datetime DEFAULT NULL,
  `validation_by` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `wallet_bill_id_fk` (`bill_id`),
  CONSTRAINT `wallet_bill_id_fk` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `wallet_history` */

insert  into `wallet_history`(`id`,`bill_id`,`amount`,`validation_at`,`validation_by`,`created_at`) values 
(14,116,100000,'2022-07-13 17:14:40','Administrator','2022-07-13 11:42:56'),
(15,119,10000,'2022-07-13 17:15:12','Administrator','2022-07-13 17:14:58');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
