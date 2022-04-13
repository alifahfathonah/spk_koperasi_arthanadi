/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.11-MariaDB : Database - u1657744_spk_kredit_fucom_smart
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u1657744_spk_kredit_fucom_smart` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `u1657744_spk_kredit_fucom_smart`;

/*Table structure for table `tb_alternatif` */

DROP TABLE IF EXISTS `tb_alternatif`;

CREATE TABLE `tb_alternatif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_hasil` int(11) DEFAULT NULL,
  `nama_alternatif` varchar(100) DEFAULT NULL,
  `bobot_alternatif` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_alternatif` */

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kriteria` */

insert  into `tb_kriteria`(`id`,`kode_kriteria`,`nama_kriteria`,`bobot_kriteria`) values 
(1,'C1','Karakter',20),
(2,'C2','Jaminan',15);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_nasabah` */

insert  into `tb_nasabah`(`id`,`id_nasabah`,`nama_nasabah`,`alamat_nasabah`,`telepon`,`no_ktp`,`jenis_kelamin`,`agama`) values 
(1,'NB00001','I Wayan Jana Antara','Denpasar Timur','081999897666','01239131231222','L','Hindu');

/*Table structure for table `tb_pengajuan` */

DROP TABLE IF EXISTS `tb_pengajuan`;

CREATE TABLE `tb_pengajuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nasabah` int(11) DEFAULT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `jaminan` varchar(100) DEFAULT NULL,
  `karakter` varchar(100) DEFAULT NULL,
  `kemampuan` varchar(50) DEFAULT NULL,
  `pendapatan` float DEFAULT NULL,
  `pengeluaran` float DEFAULT NULL,
  `kondisi_hutang` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pengajuan` */

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
