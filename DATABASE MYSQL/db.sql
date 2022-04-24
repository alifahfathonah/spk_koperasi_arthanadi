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
  `id_pengajuan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_alternatif` */

insert  into `tb_alternatif`(`id`,`kode_alternatif`,`id_pengajuan`) values 
(1,'A1',1),
(2,'A2',2);

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
  `id_hasil` int(11) NOT NULL,
  PRIMARY KEY (`id_hasil`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_hasil` */

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_nasabah` */

insert  into `tb_nasabah`(`id`,`id_nasabah`,`nama_nasabah`,`alamat_nasabah`,`telepon`,`no_ktp`,`jenis_kelamin`,`agama`) values 
(1,'NB00001','I Wayan Jana Antara','Denpasar Timur','081999897666','01239131231222','L','Hindu'),
(2,'NB00002','I Wayan Jana','Denpasar Timur','081999897565','01239131231223','L','Hindu');

/*Table structure for table `tb_pengajuan` */

DROP TABLE IF EXISTS `tb_pengajuan`;

CREATE TABLE `tb_pengajuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengajuan` varchar(100) DEFAULT NULL,
  `id_nasabah` int(11) DEFAULT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `jaminan` varchar(100) DEFAULT NULL,
  `karakter` varchar(100) DEFAULT NULL,
  `kemampuan` varchar(50) DEFAULT NULL,
  `pendapatan` varchar(50) DEFAULT NULL,
  `pengeluaran` varchar(50) DEFAULT NULL,
  `kondisi_hutang` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pengajuan` */

insert  into `tb_pengajuan`(`id`,`id_pengajuan`,`id_nasabah`,`tgl_pengajuan`,`jaminan`,`karakter`,`kemampuan`,`pendapatan`,`pengeluaran`,`kondisi_hutang`) values 
(1,'PGJ000001',1,'2022-04-17','1','6','4','2','3','9'),
(2,'PGJ000002',2,'2022-04-17','3','6','4','2','3','8');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pengguna` */

insert  into `tb_pengguna`(`id`,`id_pengguna`,`nama_pengguna`,`username`,`password`,`jabatan`) values 
(1,'U001','Wayan Admin','admin','$2y$10$JSk.ma9W0H3h0QpdwYc6wuaNN.K0FLxxmD3yMIWPhW9uUKvB3x8qS','Admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
