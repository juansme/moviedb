/*
SQLyog Ultimate
MySQL - 5.7.19-log : Database - invo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`invo` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `invo`;

/*Table structure for table `actors` */

DROP TABLE IF EXISTS `actors`;

CREATE TABLE `actors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `birth_date` date DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'images/default.png',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `actors` */

insert  into `actors`(`id`,`name`,`summary`,`birth_date`,`picture`,`created_at`,`updated_at`) values (3,'John Lone','Nació en octubre de 1952 como Ng Kwok-leung en Hong Kong. Fue criado en un orfanato y más tarde adoptado por una mujer de Shanghai. Estudió en la ópera de Beijing de Hong Kong, aquí comenzaron a llamarle \"Johnny \". Más tarde escoge el nombre Lone (solitario) para reflejar el hecho de ser huérfano y por su semejanza a Leung.\r\n\r\nPatrocinado por una familia americana, deja la ópera de Beijing y emigra a Los Ángeles, California. En los Estados Unidos, se casa con Nina Savino en 1972, y obtiene la ciudadanía americana. Continua sus estudios de artes escénicas en la Academia americana de Artes Dramáticas en Pasadena, California. Finalmente, se muda a Nueva York, para trabajar en el teatro. ','1952-10-13','images/1524501351_lone.jpg','2018-04-22 22:59:40','2018-04-23 11:35:51');

/*Table structure for table `directors` */

DROP TABLE IF EXISTS `directors`;

CREATE TABLE `directors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `birth_date` date DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'images/default.png',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `directors` */

insert  into `directors`(`id`,`name`,`summary`,`birth_date`,`picture`,`created_at`,`updated_at`) values (2,'Bernardo Bertolucci','Su padre, Attilio, era poeta. Bernardo estudió en la Universidad de Roma, donde se ganó una cierta fama como poeta. Se inició en el mundo del cine realizando cortometrajes en 16 mm con su hermano Giuseppe. En 1961 hizo de ayudante de dirección en Accattone, primer largometraje de Pier Paolo Pasolini. Un año después se estrenaba como director con La commare secca. En 1968 estrenaba Hasta que llegó su hora, dirigida por director italiano Sergio Leone.\r\n\r\nEn 1972 su película El conformista fue candidata a los Óscar por el mejor guión adaptado. Dos años después él mismo era nominado para el Óscar a la mejor dirección, en esta ocasión para Ultimo tango a Parigi (El último tango en París) que causó controversia por una escena de violación.1​2​ En 1976 dirigió Novecento, una superproducción sobre la historia de Italia con la colaboración de actores de la talla de Robert De Niro y Gerard Depardieu. Su obra más premiada en los Estados Unidos fue El último emperador (The Last Emperor), que ganó nueve estatuillas en 1988, además de otros premios internacionales.\r\n\r\nEl trabajo con Pasolini es una influencia que ha marcado toda su obra posterior, junto con la obra de otros directores como Godard, Kurosawa o los neorrealistas.\r\n\r\nEl suyo es un cine de autor. Sus principales características son un esmerado uso de la cámara y del montaje y el trabajo de la fotografía con finalidades simbólicas. ','1941-03-16','images/1524501240_berto.jpg','2018-04-22 22:56:16','2018-04-23 11:34:00');

/*Table structure for table `movies` */

DROP TABLE IF EXISTS `movies`;

CREATE TABLE `movies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `released_at` date NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'images/default.png',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `movies` */

insert  into `movies`(`id`,`title`,`summary`,`released_at`,`picture`,`created_at`,`updated_at`) values (5,'El último emperador','Es la historia de Puyi, el último emperador de China, que subió al trono a los tres años en 1908 y fue adorado por 500 millones de personas como divinidad. Gobernó en la Ciudad Prohibida hasta que las fuerzas republicanas, que querían abolir la corte imperial, lo encerraron entre sus murallas, donde se casó dos veces. Finalmente tuvo además que abdicar más tarde e irse. Entonces una de sus mujeres se divorció de él\r\n\r\nEn su afán de por lo menos gobernar Manchuria después de que China le tornase la espalda, Puyi se convirtió durante un tiempo en un títere de las fuerzas de ocupación japonesas en Manchuria hasta que Japón tuvo que rendise ante los alíados. Su segunda mujer, disgustada por lo que hizo, se separa también de él. Después de la capitulación japonesa Puyi decide rendirse ante los americanos, pero su intento fracasa y es hecho prisionero de los soviéticos, que lo entregan a los comunistas chinos.\r\n\r\nCuando la revolución comunista triunfa en China, Puyi es encarcelado para \"limpiar\" su mente de todo pensamiento capitalista y por haber colaborado con los japoneses. Durante su estancia allí el jefe de la prisión le enseña a hacer las cosas con sus manos, algo que nunca hizo a causa de la educación que recibió, a darse cuenta de las atrocidades que hicieron los japoneses en China mientras que era emperador de Manchuria, y de asumir la responsabilidad de sus acciones al respecto. Después de su encarcelamiento él volvió a Pek','1987-06-11','images/1524501089_emperador.jpg','2018-04-22 23:00:56','2018-04-23 11:31:44');

/*Table structure for table `movies_actors` */

DROP TABLE IF EXISTS `movies_actors`;

CREATE TABLE `movies_actors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_movie` int(10) unsigned NOT NULL,
  `id_actor` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `movies_actors` */

insert  into `movies_actors`(`id`,`id_movie`,`id_actor`,`created_at`) values (5,5,3,'2018-04-22 23:00:56');

/*Table structure for table `movies_directors` */

DROP TABLE IF EXISTS `movies_directors`;

CREATE TABLE `movies_directors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_movie` int(10) unsigned NOT NULL,
  `id_director` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `movies_directors` */

insert  into `movies_directors`(`id`,`id_movie`,`id_director`,`created_at`) values (5,5,2,'2018-04-22 23:00:56');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` char(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`name`,`email`,`created_at`,`active`) values (1,'demo','c0bd96dc7ea4ec56741a4e07f6ce98012814d853','Phalcon Demo','demo@phalconphp.com','2012-04-10 15:53:03','Y');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
