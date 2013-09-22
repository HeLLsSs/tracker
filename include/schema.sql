SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `tkr_ticket`;
CREATE TABLE `tkr_ticket` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` longtext,
  `project_id` bigint(20) NOT NULL,
  `author_id` bigint(20) NOT NULL,
  `developer_id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  `datemodified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`,`developer_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `tkr_ticket` (`id`, `title`, `description`, `project_id`, `author_id`, `developer_id`, `status`, `type`, `priority`, `datecreated`, `datemodified`) VALUES
(1, 'bug de merde', '<p>test</p>', 1, 1, 1, 2, 1, 0, '2013-09-19 16:42:40', '2013-09-20 18:49:53'),
(2, 'Encore un bug à la con', '<p>c&#39;est relou s&eacute;rieux</p>', 1, 1, 0, 1, 2, 0, '2013-09-20 19:27:04', '2013-09-20 19:27:04');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `tkr_project` (`id`, `name`, `description`, `url_dev`, `url_preprod`, `url_prod`, `status`, `datecreated`, `datemodified`) VALUES
(1, 'Malakoff-Quiz civiltés', '<p>quiz</p>', NULL, NULL, NULL, 1, '2013-09-19 16:39:17', '2013-09-19 16:39:17');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `tkr_user` (`id`, `lastname`, `firstname`, `email`, `password`, `picture`, `isadmin`, `valid`, `datecreated`, `datemodified`) VALUES
(1, 'Cazalet', 'Rémi', 'remi@caramia.fr', '1a1dc91c907325c69271ddf0c944bc72', NULL, 1, 1, '2013-09-19 00:00:00', '2013-09-19 00:00:00');


ALTER TABLE `tkr_ticket`
  ADD CONSTRAINT `tkr_ticket_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `tkr_user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tkr_ticket_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tkr_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
