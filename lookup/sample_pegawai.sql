/*
SQLyog Ultimate v8.55 
MySQL - 5.0.51b-community-nt-log : Database - test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`test` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `test`;

/*Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `no_int` int(5) NOT NULL auto_increment,
  `NIP` char(5) collate latin1_general_ci default NULL,
  `nama` varchar(30) collate latin1_general_ci NOT NULL,
  `umur` int(2) NOT NULL,
  `alamat` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`no_int`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `pegawai` */

insert  into `pegawai`(`no_int`,`NIP`,`nama`,`umur`,`alamat`) values (1,'P001','Abai Sudami',22,'Ketapang'),(2,'P002','Asun Monjoli',22,'Jakarta Timur'),(3,'P003','Ambli Godon',21,'Kreo'),(4,'P004','Bimil Pulanta',21,'Kota'),(5,'P005','Beni Simantupil',25,'Kreo'),(6,'P006','Caca Donima',21,'Tangerang'),(7,'P007','Cintu Ontom',23,'Pamulang'),(8,'P008','Cici Tomoli',24,'Tangerang'),(9,'P009','Coki Komplos',19,'Senen'),(10,'P010','Dani Asburep',26,'Bandung'),(11,'P011','Dani S. Policin',22,'Meruya'),(12,'P012','Deni Ambara',21,'Kembangan'),(13,'P013','Desi Kolipum',23,'Petukangan'),(14,'P014','Desica Anlom',26,'Pancoran'),(15,'P015','Desica Zukardi',26,'Tebet'),(16,'P016','Deri Zaki',27,'Pulau Seribu'),(17,'P017','Erna Sibantak',28,'Blok M'),(18,'P018','Erna Kutip',21,'Semangi');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
