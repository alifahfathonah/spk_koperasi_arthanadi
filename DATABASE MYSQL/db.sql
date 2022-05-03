/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.11-MariaDB : Database - spk_kredit_fucom_smart
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`spk_kredit_fucom_smart` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `spk_kredit_fucom_smart`;

/*Table structure for table `tb_alternatif` */

DROP TABLE IF EXISTS `tb_alternatif`;

CREATE TABLE `tb_alternatif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_alternatif` varchar(11) DEFAULT NULL,
  `id_nasabah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_alternatif` */

insert  into `tb_alternatif`(`id`,`kode_alternatif`,`id_nasabah`) values 
(1,'A1',1),
(2,'A2',2),
(3,'A3',3),
(4,'A4',5),
(5,'A5',4);

/*Table structure for table `tb_bobot_kriteria` */

DROP TABLE IF EXISTS `tb_bobot_kriteria`;

CREATE TABLE `tb_bobot_kriteria` (
  `key` varchar(100) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_bobot_kriteria` */

insert  into `tb_bobot_kriteria`(`key`,`value`) values 
('C1','0.22535'),
('C2','0.1766'),
('C3','0.20948'),
('C4','0.20948'),
('C5','0.15663'),
('C6','0.13020');

/*Table structure for table `tb_group_kriteria` */

DROP TABLE IF EXISTS `tb_group_kriteria`;

CREATE TABLE `tb_group_kriteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kriteria` varchar(20) DEFAULT NULL,
  `nama_kriteria` varchar(100) DEFAULT NULL,
  `jenis_kriteria` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_group_kriteria` */

insert  into `tb_group_kriteria`(`id`,`kode_kriteria`,`nama_kriteria`,`jenis_kriteria`) values 
(1,'C1','Jaminan','Keuntungan'),
(2,'C2','Karakter','Keuntungan'),
(3,'C3','Pendapatan','Keuntungan'),
(4,'C4','Pengeluaran','Kerugian'),
(5,'C5','Kemampuan','Keuntungan'),
(6,'C6','Kondisi Hutang','Keuntungan');

/*Table structure for table `tb_hasil` */

DROP TABLE IF EXISTS `tb_hasil`;

CREATE TABLE `tb_hasil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengajuan` varchar(20) DEFAULT NULL,
  `alternatif` varchar(20) DEFAULT NULL,
  `c1` varchar(100) DEFAULT NULL,
  `c2` varchar(100) DEFAULT NULL,
  `c3` varchar(100) DEFAULT NULL,
  `c4` varchar(100) DEFAULT NULL,
  `c5` varchar(100) DEFAULT NULL,
  `c6` varchar(100) DEFAULT NULL,
  `hasil` varchar(100) DEFAULT NULL,
  `kesimpulan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_hasil` */

/*Table structure for table `tb_hasil_normalisasi` */

DROP TABLE IF EXISTS `tb_hasil_normalisasi`;

CREATE TABLE `tb_hasil_normalisasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengajuan` varchar(20) DEFAULT NULL,
  `alternatif` varchar(10) DEFAULT NULL,
  `c1` float DEFAULT NULL,
  `c2` float DEFAULT NULL,
  `c3` float DEFAULT NULL,
  `c4` float DEFAULT NULL,
  `c5` float DEFAULT NULL,
  `c6` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_hasil_normalisasi` */

/*Table structure for table `tb_kriteria` */

DROP TABLE IF EXISTS `tb_kriteria`;

CREATE TABLE `tb_kriteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kriteria` varchar(10) DEFAULT NULL,
  `nama_kriteria` varchar(100) DEFAULT NULL,
  `bobot_kriteria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kriteria` */

insert  into `tb_kriteria`(`id`,`kode_kriteria`,`nama_kriteria`,`bobot_kriteria`) values 
(1,'C1','Surat Pegawai',5),
(2,'C1','Surat Bangunan',4),
(3,'C1','BPKB Mobil',3),
(4,'C1','BPKB Motor',2),
(5,'C1','Tidak Ada',1),
(6,'C2','Bertanggung Jawab',2),
(7,'C2','Kurang Dipercaya',1),
(8,'C6','Tidak',2),
(9,'C6','Ada',1);

/*Table structure for table `tb_nasabah` */

DROP TABLE IF EXISTS `tb_nasabah`;

CREATE TABLE `tb_nasabah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nasabah` varchar(10) DEFAULT NULL,
  `nama_nasabah` varchar(100) DEFAULT NULL,
  `alamat_nasabah` varchar(100) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `no_ktp` varchar(50) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_nasabah` */

insert  into `tb_nasabah`(`id`,`id_nasabah`,`nama_nasabah`,`alamat_nasabah`,`telepon`,`no_ktp`,`jenis_kelamin`,`agama`) values 
(1,'NB00001','I Wayan Jana Antara','Denpasar Timur','081999897666','01239131231222','L','Hindu'),
(2,'NB00002','I Wayan Jana','Denpasar Timur','081999897565','01239131231223','L','Hindu'),
(3,'NB00003','Ni Ketut Surati','Denpasar, Timur','081999876222','01239131231444','P','Hindu'),
(4,'NB00004','I Wayan Subrata','Gianyar','081999897123','01239131231223','L','Hindu'),
(5,'NB00005','Ahmad Saifulah','Jombang, Jawa Timur','081999891212','01239131231211','L','Muslim');

/*Table structure for table `tb_pengajuan` */

DROP TABLE IF EXISTS `tb_pengajuan`;

CREATE TABLE `tb_pengajuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengajuan` varchar(100) NOT NULL,
  `id_alternatif` int(11) DEFAULT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `jaminan` varchar(100) DEFAULT NULL,
  `karakter` varchar(100) DEFAULT NULL,
  `kemampuan` varchar(50) DEFAULT NULL,
  `pendapatan` varchar(50) DEFAULT NULL,
  `pengeluaran` varchar(50) DEFAULT NULL,
  `kondisi_hutang` varchar(100) DEFAULT NULL,
  `sudah_proses` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`,`id_pengajuan`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pengajuan` */

insert  into `tb_pengajuan`(`id`,`id_pengajuan`,`id_alternatif`,`tgl_pengajuan`,`jaminan`,`karakter`,`kemampuan`,`pendapatan`,`pengeluaran`,`kondisi_hutang`,`sudah_proses`) values 
(1,'PGJ000001',1,'2022-04-17','1','7','5','5','4','9',0),
(2,'PGJ000002',2,'2022-04-17','3','6','4','2','3','8',0),
(3,'PGJ000003',3,'2022-05-03','1','7','10','8.5','2.5','9',0),
(4,'PGJ000004',4,'2022-05-03','3','7','5','5.5','1.5','8',0);

/*Table structure for table `tb_pengguna` */

DROP TABLE IF EXISTS `tb_pengguna`;

CREATE TABLE `tb_pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` varchar(10) DEFAULT NULL,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pengguna` */

insert  into `tb_pengguna`(`id`,`id_pengguna`,`nama_pengguna`,`username`,`password`,`jabatan`) values 
(1,'U001','Wayan Admin','admin','$2y$10$JSk.ma9W0H3h0QpdwYc6wuaNN.K0FLxxmD3yMIWPhW9uUKvB3x8qS','Admin'),
(2,'U002','Kadek Manager','manager','$2y$10$4.J.Dotnoqr9GceIt54l7u2x4Y8kAFzUHEUvngbSmIGAjYT7TnGP.','Manager');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
