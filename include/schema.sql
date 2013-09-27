SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `tkr_project`;
CREATE TABLE `tkr_project` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext,
  `url_dev` varchar(255) DEFAULT NULL,
  `url_preprod` varchar(255) DEFAULT NULL,
  `url_prod` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  `datemodified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tkr_projectuser`;
CREATE TABLE `tkr_projectuser` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `datecreated` datetime NOT NULL,
  `datemodified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`,`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tkr_ticket`;
CREATE TABLE `tkr_ticket` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` longtext,
  `project_id` bigint(20) NOT NULL,
  `author_id` bigint(20) NOT NULL,
  `developer_id` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  `datemodified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`,`developer_id`),
  KEY `project_id` (`project_id`),
  KEY `developer_id` (`developer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tkr_user`;
CREATE TABLE `tkr_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `isadmin` tinyint(4) NOT NULL,
  `valid` tinyint(4) NOT NULL,
  `datecreated` datetime NOT NULL,
  `datemodified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


ALTER TABLE `tkr_projectuser`
  ADD CONSTRAINT `tkr_projectuser_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `tkr_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tkr_projectuser_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tkr_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tkr_ticket`
  ADD CONSTRAINT `tkr_ticket_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tkr_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tkr_ticket_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `tkr_user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tkr_ticket_ibfk_3` FOREIGN KEY (`developer_id`) REFERENCES `tkr_user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
