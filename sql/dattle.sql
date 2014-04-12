# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Hôte: 127.0.0.1 (MySQL 5.5.25)
# Base de données: dattle
# Temps de génération: 2014-04-11 22:08:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table attacks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attacks`;

CREATE TABLE `attacks` (
  `attacks_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(11) unsigned NOT NULL,
  `cities_id` varchar(255) NOT NULL DEFAULT '',
  `attacks_dt` datetime DEFAULT NULL,
  `attacks_win` int(1) DEFAULT NULL,
  `attacks_score` int(11) DEFAULT NULL,
  `opponent_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`attacks_id`),
  KEY `cities_id` (`cities_id`),
  KEY `users_id` (`users_id`),
  KEY `opponent_id` (`opponent_id`),
  CONSTRAINT `attacks_ibfk_3` FOREIGN KEY (`opponent_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `attacks_ibfk_1` FOREIGN KEY (`cities_id`) REFERENCES `cities` (`cities_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `attacks_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `attacks` WRITE;
/*!40000 ALTER TABLE `attacks` DISABLE KEYS */;

INSERT INTO `attacks` (`attacks_id`, `users_id`, `cities_id`, `attacks_dt`, `attacks_win`, `attacks_score`, `opponent_id`)
VALUES
	(2,1,'ROUEN','2014-04-11 23:40:00',0,200,NULL);

/*!40000 ALTER TABLE `attacks` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table cities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `cities_id` varchar(255) NOT NULL DEFAULT '',
  `cities_name` varchar(512) NOT NULL DEFAULT '',
  `cities_class` varchar(256) DEFAULT NULL,
  `cities_caton` varchar(256) DEFAULT NULL,
  `cities_kml` text,
  `cities_population` bigint(20) DEFAULT NULL,
  `cities_win_score` int(11) DEFAULT NULL,
  `users_id` int(11) unsigned DEFAULT NULL,
  `cities_win_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`cities_id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;

INSERT INTO `cities` (`cities_id`, `cities_name`, `cities_class`, `cities_caton`, `cities_kml`, `cities_population`, `cities_win_score`, `users_id`, `cities_win_dt`)
VALUES
	('ROUEN','Rouen','BIG','ROUEN','???\n',105000,NULL,1,NULL);

/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `questions_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questions_text` text NOT NULL,
  `questions_type` varchar(128) NOT NULL DEFAULT '',
  `questions_resp_1` varchar(1024) NOT NULL DEFAULT '',
  `questions_resp_2` varchar(1024) DEFAULT NULL,
  `questions_resp_3` varchar(1024) DEFAULT NULL,
  `questions_resp_good` int(1) DEFAULT NULL,
  `cities_id` varchar(255) NOT NULL DEFAULT '',
  `questions_datasource` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`questions_id`),
  KEY `cities_id` (`cities_id`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`cities_id`) REFERENCES `cities` (`cities_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;

INSERT INTO `questions` (`questions_id`, `questions_text`, `questions_type`, `questions_resp_1`, `questions_resp_2`, `questions_resp_3`, `questions_resp_good`, `cities_id`, `questions_datasource`)
VALUES
	(1,'Quel est la population de la ville ?','VALUE','105000',NULL,NULL,1,'ROUEN','fic_76_commune');

/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table timeline
# ------------------------------------------------------------

DROP TABLE IF EXISTS `timeline`;

CREATE TABLE `timeline` (
  `timeline_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `timeline_dt` datetime NOT NULL,
  `timeline_type` varchar(128) DEFAULT NULL,
  `timeline_message` varchar(1024) DEFAULT NULL,
  `users_id` int(11) unsigned DEFAULT NULL,
  `cities_id` varchar(255) DEFAULT NULL,
  `opponent_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`timeline_id`),
  KEY `timeline_message` (`timeline_message`(255)),
  KEY `users_id` (`users_id`),
  KEY `cities_id` (`cities_id`),
  KEY `opponent_id` (`opponent_id`),
  CONSTRAINT `timeline_ibfk_3` FOREIGN KEY (`opponent_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `timeline_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `timeline_ibfk_2` FOREIGN KEY (`cities_id`) REFERENCES `cities` (`cities_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `timeline` WRITE;
/*!40000 ALTER TABLE `timeline` DISABLE KEYS */;

INSERT INTO `timeline` (`timeline_id`, `timeline_dt`, `timeline_type`, `timeline_message`, `users_id`, `cities_id`, `opponent_id`)
VALUES
	(1,'2014-04-11 23:47:00','WIN','',1,'ROUEN',NULL);

/*!40000 ALTER TABLE `timeline` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `users_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_email` varchar(1024) NOT NULL DEFAULT '',
  `users_password` varchar(128) NOT NULL DEFAULT '',
  `users_pseudo` varchar(128) NOT NULL DEFAULT '',
  `users_round_avail` int(11) NOT NULL DEFAULT '0',
  `users_round_played` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`users_id`, `users_email`, `users_password`, `users_pseudo`, `users_round_avail`, `users_round_played`)
VALUES
	(1,'olivier@cigogne.net','37fa265330ad83eaa879efb1e2db6380896cf639','omartineau',10,0);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
