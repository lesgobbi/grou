# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.26)
# Database: grou
# Generation Time: 2019-10-08 23:22:13 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table banners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `banners`;

CREATE TABLE `banners` (
  `banner_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `banner_url` varchar(255) DEFAULT NULL,
  `banner_title` varchar(255) DEFAULT NULL,
  `banner_subtitle` varchar(560) DEFAULT NULL,
  `banner_link` varchar(255) DEFAULT NULL,
  `banner_target` tinyint(1) DEFAULT NULL,
  `banner_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;

INSERT INTO `banners` (`banner_id`, `banner_url`, `banner_title`, `banner_subtitle`, `banner_link`, `banner_target`, `banner_order`)
VALUES
	(1,'b930eca7e92680af48abc76ee4bdf227.jpg','Quidem delectus commodi','Lorem, ipsum dolor sit amet consectetur adipisicingCorrupti, cupiditate quos praesentium nobis','https://www.google.com.br/',1,1),
	(2,'de135754d6457c302445378fec6ed7de.png','Quibusdam necessitatibus asperiores','','',0,2),
	(3,'98e431865a6e336063c0696f99b0871f.png','','','',0,3);

/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table bullets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bullets`;

CREATE TABLE `bullets` (
  `post_id` int(11) DEFAULT NULL,
  `bullet_id` int(11) NOT NULL AUTO_INCREMENT,
  `bullet_order` int(11) DEFAULT NULL,
  `bullet_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `bullet_content` longtext CHARACTER SET latin1,
  PRIMARY KEY (`bullet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `bullets` WRITE;
/*!40000 ALTER TABLE `bullets` DISABLE KEYS */;

INSERT INTO `bullets` (`post_id`, `bullet_id`, `bullet_order`, `bullet_title`, `bullet_content`)
VALUES
	(4,1,2,'oooooOOOOOooo','ddd'),
	(4,3,3,'cvb','bvc'),
	(4,4,1,'pergunta','<strong>resposta</strong>');

/*!40000 ALTER TABLE `bullets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_parent` int(11) DEFAULT NULL,
  `category_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `category_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `category_content` text CHARACTER SET latin1,
  `category_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `category_views` decimal(10,0) DEFAULT NULL,
  `category_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`category_id`, `category_parent`, `category_name`, `category_title`, `category_content`, `category_date`, `category_views`, `category_order`)
VALUES
	(2,NULL,'para-voce','Para Você',NULL,'2019-10-08 16:11:29',NULL,1),
	(3,NULL,'para-sua-empresa','Para sua Empresa',NULL,'2019-10-08 16:11:31',NULL,2);

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table estados
# ------------------------------------------------------------

DROP TABLE IF EXISTS `estados`;

CREATE TABLE `estados` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(2) NOT NULL,
  `descricao` varchar(30) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;

INSERT INTO `estados` (`codigo`, `sigla`, `descricao`)
VALUES
	(1,'AC','Acre'),
	(2,'AL','Alagoas'),
	(3,'AP','Amapá'),
	(4,'AM','Amazonas'),
	(5,'BA','Bahia'),
	(6,'CE','Ceará'),
	(7,'DF','Distrito Federal'),
	(8,'ES','Espírito Santo'),
	(9,'GO','Goiás'),
	(10,'MA','Maranhão'),
	(11,'MT','Mato Grosso'),
	(12,'MS','Mato Grosso do Sul'),
	(13,'MG','Minas Gerais'),
	(14,'PA','Pará'),
	(15,'PB','Paraíba'),
	(16,'PR','Paraná'),
	(17,'PE','Pernambuco'),
	(18,'PI','Piauí'),
	(19,'RJ','Rio de Janeiro'),
	(20,'RN','Rio Grande do Norte'),
	(21,'RS','Rio Grande do Sul'),
	(22,'RO','Rondônia'),
	(23,'RR','Roraima'),
	(24,'SC','Santa Catarina'),
	(25,'SP','São Paulo'),
	(26,'SE','Sergipe'),
	(27,'TO','Tocantins');

/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table forms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `forms`;

CREATE TABLE `forms` (
  `form_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_nome` varchar(255) DEFAULT NULL,
  `form_json` text,
  `form_destino` varchar(255) DEFAULT NULL,
  `form_post` int(11) DEFAULT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;

INSERT INTO `forms` (`form_id`, `form_nome`, `form_json`, `form_destino`, `form_post`)
VALUES
	(2,'Formulário de Contato','a:3:{i:0;O:8:\"stdClass\":7:{s:4:\"name\";s:4:\"Nome\";s:4:\"type\";a:1:{i:0;s:4:\"text\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:8:\"radio341\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:1;}i:1;O:8:\"stdClass\":7:{s:4:\"name\";s:6:\"E-mail\";s:4:\"type\";a:1:{i:0;s:5:\"email\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:8:\"radio191\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:1;}i:2;O:8:\"stdClass\":7:{s:4:\"name\";s:8:\"Mensagem\";s:4:\"type\";a:1:{i:0;s:8:\"textarea\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:8:\"radio232\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:1;}}','jeanpreis@gmail.com',NULL),
	(5,NULL,'a:1:{i:0;O:8:\"stdClass\":7:{s:4:\"name\";s:8:\"pergunta\";s:4:\"type\";a:1:{i:0;s:4:\"text\";}s:8:\"validate\";s:1:\"0\";s:9:\"radioName\";s:5:\"radio\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:1;}}','jeanpreis@gmail.com',6);

/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table general
# ------------------------------------------------------------

DROP TABLE IF EXISTS `general`;

CREATE TABLE `general` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `analytics` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `email_contato` varchar(255) DEFAULT NULL,
  `social_fb` varchar(255) DEFAULT NULL,
  `social_tt` varchar(255) DEFAULT NULL,
  `social_yt` varchar(255) DEFAULT NULL,
  `social_ig` varchar(255) DEFAULT NULL,
  `social_li` varchar(255) DEFAULT NULL,
  `social_pr` varchar(255) DEFAULT NULL,
  `social_gp` varchar(255) DEFAULT NULL,
  `social_xi` varchar(255) DEFAULT NULL,
  `end` varchar(500) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  `clube` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `general` WRITE;
/*!40000 ALTER TABLE `general` DISABLE KEYS */;

INSERT INTO `general` (`id`, `logo`, `title`, `analytics`, `description`, `email_contato`, `social_fb`, `social_tt`, `social_yt`, `social_ig`, `social_li`, `social_pr`, `social_gp`, `social_xi`, `end`, `email`, `lat`, `lng`, `tel`, `clube`)
VALUES
	(1,'85c00ffd236cd53d4f56ead92c467905.png','Recovering','UA-77152881-1','Revestimentos Especiais','jeanpreis@gmail.com','https://www.facebook.com/RecoveringBR/','','','https://www.instagram.com/recovering.revestimentos/','','','',NULL,'Rua Praia de Inhaúma, 83 - CEP: 21.042-130 - Bonsucesso/RJ','comercial@recovering.com.br','-23.5879532','-46.6326489','Tel: (21) 3869-7481',2);

/*!40000 ALTER TABLE `general` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `post_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `post_subtitle` varchar(255) DEFAULT NULL,
  `post_content` longtext CHARACTER SET latin1,
  `post_chamada` longtext CHARACTER SET latin1,
  `post_cover` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `post_cover_featured` varchar(255) DEFAULT NULL,
  `post_date` timestamp NULL DEFAULT NULL,
  `post_author` int(11) DEFAULT NULL,
  `post_category` int(11) DEFAULT NULL,
  `post_estado` int(2) DEFAULT NULL,
  `post_cat_parent` int(11) DEFAULT NULL,
  `post_views` decimal(10,0) DEFAULT '0',
  `post_last_views` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `post_featured` tinyint(1) DEFAULT NULL,
  `post_status` tinyint(1) DEFAULT NULL,
  `post_type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `post_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`post_id`, `post_name`, `post_title`, `post_subtitle`, `post_content`, `post_chamada`, `post_cover`, `post_cover_featured`, `post_date`, `post_author`, `post_category`, `post_estado`, `post_cat_parent`, `post_views`, `post_last_views`, `post_featured`, `post_status`, `post_type`, `post_order`)
VALUES
	(3,'home','Home',NULL,NULL,NULL,NULL,NULL,'2019-10-07 19:34:33',NULL,1,NULL,NULL,0,'2019-10-08 19:07:39',NULL,1,'post',1),
	(4,'whatever-title-here','Whatever Title here',NULL,'Lorem ipsum dolor sit amet, consectetur adipisicing elit.<br><br>Sit deleniti incidunt doloremque facilis aut eum sint nobis quaerat deserunt commodi eaque, doloribus iste quas eligendi et perferendis exercitationem est consequuntur!<br><br><img class=\"fr-dib fr-draggable\" src=\"http://localhost:8888/grou/uploads/136ceaa0e8073fd045f577107440aea1b2a6baa7.jpg\" style=\"width: 300px;\">','Cada necessidade, precisada cobertura certa.Vamos Descobrir a sua?','',NULL,'2019-10-08 18:32:28',NULL,2,NULL,NULL,0,'2019-10-08 19:07:51',NULL,1,'post',1),
	(6,'sdf','sdf',NULL,'sdfsdf','sdfsdf','b2d99f74df53af3851d03a0ebae173c5.jpg',NULL,'2019-10-08 16:12:52',NULL,3,NULL,NULL,0,'2019-10-08 19:07:51',NULL,1,'post',1);

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts_gallery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts_gallery`;

CREATE TABLE `posts_gallery` (
  `post_id` int(11) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_image` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `gallery_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `gallery_order` int(11) DEFAULT NULL,
  `gallery_caption` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_registration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_lastupdate` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `user_level` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_registration`, `user_lastupdate`, `user_level`)
VALUES
	(-1,'Radiati','contato@radiati.com.br','$2y$11$NdPOgXZQrKJ1jyqLZ6MPNO.MEoNjKpVBxTQI3eTWJvQvKdH/Fu69C','2016-06-03 18:03:05','2016-06-07 19:05:36',3),
	(1,'admin','admin@seusite.com.br','$2y$11$ZgSB/kzVdNKoxVYmKaeCaekKiW4oZbM7ZgTsl1iHTeYEAURdKqS8a','2016-06-08 12:54:46','0000-00-00 00:00:00',3),
	(2,'parceiro','parceiro@empresa.com.br','$2y$11$gFdWD8sdsZKlyF37PQECzu4qBaTliec.MVhmpSuPqTFXYYpr5Y7D.','2017-09-25 13:08:49','0000-00-00 00:00:00',1);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
