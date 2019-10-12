# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.35)
# Database: grou
# Generation Time: 2019-10-12 16:29:44 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


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
	(4,4,1,'pergunta','<strong>resposta</strong>'),
	(19,5,1,'Nulla nulla elit, aliquet eget eros sit amet?','Proin tempus libero eget justo pretium commodo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Suspendisse eget libero eu nisi porta malesuada. Integer in sem eget ipsum imperdiet porta.'),
	(19,6,2,'Curabitur facilisis enim justo','Quisque sit amet aliquet turpis. Suspendisse auctor elit nec finibus feugiat.'),
	(19,7,3,'Donec fringilla dolor a augue egestas mattis?','Quisque quis turpis malesuada, congue quam et, molestie erat. Morbi non est vel augue bibendum interdum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas libero nisi, dictum ut mi id, mollis accumsan felis.'),
	(19,8,4,'Aliquam erat volutpat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus?','Morbi posuere elementum aliquam. Nam finibus nec ligula at maximus. Aenean ullamcorper ligula libero, vitae maximus mauris placerat nec. Nulla finibus rutrum diam, ac eleifend nibh iaculis at. Donec ac ante euismod, finibus felis in, blandit mi. Suspendisse quam diam, posuere aliquet lorem a, euismod laoreet sem. Praesent ac odio at felis eleifend ornare. Aenean sit amet orci nec arcu luctus interdum sit amet ut odio.'),
	(1,9,1,'O que são planos PME?','Planos PME atendem as Pequenas e M&eacute;dias empresas de diversos segmentos e localidades. Dependendo da Operadora/Seguradora existe um n&uacute;mero de vidas m&iacute;nimo para ingresso no plano, mas normalmente s&atilde;o de no m&iacute;nimo 02 a 99 vidas. Os valores dessa modalidade de plano s&atilde;o bem mais atrativos comparado a outras modalidades'),
	(1,10,2,'Quem pode aderir aos planos PME?','Qualquer pessoa jur&iacute;dica que tenha CNPJ constitu&iacute;do por pelo menos 6 meses!'),
	(1,11,3,'Tenho CNPJ e quero contratar um plano, o que devo levar em conta?','Al&eacute;m do pre&ccedil;o que &eacute; o que mais chama a aten&ccedil;&atilde;o, dever&aacute; levar em conta, a rede de hospitais e cl&iacute;nicas, a abrang&ecirc;ncia, ou seja, se ser&aacute; um plano Regional ou Estadual e o padr&atilde;o de conforto, por exemplo, se a acomoda&ccedil;&atilde;o no caso de interna&ccedil;&atilde;o ser&aacute; quarto individual ou coletivo. Precisa verificar se esses pontos est&atilde;o de acordo com a sua necessidade, pois, ter&atilde;o grande relev&acirc;ncia no pre&ccedil;o.'),
	(1,12,4,'Já tenho um plano PME ativo e desejo trocar, o novo plano terá carências?','Existem algumas regras para redu&ccedil;&atilde;o de car&ecirc;ncia, uma delas &eacute; o tempo que esteve no plano que deseja trocar, a partir da&iacute; &eacute; analisar a utiliza&ccedil;&atilde;o e se possui doen&ccedil;as pr&eacute;-existentes, o parecer sendo favor&aacute;vel, n&atilde;o ter&aacute; de cumprir car&ecirc;ncias contratuais no novo plano.');

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
	(5,NULL,'a:1:{i:0;O:8:\"stdClass\":7:{s:4:\"name\";s:8:\"pergunta\";s:4:\"type\";a:1:{i:0;s:4:\"text\";}s:8:\"validate\";s:1:\"0\";s:9:\"radioName\";s:5:\"radio\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:1;}}','jeanpreis@gmail.com',6),
	(6,NULL,'a:3:{i:0;O:8:\"stdClass\":7:{s:4:\"name\";s:4:\"Nome\";s:4:\"type\";a:1:{i:0;s:4:\"text\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:5:\"radio\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:0;}i:1;O:8:\"stdClass\":7:{s:4:\"name\";s:6:\"E-mail\";s:4:\"type\";a:1:{i:0;s:5:\"email\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:8:\"radio277\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:0;}i:2;O:8:\"stdClass\":7:{s:4:\"name\";s:8:\"mensagem\";s:4:\"type\";a:1:{i:0;s:8:\"textarea\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:8:\"radio903\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:0;}}','jeanpreis@gmail.com',4),
	(8,NULL,'a:3:{i:0;O:8:\"stdClass\":7:{s:4:\"name\";s:4:\"Nome\";s:4:\"type\";a:1:{i:0;s:4:\"text\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:5:\"radio\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:0;}i:1;O:8:\"stdClass\":7:{s:4:\"name\";s:6:\"E-mail\";s:4:\"type\";a:1:{i:0;s:5:\"email\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:8:\"radio290\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:0;}i:2;O:8:\"stdClass\":7:{s:4:\"name\";s:8:\"Mensagem\";s:4:\"type\";a:1:{i:0;s:8:\"textarea\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:8:\"radio172\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:0;}}','jeanpreis@gmail.com',16),
	(9,NULL,'a:3:{i:0;O:8:\"stdClass\":7:{s:4:\"name\";s:4:\"Nome\";s:4:\"type\";a:1:{i:0;s:4:\"text\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:5:\"radio\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:0;}i:1;O:8:\"stdClass\":7:{s:4:\"name\";s:8:\"Telefone\";s:4:\"type\";a:1:{i:0;s:3:\"tel\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:8:\"radio692\";s:7:\"options\";a:0:{}s:11:\"optionsView\";b:0;s:6:\"change\";b:0;}i:2;O:8:\"stdClass\":7:{s:4:\"name\";s:8:\"pergunta\";s:4:\"type\";a:1:{i:0;s:5:\"radio\";}s:8:\"validate\";s:1:\"1\";s:9:\"radioName\";s:8:\"radio257\";s:7:\"options\";a:2:{i:0;O:8:\"stdClass\":1:{s:6:\"option\";s:3:\"sim\";}i:1;O:8:\"stdClass\":1:{s:6:\"option\";s:4:\"não\";}}s:11:\"optionsView\";b:1;s:6:\"change\";b:0;}}','jeanpreis@gmail.com',19);

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
	(1,'85c00ffd236cd53d4f56ead92c467905.png','Grou','UA-77152881-1','Corretora de Seguros','jeanpreis@gmail.com','https://www.facebook.com/','','','','https://www.linkedin.com/feed/','','',NULL,'av paulista, 100','contato@grou.com.br','-23.5879532','-46.6326489','11 98953 9654',2);

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
  `post_chamada` longtext CHARACTER SET latin1,
  `post_content` longtext CHARACTER SET latin1,
  `post_link` varchar(550) DEFAULT NULL,
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

INSERT INTO `posts` (`post_id`, `post_name`, `post_title`, `post_subtitle`, `post_chamada`, `post_content`, `post_link`, `post_cover`, `post_cover_featured`, `post_date`, `post_author`, `post_category`, `post_estado`, `post_cat_parent`, `post_views`, `post_last_views`, `post_featured`, `post_status`, `post_type`, `post_order`)
VALUES
	(1,'nada','nada',NULL,'Cada necessidade, precisa<br>da cobertura certa.<br><strong>Vamos Descobrir a sua?</strong>','Cada necessidade, precisa<br>da cobertura certa.<br><strong>Vamos Descobrir a sua?</strong>',NULL,'e65f7fc4a897236dbbe86e7befaf6774.jpg',NULL,'2019-10-11 14:56:32',NULL,1,NULL,NULL,0,'2019-10-11 14:56:46',NULL,1,'post',2),
	(2,'seguro-viagem','Seguro Viagem',NULL,'Dica do Especialista','Ab consequuntur cupiditate delectus deleniti deserunt dicta, dolor est explicabo facere fuga fugiat id iste necessitatibus, neque perferendis, quaerat quo repellendus repudiandae?<br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aperiam assumenda blanditiis consequuntur deserunt, error eum illo illum in molestias nulla perspiciatis quibusdam quo repudiandae sapiente sequi, tempore ut voluptatem.',NULL,'f2666b423cc8b5e91bc411a2d07efbee.png',NULL,'2019-10-11 17:01:46',NULL,1,NULL,NULL,0,'2019-10-11 17:02:25',NULL,1,'post',1),
	(3,'conheca-a-grou','Conheça a GROU',NULL,NULL,'Mauris interdum tellus mattis quam fermentum suscipit. In semper sit amet risus pulvinar tempus. Nullam malesuada dolor et consectetur tristique. Cras vel libero ac nunc ultrices consectetur sit amet vel augue. Integer metus orci, auctor dictum sagittis vitae, fermentum ac ipsum. Praesent condimentum dolor sit amet ipsum blandit, nec dictum mauris feugiat. Fusce non facilisis arcu. Mauris vel elementum leo. Suspendisse potenti. Nullam non eleifend libero. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed mattis ipsum. Morbi imperdiet tortor vel facilisis laoreet. Cras scelerisque quis elit at facilisis. Etiam convallis faucibus dui, quis eleifend nisi. Integer ullamcorper congue eros, quis pharetra nisi porta ac.<br>Proin lacus justo, egestas in velit iaculis, vestibulum interdum nibh.<br><br>Fusce sed nunc lacinia, mattis leo in, porta elit. Donec sagittis vitae neque et euismod. In placerat purus id tortor gravida, eget maximus magna laoreet. Morbi sed metus tempus, volutpat massa id, commodo nisl. Donec ac ipsum commodo, vestibulum orci a, euismod est. Donec sed ullamcorper leo. Sed lacus dolor, commodo id bibendum porta, aliquet quis libero. Integer cursus ultrices diam, vestibulum maximus felis tempor a. Proin cursus ornare aliquet. Nam volutpat pellentesque lorem, congue laoreet erat malesuada id. Proin ultricies sit amet sem vel gravida. Nullam et iaculis ex, ac rutrum justo. Aenean volutpat nunc ac egestas aliquet. Vivamus in ipsum eu nisl gravida condimentum.<br>Phasellus ac turpis ac orci bibendum scelerisque varius quis nisl.<br><br>Ut ornare maximus arcu sit amet viverra. Phasellus viverra vitae purus eu semper. Aenean at interdum tellus, a iaculis elit. Donec blandit dolor sodales ex scelerisque, et laoreet metus dapibus. Pellentesque vulputate quis est a aliquam. Nunc ultrices sed urna id fermentum. Aenean ut sapien hendrerit, ultricies sapien quis, tristique ante. Etiam eu urna non sem dictum dapibus. Sed nisi mauris, pulvinar id nibh sit amet, volutpat elementum ipsum. Sed ac mi nibh. Pellentesque porta, felis mollis ullamcorper suscipit, enim ipsum suscipit lorem, eu venenatis odio felis ut nulla. Aliquam non ultricies odio. Donec eu sodales augue, id lacinia odio. Nulla ut erat ac mi feugiat luctus a in sem.',NULL,NULL,NULL,'2019-10-11 17:05:33',NULL,1,NULL,NULL,0,'2019-10-11 17:17:11',NULL,1,'post',1),
	(4,'whatever-title-here','Whatever Title here',NULL,'Cada necessidade, precisada<br>da cobertura certa<br><strong>Vamos Descobrir a sua?</strong>','Accusamus ad alias asperiores beatae debitis enim, eos eum expedita laboriosam minus natus nisi nulla, officia perferendis quae recusandae tempora tenetur veniam.',NULL,'c05e80ac2b114bd1f7ead546c6769bc3.jpg',NULL,'2019-10-12 11:34:25',NULL,2,NULL,NULL,0,'2019-10-12 11:35:13',1,1,'post',1),
	(12,'desmatamento-na-amazonia-cresce-96-em-setembro-indicam-alertas-do-inpe','Desmatamento na Amazônia cresce 96% em setembro, indicam alertas do Inpe',NULL,NULL,'O desmatamento cresceu cerca de 96% em setembro na Amaz&ocirc;nia na compara&ccedil;&atilde;o com o mesmo m&ecirc;s de 2018, segundo dados do sistema Deter, do Inpe (Instituto Nacional de Pesquisas Espaciais), que dispara alertas de desmate para orientar a&ccedil;&otilde;es do Ibama<br><br>Desde junho, a devasta&ccedil;&atilde;o na Amaz&ocirc;nia tem aumentado na compara&ccedil;&atilde;o com a s&eacute;rie hist&oacute;rica do Inpe. Os meses de julho, agosto e setembro do primeiro ano do governo Jair Bolsonaro tiveram as maiores taxas de desmate desde 2015 e 2016 (no caso de julho) &mdash;o Deter est&aacute; em funcionamento desde 2004.','https://www1.folha.uol.com.br/ambiente/2019/10/desmatamento-na-amazonia-cresce-96-em-setembro-indicam-alertas-do-inpe.shtml',NULL,'https://f.i.uol.com.br/fotografia/2019/08/28/15670253635d66e8d3c9c1e_1567025363_3x2_rt.jpg','2019-10-11 20:22:47',NULL,4,NULL,NULL,0,NULL,NULL,1,'post',2),
	(14,'jogador-da-chape-vai-a-justica-apos-receber-11-de-seguro-da-cbf','Jogador da Chape vai à Justiça após receber 11% de seguro da CBF',NULL,NULL,'Quase tr&ecirc;s anos ap&oacute;s o acidente envolvendo o avi&atilde;o da Chapecoense, o zagueiro Neto, 34, recebeu o seguro de vida contratado pela CBF. Mas n&atilde;o no valor que esperava.<br>Pela ap&oacute;lice, o jogador, que ainda sofre sequelas do acidente e , deveria receber o valor equivalente a 12 meses de sal&aacute;rios na &eacute;poca do contrato (cerca de R$ 500 mil). A Prudential, empresa respons&aacute;vel pelo seguro, pagou R$ 55 mil, equivalente a 11,25% do total.','https://www1.folha.uol.com.br/esporte/2019/10/jogador-da-chape-vai-a-justica-apos-receber-11-de-seguro-da-cbf.shtml',NULL,'https://f.i.uol.com.br/fotografia/2019/10/11/15708252225da0e4068fcbf_1570825222_3x2_rt.jpg','2019-10-11 20:44:50',NULL,4,NULL,NULL,0,NULL,NULL,1,'post',3),
	(15,'asteroide-de-14-metros-de-diametro-pode-colidir-com-a-terra-em-65-anos','Asteroide de 14 metros de diâmetro pode colidir com a Terra em 65 anos',NULL,NULL,'A Ag&ecirc;ncia Espacial Europeia (ESA, na sigla em ingl&ecirc;s) adicionou um novo asteroide a sua &quot;lista de risco&quot;. Batizado de 2019 SU3, a rocha espacial de 14 metros de di&acirc;metro pode colidir com a Terra em 16 de setembro de 2084, daqui a pouco menos de 65 anos.<br>O asteroide &eacute; atualmente rankeado como a quarta maior amea&ccedil;a &agrave; Terra pela ag&ecirc;ncia. Ele est&aacute; atr&aacute;s apenas de outros tr&ecirc;s objetos, que t&ecirc;m estimativa de atingir a Terra entre 2082 e 2113, com di&acirc;metros variando entre 9 metros e 700 metros','https://www.uol.com.br/tilt/noticias/redacao/2019/10/11/asteroide-de-14-metros-de-diametro-pode-colidir-com-a-terra-em-65-anos.htm','a780759d8c2bfcda645e0851c1317e4b.jpg',NULL,'2019-10-11 20:49:27',NULL,4,NULL,NULL,0,'2019-10-12 10:59:13',NULL,1,'post',4),
	(16,'renda-fixa','Renda Fixa',NULL,'Class aptent taciti<br>sociosqu ad litora<br><strong>torquent per conubia</strong>','Pellentesque eu ante nisi. Fusce eu scelerisque metus. Cras tristique sem eros, ac auctor metus volutpat a. Donec quis varius elit. Ut a neque eget leo aliquam vestibulum. Nam a lobortis ex. Praesent ut mauris id ex semper auctor. Ut porttitor finibus neque, vel pellentesque ex imperdiet eget.<br>Nam ut magna vitae diam bibendum lacinia sed et urna. Aenean sit amet lacus neque. Curabitur aliquet ipsum id enim porta imperdiet. Praesent viverra, turpis sit amet lobortis bibendum, nibh dolor rutrum nulla, sed lobortis orci lacus suscipit nulla. Nam id neque enim. Vestibulum dignissim mauris vel justo euismod rutrum. Vestibulum hendrerit ipsum sed feugiat volutpat. Vestibulum tellus mi, maximus a blandit dapibus, viverra eget arcu. Nulla facilisi. Sed auctor est massa, ut accumsan mauris venenatis non. Quisque at lectus at ligula ullamcorper malesuada non ut tellus. Ut eget feugiat dolor.<br>Ut tortor lectus, maximus quis nulla in, dictum ullamcorper ex. Nulla et orci id odio dignissim tempor. Cras mollis enim nec lacus gravida, sed rhoncus mi tincidunt. Nam gravida hendrerit dui, ut condimentum lacus eleifend a. Donec sed risus sed dui maximus molestie eu nec orci. In facilisis iaculis quam, sed eleifend dolor facilisis quis. Morbi eu eleifend purus, at sodales leo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean pellentesque elit aliquet, commodo ipsum et, porta massa. Curabitur quis hendrerit sem. Morbi lobortis sapien sed leo bibendum, in congue magna cursus. Fusce vestibulum elit vitae quam placerat, vel convallis ligula interdum. Nam sagittis consectetur nisl eget venenatis. Suspendisse aliquet odio et porta fringilla.<br>Suspendisse pellentesque nibh a congue sagittis. In varius augue eu consequat scelerisque. Vivamus condimentum metus erat, eu pellentesque arcu convallis at. Ut eu tortor vestibulum, finibus dolor et, tristique lacus. Phasellus in quam sapien. Nam id lectus ut libero cursus euismod quis non felis. Morbi rutrum mi vitae justo viverra volutpat. In id magna a urna convallis auctor vel vitae dolor. Sed quis lorem vulputate, semper neque quis, elementum est. Fusce libero diam, aliquet a faucibus sed, eleifend in ex. Nam at porttitor libero. Integer mi turpis, vulputate sit amet volutpat in, hendrerit eu neque. Fusce tincidunt ultrices posuere. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla vitae elit et leo porttitor lacinia in sodales ex. Morbi ullamcorper lacus sed diam vulputate, ac placerat enim convallis.<br>Etiam placerat egestas nulla, eu viverra nunc. In sed ex at massa cursus congue. Proin quis semper neque. Donec mi elit, scelerisque vitae eleifend ac, viverra id ante. Suspendisse a nibh arcu. Sed convallis mauris tincidunt risus accumsan, a aliquam erat feugiat. Nunc sagittis at nisl ac congue.',NULL,'03ca2fe44dd3d1e33c3320cf4c60983f.jpg',NULL,'2019-10-12 11:08:13',NULL,3,NULL,NULL,0,'2019-10-12 11:08:31',1,1,'post',1),
	(17,'fusce-dapibus','Fusce dapibus',NULL,NULL,'Eget mattis orci nisi at est. Nunc dapibus velit eget magna placerat, ut mollis velit sollicitudin. Phasellus suscipit ipsum sit amet pharetra vulputate. Ut egestas vel magna at ultrices. Cras non dui non quam elementum fermentum et sed risus. Aliquam a faucibus nunc. Mauris sed leo at odio tempus dictum. Maecenas lorem lacus, hendrerit at augue at, dignissim porttitor enim. Nullam faucibus vel velit at porta. Maecenas justo sapien, condimentum non sapien euismod, tempus pellentesque neque. Aenean nec enim nulla.<br>Fusce eu iaculis neque, feugiat maximus nibh. Donec gravida dictum risus, et accumsan felis malesuada et. Nulla luctus ipsum ac ex dapibus imperdiet. Aliquam porta tincidunt metus ac laoreet. Pellentesque urna lacus, placerat at enim ut, imperdiet varius dui. Praesent eget risus vel nisi sodales blandit vitae nec erat. Mauris eget tempus nibh. Vestibulum quis magna neque. Quisque ut ligula in odio consectetur fringilla eu sed odio. Sed scelerisque pretium augue at elementum. Phasellus viverra neque sodales, dapibus nisl a, condimentum tortor. Nulla aliquam, lorem sit amet pharetra placerat, elit ante semper lorem, in posuere turpis leo eu lectus.',NULL,NULL,NULL,'2019-10-12 11:10:11',NULL,2,NULL,NULL,0,NULL,NULL,1,'post',2),
	(18,'ut-tristique-nibh-non-ullamcorper','Ut tristique nibh non ullamcorper',NULL,'Fusce eleifend urna tristique<br><strong>eu condimentum venenatis</strong>','Maecenas id nisi malesuada, lobortis diam a, auctor tellus. Aenean ac velit tempor velit varius elementum at in ipsum. Morbi eget risus nec tortor euismod dictum. Quisque interdum, risus cursus varius iaculis, risus ligula lacinia sapien, sit amet cursus velit arcu vel neque. Mauris nec molestie eros, quis egestas lorem. Duis metus purus, condimentum vitae tortor nec, accumsan hendrerit justo. Cras nec justo eget neque maximus auctor non sit amet diam. Etiam rhoncus nibh id malesuada elementum. Aenean et tellus volutpat urna ultricies gravida a ut mi. Donec quis euismod sem. Sed elementum mi vel ipsum lobortis scelerisque. Nulla ornare sit amet lacus vitae cursus. Vivamus viverra massa et mollis porttitor. Vestibulum non congue lorem.<br>Nulla nulla elit, aliquet eget eros sit amet, facilisis consectetur ex. Mauris sem odio, tincidunt sed magna sed, faucibus posuere mauris. Integer quis ligula sed nisl rutrum mollis. Etiam ut odio quis urna venenatis hendrerit et a magna. Proin tempus libero eget justo pretium commodo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Suspendisse eget libero eu nisi porta malesuada. Integer in sem eget ipsum imperdiet porta. Curabitur facilisis enim justo. Aliquam malesuada malesuada ultricies. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sit amet aliquet turpis. Suspendisse auctor elit nec finibus feugiat.<br>Donec fringilla dolor a augue egestas mattis. Quisque quis turpis malesuada, congue quam et, molestie erat. Morbi non est vel augue bibendum interdum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas libero nisi, dictum ut mi id, mollis accumsan felis. Aliquam erat volutpat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel tempor dolor, id volutpat elit. Morbi posuere elementum aliquam. Nam finibus nec ligula at maximus. Aenean ullamcorper ligula libero, vitae maximus mauris placerat nec. Nulla finibus rutrum diam, ac eleifend nibh iaculis at. Donec ac ante euismod, finibus felis in, blandit mi. Suspendisse quam diam, posuere aliquet lorem a, euismod laoreet sem. Praesent ac odio at felis eleifend ornare. Aenean sit amet orci nec arcu luctus interdum sit amet ut odio.',NULL,NULL,NULL,'2019-10-12 11:16:47',NULL,2,NULL,NULL,0,'2019-10-12 11:17:41',1,1,'post',3),
	(19,'quisque-quis-turpis-malesuada','Quisque quis turpis malesuada',NULL,NULL,'Nulla nulla elit, aliquet eget eros sit amet, facilisis consectetur ex. Mauris sem odio, tincidunt sed magna sed, faucibus posuere mauris. Integer quis ligula sed nisl rutrum mollis. Etiam ut odio quis urna venenatis hendrerit et a magna. Proin tempus libero eget justo pretium commodo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Suspendisse eget libero eu nisi porta malesuada. Integer in sem eget ipsum imperdiet porta. Curabitur facilisis enim justo. Aliquam malesuada malesuada ultricies. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sit amet aliquet turpis. Suspendisse auctor elit nec finibus feugiat.<br>Donec fringilla dolor a augue egestas mattis. Quisque quis turpis malesuada, congue quam et, molestie erat. Morbi non est vel augue bibendum interdum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas libero nisi, dictum ut mi id, mollis accumsan felis. Aliquam erat volutpat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel tempor dolor, id volutpat elit. Morbi posuere elementum aliquam. Nam finibus nec ligula at maximus. Aenean ullamcorper ligula libero, vitae maximus mauris placerat nec. Nulla finibus rutrum diam, ac eleifend nibh iaculis at. Donec ac ante euismod, finibus felis in, blandit mi. Suspendisse quam diam, posuere aliquet lorem a, euismod laoreet sem. Praesent ac odio at felis eleifend ornare. Aenean sit amet orci nec arcu luctus interdum sit amet ut odio.',NULL,'68549426ca1757091be69410eff76e2c.jpg',NULL,'2019-10-12 11:20:56',NULL,3,NULL,NULL,0,'2019-10-12 11:22:12',1,1,'post',2);

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
